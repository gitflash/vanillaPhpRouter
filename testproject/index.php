<?php 
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config/routes.php';

use Routing\Router\Router as Router;
use Routing\Router\HttpReady as HttpReady;

new Router();
