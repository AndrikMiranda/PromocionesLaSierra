<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/*
  -> Obtener todas las las colonias que pertenecen a una ruta.
  -> Obtener colonias por ruta asignada
  -> Colonias de una ruta especifica.
  -> Agregar colonia a una ruta.
  -> Actualizar Ruta, dando el idRuta de la tabla ruta.
  -> Eliminar colonia de una ruta de la tabla ruta.
  -> Eliminar colonia de una ruta de la tabla ruta dado un NumeroRuta y un FkColonia.
 */
 
//Obtener Ruta
$app->get('/api/ruta', function (Request $request, Response $response) {

    $consulta = "SELECT
                ruta.IdRuta,
                ruta.NumeroRuta,
                ruta.FkColonia,
                cat_colonia.NomColonia,
                cat_colonia.CP
                FROM
                ruta
                INNER JOIN cat_colonia ON ruta.FkColonia = cat_colonia.IdColonia
                ORDER BY ruta.IdRuta";

    try {

        //Instanciacion de base de datos
        $db = new db();
        $db = $db->conectar();
        $ejecutar = $db->query($consulta);
        $Ruta = $ejecutar->fetchAll(PDO::FETCH_OBJ);
        $db = null;

        //Exportar y mostrar JSON
        echo json_encode($Ruta, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

    } catch (PDOException $e) {
        echo '{"error": {"text": ' . $e->getMessage() . '}';
    }

});


//Obtener colonias por ruta asignada
$app->get('/api/ruta/coloniasPorRuta', function (Request $request, Response $response) {

    $consulta = "SELECT
                cat_colonia.IdColonia,
                cat_colonia.NomColonia,
                cat_colonia.CP,
                ruta.IdRuta,
                ruta.NumeroRuta
                FROM
                ruta
                INNER JOIN cat_colonia ON ruta.FkColonia = cat_colonia.IdColonia";

    try {

        //Instanciacion de base de datos
        $db = new db();
        $db = $db->conectar();
        $ejecutar = $db->query($consulta);
        $Ruta = $ejecutar->fetchAll(PDO::FETCH_OBJ);
        $db = null;

        //Exportar y mostrar JSON
        echo json_encode($Ruta, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

    } catch (PDOException $e) {
        echo '{"error": {"text": ' . $e->getMessage() . '}';
    }

});


//Obtener Ruta Especifica
$app->get('/api/ruta/{NumeroRuta}', function (Request $request, Response $response) {

    $NumeroRuta = $request->getAttribute('NumeroRuta');

    $consulta = "SELECT
                ruta.IdRuta,
                ruta.NumeroRuta,
                ruta.FkColonia,
                cat_colonia.NomColonia,
                cat_colonia.CP
                FROM
                ruta
                INNER JOIN cat_colonia ON ruta.FkColonia = cat_colonia.IdColonia
                where ruta.NumeroRuta = '$NumeroRuta'
                ORDER BY ruta.IdRuta";

    try {

        //Instanciacion de base de datos
        $db = new db();
        $db = $db->conectar();
        $ejecutar = $db->query($consulta);
        $Ruta = $ejecutar->fetchAll(PDO::FETCH_OBJ);
        $db = null;

        //Exportar y mostrar JSON
        echo json_encode($Ruta, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

    } catch (PDOException $e) {
        echo '{"error": {"text": ' . $e->getMessage() . '}';
    }

});

//Agregar colonia a una ruta
$app->post('/api/ruta/agregar', function (Request $request, Response $response) {

    $NumeroRuta = $request->getParam('NumeroRuta');
    $FkColonia = $request->getParam('FkColonia');

    $consulta = "INSERT INTO ruta(NumeroRuta,FkColonia)
                       values (:NumeroRuta, :FkColonia)";

    try {

        //Instanciacion de base de datos
        $db = new db();
        $db = $db->conectar();
        $stmt = $db->prepare($consulta);
        $stmt->bindParam(':NumeroRuta', $NumeroRuta);
        $stmt->bindParam(':FkColonia', $FkColonia);
        $stmt->execute();
        echo '{"notice": {"text": "Ruta Agregada"}';
        //Exportar y mostrar JSON

    } catch (PDOException $e) {
        echo '{"error": {"text": ' . $e->getMessage() . '}';
    }

});

//Actualizar Ruta
$app->put('/api/ruta/actualizar/{IdRuta}', function (Request $request, Response $response) {

    $id = $request->getAttribute('IdRuta');
    $NumeroRuta = $request->getParam('NumeroRuta');
    $FkColonia = $request->getParam('FkColonia');

    $consulta = "UPDATE ruta SET
                     NumeroRuta = :NumeroRuta,
                     FkColonia = :FkColonia
                     WHERE IdRuta = $id";

    try {

        //Instanciacion de base de datos
        $db = new db();
        $db = $db->conectar();
        $stmt = $db->prepare($consulta);
        $stmt->bindParam(':NumeroRuta', $NumeroRuta);
        $stmt->bindParam(':FkColonia', $FkColonia);
        $stmt->execute();
        echo '{"notice": {"text": "Ruta actualizada"}';
        //Exportar y mostrar JSON

    } catch (PDOException $e) {
        echo '{"error": {"text": ' . $e->getMessage() . '}';
    }

});

//Eliminar colonia de una ruta de la tabla ruta dado un idRuta.
$app->delete('/api/ruta/eliminar/{IdRuta}', function (Request $request, Response $response) {

    $id = $request->getAttribute('IdRuta');

    $consulta = "DELETE 
                 FROM ruta 
                 WHERE IdRuta = $id;";

    try {

        //Instanciacion de base de datos
        $db = new db();
        $db = $db->conectar();
        $stmt = $db->query($consulta);
        $stmt->execute();
        $db = null;
        echo '{"notice": {"text": "Ruta Eliminada"}';
    } catch (PDOException $e) {
        echo '{"error": {"text": ' . $e->getMessage() . '}';
    }

});




//Eliminar colonia de una ruta de la tabla ruta dado un NumeroRuta y un FkColonia.
$app->delete('/api/ruta/eliminar/{NumeroRuta}/{FkColonia}', function (Request $request, Response $response) {

  $numeroRuta = $request->getAttribute('NumeroRuta');
  $fkColonia = $request->getAttribute('FkColonia');

  $consulta = "DELETE 
               FROM ruta 
               WHERE NumeroRuta = $numeroRuta AND
                     FkColonia = $fkColonia;";

  try {

      //Instanciacion de base de datos
      $db = new db();
      $db = $db->conectar();
      $stmt = $db->query($consulta);
      $stmt->execute();
      $db = null;
      echo '{"notice": {"text": "Ruta Eliminada"}';
  } catch (PDOException $e) {
      echo '{"error": {"text": ' . $e->getMessage() . '}';
  }

});


//Obtener colonias que no han sido asigandas a ninguna ruta.
$app->get('/api/ruta/coloniasSinRuta', function (Request $request, Response $response) {

    $consulta = "SELECT cat_colonia.IdColonia, cat_colonia.NomColonia, cat_colonia.CP
    FROM cat_colonia
    WHERE cat_colonia.IdColonia NOT IN (SELECT DISTINCT ruta.FkColonia FROM ruta)";

    try {

        //Instanciacion de base de datos
        $db = new db();
        $db = $db->conectar();
        $ejecutar = $db->query($consulta);
        $Ruta = $ejecutar->fetchAll(PDO::FETCH_OBJ);
        $db = null;

        //Exportar y mostrar JSON
        echo json_encode($Ruta, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
        
    } catch (PDOException $e) {
        echo '{"error": {"text": ' . $e->getMessage() . '}';
    }

});

?>