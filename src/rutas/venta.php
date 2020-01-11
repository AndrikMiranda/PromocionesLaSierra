<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

//$app = new \Slim\App;

//INCOMPLETO. Estructura de utra ruta (para guiarse).

//obetener todos los ventas
$app -> get('/api/ventas', function(Request $request, Response $response){

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
                venta";

  try {

    //Instanciacion de base de datos
      $db = new db();
      $db = $db -> conectar();
      $ejecutar = $db -> query($consulta);
      $ventas = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
      $db = null;

      //Exportar y mostrar JSON
      echo json_encode($ventas);

  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e -> getMessage().'}';
  }

});


//obetener una venta por id
$app -> get('/api/ventas/{IdVenta}', function(Request $request, Response $response){

  $idVenta = $request -> getAttribute('IdVenta');

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

      //Exportar y mostrar JSON
      echo json_encode($vendedores);

  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e -> getMessage().'}';
  }

});


//agregar venta
$app->post('/api/ventas/agregar', function (Request $request, Response $response) {

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

        echo '{"notice": {"text": "Venta agregada"}';
        //Exportar y mostrar JSON

    } catch (PDOException $e) {
        echo '{"error": {"text": ' . $e->getMessage() . '}';
    }

});



//Actualizar ventas
$app -> put('/api/ventas/actualizar/{IdVenta}', function(Request $request, Response $response){

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
    echo '{"notice": {"text": "Venta actualizado"}';

  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e -> getMessage().'}';
  }

});

//Eliminar ventas
$app -> delete('/api/ventas/eliminar/{IdVenta}', function(Request $request, Response $response){

  $idVenta = $request -> getAttribute('IdVenta');
  
    $consulta = "DELETE FROM venta WHERE IdVenta = '$idVenta';";
  
    try {
  
      //Instanciacion de base de datos
        $db = new db();
        $db = $db -> conectar();
        $stmt = $db -> query($consulta);
        $stmt -> execute();
        $db = null;
        echo '{"notice": {"text": "Venta borrada"}';
    } catch (PDOException $e) {
      echo '{"error": {"text": '.$e -> getMessage().'}';
    }
  
  
  });




?>
