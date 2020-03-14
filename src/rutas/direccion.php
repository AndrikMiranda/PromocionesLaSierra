<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

//Obtener Direccion
$app -> get('/api/direccion', function(Request $request, Response $response){

    $consulta = "SELECT a.IdDireccion,b.NomEstado,c.NomMunicipio,d.NomColonia,
                 e.Tipo,e.NomCalle,d.CP,a.NumExterior,a.NumInterior
                 FROM direccion a,cat_estado b,cat_municipio c,cat_colonia d,cat_calle e
                 WHERE a.FkEstado = b.IdEstado AND a.FkMunicipio = c.IdMunicipio
                 AND a.FkColonia = d.IdColonia AND a.FkCalle = e.IdCalle
                 ORDER BY a.IdDireccion";

    try {

          //Instanciacion de base de datos
           $db = new db();
           $db = $db -> conectar();
           $ejecutar = $db -> query($consulta);
           $Direcccion = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
           $db = null;

           //Exportar y mostrar JSON
           echo json_encode($Direcccion, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

       } catch (PDOException $e) {
           echo '{"error": {"text": '.$e -> getMessage().'}';
       }

});
//obtener Direccion por Colonia
$app -> get('/api/direccion/{NombreDir}', function(Request $request, Response $response){

    $NombreDir = $request -> getAttribute('NombreDir');

      $consulta = "SELECT a.IdDireccion,b.NomEstado,c.NomMunicipio,d.NomColonia,
                   e.Tipo,e.NomCalle,d.CP,a.NumExterior,a.NumInterior
                   FROM direccion a,cat_estado b,cat_municipio c,cat_colonia d,cat_calle e
                   WHERE a.FkEstado = b.IdEstado AND a.FkMunicipio = c.IdMunicipio
                   AND a.FkColonia = d.IdColonia AND a.FkCalle = e.IdCalle
                   AND NomColonia LIKE '%$NombreDir%'
                   ORDER BY a.IdDireccion";

      try {

        //Instanciacion de base de datos
          $db = new db();
          $db = $db -> conectar();
          $ejecutar = $db -> query($consulta);
          $Direcccion = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
          $db = null;

          //Exportar y mostrar JSON
          echo json_encode($Direcccion);

      } catch (PDOException $e) {
        echo '{"error": {"text": '.$e -> getMessage().'}';
      }


    });

    //Agregar Direccion
    $app -> post('/api/direccion/agregar', function(Request $request, Response $response){

        $estado = $request -> getParam('FkEstado');
        $municipio = $request -> getParam('FkMunicipio');
        $colonia = $request -> getParam('FkColonia');
        $calle = $request -> getParam('FkCalle');
        $calle2 = $request -> getParam('FkCalle2');
        $numext = $request -> getParam('NumExt');
        $numint = $request -> getParam('NumInt');

          $consulta = "INSERT INTO direccion(FkEstado,FkMunicipio,FkColonia,FkCalle, FkCalle2, NumExterior,NumInterior)
                                     values (:FkEstado, :FkMunicipio, :FkColonia, :FkCalle, :FkCalle2, :NumExt, :NumInt)";

          try {

            //Instanciacion de base de datos
              $db = new db();
              $db = $db -> conectar();
              $stmt = $db -> prepare($consulta);
              $stmt -> bindParam(':FkEstado', $estado);
              $stmt -> bindParam(':FkMunicipio', $municipio);
              $stmt -> bindParam(':FkColonia', $colonia);
              $stmt -> bindParam(':FkCalle', $calle);
              $stmt -> bindParam(':FkCalle2', $calle);
              $stmt -> bindParam(':NumExt', $numext);
              $stmt -> bindParam(':NumInt', $numint);
              $stmt -> execute();
              echo '{"notice": {"text": "Direccion agregada"}';
              //Exportar y mostrar JSON

          } catch (PDOException $e) {
            echo '{"error": {"text": '.$e -> getMessage().'}';
          }


        });

                 //Actualizar Direccion
    $app -> put('/api/direccion/actualizar/{IdDireccion}', function(Request $request, Response $response){

        $id = $request -> getAttribute('IdDireccion');
        $estado = $request -> getParam('Estado');
        $municipio = $request -> getParam('Municipio');
        $colonia = $request -> getParam('Colonia');
        $calle = $request -> getParam('Calle');
        $numext = $request -> getParam('NumExt');
        $numint = $request -> getParam('NumInt');


        $consulta = "UPDATE direccion SET
                     FkEstado = :Estado,
                     FkMunicipio = :Municipio,
                     FkColonia = :Colonia,
                     FkCalle = :Calle,
                     NumExterior = :NumExt,
                     NumInterior = :NumInt
                     WHERE IdDireccion = $id";

        try {

          //Instanciacion de base de datos
            $db = new db();
            $db = $db -> conectar();
            $stmt = $db -> prepare($consulta);
            $stmt -> bindParam(':Estado', $estado);
            $stmt -> bindParam(':Municipio', $municipio);
            $stmt -> bindParam(':Colonia', $colonia);
            $stmt -> bindParam(':Calle', $calle);
            $stmt -> bindParam(':NumExt', $numext);
            $stmt -> bindParam(':NumInt', $numint);
            $stmt -> execute();
            echo '{"notice": {"text": "Direccion actualizada"}';
            //Exportar y mostrar JSON

        } catch (PDOException $e) {
          echo '{"error": {"text": '.$e -> getMessage().'}';
        }

      });

            //Eliminar Direccion
    $app -> delete('/api/direccion/eliminar/{IdDireccion}', function(Request $request, Response $response){

        $id = $request -> getAttribute('IdDireccion');

          $consulta = "DELETE FROM direccion WHERE IdDireccion = $id;";

          try {

            //Instanciacion de base de datos
              $db = new db();
              $db = $db -> conectar();
              $stmt = $db -> query($consulta);
              $stmt -> execute();
              $db = null;
              echo '{"notice": {"text": "Direccion borrada"}';
          } catch (PDOException $e) {
            echo '{"error": {"text": '.$e -> getMessage().'}';
          }


        });

?>
