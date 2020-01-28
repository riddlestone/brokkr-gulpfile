<?php

namespace Riddlestone\Brokkr\Gulpfile\Test\Command;

use PHPUnit\Framework\TestCase;
use Riddlestone\Brokkr\Gulpfile\Command\Gulpfile;

class GulpfileTest extends TestCase
{
    public function testGetGulpConfig()
    {
        $command = new Gulpfile();
        $command->setConfig([
            'target' => '/tmp/test',
            'template' => __DIR__ . '/../../view/gulpfile.js.php',
            'portals' => [
                'main' => [
                    'img' => [
                        'foo.png',
                        'bar/**/*.jpg',
                    ],
                    'css' => [
                        'foo.scss',
                        'bar/baz.scss',
                    ],
                    'js' => [
                        'script.js',
                        'stuff/**/*.js',
                    ],
                ],
            ],
        ]);
        $this->assertEquals(file_get_contents(__DIR__ . '/gulpfile.js'), $command->getGulpConfig());
    }
}
