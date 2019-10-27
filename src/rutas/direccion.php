<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

//Obtener Direccion
$app -> get('/api/direccion', function(Request $request, Response $response){

    $consulta = "SELECT a.IdDireccion,b.NomEstado,c.NomMunicipio,d.NomColonia,
                 e.Tipo,e.NomCalle,d.CP,a.NumExterior,a.NumInterior
                 FROM direccion a,cat_estado b,cat_municipio c,cat_colonia d,cat_calle e
<<<<<<< HEAD
                 WHERE a.FkEstado = b.IdEstado AND a.FkMunicipio = c.IdMunicipio 
                 AND a.FkColonia = d.IdColonia AND a.FkCalle = e.IdCalle
                 ORDER BY a.IdDireccion";
 
    try {
 
=======
                 WHERE a.FkEstado = b.IdEstado AND a.FkMunicipio = c.IdMunicipio
                 AND a.FkColonia = d.IdColonia AND a.FkCalle = e.IdCalle
                 ORDER BY a.IdDireccion";

    try {

>>>>>>> Actualizacion Arturo. Nuevo push para que Ruben vea version actualizada
          //Instanciacion de base de datos
           $db = new db();
           $db = $db -> conectar();
           $ejecutar = $db -> query($consulta);
           $Direcccion = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
           $db = null;
<<<<<<< HEAD
 
           //Exportar y mostrar JSON
           echo json_encode($Direcccion, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
 
       } catch (PDOException $e) {
           echo '{"error": {"text": '.$e -> getMessage().'}';
       }
 
=======

           //Exportar y mostrar JSON
           echo json_encode($Direcccion, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

       } catch (PDOException $e) {
           echo '{"error": {"text": '.$e -> getMessage().'}';
       }

>>>>>>> Actualizacion Arturo. Nuevo push para que Ruben vea version actualizada
});
//obtener Direccion por Colonia
$app -> get('/api/direccion/{NombreDir}', function(Request $request, Response $response){

    $NombreDir = $request -> getAttribute('NombreDir');
<<<<<<< HEAD
    
      $consulta = "SELECT a.IdDireccion,b.NomEstado,c.NomMunicipio,d.NomColonia,
                   e.Tipo,e.NomCalle,d.CP,a.NumExterior,a.NumInterior
                   FROM direccion a,cat_estado b,cat_municipio c,cat_colonia d,cat_calle e
                   WHERE a.FkEstado = b.IdEstado AND a.FkMunicipio = c.IdMunicipio 
                   AND a.FkColonia = d.IdColonia AND a.FkCalle = e.IdCalle
                   AND NomColonia LIKE '%$NombreDir%'
                   ORDER BY a.IdDireccion";
    
      try {
    
=======

      $consulta = "SELECT a.IdDireccion,b.NomEstado,c.NomMunicipio,d.NomColonia,
                   e.Tipo,e.NomCalle,d.CP,a.NumExterior,a.NumInterior
                   FROM direccion a,cat_estado b,cat_municipio c,cat_colonia d,cat_calle e
                   WHERE a.FkEstado = b.IdEstado AND a.FkMunicipio = c.IdMunicipio
                   AND a.FkColonia = d.IdColonia AND a.FkCalle = e.IdCalle
                   AND NomColonia LIKE '%$NombreDir%'
                   ORDER BY a.IdDireccion";

      try {

>>>>>>> Actualizacion Arturo. Nuevo push para que Ruben vea version actualizada
        //Instanciacion de base de datos
          $db = new db();
          $db = $db -> conectar();
          $ejecutar = $db -> query($consulta);
          $Direcccion = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
          $db = null;
<<<<<<< HEAD
    
          //Exportar y mostrar JSON
          echo json_encode($Direcccion);
    
      } catch (PDOException $e) {
        echo '{"error": {"text": '.$e -> getMessage().'}';
      }
    
    
=======

          //Exportar y mostrar JSON
          echo json_encode($Direcccion);

      } catch (PDOException $e) {
        echo '{"error": {"text": '.$e -> getMessage().'}';
      }


>>>>>>> Actualizacion Arturo. Nuevo push para que Ruben vea version actualizada
    });

    //Agregar Direccion
    $app -> post('/api/direccion/agregar', function(Request $request, Response $response){

<<<<<<< HEAD
        $estado = $request -> getParam('Estado');
        $municipio = $request -> getParam('Municipio');
        $colonia = $request -> getParam('Colonia');
        $calle = $request -> getParam('Calle');
        $numext = $request -> getParam('NumExt');
        $numint = $request -> getParam('NumInt');
         
          $consulta = "INSERT INTO direccion(FkEstado,FkMunicipio,FkColonia,
                       FkCalle,NumExterior,NumInterior)
                       values (:Estado, :Municipio, :Colonia, :Calle, :NumExt, :NumInt)";
        
          try {
        
=======
        $estado = $request -> getParam('FkEstado');
        $municipio = $request -> getParam('FkMunicipio');
        $colonia = $request -> getParam('FkColonia');
        $calle = $request -> getParam('FkCalle');
        $calle2 = $request -> getParam('FkCalle2');
        $numext = $request -> getParam('NumExt');
        $numint = $request -> getParam('NumInt');

          $consulta = "INSERT INTO direccion(FkEstado,FkMunicipio,FkColonia,
                       FkCalle,NumExterior,NumInterior)
                       values (:FkEstado, :FkMunicipio, :FkColonia, :FkCalle, :FkCalle2, :NumExt, :NumInt)";

          try {

>>>>>>> Actualizacion Arturo. Nuevo push para que Ruben vea version actualizada
            //Instanciacion de base de datos
              $db = new db();
              $db = $db -> conectar();
              $stmt = $db -> prepare($consulta);
<<<<<<< HEAD
              $stmt -> bindParam(':Estado', $estado);
              $stmt -> bindParam(':Municipio', $municipio);
              $stmt -> bindParam(':Colonia', $colonia);
              $stmt -> bindParam(':Calle', $calle);
=======
              $stmt -> bindParam(':FkEstado', $estado);
              $stmt -> bindParam(':FkMunicipio', $municipio);
              $stmt -> bindParam(':FkColonia', $colonia);
              $stmt -> bindParam(':FkCalle', $calle);
>>>>>>> Actualizacion Arturo. Nuevo push para que Ruben vea version actualizada
              $stmt -> bindParam(':NumExt', $numext);
              $stmt -> bindParam(':NumInt', $numint);
              $stmt -> execute();
              echo '{"notice": {"text": "Direccion agregada"}';
              //Exportar y mostrar JSON
<<<<<<< HEAD
        
          } catch (PDOException $e) {
            echo '{"error": {"text": '.$e -> getMessage().'}';
          }
        
        
=======

          } catch (PDOException $e) {
            echo '{"error": {"text": '.$e -> getMessage().'}';
          }


>>>>>>> Actualizacion Arturo. Nuevo push para que Ruben vea version actualizada
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
<<<<<<< HEAD
      
      
=======


>>>>>>> Actualizacion Arturo. Nuevo push para que Ruben vea version actualizada
        $consulta = "UPDATE direccion SET
                     FkEstado = :Estado,
                     FkMunicipio = :Municipio,
                     FkColonia = :Colonia,
                     FkCalle = :Calle,
                     NumExterior = :NumExt,
                     NumInterior = :NumInt
                     WHERE IdDireccion = $id";
<<<<<<< HEAD
      
        try {
      
=======

        try {

>>>>>>> Actualizacion Arturo. Nuevo push para que Ruben vea version actualizada
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
<<<<<<< HEAD
      
        } catch (PDOException $e) {
          echo '{"error": {"text": '.$e -> getMessage().'}';
        }
      
=======

        } catch (PDOException $e) {
          echo '{"error": {"text": '.$e -> getMessage().'}';
        }

>>>>>>> Actualizacion Arturo. Nuevo push para que Ruben vea version actualizada
      });

            //Eliminar Direccion
    $app -> delete('/api/direccion/eliminar/{IdDireccion}', function(Request $request, Response $response){

        $id = $request -> getAttribute('IdDireccion');
<<<<<<< HEAD
        
          $consulta = "DELETE FROM direccion WHERE IdDireccion = $id;";
        
          try {
        
=======

          $consulta = "DELETE FROM direccion WHERE IdDireccion = $id;";

          try {

>>>>>>> Actualizacion Arturo. Nuevo push para que Ruben vea version actualizada
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
<<<<<<< HEAD
        
        
        });

?>
=======


        });

?>
>>>>>>> Actualizacion Arturo. Nuevo push para que Ruben vea version actualizada
