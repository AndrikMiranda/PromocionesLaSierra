<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

require '../src/config/db.php';
require '../vendor/autoload.php';

$app = new \Slim\App;


//rutas
require '../src/rutas/reportes.php';
require '../src/rutas/usuario.php';
require '../src/rutas/inventarioP.php';
require '../src/rutas/inventarioS.php';
require '../src/rutas/tipomovimiento.php';
require '../src/rutas/articulos.php';
require '../src/rutas/categoriaArticulo.php';
require '../src/rutas/catCalle.php';
require '../src/rutas/catColonia.php';
require '../src/rutas/catEstado.php';
require '../src/rutas/catMunicipio.php';
require '../src/rutas/direccion.php';
require '../src/rutas/catLio.php';
require '../src/rutas/catMotivo.php';
require '../src/rutas/catTipoUsuario.php';
require '../src/rutas/ruta.php';


$app->run();

?>
