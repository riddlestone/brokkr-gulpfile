<?php

namespace Riddlestone\ZF\Gulpfile\Command;

use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Laminas\ServiceManager\Exception\ServiceNotCreatedException;
use Laminas\ServiceManager\Exception\ServiceNotFoundException;
use Laminas\ServiceManager\Factory\FactoryInterface;

class GulpfileFactory implements FactoryInterface
{
    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        if(!is_a($requestedName, Gulpfile::class, true)) {
            throw new ServiceNotCreatedException(sprintf('%s is not a %s', $requestedName, Gulpfile::class));
        }
        /** @var Gulpfile $command */
        $command = new $requestedName;
        $command->setConfig($container->get('Config')['gulp']);
        return $command;
    }
}
