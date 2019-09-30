# vanillaPhpRouter

a simple vanilla php router

## How to use

the router is a composer ready library. 

1. Copy php-router/ to the root project directoy

2. run `composer require "hichemkhial/php-router":"@dev"`

3. run `composer dumpautoload -o`

4. the project folder structure needs to be the following

   ```shell
   [APP_NAME]/controller
             /config/routes.php
             /index.php
   ```

   ​          

to instanciate the router you just need to create an instance of it on the index.php file 

```php
<?php 
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config/routes.php';

use Routing\Router\Router as Router;
use Routing\Router\HttpReady as HttpReady;

new Router();

```

