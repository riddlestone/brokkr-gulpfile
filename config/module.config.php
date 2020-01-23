<?php

namespace Riddlestone\ZF\Gulpfile;

return [
    'console' => [
        'commands' => [
            Command\Gulpfile::class,
        ],
    ],
    'gulp' => [
        'template' => __DIR__ . '/../view/gulpfile-template.php',
        'target' => 'gulpfile.js',
        'portals' => [],
    ],
    'npm' => [
        '' => [
            'gulp' => '^4.0.2',
            'gulp-concat' => '^2.6.1',
            'gulp-csso' => '^4.0.1',
            'gulp-image' => '^6.0.0',
            'gulp-sass' => '^4.0.2',
        ],
    ],
    'service_manager' => [
        'factories' => [
            Command\Gulpfile::class => Command\GulpfileFactory::class,
        ],
    ],
];
