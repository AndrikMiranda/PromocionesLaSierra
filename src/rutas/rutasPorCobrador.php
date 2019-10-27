<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/*
    -> Asignar Ruta a Cobrador
    -> Cobradores por Ruta
    -> Cobradores sin Ruta asignada
    -> Desasignar Cobrador de una Ruta
    -> Rutas con sus cobradores asignados, ordenados por ruta.
*/

//Asignar ruta a cobrador
$app->post('/api/rutaCobrador/agregarRelacion', function (Request $request, Response $response) {

    $FkRuta = $request->getParam('fkRuta');
    $FkCobrador = $request->getParam('fkUsuario');

    $consulta = "INSERT INTO ruta_cobrador(fkRuta,fkUsuario)
                   values (:FkRuta, :FkCobrador)";

    try {

        if ($FkCobrador == 2) {
            //Instanciacion de base de datos
            $db = new db();
            $db = $db->conectar();
            $stmt = $db->prepare($consulta);
            $stmt->bindParam(':FkRuta', $FkRuta);
            $stmt->bindParam(':FkCobrador', $FkCobrador);
            $stmt->execute();
            echo '{"notice": {"text": "Ruta asignada satisfactoriamente."}';
        } else {
            echo '{"notice": {"text": "Solo se permiten agregar usuarios tipo cobrador. Intentalo de nuevo."}';
        }

    } catch (PDOException $e) {
        echo '{"error": {"text": ' . $e->getMessage() . '}';
    }

});

//Cobradores por ruta
$app->get('/api/rutaCobrador/cobradoresPorRuta/{NumeroRuta}', function (Request $request, Response $response) {

    $NumeroRuta = $request->getParam('NumeroRuta');

    $consulta = "SELECT
                ruta_cobrador.fkRuta,
                ruta.NumeroRuta,
                ruta_cobrador.fkUsuario,
                usuario.Nombre,
                usuario.FkCat_Estatus_Usuario
                FROM
                ruta_cobrador
                INNER JOIN usuario ON ruta_cobrador.fkUsuario = usuario.IdUsuario
                INNER JOIN ruta ON ruta_cobrador.fkRuta = ruta.IdRuta
                where ruta.NumeroRuta = '$NumeroRuta'";

    try {

        $db = new db();
        $db = $db->conectar();
        $ejecutar = $db->query($consulta);
        $resultado = $ejecutar->fetchAll(PDO::FETCH_OBJ);
        $db = null;

        echo json_encode($resultado);

    } catch (PDOException $e) {
        echo '{"error": {"text": ' . $e->getMessage() . '}';
    }

});

//Cobradores SIN ruta asiganada
$app->get('/api/rutaCobrador/cobradoresSinRuta', function (Request $request, Response $response) {

    $consulta = "SELECT
                usuario.IdUsuario,
                usuario.Nombre,
                usuario.FkCat_Estatus_Usuario
                FROM
                ruta_cobrador
                INNER JOIN usuario ON ruta_cobrador.fkUsuario = usuario.IdUsuario
                WHERE usuario.IdUsuario NOT IN (SELECT ruta_cobrador.fkUsuario
                                                FROM ruta_cobrador)";

    try {

        $db = new db();
        $db = $db->conectar();
        $ejecutar = $db->query($consulta);
        $resultado = $ejecutar->fetchAll(PDO::FETCH_OBJ);
        $db = null;

        echo json_encode($resultado);

    } catch (PDOException $e) {
        echo '{"error": {"text": ' . $e->getMessage() . '}';
    }

});

//Desasignar cobrador de ruta
$app->delete('/api/rutaCobrador/desasignarCobrador/{fkUsuario}', function (Request $request, Response $response) {

    $FkUsuario = $request->getParam('fkUsuario');

    $consulta = "DELETE
                 FROM ruta_cobrador
                 WHERE ruta_cobrador.fkUsuario = '$FkUsuario'";

    try {

        $db = new db();
        $db = $db->conectar();
        $ejecutar = $db->query($consulta);
        $resultado = $ejecutar->fetchAll(PDO::FETCH_OBJ);
        $db = null;

        echo '{"notice": {"text": "Ruta desasignada satisfactoriamente."}';

    } catch (PDOException $e) {
        echo '{"error": {"text": ' . $e->getMessage() . '}';
    }

});

//Todas las rutas con todos sus cobradores, ordenados por ruta.
$app->get('/api/rutaCobrador/todos/', function (Request $request, Response $response) {

    $consulta = "SELECT
                ruta_cobrador.fkRuta,
                ruta.NumeroRuta,
                ruta_cobrador.fkUsuario,
                usuario.Nombre,
                usuario.FkCat_Estatus_Usuario
                FROM
                ruta_cobrador
                INNER JOIN ruta ON ruta_cobrador.fkRuta = ruta.IdRuta
                INNER JOIN usuario ON ruta_cobrador.fkUsuario = usuario.IdUsuario
                WHERE usuario.FkCat_TipoUsuario = 2
                ORDER BY ruta.NumeroRuta DESC";

    try {

        $db = new db();
        $db = $db->conectar();
        $ejecutar = $db->query($consulta);
        $resultado = $ejecutar->fetchAll(PDO::FETCH_OBJ);
        $db = null;

        echo json_encode($resultado);

    } catch (PDOException $e) {
        echo '{"error": {"text": ' . $e->getMessage() . '}';
    }

});


