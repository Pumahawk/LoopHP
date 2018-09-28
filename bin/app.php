<?php

require __DIR__.'/init.php';

use LoopHP\AppConfiguration;
use LoopHP\App;

$config = new AppConfiguration(__DIR__.'/../app');
(new App($config)) -> start();
