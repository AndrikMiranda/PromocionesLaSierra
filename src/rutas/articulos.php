<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

/*Ruta general de GET glientes*/
$app -> get('/api/articulos', function(Request $request, Response $response){
  
  $mCustomHelper = new MyCustomHelper();

  //$idUsuario = $request->getParam('idUser');
  $page = $request->getParam('page');
  $limit = $request->getParam('pageSize');
  $likeSearch = $request->getParam('likeSearch');
  $columnaGenerica = $request->getParam('columnaGenerica');
  $parametroColumnaGenerica = $request->getParam('parametroGenerico');

  $pageReal = (isset( $page ) && $page > 0) ? $page : 1;
  $pageForReturn = $pageReal;
  $limit = isset( $limit ) ? $limit : 10;
  $offset = (--$pageReal) * $limit;
  
  $consultaGenerica = "SELECT
                    articulo.IdArticulo,
                    articulo.Codigo,
                    articulo.NombreArticulo,
                    articulo.Costo,
                    articulo.PrecioVenta,
                    articulo.PrecioMayoreo,
                    cat_categoriaarticulos.NombreCategoria
                    FROM
                    articulo
                    INNER JOIN cat_categoriaarticulos ON articulo.FkCategoria = cat_categoriaarticulos.IdCategoria
                    WHERE ".$columnaGenerica." = '$parametroColumnaGenerica' 
                    LIMIT $limit
                    OFFSET $offset";
  
  $totalConsultaGenerica = "SELECT
                    articulo.IdArticulo,
                    articulo.Codigo,
                    articulo.NombreArticulo,
                    articulo.Costo,
                    articulo.PrecioVenta,
                    articulo.PrecioMayoreo,
                    cat_categoriaarticulos.NombreCategoria
                    FROM
                    articulo
                    INNER JOIN cat_categoriaarticulos ON articulo.FkCategoria = cat_categoriaarticulos.IdCategoria
                    WHERE ".$columnaGenerica." = '$parametroColumnaGenerica' 
                    LIMIT $limit
                    OFFSET $offset";
  
  $consultaTodos = "SELECT
                    articulo.IdArticulo,
                    articulo.Codigo,
                    articulo.NombreArticulo,
                    articulo.Costo,
                    articulo.PrecioVenta,
                    articulo.PrecioMayoreo,
                    cat_categoriaarticulos.NombreCategoria
                    FROM
                    articulo
                    INNER JOIN cat_categoriaarticulos ON articulo.FkCategoria = cat_categoriaarticulos.IdCategoria
                    LIMIT $limit
                    OFFSET $offset";

  $consultaLikeSearch = "articulo.IdArticulo,
                    articulo.Codigo,
                    articulo.NombreArticulo,
                    articulo.Costo,
                    articulo.PrecioVenta,
                    articulo.PrecioMayoreo,
                    cat_categoriaarticulos.NombreCategoria
                    FROM
                    articulo
                    INNER JOIN cat_categoriaarticulos ON articulo.FkCategoria = cat_categoriaarticulos.IdCategoria
                    WHERE Nombre LIKE '%$likeSearch%' OR
                            articulo.Codigo LIKE '%$likeSearch%' OR
                            articulo.NombreArticulo LIKE '%$likeSearch%' OR
                            articulo.Costo LIKE '%$likeSearch%' OR
                            articulo.PrecioVenta LIKE '%$likeSearch%' OR
                            articulo.PrecioMayoreo LIKE '%$likeSearch%' OR
                            cat_categoriaarticulos.NombreCategoria LIKE '%$likeSearch%' 
                        LIMIT $limit
                        OFFSET $offset";

$totalConsultaTodos = "SELECT
                    COUNT(articulo.IdArticulo) as Total
                    FROM
                    articulo
                    INNER JOIN cat_categoriaarticulos ON articulo.FkCategoria = cat_categoriaarticulos.IdCategoria";
                    
$totalConsultaLikeSearch = "SELECT
                    COUNT(articulo.IdArticulo) as Total
                    FROM
                    articulo
                    INNER JOIN cat_categoriaarticulos ON articulo.FkCategoria = cat_categoriaarticulos.IdCategoria
                    WHERE Nombre LIKE '%$likeSearch%' OR
                            articulo.Codigo LIKE '%$likeSearch%' OR
                            articulo.NombreArticulo LIKE '%$likeSearch%' OR
                            articulo.Costo LIKE '%$likeSearch%' OR
                            articulo.PrecioVenta LIKE '%$likeSearch%' OR
                            articulo.PrecioMayoreo LIKE '%$likeSearch%' OR
                            cat_categoriaarticulos.NombreCategoria LIKE '%$likeSearch%'";

  try {
      /* Si la tura trae algun parametro para busqueda generica, se utiliza la consulta generica. Si no, se va al ELSE IF */
      if($columnaGenerica != null){
          $db = new db();
          $db = $db -> conectar();
          $ejecutar = $db -> query($consultaGenerica);
          $articulos = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
          $db = null;
          
          $db = new db();
          $db = $db -> conectar();
          $ejecutar = $db -> query($totalConsultaGenerica);
          $mTotal = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
          $db = null;
          
          $mTotal = json_decode( json_encode($total[0]) , true );
          
          $mCustomResponse = new CustomResponse(200,  $articulos, null, (int)$pageForReturn, (int)$mTotal['Total'] );
          
          return $response->withStatus(200)
                ->withHeader('Content-Type', 'application/json')
                ->write( $mCustomHelper -> returnCatchAsJson($mCustomResponse ) );
        
    } else if($likeSearch != null){
      /* Si la ruta NO contiene CONSULTA GENERICA y tampoco lleva parametro para la busqueda con LIKE */    
      $db = new db();
      $db = $db -> conectar();
      $ejecutar = $db -> query($consultaLikeSearch);
      $articulos = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
      $db = null;
      
      $db = new db();
      $db = $db -> conectar();
      $ejecutar = $db -> query($totalConsultaLikeSearch);
      $total = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
      $db = null;
      
      $mTotal = json_decode( json_encode($total[0]) , true );
      
      $mCustomResponse = new CustomResponse(200,  $articulos, null, (int)$pageForReturn, (int)$mTotal['Total']);

      return $response->withStatus(200)
                ->withHeader('Content-Type', 'application/json')
                ->write( $mCustomHelper -> returnCatchAsJson($mCustomResponse ) );
                
    } else if ($likeSearch == null) {
        /* Si la ruta NO contiene CONSULTA GENERICA, NI parametro de busqueda LIKE, se toma la busqueda SIN parametros y se regresa GET ALL */
        $db = new db();
        $db = $db -> conectar();
        $ejecutar = $db -> query($consultaTodos);
        $articulos = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
        $db = null;
        
        $db = new db();
        $db = $db -> conectar();
        $ejecutar = $db -> query($totalConsultaTodos);
        $total = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
        $db = null;
      
        $mTotal = json_decode( json_encode($total[0]) , true );

        $mCustomResponse = new CustomResponse(200,  $articulos, null, (int)$pageForReturn, (int)$mTotal['Total']);
        
        return $response->withStatus(200)
                ->withHeader('Content-Type', 'application/json')
                ->write( $mCustomHelper -> returnCatchAsJson($mCustomResponse ) );
        
    } else {
      /* Si ningun CASO de los anteriores se cumple, entra al ELSE de errorResponse.
         Si bien no es un ERROR como tal, es una respuesta que nos dice que no se cumplieron los
         criterios anteriores.*/    
      $mErrorResponse = new ErrorResponse(200, 'Hubo un problema con la solicitud. Intentelo de nuevo.', false);
      return $mCustomHelper -> returnCatchAsJson($mErrorResponse );

    }

  } catch (PDOException $e) {
    /* Si algo sale mal en cualquier caso de los anteriores del TRY, se lanza este catch. */  
    $mErrorResponse = new ErrorResponse(500, $e -> getMessage(), true);
    return $mCustomHelper -> returnCatchAsJson($mErrorResponse );
  }

});










/*
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
  
  $mCustomHelper = new MyCustomHelper();
  
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
    
          $mCustomResponse = new CustomResponse(200,  null, null, null, null );
          return $mCustomHelper -> returnCatchAsJson($mCustomResponse );

        } catch (PDOException $e) {
            $mErrorResponse = new ErrorResponse(500, $e -> getMessage(), true);
            return $mCustomHelper -> returnCatchAsJson($mErrorResponse );
        }
    
    
    
    });
*/

    //Agregar Categoria Articulo
    $app -> post('/api/articulos/agregar', function(Request $request, Response $response){

        $mCustomHelper = new MyCustomHelper();
        
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
            
              $mCustomResponse = new CustomResponse(200,'Se agregó categoría con éxito.', null, null, null );
              return $mCustomHelper -> returnCatchAsJson($mCustomResponse );

              } catch (PDOException $e) {
              $mErrorResponse = new ErrorResponse(500, $e -> getMessage(), true);
              return $mCustomHelper -> returnCatchAsJson($mErrorResponse );
             }
        
        
        });

                 //Actualizar Articulo
    $app -> put('/api/articulos/actualizar/', function(Request $request, Response $response){
        
        $mCustomHelper = new MyCustomHelper();
        
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
    
              $mCustomResponse = new CustomResponse(200,'Se actualizó articulo con éxito.', null, null, null );
              return $mCustomHelper -> returnCatchAsJson($mCustomResponse );

              } catch (PDOException $e) {
              $mErrorResponse = new ErrorResponse(500, $e -> getMessage(), true);
              return $mCustomHelper -> returnCatchAsJson($mErrorResponse );
             }
      
      });

            //Eliminar Articulo
    $app -> delete('/api/articulos/eliminar/', function(Request $request, Response $response){
        
        $mCustomHelper = new MyCustomHelper();
        $id = $request -> getParam('IdArticulo');
        
          $consulta = "DELETE FROM articulo WHERE IdArticulo = $id;";
        
          try {
        
            //Instanciacion de base de datos
              $db = new db();
              $db = $db -> conectar();
              $stmt = $db -> query($consulta);
              $stmt -> execute();
              $db = null;
              
            $mCustomResponse = new CustomResponse(200,'Se eliminó articulo con éxito.', null, null, null );
              return $mCustomHelper -> returnCatchAsJson($mCustomResponse );

              } catch (PDOException $e) {
              $mErrorResponse = new ErrorResponse(500, $e -> getMessage(), true);
              return $mCustomHelper -> returnCatchAsJson($mErrorResponse );
             }
        
        
        });
        
        
        
        $app->post('/api/articulo/transaccion', function (Request $request, Response $response) {

    
    try {
        
        $consultaNotificacionVenta = "INSERT INTO subventa(FkArticulo, Cantidad, SubTotal, FkVenta)
                                        VALUES( :FkArticulo, :Cantidad, :SubTotal, :FkVenta)";


        

        

        //Instanciacion de base de datos
        $db = new db();
        $db = $db->conectar();
        
       $consultaSubVentaTablaValor = "SELECT
                                                   tabla_valor.clave,
                                                   CAST(tabla_valor.dato1 AS INT) AS FkArticulo,
                                                   CAST(tabla_valor.dato2 AS INT) AS Cantidad,
                                                   CAST(tabla_valor.dato3 AS INT) AS SubTotal,
                                                   CAST(tabla_valor.dato4 AS INT) AS FkVenta
                                                   FROM
                                                   tabla_valor
                                                   WHERE
                                                   tabla_valor.clave = 'NOTI-SUBVENTA' AND
                                                   tabla_valor.dato4 = 10";

                    $ejecutar = $db -> query($consultaSubVentaTablaValor);
                    $subVentaArray = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
        
        $json = json_encode( ['subVenta' => $subVentaArray] , JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
        
        echo $json;
        

    } catch (PDOException $e) {
        $mErrorResponse = new ErrorResponse(500, $e -> getMessage(), true);
        return $mCustomHelper -> returnCatchAsJson($mErrorResponse );
    }

});

?>