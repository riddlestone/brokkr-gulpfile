<?php

namespace Riddlestone\Brokkr\Gulpfile\Command;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Exception\ServiceNotCreatedException;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Riddlestone\Brokkr\Portals\PortalManager;

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
        $command->setPortalManager($container->get(PortalManager::class));
        return $command;
    }
}
