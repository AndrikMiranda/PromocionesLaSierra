<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

<<<<<<< HEAD
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
=======
//Obtener Cuentas con saldo Pendiente
$app -> get('/api/reporte/saldoPendiente', function(Request $request, Response $response){

    $consulta = "SELECT
                cliente.IdCliente,
                cliente.Nombre,
                cliente.APaterno,
                cliente.AMaterno,
                cuenta.NumeroCuenta,
                cuenta.ContadorVencidos,
                cuenta.ContadorAtrasados,
                cuenta.EstatusPagador,
                cuenta.SaldoTotal
                FROM
                cliente
                INNER JOIN cuenta ON cuenta.FkCliente = cliente.IdCliente
                WHERE cuenta.SaldoTotal > 0
                ORDER BY cuenta.SaldoTotal DESC";
 
    try {
 
          //Instanciacion de base de datos
           $db = new db();
           $db = $db -> conectar();
           $ejecutar = $db -> query($consulta);
           $SalPend = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
           $db = null;
 
           //Exportar y mostrar JSON
           echo json_encode($SalPend, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
 
       } catch (PDOException $e) {
           echo '{"error": {"text": '.$e -> getMessage().'}';
       }
 
});


//Obtener Cuentas en base a su estatus
$app -> get('/api/reporte/clientePorEstatus/{EstatusPagador}', function(Request $request, Response $response){

    $EstatusPagador = $request -> getAttribute('EstatusPagador');

    $consulta = "SELECT
                cliente.IdCliente,
                cliente.Nombre,
                cliente.APaterno,
                cliente.AMaterno,
                cuenta.NumeroCuenta,
                cuenta.ContadorVencidos,
                cuenta.ContadorAtrasados,
                cuenta.EstatusPagador,
                cuenta.SaldoTotal
                FROM
                cliente
                INNER JOIN cuenta ON cuenta.FkCliente = cliente.IdCliente
                WHERE cuenta.EstatusPagador = '$EstatusPagador'
                ORDER BY cuenta.SaldoTotal DESC";
 
    try {
 
          //Instanciacion de base de datos
           $db = new db();
           $db = $db -> conectar();
           $ejecutar = $db -> query($consulta);
           $SalPend = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
           $db = null;
 
           //Exportar y mostrar JSON
           echo json_encode($SalPend, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
 
       } catch (PDOException $e) {
           echo '{"error": {"text": '.$e -> getMessage().'}';
       }
 
});

//Obtener reporte mensual por ruta
$app -> get('/api/reporte/reporteMensualPorRuta/{ruta}/{mes}', function(Request $request, Response $response){

    $Ruta = $request -> getAttribute('ruta');
    $Mes = $request -> getAttribute('mes');

    $consulta = "SELECT
                ruta.NumeroRuta,
                ruta.FkColonia,
                cobranza.FkCobrador,
                usuario.Nombre,
                cuenta.NumeroCuenta,
                cuenta.SaldoTotal,
                cuenta.EstatusPagador,
                cuenta.FkCliente,
                cliente.Nombre,
                cliente.APaterno,
                cliente.AMaterno,
                cobranza.FechaCobro,
                cobranza.Abono,
                venta.TotalVenta
                FROM
                ruta
                INNER JOIN ruta_cobrador ON ruta_cobrador.fkRuta = ruta.IdRuta
                INNER JOIN cobranza ON ruta_cobrador.fkUsuario = cobranza.FkCobrador
                INNER JOIN usuario ON ruta_cobrador.fkUsuario = usuario.IdUsuario,
                cuenta
                INNER JOIN venta ON venta.FkCuenta = cuenta.IdCuenta
                INNER JOIN cliente ON cuenta.FkCliente = cliente.IdCliente
                WHERE
                MONTH(cobranza.FechaCobro) = $Mes AND
                ruta.NumeroRuta = $Ruta
                ORDER BY cobranza.FechaCobro DESC";
 
    try {
 
          //Instanciacion de base de datos
           $db = new db();
           $db = $db -> conectar();
           $ejecutar = $db -> query($consulta);
           $SalPend = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
           $db = null;
 
           //Exportar y mostrar JSON
           echo json_encode($SalPend, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
 
       } catch (PDOException $e) {
           echo '{"error": {"text": '.$e -> getMessage().'}';
       }
 
});

//Obtener reporte mensual por ruta por cobrador
$app -> get('/api/reporte/reporteMensualPorRutaPorCobrador/{ruta}/{mes}/{cobrador}', function(Request $request, Response $response){

    $Ruta = $request -> getAttribute('ruta');
    $Mes = $request -> getAttribute('mes');
    $Cobrador = $request -> getAttribute('cobrador');

    $consulta = "SELECT
                ruta.NumeroRuta,
                ruta.FkColonia,
                cobranza.FkCobrador,
                usuario.Nombre,
                cuenta.NumeroCuenta,
                cuenta.SaldoTotal,
                cuenta.EstatusPagador,
                cuenta.FkCliente,
                cliente.Nombre,
                cliente.APaterno,
                cliente.AMaterno,
                cobranza.FechaCobro,
                cobranza.Abono,
                venta.TotalVenta
                FROM
                ruta
                INNER JOIN ruta_cobrador ON ruta_cobrador.fkRuta = ruta.IdRuta
                INNER JOIN cobranza ON ruta_cobrador.fkUsuario = cobranza.FkCobrador
                INNER JOIN usuario ON ruta_cobrador.fkUsuario = usuario.IdUsuario,
                cuenta
                INNER JOIN venta ON venta.FkCuenta = cuenta.IdCuenta
                INNER JOIN cliente ON cuenta.FkCliente = cliente.IdCliente
                WHERE
                MONTH(cobranza.FechaCobro) = $Mes AND
                ruta.NumeroRuta = $Ruta AND
                cobranza.FkCobrador = $Cobrador
                ORDER BY cobranza.FechaCobro DESC";
 
    try {
 
          //Instanciacion de base de datos
           $db = new db();
           $db = $db -> conectar();
           $ejecutar = $db -> query($consulta);
           $SalPend = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
           $db = null;
 
           //Exportar y mostrar JSON
           echo json_encode($SalPend, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
 
       } catch (PDOException $e) {
           echo '{"error": {"text": '.$e -> getMessage().'}';
       }
 
});

//Obtener Cuentas en base a una ruta, ordenados por el saldoTotal
$app -> get('/api/reporte/clientePorRuta/{NumeroRuta}', function(Request $request, Response $response){

    $NumeroRuta = $request -> getAttribute('NumeroRuta');

    $consulta = "SELECT
                cuenta.NumeroCuenta,
                cuenta.SaldoTotal,
                cuenta.EstatusPagador,
                cliente.Nombre,
                cliente.APaterno,
                cliente.AMaterno,
                cliente.FkDireccion,
                direccion.FkColonia,
                cat_colonia.CP,
                cat_colonia.NomColonia,
                ruta.NumeroRuta
                FROM
                cuenta
                INNER JOIN cliente ON cuenta.FkCliente = cliente.IdCliente
                INNER JOIN direccion ON cliente.FkDireccion = direccion.IdDireccion AND cliente.FkDireccionCobro = direccion.IdDireccion AND cliente.FkDireccion = direccion.IdDireccion
                INNER JOIN cat_colonia ON direccion.FkColonia = cat_colonia.IdColonia
                INNER JOIN ruta ON ruta.FkColonia = cat_colonia.IdColonia
                WHERE ruta.NumeroRuta = $NumeroRuta
                ORDER BY cuenta.SaldoTotal DESC";
 
    try {
 
          //Instanciacion de base de datos
           $db = new db();
           $db = $db -> conectar();
           $ejecutar = $db -> query($consulta);
           $SalPend = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
           $db = null;
 
           //Exportar y mostrar JSON
           echo json_encode($SalPend, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
 
       } catch (PDOException $e) {
           echo '{"error": {"text": '.$e -> getMessage().'}';
       }
 
});

//Obtener Cuentas en base a una ruta, ordenados por el saldoTotal
$app -> get('/api/reporte/ventasPorVendedor/{idVendedor}', function(Request $request, Response $response){

    $idVendedor = $request -> getAttribute('idVendedor');

    $consulta = "SELECT
                venta.FkVendedor,
                usuario.Nombre,
                usuario.FkCat_Estatus_Usuario,
                venta.TotalVenta,
                venta.Fecha
                FROM
                venta
                INNER JOIN usuario ON venta.FkVendedor = usuario.IdUsuario
                WHERE venta.FkVendedor = $idVendedor
                ORDER BY venta.TotalVenta DESC";
 
    try {
 
          //Instanciacion de base de datos
           $db = new db();
           $db = $db -> conectar();
           $ejecutar = $db -> query($consulta);
           $SalPend = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
           $db = null;
 
           //Exportar y mostrar JSON
           echo json_encode($SalPend, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
 
       } catch (PDOException $e) {
           echo '{"error": {"text": '.$e -> getMessage().'}';
       }
 
});

//Obtener Lista Negra General
$app -> get('/api/reporte/listaNegra/', function(Request $request, Response $response){

    $FechaInicial = $request -> getParam('FechaInicial');
    $FechaFinal = $request -> getParam('FechaFinal');
    $Motivo = $request -> getParam('FkCat_Motivo');

    if(empty($Motivo) || $Motivo =='')
    {

            $consulta = "SELECT a.IdLIstaNegra,b.Nombre,b.APaterno,b.AMaterno,
                         c.TipoMotivo,a.Comentario,a.FechaAgregado 
                         FROM listanegra a,cliente b, cat_motivo c
                         WHERE a.FKCliente=b.IdCliente 
                         AND a.FKCat_Motivo=c.IdMotivo 
                         AND a.FechaAgregado>='$FechaInicial'
                         AND a.FechaAgregado<='$FechaFinal'
                         ORDER BY a.FechaAgregado DESC";
    }else{

             $consulta = "SELECT a.IdLIstaNegra,b.Nombre,b.APaterno,b.AMaterno,
                          c.TipoMotivo,a.Comentario,a.FechaAgregado  
                          FROM listanegra a,cliente b, cat_motivo c
                          WHERE a.FKCliente=b.IdCliente 
                          AND a.FKCat_Motivo=c.IdMotivo 
                          AND a.FechaAgregado>='$FechaInicial'
                          AND a.FechaAgregado<='$FechaFinal'
                          AND a.FkCat_Motivo=$Motivo
                          ORDER BY a.FechaAgregado DESC";
    }
    try {
 
          //Instanciacion de base de datos
           $db = new db();
           $db = $db -> conectar();
           $ejecutar = $db -> query($consulta);
           $Ruta = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
           $db = null;
 
           //Exportar y mostrar JSON
           echo json_encode($Ruta, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
 
       } catch (PDOException $e) {
           echo '{"error": {"text": '.$e -> getMessage().'}';
       }
 
});
>>>>>>> Actualizacion Arturo. Nuevo push para que Ruben vea version actualizada
