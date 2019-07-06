<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

//obtener Articulos
$app -> get('/api/articulos', function(Request $request, Response $response){

    $consulta = "SELECT a.IdArticulo,a.Codigo,a.NombreArticulo,a.Costo,a.PrecioVenta,a.PrecioMayoreo,b.NombreCategoria 
                 FROM articulo a, cat_categoriaarticulos b 
                 WHERE a.FkCategoria=b.IdCategoria order by IdArticulo";
 
    try {
 
          //Instanciacion de base de datos
           $db = new db();
           $db = $db -> conectar();
           $ejecutar = $db -> query($consulta);
           $Articulos = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
           $db = null;
 
           //Exportar y mostrar JSON
           echo json_encode($Articulos, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
 
       } catch (PDOException $e) {
           echo '{"error": {"text": '.$e -> getMessage().'}';
       }
 
});
//obtener Categoria en especifico
$app -> get('/api/articulos/{NombreArt}', function(Request $request, Response $response){

    $NombreArt = $request -> getAttribute('NombreArt');
    
      $consulta = "SELECT a.IdArticulo,a.Codigo,a.NombreArticulo,a.Costo,a.PrecioVenta,a.PrecioMayoreo,b.NombreCategoria 
                   FROM articulo a, cat_categoriaarticulos b
                   WHERE a.FkCategoria=b.IdCategoria and NombreArticulo LIKE '%$NombreArt%'
                   order by IdArticulo;";
    
      try {
    
        //Instanciacion de base de datos
          $db = new db();
          $db = $db -> conectar();
          $ejecutar = $db -> query($consulta);
          $articulo = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
          $db = null;
    
          //Exportar y mostrar JSON
          echo json_encode($articulo);
    
      } catch (PDOException $e) {
        echo '{"error": {"text": '.$e -> getMessage().'}';
      }
    
    
    });

    //Agregar Categoria Articulo
    $app -> post('/api/articulos/agregar', function(Request $request, Response $response){

        $codigo = $request -> getParam('Codigo');
        $nombre = $request -> getParam('Nombre');
        $costo = $request -> getParam('Costo');
        $venta = $request -> getParam('PrecioVenta');
        $mayoreo = $request -> getParam('PrecioMayoreo');
        $categoria = $request -> getParam('Categoria');
         
          $consulta = "INSERT INTO articulo(Codigo,NombreArticulo,Costo,PrecioVenta,
                       PrecioMayoreo,FkCategoria)
                       values (:Codigo, :Nombre, :Costo, :PrecioVenta, :PrecioMayoreo, :Categoria)";
        
          try {
        
            //Instanciacion de base de datos
              $db = new db();
              $db = $db -> conectar();
              $stmt = $db -> prepare($consulta);
              $stmt -> bindParam(':Codigo', $codigo);
              $stmt -> bindParam(':Nombre', $nombre);
              $stmt -> bindParam(':Costo', $costo);
              $stmt -> bindParam(':PrecioVenta', $venta);
              $stmt -> bindParam(':PrecioMayoreo', $mayoreo);
              $stmt -> bindParam(':Categoria', $categoria);
              $stmt -> execute();
              echo '{"notice": {"text": "Articulo agregado"}';
              //Exportar y mostrar JSON
        
          } catch (PDOException $e) {
            echo '{"error": {"text": '.$e -> getMessage().'}';
          }
        
        
        });

                 //Actualizar Articulo
    $app -> put('/api/articulos/actualizar/{IdArticulo}', function(Request $request, Response $response){

        $id = $request -> getAttribute('IdArticulo');
        $codigo = $request -> getParam('Codigo');
        $nombre = $request -> getParam('Nombre');
        $costo = $request -> getParam('Costo');
        $venta = $request -> getParam('PrecioVenta');
        $mayoreo = $request -> getParam('PrecioMayoreo');
        $categoria = $request -> getParam('Categoria');
      
      
        $consulta = "UPDATE articulo SET
                     Codigo = :Codigo,
                     NombreArticulo = :Nombre,
                     Costo = :Costo,
                     PrecioVenta = :PrecioVenta,
                     PrecioMayoreo = :PrecioMayoreo,
                     FkCategoria = :Categoria
                     WHERE IdArticulo = $id";
      
        try {
      
          //Instanciacion de base de datos
            $db = new db();
            $db = $db -> conectar();
            $stmt = $db -> prepare($consulta);
            $stmt -> bindParam(':Codigo', $codigo);
            $stmt -> bindParam(':Nombre', $nombre);
            $stmt -> bindParam(':Costo', $costo);
            $stmt -> bindParam(':PrecioVenta', $venta);
            $stmt -> bindParam(':PrecioMayoreo', $mayoreo);
            $stmt -> bindParam(':Categoria', $categoria);
            $stmt -> execute();
            echo '{"notice": {"text": "Categoria actualizada"}';
            //Exportar y mostrar JSON
      
        } catch (PDOException $e) {
          echo '{"error": {"text": '.$e -> getMessage().'}';
        }
      
      });

            //Eliminar Articulo
    $app -> delete('/api/articulos/eliminar/{IdArticulo}', function(Request $request, Response $response){

        $id = $request -> getAttribute('IdArticulo');
        
          $consulta = "DELETE FROM articulo WHERE IdArticulo = $id;";
        
          try {
        
            //Instanciacion de base de datos
              $db = new db();
              $db = $db -> conectar();
              $stmt = $db -> query($consulta);
              $stmt -> execute();
              $db = null;
              echo '{"notice": {"text": "Articulo borrado"}';
          } catch (PDOException $e) {
            echo '{"error": {"text": '.$e -> getMessage().'}';
          }
        
        
        });

?>