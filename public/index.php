<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

require '../src/config/db.php';
require '../vendor/autoload.php';

$app = new \Slim\App;


//rutas
require '../src/rutas/usuario.php';
require '../src/rutas/inventarioP.php';
require '../src/rutas/inventarioS.php';
require '../src/templates/inventario.php';

$app->run();

?>
