<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

//$app = new \Slim\App;

//INCOMPLETO. Estructura de utra ruta (para guiarse).
$app -> get('/api/ventas/', function(Request $request, Response $response){
  $mCustomHelper = new MyCustomHelper();

  $idUsuario = $request->getParam('idUser');
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
                    venta.IdVenta,
                    venta.TotalVenta,
                    venta.Enganche,
                    venta.Fecha,
                    venta.PeriodoPago,
                    venta.CantidadAbono,
                    venta.SaldoPendiente,
                    venta.HorarioCobro,
                    venta.TipoVenta,
                    venta.GpsLat,
                    venta.GpsLon,
                    cuenta.NumeroCuenta,
                    usuario.Nombre,
                    cliente.Nombre,
                    cliente.APaterno,
                    cliente.AMaterno
                    FROM
                    venta
                    INNER JOIN cuenta ON venta.FkCuenta = cuenta.IdCuenta
                    INNER JOIN usuario ON venta.FkVendedor = usuario.IdUsuario
                    INNER JOIN cliente ON cuenta.FkCliente = cliente.IdCliente
                    WHERE ".$columnaGenerica." = '$parametroColumnaGenerica' 
                    LIMIT $limit
                    OFFSET $offset";
  
  $totalConsultaGenerica = "SELECT
                    COUNT (venta.IdVenta) as Total
                    FROM
                    venta
                    INNER JOIN cuenta ON venta.FkCuenta = cuenta.IdCuenta
                    INNER JOIN usuario ON venta.FkVendedor = usuario.IdUsuario
                    INNER JOIN cliente ON cuenta.FkCliente = cliente.IdCliente
                    WHERE ".$columnaGenerica." = '$parametroColumnaGenerica'";
  
  $consultaTodos = "SELECT
                    venta.IdVenta,
                    venta.TotalVenta,
                    venta.Enganche,
                    venta.Fecha,
                    venta.PeriodoPago,
                    venta.CantidadAbono,
                    venta.SaldoPendiente,
                    venta.HorarioCobro,
                    venta.TipoVenta,
                    venta.GpsLat,
                    venta.GpsLon,
                    cuenta.NumeroCuenta,
                    usuario.Nombre,
                    cliente.Nombre,
                    cliente.APaterno,
                    cliente.AMaterno
                    FROM
                    venta
                    INNER JOIN cuenta ON venta.FkCuenta = cuenta.IdCuenta
                    INNER JOIN usuario ON venta.FkVendedor = usuario.IdUsuario
                    INNER JOIN cliente ON cuenta.FkCliente = cliente.IdCliente
                    LIMIT $limit
                    OFFSET $offset";

  $consultaLikeSearch = "SELECT
                    venta.IdVenta,
                    venta.TotalVenta,
                    venta.Enganche,
                    venta.Fecha,
                    venta.PeriodoPago,
                    venta.CantidadAbono,
                    venta.SaldoPendiente,
                    venta.HorarioCobro,
                    venta.TipoVenta,
                    venta.GpsLat,
                    venta.GpsLon,
                    cuenta.NumeroCuenta,
                    usuario.Nombre,
                    cliente.Nombre,
                    cliente.APaterno,
                    cliente.AMaterno
                    FROM
                    venta
                    INNER JOIN cuenta ON venta.FkCuenta = cuenta.IdCuenta
                    INNER JOIN usuario ON venta.FkVendedor = usuario.IdUsuario
                    INNER JOIN cliente ON cuenta.FkCliente = cliente.IdCliente
                    WHERE venta.Fecha LIKE '%$likeSearch%' OR
                    venta.PeriodoPago LIKE '%$likeSearch%' OR
                    venta.CantidadAbono LIKE '%$likeSearch%' OR
                    venta.HorarioCobro LIKE '%$likeSearch%' OR
                    venta.TipoVenta LIKE '%$likeSearch%' OR
                    venta.GpsLat LIKE '%$likeSearch%' OR
                    venta.GpsLon LIKE '%$likeSearch%' OR
                    cuenta.NumeroCuenta LIKE '%$likeSearch%' OR
                    usuario.Nombre LIKE '%$likeSearch%' OR
                    cliente.Nombre LIKE '%$likeSearch%' OR
                    cliente.APaterno LIKE '%$likeSearch%' OR
                    cliente.AMaterno LIKE '%$likeSearch%'
                        LIMIT $limit
                        OFFSET $offset";

$totalConsultaTodos = "SELECT
                    COUNT(venta.IdVenta) as Total
                    FROM
                    venta
                    INNER JOIN cuenta ON venta.FkCuenta = cuenta.IdCuenta
                    INNER JOIN usuario ON venta.FkVendedor = usuario.IdUsuario
                    INNER JOIN cliente ON cuenta.FkCliente = cliente.IdCliente";
                    
$totalConsultaLikeSearch = "SELECT
                    venta.IdVenta,
                    venta.TotalVenta,
                    venta.Enganche,
                    venta.Fecha,
                    venta.PeriodoPago,
                    venta.CantidadAbono,
                    venta.SaldoPendiente,
                    venta.HorarioCobro,
                    venta.TipoVenta,
                    venta.GpsLat,
                    venta.GpsLon,
                    cuenta.NumeroCuenta,
                    usuario.Nombre,
                    cliente.Nombre,
                    cliente.APaterno,
                    cliente.AMaterno
                    FROM
                    venta
                    INNER JOIN cuenta ON venta.FkCuenta = cuenta.IdCuenta
                    INNER JOIN usuario ON venta.FkVendedor = usuario.IdUsuario
                    INNER JOIN cliente ON cuenta.FkCliente = cliente.IdCliente
                    WHERE venta.Fecha LIKE '%$likeSearch%' OR
                    venta.PeriodoPago LIKE '%$likeSearch%' OR
                    venta.CantidadAbono LIKE '%$likeSearch%' OR
                    venta.HorarioCobro LIKE '%$likeSearch%' OR
                    venta.TipoVenta LIKE '%$likeSearch%' OR
                    venta.GpsLat LIKE '%$likeSearch%' OR
                    venta.GpsLon LIKE '%$likeSearch%' OR
                    cuenta.NumeroCuenta LIKE '%$likeSearch%' OR
                    usuario.Nombre LIKE '%$likeSearch%' OR
                    cliente.Nombre LIKE '%$likeSearch%' OR
                    cliente.APaterno LIKE '%$likeSearch%' OR
                    cliente.AMaterno LIKE '%$likeSearch%'";  

  try {
      if($columnaGenerica != null){
          $db = new db();
          $db = $db -> conectar();
          $ejecutar = $db -> query($consultaGenerica);
          $ventas = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
          $db = null;
          
          $db = new db();
          $db = $db -> conectar();
          $ejecutar = $db -> query($totalConsultaGenerica);
          $mTotal = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
          $db = null;
          
          $mTotal = json_decode( json_encode($total[0]) , true );
          
          if ($ventas) { 
          $mCustomResponse = new CustomResponse(200,  $ventas, null, (int)$pageForReturn, (int)$mTotal['Total'] );
          return $response->withStatus(200)
                ->withHeader('Content-Type', 'application/json')
                ->write( $mCustomHelper -> returnCatchAsJson($mCustomResponse ) );
          }
    } else if($likeSearch != null){
      $db = new db();
      $db = $db -> conectar();
      $ejecutar = $db -> query($consultaLikeSearch);
      $ventas = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
      $db = null;
      
      $db = new db();
      $db = $db -> conectar();
      $ejecutar = $db -> query($totalConsultaLikeSearch);
      $total = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
      $db = null;
      
      $mTotal = json_decode( json_encode($total[0]) , true );

      if ($ventas) {       
      $mCustomResponse = new CustomResponse(200,  $ventas, null, (int)$pageForReturn, (int)$mTotal['Total']);
      return $response->withStatus(200)
                ->withHeader('Content-Type', 'application/json')
                ->write( $mCustomHelper -> returnCatchAsJson($mCustomResponse ) );
      }        
    } else if ($likeSearch == null) {
        $db = new db();
        $db = $db -> conectar();
        $ejecutar = $db -> query($consultaTodos);
        $ventas = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
        $db = null;
        
        $db = new db();
        $db = $db -> conectar();
        $ejecutar = $db -> query($totalConsultaTodos);
        $total = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
        $db = null;
      
        $mTotal = json_decode( json_encode($total[0]) , true );
        
        if ($ventas) { 
        $mCustomResponse = new CustomResponse(200,  $ventas, null, (int)$pageForReturn, (int)$mTotal['Total']);
        return $response->withStatus(200)
                ->withHeader('Content-Type', 'application/json')
                ->write( $mCustomHelper -> returnCatchAsJson($mCustomResponse ) );
        }
    } else {
      $mErrorResponse = new ErrorResponse(200, 'Hubo un problema con la solicitud. Intentelo de nuevo.', false);
      return $mCustomHelper -> returnCatchAsJson($mErrorResponse );

    }

  } catch (PDOException $e) {
    $mErrorResponse = new ErrorResponse(500, $e -> getMessage(), true);
    return $mCustomHelper -> returnCatchAsJson($mErrorResponse );
  }
});








<<<<<<< HEAD
=======





/*
>>>>>>> Actualizacion de API 13-marzo-2020
//obetener todos los ventas
$app -> get('/api/ventas/', function(Request $request, Response $response){
    
    $limit = $request -> getParam('limit');
    $page = $request -> getParam('page');
    
    $pageReal = (isset( $page ) && $page > 0) ? $page : 1;
    $limit = isset( $limit ) ? $limit : 10;
    $offset = (--$pageReal) * $limit;
  
  $count = "SELECT COUNT(*) as Total FROM venta";
  $consulta = "SELECT
                venta.IdVenta,
                venta.FkCuenta,
                venta.TotalVenta,
                venta.Enganche,
                venta.Fecha,
                venta.FkVendedor,
                venta.PeriodoPago,
                venta.CantidadAbono,
                venta.SaldoPendiente,
                venta.HorarioCobro,
                venta.TipoVenta,
                venta.GpsLat,
                venta.GpsLon,
                venta.EstatusAprobacion
              FROM
                venta
              LIMIT $limit
              OFFSET $offset";
  try {

    //Instanciacion de base de datos
      $db = new db();
      $db = $db -> conectar();
      $ejecutar = $db -> query($consulta);
      $ventas = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
      $db = null;
      //Exportar y mostrar JSON
      echo json_encode($ventas);
      
      $db = new db();
      $db = $db->conectar();
      $ejecutar1 = $db -> query($count);
      $stmt2 = $ejecutar1 -> fetchAll(PDO::FETCH_OBJ);
      $db = null;

      if($ventas) {
        return $response->withStatus(200)
            ->withHeader('Content-Type', 'application/json')
            ->write(json_encode($ventas));
      }


  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e -> getMessage().'} }';
  }
});

//obetener una venta por id
$app -> get('/api/ventas/IdVenta/', function(Request $request, Response $response){

  $idVenta = $request -> getParam('IdVenta');

  $consulta = "SELECT
                venta.IdVenta,
                venta.FkCuenta,
                venta.TotalVenta,
                venta.Enganche,
                venta.Fecha,
                venta.FkVendedor,
                venta.PeriodoPago,
                venta.CantidadAbono,
                venta.SaldoPendiente,
                venta.HorarioCobro,
                venta.TipoVenta,
                venta.GpsLat,
                venta.GpsLon,
                venta.EstatusAprobacion
              FROM
                venta
              WHERE `IdVenta` = $idVenta";

  try {

    //Instanciacion de base de datos
      $db = new db();
      $db = $db -> conectar();
      $ejecutar = $db -> query($consulta);
      $vendedores = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
      $db = null;

      if($vendedores) {
        return $response->withStatus(200)
            ->withHeader('Content-Type', 'application/json')
            ->write(json_encode($vendedores));
      }

  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e -> getMessage().'} }';
  }

});
*/

//agregar venta
$app->post('/api/ventas/agregar', function (Request $request, Response $response) {
    
    $mCustomHelper = new MyCustomHelper();
    
    $fkCuenta = $request->getParam('FkCuenta');
    $totalVenta = $request->getParam('TotalVenta');
    $enganche = $request->getParam('Enganche');
    $fkVendedor = $request->getParam('FkVendedor');
    $periodoPago = $request->getParam('PeriodoPago');
    $cantidadAbono = $request->getParam('CantidadAbono');
    $saldoPendiente = $request->getParam('SaldoPendiente');
    $horarioCobro = $request->getParam('HorarioCobro');
    $tipoVenta = $request->getParam('TipoVenta');
    $gpsLat = $request->getParam('GpsLat');
    $gpsLon = $request->getParam('GpsLon');
    $estatusAprobacion = $request->getParam('EstatusAprobacion');

    $consulta = "INSERT INTO venta(FkCuenta, TotalVenta, Enganche, 
                                   FkVendedor, PeriodoPago ,CantidadAbono, 
                                   SaldoPendiente, HorarioCobro, TipoVenta, GpsLat, 
                                   GpsLon, EstatusAprobacion)
                  values (:FkCuenta, :TotalVenta, :Enganche, 
                          :FkVendedor, :PeriodoPago, :CantidadAbono, 
                          :SaldoPendiente, :HorarioCobro, :TipoVenta, :GpsLat, 
                          :GpsLon, :EstatusAprobacion)";

    try {

        //Instanciacion de base de datos
        $db = new db();
        $db = $db->conectar();
        $stmt = $db->prepare($consulta);

        $stmt->bindParam(':FkCuenta', $fkCuenta);
        $stmt->bindParam(':TotalVenta', $totalVenta);
        $stmt->bindParam(':Enganche', $enganche);
        $stmt->bindParam(':FkVendedor', $fkVendedor);
        $stmt->bindParam(':PeriodoPago', $periodoPago);
        $stmt->bindParam(':CantidadAbono', $cantidadAbono);
        $stmt->bindParam(':SaldoPendiente', $saldoPendiente);
        $stmt->bindParam(':HorarioCobro', $horarioCobro);
        $stmt->bindParam(':TipoVenta', $tipoVenta);
        $stmt->bindParam(':GpsLat', $gpsLat);
        $stmt->bindParam(':GpsLon', $gpsLon);
        $stmt->bindParam(':EstatusAprobacion', $estatusAprobacion);

        $stmt->execute();
<<<<<<< HEAD

      if($stmt) {
        return $response->withStatus(200)
            ->withHeader('Content-Type', 'application/json')
            ->write(json_encode($stmt));
      }

    } catch (PDOException $e) {
        echo '{"error": {"text": ' . $e->getMessage() . '} }';
    }
=======
        
        if ($stmt) { 
        $mCustomResponse = new CustomResponse(200,'Se agregó venta con éxito.', null, null, null );
        return $mCustomHelper -> returnCatchAsJson($mCustomResponse );
        }
        } catch (PDOException $e) {
        $mErrorResponse = new ErrorResponse(500, $e -> getMessage(), true);
        return $mCustomHelper -> returnCatchAsJson($mErrorResponse );
        }
>>>>>>> Actualizacion de API 13-marzo-2020

});



//Actualizar ventas
$app -> put('/api/ventas/actualizar/{IdVenta}', function(Request $request, Response $response){
    
    $mCustomHelper = new MyCustomHelper();
    
    $idVenta = $request -> getAttribute('IdVenta');
    $fkCuenta = $request->getParam('FkCuenta');
    $totalVenta = $request->getParam('TotalVenta');
    $enganche = $request->getParam('Enganche');
    $fkVendedor = $request->getParam('FkVendedor');
    $periodoPago = $request->getParam('PeriodoPago');
    $cantidadAbono = $request->getParam('CantidadAbono');
    $saldoPendiente = $request->getParam('SaldoPendiente');
    $horarioCobro = $request->getParam('HorarioCobro');
    $tipoVenta = $request->getParam('TipoVenta');
    $gpsLat = $request->getParam('GpsLat');
    $gpsLon = $request->getParam('GpsLon');
    $estatusAprobacion = $request->getParam('EstatusAprobacion');

    $consulta = "UPDATE  venta 
              SET 
               FkCuenta = :FkCuenta,
               TotalVenta = :TotalVenta,
               Enganche = :Enganche,
               FkVendedor = :FkVendedor,
               PeriodoPago = :PeriodoPago,
               CantidadAbono = :CantidadAbono,
               SaldoPendiente = :SaldoPendiente,
               HorarioCobro = :HorarioCobro,
               TipoVenta = :TipoVenta,
               GpsLat = :GpsLat,
               GpsLon = :GpsLon,
               EstatusAprobacion = :EstatusAprobacion
              WHERE 
               IdVenta = $idVenta";

  try {

    //Instanciacion de base de datos
    $db = new db();
    $db = $db -> conectar();
    $stmt = $db -> prepare($consulta);

    $stmt->bindParam(':FkCuenta', $fkCuenta);
    $stmt->bindParam(':TotalVenta', $totalVenta);
    $stmt->bindParam(':Enganche', $enganche);
    $stmt->bindParam(':FkVendedor', $fkVendedor);
    $stmt->bindParam(':PeriodoPago', $periodoPago);
    $stmt->bindParam(':CantidadAbono', $cantidadAbono);
    $stmt->bindParam(':SaldoPendiente', $saldoPendiente);
    $stmt->bindParam(':HorarioCobro', $horarioCobro);
    $stmt->bindParam(':TipoVenta', $tipoVenta);
    $stmt->bindParam(':GpsLat', $gpsLat);
    $stmt->bindParam(':GpsLon', $gpsLon);
    $stmt->bindParam(':EstatusAprobacion', $estatusAprobacion);

    $stmt -> execute();
<<<<<<< HEAD

    if($stmt) {
        return $response->withStatus(201)
            ->withHeader('Content-Type', 'application/json')
            ->write(json_encode($stmt));
      }

  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e -> getMessage().'} }';
  }
=======
    if ($stmt) { 
    $mCustomResponse = new CustomResponse(201,'Se actualizó venta con éxito.', null, null, null );
    return $mCustomHelper -> returnCatchAsJson($mCustomResponse );
    }
    } catch (PDOException $e) {
        $mErrorResponse = new ErrorResponse(500, $e -> getMessage(), true);
        return $mCustomHelper -> returnCatchAsJson($mErrorResponse );
    }
>>>>>>> Actualizacion de API 13-marzo-2020

});

//Eliminar ventas
$app -> delete('/api/ventas/eliminar/{IdVenta}', function(Request $request, Response $response){
    
  $mCustomHelper = new MyCustomHelper();
      
  $idVenta = $request -> getAttribute('IdVenta');
  
    $consulta = "DELETE FROM venta WHERE IdVenta = '$idVenta';";
  
    try {
  
      //Instanciacion de base de datos
        $db = new db();
        $db = $db -> conectar();
        $stmt = $db -> query($consulta);
        $stmt -> execute();
        $db = null;
        
<<<<<<< HEAD
    if($stmt) {
        return $response->withStatus(200)
            ->withHeader('Content-Type', 'application/json')
            ->write(json_encode($stmt));
      }
    } catch (PDOException $e) {
      echo '{"error": {"text": '.$e -> getMessage().'} }';
=======
        if ($stmt) { 
            $mCustomResponse = new CustomResponse(200,'Se eliminó venta con éxito.', null, null, null );
            return $mCustomHelper -> returnCatchAsJson($mCustomResponse );
        }
    } catch (PDOException $e) {
        $mErrorResponse = new ErrorResponse(500, $e -> getMessage(), true);
        return $mCustomHelper -> returnCatchAsJson($mErrorResponse );
>>>>>>> Actualizacion de API 13-marzo-2020
    }
  
  
  });




?>
