<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

//obtener Articulos
$app -> get('/api/articulos', function(Request $request, Response $response){

  $limit = $request -> getParam('limit');
  $page = $request -> getParam('page');
  
  $pageReal = (isset( $page ) && $page > 0) ? $page : 1;
  $limit = isset( $limit ) ? $limit : 10;
  $offset = (--$pageReal) * $limit;

  $count = "SELECT COUNT(*) as Total FROM `articulo`";

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

          $db = new db();
          $db = $db->conectar();
          $ejecutar1 = $db -> query($count);
          $stmt2 = $ejecutar1 -> fetchAll(PDO::FETCH_OBJ);
          $db = null;
 
          if($Articulos) {
            return $response->withStatus(200)
                ->withHeader('Content-Type', 'application/json')
                ->write(json_encode($Articulos, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
          }
          
 
       } catch (PDOException $e) {
           echo '{"error": {"text": '.$e -> getMessage().'}';
       }
 
});
//obtener Categoria en especifico
$app -> get('/api/articulos/', function(Request $request, Response $response){

  $NombreArt = $request -> getParam('NombreArt');
    
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
    
          if($articulo) {
            return $response->withStatus(200)
                ->withHeader('Content-Type', 'application/json')
                ->write(json_encode($articulo, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
          }
    
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
            
              if($stmt) {
                return $response->withStatus(200)
                    ->withHeader('Content-Type', 'application/json')
                    ->write(json_encode($stmt, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
              }
        
          } catch (PDOException $e) {
            echo '{"error": {"text": '.$e -> getMessage().'}';
          }
        
        
        });

                 //Actualizar Articulo
    $app -> put('/api/articulos/actualizar/', function(Request $request, Response $response){

        $id = $request -> getParam('IdArticulo');
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

            if($stmt) {
              return $response->withStatus(201)
                  ->withHeader('Content-Type', 'application/json')
                  ->write(json_encode($stmt, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
            }
      
        } catch (PDOException $e) {
          echo '{"error": {"text": '.$e -> getMessage().'}';
        }
      
      });

            //Eliminar Articulo
    $app -> delete('/api/articulos/eliminar/', function(Request $request, Response $response){

        $id = $request -> getParam('IdArticulo');
        
          $consulta = "DELETE FROM articulo WHERE IdArticulo = $id;";
        
          try {
        
            //Instanciacion de base de datos
              $db = new db();
              $db = $db -> conectar();
              $stmt = $db -> query($consulta);
              $stmt -> execute();
              $db = null;
              
              if($stmt) {
                return $response->withStatus(200)
                    ->withHeader('Content-Type', 'application/json')
                    ->write(json_encode($stmt, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
              }

          } catch (PDOException $e) {
            echo '{"error": {"text": '.$e -> getMessage().'}';
          }
        
        
        });

?>