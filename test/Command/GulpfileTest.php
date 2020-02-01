<?php

namespace Riddlestone\Brokkr\Gulpfile\Test\Command;

use PHPUnit\Framework\TestCase;
use Riddlestone\Brokkr\Gulpfile\Command\Gulpfile;

class GulpfileTest extends TestCase
{
    public function getTestGulpfileDataProvider()
    {
        return array_map(function($testName) {
            return [
                'config' => json_decode(file_get_contents(__DIR__ . '/../data/' . $testName . '.json'), true),
                'expected' => file_get_contents(__DIR__ . '/../data/' . $testName . '.js'),
            ];
        }, [
            'test1',
            'test2'
        ]);
    }

    /**
     * @dataProvider getTestGulpfileDataProvider
     * @param array $config
     * @param string $expected
     */
    public function testGulpfile($config, $expected)
    {
        $command = new Gulpfile();
        $command->setConfig($config + [
                'target' => '/tmp/test',
                'template' => __DIR__ . '/../../view/gulpfile.js.php'
            ]);
        $this->assertEquals($expected, $command->getGulpConfig());
    }
}
