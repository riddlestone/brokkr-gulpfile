<?php

namespace Riddlestone\Brokkr\Gulpfile\Test;

use PHPUnit\Framework\TestCase;
use Riddlestone\Brokkr\Gulpfile\Module;

class ModuleTest extends TestCase
{
    public function testGetConfig()
    {
        $module = new Module();
        $config = $module->getConfig();
        $this->assertIsArray($config);
        $this->assertArrayHasKey('gulp', $config);
    }
}
