<?php

namespace Riddlestone\ZF\Gulpfile\Test\Command;

use PHPUnit\Framework\TestCase;
use Riddlestone\ZF\Gulpfile\Command\Gulpfile;

class GulpfileTest extends TestCase
{
    public function testGetGulpConfig()
    {
        $command = new Gulpfile();
        $target = tempnam('/tmp', 'php');
        $command->setConfig([
            'target' => $target,
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
