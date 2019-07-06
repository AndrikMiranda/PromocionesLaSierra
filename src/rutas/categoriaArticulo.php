<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

//obtener Categorias de Articulo
$app -> get('/api/categoriaArticulo', function(Request $request, Response $response){

     $consulta = "select * from cat_categoriaarticulos";
  
     try {
  
           //Instanciacion de base de datos
            $db = new db();
            $db = $db -> conectar();
            $ejecutar = $db -> query($consulta);
            $categoriaArticulo = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
            $db = null;
  
            //Exportar y mostrar JSON
            echo json_encode($categoriaArticulo);
  
        } catch (PDOException $e) {
            echo '{"error": {"text": '.$e -> getMessage().'}';
        }
  
});

//obtener Categoria en especifico
$app -> get('/api/categoriaArticulo/{NombreCat}', function(Request $request, Response $response){

    $NombreCat = $request -> getAttribute('NombreCat');
    
      $consulta = "SELECT * FROM cat_categoriaarticulos WHERE NombreCategoria LIKE '%$NombreCat%';";
    
      try {
    
        //Instanciacion de base de datos
          $db = new db();
          $db = $db -> conectar();
          $ejecutar = $db -> query($consulta);
          $categoria = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
          $db = null;
    
          //Exportar y mostrar JSON
          echo json_encode($categoria);
    
      } catch (PDOException $e) {
        echo '{"error": {"text": '.$e -> getMessage().'}';
      }
    
    
    });

    //Agregar Categoria Articulo
    $app -> post('/api/categoriaArticulo/agregar', function(Request $request, Response $response){

        $nombre = $request -> getParam('Nombre');
         
          $consulta = "INSERT INTO cat_categoriaarticulos(NombreCategoria)
                       values (:Nombre)";
        
          try {
        
            //Instanciacion de base de datos
              $db = new db();
              $db = $db -> conectar();
              $stmt = $db -> prepare($consulta);
              $stmt -> bindParam(':Nombre', $nombre);
              $stmt -> execute();
              echo '{"notice": {"text": "Categoria agregado"}';
              //Exportar y mostrar JSON
        
          } catch (PDOException $e) {
            echo '{"error": {"text": '.$e -> getMessage().'}';
          }
        
        
        });

         //Actualizar Categoria Articulos
    $app -> put('/api/categoriaArticulo/actualizar/{IdCategoria}', function(Request $request, Response $response){

        $id = $request -> getAttribute('IdCategoria');
        $nombre = $request -> getParam('Nombre');
      
      
        $consulta = "UPDATE cat_categoriaarticulos SET
                     NombreCategoria = :Nombre
                     WHERE IdCategoria = $id";
      
        try {
      
          //Instanciacion de base de datos
            $db = new db();
            $db = $db -> conectar();
            $stmt = $db -> prepare($consulta);
            $stmt -> bindParam(':Nombre', $nombre);
            $stmt -> execute();
            echo '{"notice": {"text": "Categoria actualizada"}';
            //Exportar y mostrar JSON
      
        } catch (PDOException $e) {
          echo '{"error": {"text": '.$e -> getMessage().'}';
        }
      
      });

      //Eliminar Categorias Articulo
    $app -> delete('/api/categoriaArticulo/eliminar/{IdCategoria}', function(Request $request, Response $response){

        $id = $request -> getAttribute('IdCategoria');
        
          $consulta = "DELETE FROM cat_categoriaarticulos WHERE IdCategoria = $id;";
        
          try {
        
            //Instanciacion de base de datos
              $db = new db();
              $db = $db -> conectar();
              $stmt = $db -> query($consulta);
              $stmt -> execute();
              $db = null;
              echo '{"notice": {"text": "Categoria borrada"}';
          } catch (PDOException $e) {
            echo '{"error": {"text": '.$e -> getMessage().'}';
          }
        
        
        });
?>