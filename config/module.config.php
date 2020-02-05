<?php

namespace Riddlestone\Brokkr\Gulpfile;

return [
    'console' => [
        'commands' => [
            Command\Gulpfile::class,
        ],
    ],
    'gulp' => [
        'template' => __DIR__ . '/../view/gulpfile.js.php',
        'target' => 'gulpfile.js',
    ],
    'npm' => [
        'dependencies' => [
            'gulp' => '^4.0.2',
            'gulp-concat' => '^2.6.1',
            'gulp-csso' => '^4.0.1',
            'gulp-image' => '^6.0.0',
            'gulp-sass' => '^4.0.2',
            'gulp-uglify' => '^3.0.2',
        ],
    ],
    'service_manager' => [
        'factories' => [
            Command\Gulpfile::class => Command\GulpfileFactory::class,
        ],
    ],
];
