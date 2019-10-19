<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;


//---------------------------------------OBTENER REGISTRO COBRADOR POR MES MEDIANTE EL ID
$app -> get('/api/cobradores/{IdCobrador}', function(Request $request, Response $response){

$id = $request -> getAttribute('IdCobrador');

  $consulta = "SELECT
  `cobrador`.`IdCobrador`,
  `cobrador`.`NombreCobrador`,
  `cobrador`.`APaterno`,
  `cobrador`.`AMaterno`,
  `cobrador`.`Estatus`,
  `ruta`.`NumeroRuta`,
  `cobranza`.`FechaCobro`,
  `cobranza`.`Abono`,
  `cobranza`.`MontoVencido`,
  `cobranza`.`AbonoVencido`,
  `cobranza`.`AbonoAtrasado`,
  `cobranza`.`GpsLat`,
  `cobranza`.`GpsLon`,
  `venta`.`TotalVenta`,
  `venta`.`PeriodoPago`,
  `venta`.`CantidadAbono`,
  `venta`.`SaldoPendiente`
FROM
  `cobranza`
  INNER JOIN `venta` ON `venta`.`IdVenta` = `cobranza`.`FkVenta`
  INNER JOIN `cobrador` ON `cobranza`.`FkCobrador` = `cobrador`.`IdCobrador`
  INNER JOIN `ruta` ON `cobrador`.`FkRuta` = `ruta`.`IdRuta`
WHERE
  `cobranza`.`FechaCobro` = Month(CurDate()) AND
  `cobrador`.`IdCobrador` = $id";

  try {

    //Instanciacion de base de datos
      $db = new db();
      $db = $db -> conectar();
      $ejecutar = $db -> query($consulta);
      $cobradorMes = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
      $db = null;

      //Exportar y mostrar JSON
      echo json_encode($cobradorMes);

  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e -> getMessage().'}';
  }

});

//---------------------------------------OBTENER REGISTRO COBRADOR POR MES
$app -> get('/api/cobradores/nombre/{NombreCobrador}', function(Request $request, Response $response){

$nombre = $request -> getAttribute('NombreCobrador');

  $consulta = "SELECT
  `cobrador`.`IdCobrador`,
  `cobrador`.`NombreCobrador`,
  `cobrador`.`APaterno`,
  `cobrador`.`AMaterno`,
  `cobrador`.`Estatus`,
  `ruta`.`NumeroRuta`,
  `cobranza`.`FechaCobro`,
  `cobranza`.`Abono`,
  `cobranza`.`MontoVencido`,
  `cobranza`.`AbonoVencido`,
  `cobranza`.`AbonoAtrasado`,
  `cobranza`.`GpsLat`,
  `cobranza`.`GpsLon`,
  `venta`.`TotalVenta`,
  `venta`.`PeriodoPago`,
  `venta`.`CantidadAbono`,
  `venta`.`SaldoPendiente`
FROM
  `cobranza`
  INNER JOIN `venta` ON `venta`.`IdVenta` = `cobranza`.`FkVenta`
  INNER JOIN `cobrador` ON `cobranza`.`FkCobrador` = `cobrador`.`IdCobrador`
  INNER JOIN `ruta` ON `cobrador`.`FkRuta` = `ruta`.`IdRuta`
WHERE
  
  `cobrador`.`NombreCobrador` LIKE '%$nombre%'";

  try {

    //Instanciacion de base de datos
      $db = new db();
      $db = $db -> conectar();
      $ejecutar = $db -> query($consulta);
      $cobradorMes = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
      $db = null;

      //Exportar y mostrar JSON
      echo json_encode($cobradorMes);

  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e -> getMessage().'}';
  }

});


//---------------------------------------OBTENER REGISTRO POR ESTATUS CLIENTES
$app -> get('/api/reportes/{EstatusPagador}', function(Request $request, Response $response){

$estatus = $request -> getAttribute('EstatusPagador');

  $consulta = "SELECT
  cliente.`IdCliente`,
  cliente.`Nombre`,
  cliente.`APaterno`,
  cliente.`AMaterno`,
  cliente.`Celular`,
  cuenta.`EstatusPagador`,
  cuenta.`ContadorVencidos`,
  cuenta.`ContadorAtrasados`,
  cuenta.`NumeroCuenta`,
  cuenta.`SaldoTotal`
FROM
  cuenta
INNER JOIN cliente ON cuenta.`FkCliente` = cliente.`IdCliente`
  WHERE EstatusPagador = '$estatus'
  ORDER BY SaldoTotal DESC LIMIT 30;";
  try {

    //Instanciacion de base de datos
      $db = new db();
      $db = $db -> conectar();
      $ejecutar = $db -> query($consulta);
      $reportes = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
      $db = null;

      //Exportar y mostrar JSON
      echo json_encode($reportes);

  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e -> getMessage().'}';
  }

});


?>
