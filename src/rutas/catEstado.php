<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

//Obtener Los Estados
$app->get('/api/catEstado', function (Request $request, Response $response) {

    $consulta = "select * from cat_estado";

    $limit = $request->getParam('limit');
    $page = $request->getParam('page');

    $pageReal = (isset($page) && $page > 0) ? $page : 1;
    $limit = isset($limit) ? $limit : 10;
    $offset = (--$pageReal) * $limit;

    $count = "SELECT COUNT(*) as Total FROM cat_estado";

    try {

        //Instanciacion de base de datos
        $db = new db();
        $db = $db->conectar();
        $ejecutar = $db->query($consulta);
        $catestado = $ejecutar->fetchAll(PDO::FETCH_OBJ);
        $db = null;

        $db = new db();
        $db = $db->conectar();
        $ejecutar1 = $db->query($count);
        $stmt2 = $ejecutar1->fetchAll(PDO::FETCH_OBJ);
        $db = null;

        if ($catestado) {
            return $response->withStatus(200)
                ->withHeader('Content-Type', 'application/json')
                ->write(json_encode($catestado, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
        }

    } catch (PDOException $e) {
        echo '{"error": {"text": ' . $e->getMessage() . '}';
    }

});

//Obtener Estado en especifico
$app->get('/api/catEstado/', function (Request $request, Response $response) {

    $NombEstado = $request->getParam('NomEstado');

    $consulta = "select * from cat_estado WHERE NomEstado LIKE '%$NombEstado%';";

    try {

        //Instanciacion de base de datos
        $db = new db();
        $db = $db->conectar();
        $ejecutar = $db->query($consulta);
        $catestado = $ejecutar->fetchAll(PDO::FETCH_OBJ);
        $db = null;

        if ($catestado) {
            return $response->withStatus(200)
                ->withHeader('Content-Type', 'application/json')
                ->write(json_encode($catestado, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
        }

    } catch (PDOException $e) {
        echo '{"error": {"text": ' . $e->getMessage() . '}';
    }

});

//Agregar Estado
$app->post('/api/catEstado/agregar', function (Request $request, Response $response) {

    $NombEstado = $request->getParam('NomEstado');

    $consulta = "INSERT INTO cat_estado(NomEstado)
                       values (:NomEstado)";

    try {

        //Instanciacion de base de datos
        $db = new db();
        $db = $db->conectar();
        $stmt = $db->prepare($consulta);
        $stmt->bindParam(':NomEstado', $NombEstado);
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

//Actualizar Estado
$app->put('/api/catEstado/actualizar/', function (Request $request, Response $response) {

    $id = $request->getParam('IdEstado');
    $NombEstado = $request->getParam('NomEstado');

    $consulta = "UPDATE cat_estado SET
                     NomEstado = :NomEstado
                     WHERE IdEstado = $id";

    try {

        //Instanciacion de base de datos
        $db = new db();
        $db = $db->conectar();
        $stmt = $db->prepare($consulta);
        $stmt->bindParam(':NomEstado', $NombEstado);
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

//Eliminar Estado
$app->delete('/api/catEstado/eliminar/', function (Request $request, Response $response) {

    $id = $request->getParam('IdEstado');

    $consulta = "DELETE FROM cat_estado WHERE IdEstado = $id;";

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
