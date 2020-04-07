<?php

namespace Riddlestone\Brokkr\Gulpfile\Command;

use Riddlestone\Brokkr\Portals\PortalManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Gulpfile extends Command
{
    protected static $defaultName = 'gulpfile';

    /**
     * @var array
     */
    protected $config;

    /**
     * @var PortalManager
     */
    protected $portalManager;

    /**
     * @param array $config
     */
    public function setConfig(array $config)
    {
        $this->config = $config;
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param PortalManager $portalManager
     */
    public function setPortalManager(PortalManager $portalManager): void
    {
        $this->portalManager = $portalManager;
    }

    /**
     * @return PortalManager
     */
    public function getPortalManager(): PortalManager
    {
        return $this->portalManager;
    }

    protected function getPortalConfig()
    {
        $portalConfig = [];
        foreach($this->getPortalManager()->getPortalNames() as $portalName) {
            $portalConfig[$portalName] = [];
            foreach(['css', 'js', 'other', 'sass_options'] as $type) {
                $portalConfig[$portalName][$type] = $this->getPortalManager()->getPortalConfig($portalName, $type);
            }
        }
        return $portalConfig;
    }

    /**
     * @return false|string
     */
    public function getGulpConfig()
    {
        /**
         * @param string $template
         * @param array $portals Used in $template file
         * @return false|string
         */
        $render = function($template, $portals) {
            ob_start();
            require $template;
            return ob_get_clean();
        };
        return $render($this->config['template'], $this->getPortalConfig());
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        file_put_contents($this->config['target'], $this->getGulpConfig());
    }
}
