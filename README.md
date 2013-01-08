# Silex skeleton

## Installation

    $ git clone https://github.com/sanpii/behatch-skeleton.git
    $ cd behatch-skeleton
    $ curl -s http://getcomposer.org/installer | php
    $ php composer.phar install
    $ ./bin/behat features/github.feature

## Configuration

    $ cd src/Sanpi/Cist/Resources/config
    $ ln -s development.php current.php

## Test

    $ php -S localhost:8080 -t web/ web/index.php
