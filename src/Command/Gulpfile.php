<?php

namespace Riddlestone\Brokkr\Gulpfile\Command;

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
     * @var array
     */
    protected $portalConfig;

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
     * @param array $portalConfig
     */
    public function setPortalConfig(array $portalConfig)
    {
        $this->portalConfig = $portalConfig;
    }

    /**
     * @return array
     */
    public function getPortalConfig()
    {
        return $this->portalConfig;
    }

    public function getGulpConfig()
    {
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
