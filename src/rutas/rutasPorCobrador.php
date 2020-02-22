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

    $FkRuta = $request->getParam('NumeroRuta');
    $FkUsuario = $request->getParam('IdUsuario');
    $FkCat_TipoUsuario = $request->getParam('FkCat_TipoUsuario');

    $consulta = "INSERT INTO ruta_cobrador(fkRuta,fkUsuario)
                   values (:FkRuta, :FkCobrador)";

    try {

        if ($FkCat_TipoUsuario == 2) {
            //Instanciacion de base de datos
            $db = new db();
            $db = $db->conectar();
            $stmt = $db->prepare($consulta);
            $stmt->bindParam(':FkRuta', $FkRuta);
            $stmt->bindParam(':FkCobrador', $FkUsuario);
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
$app->get('/api/rutaCobrador/cobradoresPorRuta/NumeroRuta/', function (Request $request, Response $response) {

    $NumeroRuta = $request->getParam('NumeroRuta');
    $limit = $request -> getParam('limit');
    $page = $request -> getParam('page');
  
  $pageReal = (isset( $page ) && $page > 0) ? $page : 1;
  $limit = isset( $limit ) ? $limit : 10;
  $offset = (--$pageReal) * $limit;
  
  $count = "SELECT COUNT(*) as Total FROM ruta_cobrador WHERE ruta_cobrador.fkRuta = $NumeroRuta";

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
                WHERE ruta_cobrador.fkRuta = $NumeroRuta
                LIMIT $limit
                OFFSET $offset";

    try {

        $db = new db();
        $db = $db->conectar();
        $ejecutar = $db->query($consulta);
        $resultado = $ejecutar->fetchAll(PDO::FETCH_OBJ);
        $db = null;

        $db = new db();
        $db = $db->conectar();
        $ejecutar1 = $db -> query($count);
        $stmt2 = $ejecutar1 -> fetchAll(PDO::FETCH_OBJ);
        $db = null;

      //Exportar y mostrar JSON
       if($resultado) {
        return $response->withStatus(200)
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($resultado, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
        }

        
    } catch (PDOException $e) {
        echo '{"error": {"text": ' . $e->getMessage() . '}';
    }

});

//Cobradores SIN ruta asiganada
$app->get('/api/rutaCobrador/cobradoresSinRuta/', function (Request $request, Response $response) {
    
    $limit = $request -> getParam('limit');
    $page = $request -> getParam('page');
  
    $pageReal = (isset( $page ) && $page > 0) ? $page : 1;
    $limit = isset( $limit ) ? $limit : 10;
    $offset = (--$pageReal) * $limit;
  
    $count = "SELECT COUNT(*) as Total FROM usuario WHERE usuario.IdUsuario NOT IN (SELECT ruta_cobrador.fkUsuario
    FROM ruta_cobrador) AND
    usuario.FkCat_TipoUsuario = 2";
  
    $consulta = "SELECT
                usuario.IdUsuario,
                usuario.Nombre,
                usuario.FkCat_Estatus_Usuario,
                usuario.FkCat_TipoUsuario
                FROM
                usuario
                WHERE usuario.IdUsuario NOT IN (SELECT ruta_cobrador.fkUsuario
                                                FROM ruta_cobrador) AND
                usuario.FkCat_TipoUsuario = 2
                LIMIT $limit
                OFFSET $offset";

    try {

        $db = new db();
        $db = $db->conectar();
        $ejecutar = $db->query($consulta);
        $resultado = $ejecutar->fetchAll(PDO::FETCH_OBJ);
        $db = null;

        $db = new db();
        $db = $db->conectar();
        $ejecutar1 = $db -> query($count);
        $stmt2 = $ejecutar1 -> fetchAll(PDO::FETCH_OBJ);
        $db = null;

      //Exportar y mostrar JSON
        if($resultado) {
        return $response->withStatus(200)
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($resultado, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
        }


    } catch (PDOException $e) {
        echo '{"error": {"text": ' . $e->getMessage() . '}';
    }

});

//Desasignar cobrador de ruta
$app->delete('/api/rutaCobrador/desasignarCobrador/{fkUsuario}', function (Request $request, Response $response) {

    $FkUsuario = $request->getAttribute('fkUsuario');

    $consulta = "DELETE
                 FROM ruta_cobrador
                 WHERE ruta_cobrador.fkUsuario = $FkUsuario";

    try {

        $db = new db();
        $db = $db->conectar();
        $ejecutar = $db->query($consulta);
        $ejecutar -> execute();
        $db = null;

        echo '{"notice": {"text": "Ruta desasignada satisfactoriamente."}';
        if($resultado) {
        return $response->withStatus(200)
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($resultado, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
        }

    } catch (PDOException $e) {
        echo '{"error": {"text": ' . $e->getMessage() . '}';
    }

});

//Todas las rutas con todos sus cobradores, ordenados por ruta.
$app->get('/api/rutaCobrador/todos/', function (Request $request, Response $response) {
    
    $limit = $request -> getParam('limit');
    $page = $request -> getParam('page');
  
    $pageReal = (isset( $page ) && $page > 0) ? $page : 1;
    $limit = isset( $limit ) ? $limit : 10;
    $offset = (--$pageReal) * $limit;
  
    $count = "SELECT COUNT(*) as Total FROM ruta_cobrador WHERE usuario.FkCat_TipoUsuario = 2
                ORDER BY ruta.NumeroRuta DESC";
    
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
                ORDER BY ruta.NumeroRuta DESC
                LIMIT $limit
                OFFSET $offset";

    try {

        $db = new db();
        $db = $db->conectar();
        $ejecutar = $db->query($consulta);
        $resultado = $ejecutar->fetchAll(PDO::FETCH_OBJ);
        $db = null;

        $db = new db();
        $db = $db->conectar();
        $ejecutar1 = $db -> query($count);
        $stmt2 = $ejecutar1 -> fetchAll(PDO::FETCH_OBJ);
        $db = null;

      //Exportar y mostrar JSON
        if($resultado) {
        return $response->withStatus(200)
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($resultado, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
        }

    } catch (PDOException $e) {
        echo '{"error": {"text": ' . $e->getMessage() . '}';
    }

});


