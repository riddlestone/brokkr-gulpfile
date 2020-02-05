<?php

namespace Riddlestone\Brokkr\Gulpfile\Test\Command;

use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Laminas\ServiceManager\Exception\ServiceNotCreatedException;
use Laminas\ServiceManager\Exception\ServiceNotFoundException;
use PHPUnit\Framework\TestCase;
use Riddlestone\Brokkr\Gulpfile\Command\Gulpfile;
use Riddlestone\Brokkr\Gulpfile\Command\GulpfileFactory;
use Riddlestone\Brokkr\Portals\PortalManager;
use stdClass;

class GulpfileFactoryTest extends TestCase
{
    /**
     * @throws ContainerException
     */
    public function testFactory()
    {
        $config = [
            'my_gulp_config',
        ];
        $portalManager = $this->createMock(PortalManager::class);

        $container = $this->createMock(ContainerInterface::class);
        $container->method('get')->willReturnCallback(function ($name) use ($config, $portalManager) {
            switch($name) {
                case 'Config':
                    return ['gulp' => $config];
                case PortalManager::class:
                    return $portalManager;
                default:
                    throw new ServiceNotFoundException();
            }
        });

        $factory = new GulpfileFactory();
        $gulpfileCommand = $factory($container, Gulpfile::class);
        $this->assertInstanceOf(Gulpfile::class, $gulpfileCommand);
        $this->assertEquals($config, $gulpfileCommand->getConfig());
        $this->assertEquals($portalManager, $gulpfileCommand->getPortalManager());

        $this->expectException(ServiceNotCreatedException::class);
        $factory($container, stdClass::class);
    }
}
