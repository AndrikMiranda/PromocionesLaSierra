<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

require '../src/config/db.php';
require '../vendor/autoload.php';

$app = new \Slim\App;


//rutas
<<<<<<< HEAD
require '../src/rutas/reportes.php';
=======
require '../src/rutas/signup.php';
require '../src/rutas/login.php';
require '../src/rutas/venta.php';
require '../src/rutas/vendedor.php';
require '../src/rutas/cobrador.php';
require '../src/rutas/cobranza.php';
require '../src/rutas/cuenta.php';
require '../src/rutas/cliente.php';
require '../src/rutas/notificaciones.php';
>>>>>>> Actualizacion Arturo. Nuevo push para que Ruben vea version actualizada
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
<<<<<<< HEAD
require '../src/rutas/RepListaNegra.php';
require '../src/rutas/RepSaldoPendiente.php';
=======
require '../src/rutas/rutasPorCobrador.php';
require '../src/rutas/reportes.php';

$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});

//CAMBIAR 
$app->add(function ($req, $res, $next) {
    $response = $next($req, $res);
    return $response
            ->withHeader('Access-Control-Allow-Origin', 'http://localhost:8080')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});

// Catch-all route to serve a 404 Not Found page if none of the routes match
// NOTE: make sure this route is defined last
$app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function($req, $res) {
    $handler = $this->notFoundHandler; // handle using the default Slim page not found handler
    return $handler($req, $res);
});
>>>>>>> Actualizacion Arturo. Nuevo push para que Ruben vea version actualizada


$app->run();

?>
