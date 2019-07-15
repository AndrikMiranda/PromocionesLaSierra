<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

//---------------------------------------OBTENER REGISTRO COBRADOR POR MES
$app -> get('/api/cobradores/{IdCobrador}', function(Request $request, Response $response){

$id = $request -> getAttribute('IdCobrador');

  $consulta = "SELECT
  cobrador.`IdCobrador`,
  cobrador.`NombreCobrador`,
  cobrador.`APaterno`,
  cobrador.`AMaterno`,
  ruta.`NumeroRuta`,
  cobranza.`FechaCobro`,
  cobranza.`Abono`,
  cobranza.`MontoVencido`,
  cobranza.`AbonoVencido`,
  cobranza.`AbonoAtrasado`,
  venta.`TotalVenta`,
  venta.`PeriodoPago`,
  venta.`CantidadAbono`,
  venta.`SaldoPendiente`
FROM
  cobrador,
  cobranza,
  ruta,
  venta
WHERE
  cobranza.`FechaCobro` = Month(CurDate()) AND
  cobrador.`IdCobrador` = $id";

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

//---------------------------------------OBTENER REGISTRO EXCELENTES CLIENTES
$app -> get('/api/reportes/Execelentes', function(Request $request, Response $response){

  $consulta = "SELECT
  `cliente`.`IdCliente`,
  `cliente`.`Nombre`,
  `cliente`.`APaterno`,
  `cliente`.`AMaterno`,
  `cliente`.`Celular`,
  `cuenta`.`EstatusPagador`,
  `cuenta`.`ContadorVencidos`,
  `cuenta`.`ContadorAtrasados`,
  `cobranza`.`MontoVencido`,
  `cuenta`.`NumeroCuenta`,
  `cuenta`.`SaldoTotal`,
  `ruta`.`NumeroRuta`
FROM
  `ruta`,
  `cliente`,
  `cobranza`,
  `cuenta`,
  `venta`
  WHERE EstatusPagador = 'Execelente'
  ORDER BY SaldoTotal DESC LIMIT 30";

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

//---------------------------------------OBTENER REGISTRO BUENOS CLIENTES
$app -> get('/api/reportes/Buenos', function(Request $request, Response $response){

  $consulta = "SELECT
  `cliente`.`IdCliente`,
  `cliente`.`Nombre`,
  `cliente`.`APaterno`,
  `cliente`.`AMaterno`,
  `cliente`.`Celular`,
  `cuenta`.`EstatusPagador`,
  `cuenta`.`ContadorVencidos`,
  `cuenta`.`ContadorAtrasados`,
  `cuenta`.`NumeroCuenta`,
  `cuenta`.`SaldoTotal`
FROM
  `cuenta`
INNER JOIN `cliente` ON `cuenta`.`FkCliente` = `cliente`.`IdCliente`
  WHERE EstatusPagador = 'Bueno'
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

//---------------------------------------OBTENER REGISTRO REGULARES
$app -> get('/api/reportes/Regulares', function(Request $request, Response $response){

  $consulta = "SELECT
  `cliente`.`IdCliente`,
  `cliente`.`Nombre`,
  `cliente`.`APaterno`,
  `cliente`.`AMaterno`,
  `cliente`.`Celular`,
  `cuenta`.`EstatusPagador`,
  `cuenta`.`ContadorVencidos`,
  `cuenta`.`ContadorAtrasados`,
  `cuenta`.`NumeroCuenta`,
  `cuenta`.`SaldoTotal`
FROM
  `cuenta`
INNER JOIN `cliente` ON `cuenta`.`FkCliente` = `cliente`.`IdCliente`
  WHERE EstatusPagador = 'Regular'
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

//---------------------------------------OBTENER REGISTRO MALOS CLIENTES
$app -> get('/api/reportes/Malos', function(Request $request, Response $response){

  $consulta = "SELECT
  `cliente`.`IdCliente`,
  `cliente`.`Nombre`,
  `cliente`.`APaterno`,
  `cliente`.`AMaterno`,
  `cliente`.`Celular`,
  `cuenta`.`EstatusPagador`,
  `cuenta`.`ContadorVencidos`,
  `cuenta`.`ContadorAtrasados`,
  `cuenta`.`NumeroCuenta`,
  `cuenta`.`SaldoTotal`
FROM
  `cuenta`
INNER JOIN `cliente` ON `cuenta`.`FkCliente` = `cliente`.`IdCliente`
  WHERE EstatusPagador = 'Malo'
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

//---------------------------------------OBTENER REGISTRO lISTA NEGRA
$app -> get('/api/reportes/ListaNegra', function(Request $request, Response $response){

  $consulta = "SELECT
  `cliente`.`IdCliente`,
  `cliente`.`Nombre`,
  `cliente`.`APaterno`,
  `cliente`.`AMaterno`,
  `cliente`.`Celular`,
  `cuenta`.`EstatusPagador`,
  `cuenta`.`ContadorVencidos`,
  `cuenta`.`ContadorAtrasados`,
  `cuenta`.`NumeroCuenta`,
  `cuenta`.`SaldoTotal`
FROM
  `cuenta`
INNER JOIN `cliente` ON `cuenta`.`FkCliente` = `cliente`.`IdCliente`
  WHERE EstatusPagador = 'ListaNegra'
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


//---------------------------------------OBTENER REGISTRO EXCELENTES CLIENTES CON ELECCION DE CANTIDAD
$app -> get('/api/reportes/Execelentes/{Numero}', function(Request $request, Response $response){

  $cantidadMostrar = $request -> getAttribute('Numero');

  $consulta = "SELECT
  `cliente`.`IdCliente`,
  `cliente`.`Nombre`,
  `cliente`.`APaterno`,
  `cliente`.`AMaterno`,
  `cliente`.`Celular`,
  `cuenta`.`EstatusPagador`,
  `cuenta`.`ContadorVencidos`,
  `cuenta`.`ContadorAtrasados`,
  `cobranza`.`MontoVencido`,
  `cuenta`.`NumeroCuenta`,
  `cuenta`.`SaldoTotal`,
  `ruta`.`NumeroRuta`
FROM
  `ruta`,
  `cliente`,
  `cobranza`,
  `cuenta`,
  `venta`
  WHERE EstatusPagador = 'Execelente'
  ORDER BY SaldoTotal DESC LIMIT $cantidadMostrar";

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

//---------------------------------------OBTENER REGISTRO BUENOS CLIENTES CON ELECCION DE CANTIDAD
$app -> get('/api/reportes/Buenos/{Numero}', function(Request $request, Response $response){

  $cantidadMostrar = $request -> getAttribute('Numero');

  $consulta = "SELECT
  `cliente`.`IdCliente`,
  `cliente`.`Nombre`,
  `cliente`.`APaterno`,
  `cliente`.`AMaterno`,
  `cliente`.`Celular`,
  `cuenta`.`EstatusPagador`,
  `cuenta`.`ContadorVencidos`,
  `cuenta`.`ContadorAtrasados`,
  `cuenta`.`NumeroCuenta`,
  `cuenta`.`SaldoTotal`
FROM
  `cuenta`
INNER JOIN `cliente` ON `cuenta`.`FkCliente` = `cliente`.`IdCliente`
  WHERE EstatusPagador = 'Bueno'
  ORDER BY SaldoTotal DESC LIMIT $cantidadMostrar;";

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

//---------------------------------------OBTENER REGISTRO REGULARES CLIENTES CON ELECCION DE CANTIDAD
$app -> get('/api/reportes/Regulares/{Numero}', function(Request $request, Response $response){

  $cantidadMostrar = $request -> getAttribute('Numero');

  $consulta = "SELECT
  `cliente`.`IdCliente`,
  `cliente`.`Nombre`,
  `cliente`.`APaterno`,
  `cliente`.`AMaterno`,
  `cliente`.`Celular`,
  `cuenta`.`EstatusPagador`,
  `cuenta`.`ContadorVencidos`,
  `cuenta`.`ContadorAtrasados`,
  `cuenta`.`NumeroCuenta`,
  `cuenta`.`SaldoTotal`
FROM
  `cuenta`
INNER JOIN `cliente` ON `cuenta`.`FkCliente` = `cliente`.`IdCliente`
  WHERE EstatusPagador = 'Regular'
  ORDER BY SaldoTotal DESC LIMIT $cantidadMostrar;";

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

//---------------------------------------OBTENER REGISTRO MALOS CLIENTES CON ELECCION DE CANTIDAD
$app -> get('/api/reportes/Malos/{Numero}', function(Request $request, Response $response){

  $cantidadMostrar = $request -> getAttribute('Numero');

  $consulta = "SELECT
  `cliente`.`IdCliente`,
  `cliente`.`Nombre`,
  `cliente`.`APaterno`,
  `cliente`.`AMaterno`,
  `cliente`.`Celular`,
  `cuenta`.`EstatusPagador`,
  `cuenta`.`ContadorVencidos`,
  `cuenta`.`ContadorAtrasados`,
  `cuenta`.`NumeroCuenta`,
  `cuenta`.`SaldoTotal`
FROM
  `cuenta`
INNER JOIN `cliente` ON `cuenta`.`FkCliente` = `cliente`.`IdCliente`
  WHERE EstatusPagador = 'Malo'
  ORDER BY SaldoTotal DESC LIMIT $cantidadMostrar;";

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

//---------------------------------------OBTENER REGISTRO LISTA NEGRA CON ELECCION DE CANTIDAD
$app -> get('/api/reportes/ListaNegra/{Numero}', function(Request $request, Response $response){

  $cantidadMostrar = $request -> getAttribute('Numero');

  $consulta = "SELECT
  `cliente`.`IdCliente`,
  `cliente`.`Nombre`,
  `cliente`.`APaterno`,
  `cliente`.`AMaterno`,
  `cliente`.`Celular`,
  `cuenta`.`EstatusPagador`,
  `cuenta`.`ContadorVencidos`,
  `cuenta`.`ContadorAtrasados`,
  `cuenta`.`NumeroCuenta`,
  `cuenta`.`SaldoTotal`
FROM
  `cuenta`
INNER JOIN `cliente` ON `cuenta`.`FkCliente` = `cliente`.`IdCliente`
  WHERE EstatusPagador = 'ListaNegra'
  ORDER BY SaldoTotal DESC LIMIT $cantidadMostrar;";

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
