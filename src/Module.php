<?php

namespace Riddlestone\Brokkr\Gulpfile;

class Module
{
    public function getConfig()
    {
        return require __DIR__ . '/../config/module.config.php';
    }
}
