<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

//Obtener Los Municipios
$app -> get('/api/catMunicipio', function(Request $request, Response $response){

     $consulta = "select * from cat_municipio";
  
     try {
  
           //Instanciacion de base de datos
            $db = new db();
            $db = $db -> conectar();
            $ejecutar = $db -> query($consulta);
            $catmunicipio = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
            $db = null;
  
            //Exportar y mostrar JSON
            echo json_encode($catmunicipio);
  
        } catch (PDOException $e) {
            echo '{"error": {"text": '.$e -> getMessage().'}';
        }
  
});

//Obtener Municipio en especifico
$app -> get('/api/catMunicipio/{NomMunicipio}', function(Request $request, Response $response){

    $NomMunicipio = $request -> getAttribute('NomMunicipio');
    
      $consulta = "select * from cat_municipio WHERE NomMunicipio LIKE '%$NomMunicipio%';";
    
      try {
    
        //Instanciacion de base de datos
          $db = new db();
          $db = $db -> conectar();
          $ejecutar = $db -> query($consulta);
          $catmunicipio = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
          $db = null;
    
          //Exportar y mostrar JSON
          echo json_encode($catmunicipio);
    
      } catch (PDOException $e) {
        echo '{"error": {"text": '.$e -> getMessage().'}';
      }
    
    
    });

    //Agregar Municipio
    $app -> post('/api/catMunicipio/agregar', function(Request $request, Response $response){

        $NomMunicipio = $request -> getParam('NomMunicipio');
         
          $consulta = "INSERT INTO cat_municipio(NomMunicipio)
                       values (:NomMunicipio)";
        
          try {
        
            //Instanciacion de base de datos
              $db = new db();
              $db = $db -> conectar();
              $stmt = $db -> prepare($consulta);
              $stmt -> bindParam(':NomMunicipio', $NomMunicipio);
              $stmt -> execute();
              echo '{"notice": {"text": "Municipio agregado"}';
              //Exportar y mostrar JSON
        
          } catch (PDOException $e) {
            echo '{"error": {"text": '.$e -> getMessage().'}';
          }
        
        
        });

         //Actualizar Municipio
    $app -> put('/api/catMunicipio/actualizar/{IdMunicipio}', function(Request $request, Response $response){

        $id = $request -> getAttribute('IdMunicipio');
        $NomMunicipio = $request -> getParam('NomMunicipio');
      
      
        $consulta = "UPDATE cat_municipio SET
                     NomMunicipio = :NomMunicipio
                     WHERE IdMunicipio = $id";
      
        try {
      
          //Instanciacion de base de datos
            $db = new db();
            $db = $db -> conectar();
            $stmt = $db -> prepare($consulta);
            $stmt -> bindParam(':NomMunicipio', $NomMunicipio);
            $stmt -> execute();
            echo '{"notice": {"text": "Municipio actualizado"}';
            //Exportar y mostrar JSON
      
        } catch (PDOException $e) {
          echo '{"error": {"text": '.$e -> getMessage().'}';
        }
      
      });

      //Eliminar Municipio
    $app -> delete('/api/catMunicipio/eliminar/{IdMunicipio}', function(Request $request, Response $response){

        $id = $request -> getAttribute('IdMunicipio');
        
          $consulta = "DELETE FROM cat_municipio WHERE IdMunicipio = $id;";
        
          try {
        
            //Instanciacion de base de datos
              $db = new db();
              $db = $db -> conectar();
              $stmt = $db -> query($consulta);
              $stmt -> execute();
              $db = null;
              echo '{"notice": {"text": "Municipio borrado"}';
          } catch (PDOException $e) {
            echo '{"error": {"text": '.$e -> getMessage().'}';
          }
        
        
        });
?>