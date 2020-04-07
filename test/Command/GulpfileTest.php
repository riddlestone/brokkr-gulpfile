<?php

namespace Riddlestone\Brokkr\Gulpfile\Test\Command;

use Exception;
use PHPUnit\Framework\TestCase;
use Riddlestone\Brokkr\Gulpfile\Command\Gulpfile;
use Riddlestone\Brokkr\Portals\PortalManager;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GulpfileTest extends TestCase
{
    public function getTestGulpfileDataProvider()
    {
        return array_map(function ($testName) {
            return [
                'portalConfig' => json_decode(file_get_contents(__DIR__ . '/../data/' . $testName . '.json'), true),
                'expected' => realpath(__DIR__ . '/../data/' . $testName . '.js'),
            ];
        }, [
            'test1',
            'test2',
            'test3',
            'test4',
        ]);
    }

    /**
     * @dataProvider getTestGulpfileDataProvider
     * @param $portalConfig
     * @param string $expected
     * @throws Exception
     */
    public function testGetGulpConfig($portalConfig, $expected)
    {
        $portalManager = $this->createMock(PortalManager::class);
        $portalManager->method('getPortalNames')->willReturn(array_keys($portalConfig));
        $portalManager->method('getPortalConfig')->willReturnCallback(function ($portal, $key) use ($portalConfig) {
            $config = $portalConfig[$portal];
            if ($key) {
                return array_key_exists($key, $config) ? $config[$key] : [];
            }
            return $config;
        });

        $command = new Gulpfile();
        $command->setPortalManager($portalManager);
        $command->setConfig([
            'target' => '/tmp/test',
            'template' => __DIR__ . '/../../view/gulpfile.js.php'
        ]);

        $input = $this->createMock(InputInterface::class);
        $output = $this->createMock(OutputInterface::class);
        $command->run($input, $output);
        $this->assertFileEquals($expected, '/tmp/test');
    }
}
