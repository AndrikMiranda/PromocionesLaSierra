<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

//Obtener Lio
$app->get('/api/lio', function (Request $request, Response $response) {

    $consulta = "SELECT IdLio,TipoLio
                 FROM cat_lio
                 ORDER BY IdLio";

    $limit = $request->getParam('limit');
    $page = $request->getParam('page');

    $pageReal = (isset($page) && $page > 0) ? $page : 1;
    $limit = isset($limit) ? $limit : 10;
    $offset = (--$pageReal) * $limit;

    $count = "SELECT COUNT(*) as Total FROM cat_lio";

    try {

        //Instanciacion de base de datos
        $db = new db();
        $db = $db->conectar();
        $ejecutar = $db->query($consulta);
        $Lio = $ejecutar->fetchAll(PDO::FETCH_OBJ);
        $db = null;

        $db = new db();
        $db = $db->conectar();
        $ejecutar1 = $db->query($count);
        $stmt2 = $ejecutar1->fetchAll(PDO::FETCH_OBJ);
        $db = null;

        if ($Lio) {
            return $response->withStatus(200)
                ->withHeader('Content-Type', 'application/json')
                ->write(json_encode($Lio, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
        }

    } catch (PDOException $e) {
        echo '{"error": {"text": ' . $e->getMessage() . '}';
    }

});

//obtener Lio en especifico
$app->get('/api/lio/', function (Request $request, Response $response) {

    $TipoLio = $request->getParam('TipoLio');

    $consulta = "SELECT IdLio,TipoLio
                   FROM cat_lio
                   WHERE TipoLio LIKE '%$TipoLio%'
                   ORDER BY IdLio;";

    try {

        //Instanciacion de base de datos
        $db = new db();
        $db = $db->conectar();
        $ejecutar = $db->query($consulta);
        $Lio = $ejecutar->fetchAll(PDO::FETCH_OBJ);
        $db = null;

        if ($Lio) {
            return $response->withStatus(200)
                ->withHeader('Content-Type', 'application/json')
                ->write(json_encode($Lio, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
        }

    } catch (PDOException $e) {
        echo '{"error": {"text": ' . $e->getMessage() . '}';
    }

});

//Agregar Lio
$app->post('/api/lio/agregar', function (Request $request, Response $response) {

    $TipoLio = $request->getParam('TipoLio');

    $consulta = "INSERT INTO cat_lio(TipoLio)
                       values (:TipoLio)";

    try {

        //Instanciacion de base de datos
        $db = new db();
        $db = $db->conectar();
        $stmt = $db->prepare($consulta);
        $stmt->bindParam(':TipoLio', $TipoLio);
        $stmt->execute();

        if ($stmt) {
            return $response->withStatus(200)
                ->withHeader('Content-Type', 'application/json')
                ->write(json_encode($stmt, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
        }

    } catch (PDOException $e) {
        echo '{"error": {"text": ' . $e->getMessage() . '}';
    }

});

//Actualizar Lio
$app->put('/api/lio/actualizar/', function (Request $request, Response $response) {

    $id = $request->getParam('IdLio');
    $TipoLio = $request->getParam('TipoLio');

    $consulta = "UPDATE cat_lio SET
                     TipoLio = :TipoLio
                     WHERE IdLio = $id";

    try {

        //Instanciacion de base de datos
        $db = new db();
        $db = $db->conectar();
        $stmt = $db->prepare($consulta);
        $stmt->bindParam(':TipoLio', $TipoLio);
        $stmt->execute();

        if ($stmt) {
            return $response->withStatus(200)
                ->withHeader('Content-Type', 'application/json')
                ->write(json_encode($stmt, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
        }

    } catch (PDOException $e) {
        echo '{"error": {"text": ' . $e->getMessage() . '}';
    }

});

//Eliminar Tipo de Lio
$app->delete('/api/lio/eliminar/', function (Request $request, Response $response) {

    $id = $request->getParam('IdLio');

    $consulta = "DELETE FROM cat_lio WHERE IdLio = $id;";

    try {

        //Instanciacion de base de datos
        $db = new db();
        $db = $db->conectar();
        $stmt = $db->query($consulta);
        $stmt->execute();
        $db = null;

        if ($stmt) {
            return $response->withStatus(200)
                ->withHeader('Content-Type', 'application/json')
                ->write(json_encode($stmt, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
        }

    } catch (PDOException $e) {
        echo '{"error": {"text": ' . $e->getMessage() . '}';
    }

});
