# Riddlestone Brokkr-Gulpfile

A [Laminas](https://github.com/laminas) module for creating [Gulp](https://gulpjs.com) config files

## Installation

Installation of this module uses composer. For composer documentation, please refer to
[getcomposer.org](http://getcomposer.org/).

```sh
composer require riddlestone/brokkr-gulpfile
```

## Usage

To include your js/sass files in the gulpfile, add them in portals to your module or site's config file:

```php
<?php
return [
    'gulp' => [
        'portals' => [
            'main' => [
                'css' => [
                    realpath(__DIR__ . '/../resources/css/**/*.scss'),
                ],
                'js' => [
                    realpath(__DIR__ . '/../resources/js/**/*.js'),
                ],
            ],
        ],
    ],
];
```

A gulpfile can now be created using the brokkr command `gulpfile`:
```sh
vendor/bin/brokkr gulpfile
```

## Changing the template

To change the template for your gulpfile, just copy view/gulpfile.js.php somewhere, change it, and add the new path to your module/site's config:
```php
<?php
return [
    'gulp' => [
        'template' => realpath(__DIR__ . '/../view/gulpfile.js.php'),
    ],
];
```

## Get Involved

File issues at https://github.com/riddlestone/brokkr-gulpfile/issues
