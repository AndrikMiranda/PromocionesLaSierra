<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

//$app = new \Slim\App;

//INCOMPLETO. Estructura de otra ruta (para guiarse).

//obetener todas las notificaciones
$app -> get('/api/notificaciones', function(Request $request, Response $response){

  $consulta = "SELECT
  `tabla_valor`.`idTablaValor`,
  `tabla_valor`.`clave`,
  `tabla_valor`.`descripcion1`,
  `tabla_valor`.`dato1`,
  `tabla_valor`.`descripcion2`,
  `tabla_valor`.`dato2`,
  `tabla_valor`.`descripcion3`,
  `tabla_valor`.`dato3`,
  `tabla_valor`.`descripcion4`,
  `tabla_valor`.`dato4`,
  `tabla_valor`.`descripcion5`,
  `tabla_valor`.`dato5`,
  `tabla_valor`.`descripcion6`,
  `tabla_valor`.`dato6`,
  `tabla_valor`.`descripcion7`,
  `tabla_valor`.`dato7`,
  `tabla_valor`.`descripcion8`,
  `tabla_valor`.`dato8`,
  `tabla_valor`.`descripcion9`,
  `tabla_valor`.`dato9`,
  `tabla_valor`.`descripcion10`,
  `tabla_valor`.`dato10`,
  `tabla_valor`.`descripcion11`,
  `tabla_valor`.`dato11`,
  `tabla_valor`.`descripcion12`,
  `tabla_valor`.`dato12`,
  `tabla_valor`.`descripcion13`,
  `tabla_valor`.`dato13`,
  `tabla_valor`.`descripcion14`,
  `tabla_valor`.`dato14`,
  `tabla_valor`.`descripcion15`,
  `tabla_valor`.`dato15`,
  `tabla_valor`.`descripcion16`,
  `tabla_valor`.`dato16`,
  `tabla_valor`.`descripcion17`,
  `tabla_valor`.`dato17`,
  `tabla_valor`.`descripcion18`,
  `tabla_valor`.`dato18`
FROM
  `tabla_valor`";



  try {

    //Instanciacion de base de datos
      $db = new db();
      $db = $db -> conectar();
      $ejecutar = $db -> query($consulta);
      $notificaciones = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
      $db = null;

      //Exportar y mostrar JSON
      echo json_encode($notificaciones);

  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e -> getMessage().'}';
  }

});

//obetener todas las notificaciones por clave
$app -> get('/api/notificaciones/{clave}', function(Request $request, Response $response){

  $clave = $request -> getAttribute('clave');

  $consulta = "SELECT
  `tabla_valor`.`clave`,
  `tabla_valor`.`descripcion1`,
  `tabla_valor`.`dato1`,
  `tabla_valor`.`descripcion2`,
  `tabla_valor`.`dato2`,
  `tabla_valor`.`descripcion3`,
  `tabla_valor`.`dato3`,
  `tabla_valor`.`descripcion4`,
  `tabla_valor`.`dato4`,
  `tabla_valor`.`descripcion5`,
  `tabla_valor`.`dato5`,
  `tabla_valor`.`descripcion6`,
  `tabla_valor`.`dato6`,
  `tabla_valor`.`descripcion7`,
  `tabla_valor`.`dato7`,
  `tabla_valor`.`descripcion8`,
  `tabla_valor`.`dato8`,
  `tabla_valor`.`descripcion9`,
  `tabla_valor`.`dato9`,
  `tabla_valor`.`descripcion10`,
  `tabla_valor`.`dato10`,
  `tabla_valor`.`descripcion11`,
  `tabla_valor`.`dato11`,
  `tabla_valor`.`descripcion12`,
  `tabla_valor`.`dato12`,
  `tabla_valor`.`descripcion13`,
  `tabla_valor`.`dato13`,
  `tabla_valor`.`descripcion14`,
  `tabla_valor`.`dato14`,
  `tabla_valor`.`descripcion15`,
  `tabla_valor`.`dato15`,
  `tabla_valor`.`descripcion16`,
  `tabla_valor`.`dato16`,
  `tabla_valor`.`descripcion17`,
  `tabla_valor`.`dato17`,
  `tabla_valor`.`descripcion18`,
  `tabla_valor`.`dato18`
FROM
  `tabla_valor`
  WHERE `tabla_valor`.`clave` = $clave";

  try {

    //Instanciacion de base de datos
      $db = new db();
      $db = $db -> conectar();
      $ejecutar = $db -> query($consulta);
      $notificaciones = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
      $db = null;

      //Exportar y mostrar JSON
      echo json_encode($notificaciones);

  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e -> getMessage().'}';
  }

});

//agregar notificaciones de clientes
$app -> post('/api/notificaciones/agregarCliente', function(Request $request, Response $response){

$clave = $request -> getParam('clave');
$nombre = $request -> getParam('Nombre');
$aPaterno = $request -> getParam('APaterno');
$aMaterno = $request -> getParam('AMaterno');
$fechaNacimiento = $request -> getParam('FechaNacimiento');
$sexo = $request -> getParam('Sexo');
$telefono = $request -> getParam('Telefono');
$celular = $request -> getParam('Celular');
$casaPropia = $request -> getParam('CasaPropia');
$autoPropio = $request -> getParam('AutoPropio');
$lugarTrabajo = $request -> getParam('LugarTrabajo');
$telTrabajo = $request -> getParam('TelTrabajo');
$antiguedad = $request -> getParam('Antiguedad');
$fkDireccion = $request -> getParam('FkDireccion');
$fkDireccionCobro = $request -> getParam('FkDireccionCobro');
$estatus = $request -> getParam('Estatus');

$consulta0 = "SELECT `cliente`.`Nombre`,
             `cliente`.`APaterno`,
             `cliente`.`AMaterno`,
             `cliente`.`FechaNacimiento`,
             `cliente`.`Sexo`,
             `cliente`.`Telefono`,
             `cliente`.`Celular`,
             `cliente`.`CasaPropia`,
             `cliente`.`AutoPropio`,
             `cliente`.`TelTrabajo`,
             `cliente`.`LugarTrabajo`,
             `cliente`.`Antiguedad`,
             `cliente`.`FkDireccion`,
             `cliente`.`FkDireccionCobro`,
             `cliente`.`Estatus`
             FROM `cliente`
             WHERE `Nombre` = '".$nombre."' OR `APaterno` = '".$aPaterno."'  OR `AMaterno` = '".$aMaterno."' OR `FechaNacimiento` = '".$fechaNacimiento."'
              OR `Sexo` = '".$sexo."' OR `Telefono` = '".$telefono."' OR `Celular` = '".$celular."' OR `CasaPropia` = '".$casaPropia."' OR `AutoPropio` = '".$autoPropio."'
              OR `LugarTrabajo` = '".$lugarTrabajo."' OR `TelTrabajo` = '".$telTrabajo."' OR `Antiguedad` = '".$antiguedad."' OR `FkDireccion` = '".$fkDireccion."'
              OR `FkDireccionCobro` = '".$fkDireccionCobro."' OR `Estatus` = '".$estatus."'";

$numRows = mysqli_num_rows($consulta0);
if($numRows > 0)
{

echo '{"notice": {"text": coincidencias = "'.$numRows.'"}';

$consulta = "INSERT INTO tabla_valor (
            `tabla_valor`.`clave`,
            `tabla_valor`.`descripcion1`,  `tabla_valor`.`dato1`,
            `tabla_valor`.`descripcion2`,  `tabla_valor`.`dato2`,
            `tabla_valor`.`descripcion3`,  `tabla_valor`.`dato3`,
            `tabla_valor`.`descripcion4`,  `tabla_valor`.`dato4`,
            `tabla_valor`.`descripcion5`, `tabla_valor`.`dato5`,
            `tabla_valor`.`descripcion6`,  `tabla_valor`.`dato6`,
            `tabla_valor`.`descripcion7`,  `tabla_valor`.`dato7`,
            `tabla_valor`.`descripcion8`,  `tabla_valor`.`dato8`,
            `tabla_valor`.`descripcion9`,  `tabla_valor`.`dato9`,
            `tabla_valor`.`descripcion10`, `tabla_valor`.`dato10`,
            `tabla_valor`.`descripcion11`, `tabla_valor`.`dato11`,
            `tabla_valor`.`descripcion12`, `tabla_valor`.`dato12`,
            `tabla_valor`.`descripcion13`, `tabla_valor`.`dato13`,
            `tabla_valor`.`descripcion14`, `tabla_valor`.`dato14`,
            `tabla_valor`.`descripcion15`, `tabla_valor`.`dato15`)
                values (:clave,
                        'Nombre',:Nombre,
                        'APaterno',:APaterno,
                        'AMaterno',:AMaterno,
                        'FechaNacimiento', :FechaNacimiento,
                        'Sexo',:Sexo,
                        'Telefono', :Telefono,
                        'Celular', :Celular,
                        'CasaPropia', :CasaPropia,
                        'AutoPropio', :AutoPropio,
                        'LugarTrabajo', :LugarTrabajo,
                        'TelTrabajo',:TelTrabajo,
                        'Antiguedad',:Antiguedad,
                        'FkDireccion', :FkDireccion,
                        'FkDireccionCobro', :FkDireccionCobro,
                        'Estatus', :Estatus)";

/*
values (:Clave, Nombre, :Nombre, APaterno, :APaterno, AMaterno, :AMaterno, FechaNacimiento, :FechaNacimiento,
Sexo, :Sexo, Telefono, :Telefono, Celular, :Celular, CasaPropia, :CasaPropia, AutoPropio, :AutoPropio, LugarTrabajo, :LugarTrabajo,
TelTrabajo, :TelTrabajo, Antiguedad, :Antiguedad, FkDireccion, :FkDireccion, FkDireccionCobro, :FkDireccionCobro, Estatus, :Estatus)";
*/

  try {

    //Instanciacion de base de datos
      $db = new db();
      $db = $db -> conectar();
      $stmt = $db -> prepare($consulta);
      $stmt -> bindParam(':clave', $clave);
      $stmt -> bindParam(':Nombre', $nombre);
      $stmt -> bindParam(':APaterno', $aPaterno);
      $stmt -> bindParam(':AMaterno', $aMaterno);
      $stmt -> bindParam(':FechaNacimiento', $fechaNacimiento);
      $stmt -> bindParam(':Sexo', $sexo);
      $stmt -> bindParam(':Telefono', $telefono);
      $stmt -> bindParam(':Celular', $celular);
      $stmt -> bindParam(':CasaPropia', $casaPropia);
      $stmt -> bindParam(':AutoPropio', $autoPropio);
      $stmt -> bindParam(':LugarTrabajo', $lugarTrabajo);
      $stmt -> bindParam(':TelTrabajo', $telTrabajo);
      $stmt -> bindParam(':Antiguedad', $antiguedad);
      $stmt -> bindParam(':FkDireccion', $fkDireccion);
      $stmt -> bindParam(':FkDireccionCobro', $fkDireccionCobro);
      $stmt -> bindParam(':Estatus', $estatus);
      $stmt -> execute();
      echo '{"notice": {"text": "Cliente agregado" '.$numRows.'}';
      //Exportar y mostrar JSON

  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e -> getMessage().'}';
  }

} else {
  echo '{"notice": {"text": nel no hay coincidencias = "'.$numRows.'"}';
}

});



//Actualizar notificaciones de clientes
$app -> put('/api/notificaciones/actualizar/{idTablaValor}', function(Request $request, Response $response){

  $id = $request -> getAttribute('idTablaValor');
  $nombre = $request -> getParam('Nombre');
  $aPaterno = $request -> getParam('APaterno');
  $aMaterno = $request -> getParam('AMaterno');
  $fechaNacimiento = $request -> getParam('FechaNacimiento');
  $sexo = $request -> getParam('Sexo');
  $telefono = $request -> getParam('Telefono');
  $celular = $request -> getParam('Celular');
  $casaPropia = $request -> getParam('CasaPropia');
  $autoPropio = $request -> getParam('AutoPropio');
  $lugarTrabajo = $request -> getParam('LugarTrabajo');
  $telTrabajo = $request -> getParam('TelTrabajo');
  $antiguedad = $request -> getParam('Antiguedad');
  $fkDireccion = $request -> getParam('FkDireccion');
  $fkDireccionCobro = $request -> getParam('FkDireccionCobro');
  $estatus = $request -> getParam('Estatus');



  $consulta = "UPDATE  tabla_valor SET
  `tabla_valor`.`dato1` =                       :Nombre,
  `tabla_valor`.`dato2` =                     :APaterno,
  `tabla_valor`.`dato3` =                     :AMaterno,
  `tabla_valor`.`dato4` =              :FechaNacimiento,
  `tabla_valor`.`dato5` =                         :Sexo,
  `tabla_valor`.`dato6` =                     :Telefono,
  `tabla_valor`.`dato7` =                      :Celular,
  `tabla_valor`.`dato8` =                   :CasaPropia,
  `tabla_valor`.`dato9` =                   :AutoPropio,
  `tabla_valor`.`dato10` =                :LugarTrabajo,
  `tabla_valor`.`dato11` =                  :TelTrabajo,
  `tabla_valor`.`dato12` =                  :Antiguedad,
  `tabla_valor`.`dato13` =                 :FkDireccion,
  `tabla_valor`.`dato14` =            :FkDireccionCobro,
  `tabla_valor`.`dato15` =                     :Estatus,
  `tabla_valor`.`dato16` =                         null,
  `tabla_valor`.`dato17` =                         null,
  `tabla_valor`.`dato18` =                         null
  WHERE idTablaValor = $id";

  try {

    //Instanciacion de base de datos
      $db = new db();
      $db = $db -> conectar();
      $stmt = $db -> prepare($consulta);
      $stmt -> bindParam(':Nombre', $nombre);
      $stmt -> bindParam(':APaterno', $aPaterno);
      $stmt -> bindParam(':AMaterno', $aMaterno);
      $stmt -> bindParam(':FechaNacimiento', $fechaNacimiento);
      $stmt -> bindParam(':Sexo', $sexo);
      $stmt -> bindParam(':Telefono', $telefono);
      $stmt -> bindParam(':Celular', $celular);
      $stmt -> bindParam(':CasaPropia', $casaPropia);
      $stmt -> bindParam(':AutoPropio', $autoPropio);
      $stmt -> bindParam(':LugarTrabajo', $lugarTrabajo);
      $stmt -> bindParam(':TelTrabajo', $telTrabajo);
      $stmt -> bindParam(':Antiguedad', $antiguedad);
      $stmt -> bindParam(':FkDireccion', $fkDireccion);
      $stmt -> bindParam(':FkDireccionCobro', $fkDireccionCobro);
      $stmt -> bindParam(':Estatus', $estatus);
      $stmt -> execute();
      echo '{"notice": {"text": "notificación actualizado"}';
      //Exportar y mostrar JSON

  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e -> getMessage().'}';
  }


});

//Actualizar estatus de la notificaciones de venta
$app -> put('/api/notificaciones/actualizarEstatus/{idTablaValor}', function(Request $request, Response $response){

  $id = $request -> getAttribute('idTablaValor');
  $estatus = $request -> getParam('Estatus');



  $consulta = "UPDATE  tabla_valor SET
  `tabla_valor`.`dato15` =                     :Estatus
  WHERE idTablaValor = $id";

  try {

    //Instanciacion de base de datos
      $db = new db();
      $db = $db -> conectar();
      $stmt = $db -> prepare($consulta);
      $stmt -> bindParam(':Estatus', $estatus);
      $stmt -> execute();
      echo '{"notice": {"text": "notificación actualizado"}';
      //Exportar y mostrar JSON

  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e -> getMessage().'}';
  }


});

//Eliminar notificación
$app -> delete('/api/notificaciones/eliminar/{idTablaValor}', function(Request $request, Response $response){

$id = $request -> getAttribute('idTablaValor');

  $consulta = "DELETE FROM tabla_valor WHERE idTablaValor = '$id';";

  try {

    //Instanciacion de base de datos
      $db = new db();
      $db = $db -> conectar();
      $stmt = $db -> query($consulta);
      $stmt -> execute();
      $db = null;
      echo '{"notice": {"text": "Notificación borrada"}';
  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e -> getMessage().'}';
  }


});













/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
/* * * * * * * * * * * * * * * * * * * * V E N T A S * * * * * * * * * * * * * * * */
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

/*
ESTATUS DE APROBACION
1 - ESPERA
2 - APROBADO
3 - RECHAZADO
*/


//agregar notificaciones de ventas -> ESTATUS POR DEFECTO 1 - ESPERA
$app->post('/api/notificaciones/ventas/agregar', function (Request $request, Response $response) {

    $clave = $request->getParam('clave');
    $fkCuenta = $request->getParam('FkCuenta');
    $fkSubVenta = $request->getParam('FkSubVenta');
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

    $consulta = "INSERT INTO tabla_valor(`tabla_valor`.`clave`,
                                `tabla_valor`.`descripcion1`, `tabla_valor`.`dato1`,
                                `tabla_valor`.`descripcion2`, `tabla_valor`.`dato2`,
                                `tabla_valor`.`descripcion3`, `tabla_valor`.`dato3`,
                                `tabla_valor`.`descripcion4`, `tabla_valor`.`dato4`,
                                `tabla_valor`.`descripcion5`, `tabla_valor`.`dato5`,
                                `tabla_valor`.`descripcion6`, `tabla_valor`.`dato6`,
                                `tabla_valor`.`descripcion7`, `tabla_valor`.`dato7`,
                                `tabla_valor`.`descripcion8`, `tabla_valor`.`dato8`,
                                `tabla_valor`.`descripcion9`, `tabla_valor`.`dato9`,
                                `tabla_valor`.`descripcion10`, `tabla_valor`.`dato10`,
                                `tabla_valor`.`descripcion11`, `tabla_valor`.`dato11`,
                                `tabla_valor`.`descripcion12`, `tabla_valor`.`dato12`,
                                `tabla_valor`.`descripcion13`, `tabla_valor`.`dato13`,
                                `tabla_valor`.`descripcion14`, `tabla_valor`.`dato14`)
                  values (:clave,
                          'FkCuenta', :FkCuenta, 
                          'FkSubVenta', :FkSubVenta, 
                          'TotalVenta', :TotalVenta, 
                          'Enganche', :Enganche, 
                          'Fecha', CURDATE(),
                          'FkVendedor', :FkVendedor, 
                          'PeriodoPago', :PeriodoPago, 
                          'CantidadAbono', :CantidadAbono, 
                          'SaldoPendiente', :SaldoPendiente, 
                          'HorarioCobro', :HorarioCobro, 
                          'TipoVenta', :TipoVenta, 
                          'GpsLat', :GpsLat, 
                          'GpsLon', :GpsLon,
                          'EstatusAprobacion', 1)";

    try {

        //Instanciacion de base de datos
        $db = new db();
        $db = $db->conectar();
        $stmt = $db->prepare($consulta);

        $stmt->bindParam(':clave', $clave);
        $stmt->bindParam(':FkCuenta', $fkCuenta);
        $stmt->bindParam(':FkSubVenta', $fkSubVenta);
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

        $stmt->execute();
        echo '{"notice": {"text": "Cliente agregado" ' . $numRows . '}';
        //Exportar y mostrar JSON

    } catch (PDOException $e) {
        echo '{"error": {"text": ' . $e->getMessage() . '}';
    }

});


//obetener notificaciones de venta por estatus
$app -> get('/api/notificaciones/ventas/Estatus/{estatus}', function(Request $request, Response $response){

  $estatus = $request -> getAttribute('estatus');

  $consulta = "SELECT
    tabla_valor.idTablaValor,
    tabla_valor.clave,
    tabla_valor.descripcion1,
    tabla_valor.dato1,
    tabla_valor.descripcion2,
    tabla_valor.dato2,
    tabla_valor.descripcion3,
    tabla_valor.dato3,
    tabla_valor.descripcion4,
    tabla_valor.dato4,
    tabla_valor.descripcion5,
    tabla_valor.dato5,
    tabla_valor.descripcion6,
    tabla_valor.dato6,
    tabla_valor.descripcion7,
    tabla_valor.dato7,
    tabla_valor.descripcion8,
    tabla_valor.dato8,
    tabla_valor.descripcion9,
    tabla_valor.dato9,
    tabla_valor.descripcion10,
    tabla_valor.dato10,
    tabla_valor.descripcion11,
    tabla_valor.dato11,
    tabla_valor.descripcion12,
    tabla_valor.dato12,
    tabla_valor.descripcion13,
    tabla_valor.dato13,
    tabla_valor.descripcion14,
    tabla_valor.dato14
  FROM
    tabla_valor
  WHERE
    tabla_valor.dato14 = $estatus";

  try {

    //Instanciacion de base de datos
      $db = new db();
      $db = $db -> conectar();
      $ejecutar = $db -> query($consulta);
      $notificaciones = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
      $db = null;

      //Exportar y mostrar JSON
      echo json_encode($notificaciones);

  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e -> getMessage().'}';
  }

});

//obetener notificaciones de venta por estatus
$app -> get('/api/notificaciones/ventas/EstatusId/{idTablaValor}', function(Request $request, Response $response){

  $idTablaValor = $request -> getAttribute('idTablaValor');

  $consulta = "SELECT
    tabla_valor.idTablaValor,
    tabla_valor.clave,
    tabla_valor.descripcion1,
    tabla_valor.dato1,
    tabla_valor.descripcion2,
    tabla_valor.dato2,
    tabla_valor.descripcion3,
    tabla_valor.dato3,
    tabla_valor.descripcion4,
    tabla_valor.dato4,
    tabla_valor.descripcion5,
    tabla_valor.dato5,
    tabla_valor.descripcion6,
    tabla_valor.dato6,
    tabla_valor.descripcion7,
    tabla_valor.dato7,
    tabla_valor.descripcion8,
    tabla_valor.dato8,
    tabla_valor.descripcion9,
    tabla_valor.dato9,
    tabla_valor.descripcion10,
    tabla_valor.dato10,
    tabla_valor.descripcion11,
    tabla_valor.dato11,
    tabla_valor.descripcion12,
    tabla_valor.dato12,
    tabla_valor.descripcion13,
    tabla_valor.dato13,
    tabla_valor.descripcion14,
    tabla_valor.dato14
  FROM
    tabla_valor
  WHERE
    tabla_valor.idTablaValor = $idTablaValor and tabla_valor.clave = 'NOTI-VENT'";

  try {

    //Instanciacion de base de datos
      $db = new db();
      $db = $db -> conectar();
      $ejecutar = $db -> query($consulta);
      $notificaciones = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
      $db = null;

      //Exportar y mostrar JSON
      echo json_encode($notificaciones);

  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e -> getMessage().'}';
  }

});


//Actualizar notificaciones de venta
$app->put('/api/notificaciones/ventas/actualizar/{idTablaValor}', function (Request $request, Response $response) {

    $idTablaValor = $request->getAttribute('idTablaValor');
    $clave = $request->getParam('clave');
    $fkCuenta = $request->getParam('FkCuenta');
    $fkSubVenta = $request->getParam('FkSubVenta');
    $totalVenta = $request->getParam('TotalVenta');
    $enganche = $request->getParam('Enganche');
    $fecha = $request->getParam('Fecha');
    $fkVendedor = $request->getParam('FkVendedor');
    $periodoPago = $request->getParam('PeriodoPago');
    $cantidadAbono = $request->getParam('CantidadAbono');
    $saldoPendiente = $request->getParam('SaldoPendiente');
    $horarioCobro = $request->getParam('HorarioCobro');
    $tipoVenta = $request->getParam('TipoVenta');
    $gpsLat = $request->getParam('GpsLat');
    $gpsLon = $request->getParam('GpsLon');
    $estatusAprobacion = $request->getParam('EstatusAprobacion');

    $consulta = "UPDATE  tabla_valor SET
                    `tabla_valor`.`dato1` = :FkCuenta,
                    `tabla_valor`.`dato2` = :FkSubVenta,
                    `tabla_valor`.`dato3` = :TotalVenta,
                    `tabla_valor`.`dato4` = :Enganche,
                    `tabla_valor`.`dato5` = :Fecha,
                    `tabla_valor`.`dato6` = :FkVendedor,
                    `tabla_valor`.`dato7` = :PeriodoPago,
                    `tabla_valor`.`dato8` = :CantidadAbono,
                    `tabla_valor`.`dato9` = :SaldoPendiente,
                    `tabla_valor`.`dato10` = :HorarioCobro,
                    `tabla_valor`.`dato11` = :TipoVenta,
                    `tabla_valor`.`dato12` = :GpsLat,
                    `tabla_valor`.`dato13` = :GpsLon,
                    `tabla_valor`.`dato14` =  :EstatusAprobacion
                WHERE idTablaValor = $idTablaValor AND clave = :clave";

    try {

        //Instanciacion de base de datos
        $db = new db();
        $db = $db->conectar();
        $stmt = $db->prepare($consulta);

        $stmt->bindParam(':FkCuenta', $fkCuenta);
        $stmt->bindParam(':FkSubVenta', $fkSubVenta);
        $stmt->bindParam(':TotalVenta', $totalVenta);
        $stmt->bindParam(':Enganche', $enganche);
        $stmt->bindParam(':Fecha', $fecha);
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
        echo '{"notice": {"text": "notificación de venta actualizado"}';
        //Exportar y mostrar JSON

    } catch (PDOException $e) {
        echo '{"error": {"text": ' . $e->getMessage() . '}';
    }

});

//APROBAR VENTA
$app->put('/api/notificaciones/ventas/aprobar/{idTablaValor}', function (Request $request, Response $response) {

  $idTablaValor = $request->getAttribute('idTablaValor');
  $fkCuenta = $request->getParam('FkCuenta');
  $fkSubVenta = $request->getParam('FkSubVenta');
  $totalVenta = $request->getParam('TotalVenta');
  $enganche = $request->getParam('Enganche');
  $fecha = $request->getParam('Fecha');
  $fkVendedor = $request->getParam('FkVendedor');
  $periodoPago = $request->getParam('PeriodoPago');
  $cantidadAbono = $request->getParam('CantidadAbono');
  $saldoPendiente = $request->getParam('SaldoPendiente');
  $horarioCobro = $request->getParam('HorarioCobro');
  $tipoVenta = $request->getParam('TipoVenta');
  $gpsLat = $request->getParam('GpsLat');
  $gpsLon = $request->getParam('GpsLon');

  $consulta = "UPDATE  tabla_valor SET
                  `tabla_valor`.`dato1` = :FkCuenta,
                  `tabla_valor`.`dato2` = :FkSubVenta,
                  `tabla_valor`.`dato3` = :TotalVenta,
                  `tabla_valor`.`dato4` = :Enganche,
                  `tabla_valor`.`dato5` = :Fecha,
                  `tabla_valor`.`dato6` = :FkVendedor,
                  `tabla_valor`.`dato7` = :PeriodoPago,
                  `tabla_valor`.`dato8` = :CantidadAbono,
                  `tabla_valor`.`dato9` = :SaldoPendiente,
                  `tabla_valor`.`dato10` = :HorarioCobro,
                  `tabla_valor`.`dato11` = :TipoVenta,
                  `tabla_valor`.`dato12` = :GpsLat,
                  `tabla_valor`.`dato13` = :GpsLon,
                  `tabla_valor`.`dato14` =  2
              WHERE idTablaValor = $idTablaValor AND clave = 'NOTI-VENT'";

  try {

      //Instanciacion de base de datos
      $db = new db();
      $db = $db->conectar();
      $stmt = $db->prepare($consulta);

      $stmt->bindParam(':FkCuenta', $fkCuenta);
      $stmt->bindParam(':FkSubVenta', $fkSubVenta);
      $stmt->bindParam(':TotalVenta', $totalVenta);
      $stmt->bindParam(':Enganche', $enganche);
      $stmt->bindParam(':Fecha', $fecha);
      $stmt->bindParam(':FkVendedor', $fkVendedor);
      $stmt->bindParam(':PeriodoPago', $periodoPago);
      $stmt->bindParam(':CantidadAbono', $cantidadAbono);
      $stmt->bindParam(':SaldoPendiente', $saldoPendiente);
      $stmt->bindParam(':HorarioCobro', $horarioCobro);
      $stmt->bindParam(':TipoVenta', $tipoVenta);
      $stmt->bindParam(':GpsLat', $gpsLat);
      $stmt->bindParam(':GpsLon', $gpsLon);

      $stmt->execute();
      echo '{"notice": {"text": "Venta aprobada"}';
      //Exportar y mostrar JSON

  } catch (PDOException $e) {
      echo '{"error": {"text": ' . $e->getMessage() . '}';
  }

});

//RECHAZAR VENTA
$app->put('/api/notificaciones/ventas/rechazar/{idTablaValor}', function (Request $request, Response $response) {

  $idTablaValor = $request->getAttribute('idTablaValor');
  $fkCuenta = $request->getParam('FkCuenta');
  $fkSubVenta = $request->getParam('FkSubVenta');
  $totalVenta = $request->getParam('TotalVenta');
  $enganche = $request->getParam('Enganche');
  $fecha = $request->getParam('Fecha');
  $fkVendedor = $request->getParam('FkVendedor');
  $periodoPago = $request->getParam('PeriodoPago');
  $cantidadAbono = $request->getParam('CantidadAbono');
  $saldoPendiente = $request->getParam('SaldoPendiente');
  $horarioCobro = $request->getParam('HorarioCobro');
  $tipoVenta = $request->getParam('TipoVenta');
  $gpsLat = $request->getParam('GpsLat');
  $gpsLon = $request->getParam('GpsLon');

  $consulta = "UPDATE  tabla_valor SET
                  `tabla_valor`.`dato1` = :FkCuenta,
                  `tabla_valor`.`dato2` = :FkSubVenta,
                  `tabla_valor`.`dato3` = :TotalVenta,
                  `tabla_valor`.`dato4` = :Enganche,
                  `tabla_valor`.`dato5` = :Fecha,
                  `tabla_valor`.`dato6` = :FkVendedor,
                  `tabla_valor`.`dato7` = :PeriodoPago,
                  `tabla_valor`.`dato8` = :CantidadAbono,
                  `tabla_valor`.`dato9` = :SaldoPendiente,
                  `tabla_valor`.`dato10` = :HorarioCobro,
                  `tabla_valor`.`dato11` = :TipoVenta,
                  `tabla_valor`.`dato12` = :GpsLat,
                  `tabla_valor`.`dato13` = :GpsLon,
                  `tabla_valor`.`dato14` =  3
              WHERE idTablaValor = $idTablaValor AND clave = 'NOTI-VENT'";

  try {

      //Instanciacion de base de datos
      $db = new db();
      $db = $db->conectar();
      $stmt = $db->prepare($consulta);

      $stmt->bindParam(':FkCuenta', $fkCuenta);
      $stmt->bindParam(':FkSubVenta', $fkSubVenta);
      $stmt->bindParam(':TotalVenta', $totalVenta);
      $stmt->bindParam(':Enganche', $enganche);
      $stmt->bindParam(':Fecha', $fecha);
      $stmt->bindParam(':FkVendedor', $fkVendedor);
      $stmt->bindParam(':PeriodoPago', $periodoPago);
      $stmt->bindParam(':CantidadAbono', $cantidadAbono);
      $stmt->bindParam(':SaldoPendiente', $saldoPendiente);
      $stmt->bindParam(':HorarioCobro', $horarioCobro);
      $stmt->bindParam(':TipoVenta', $tipoVenta);
      $stmt->bindParam(':GpsLat', $gpsLat);
      $stmt->bindParam(':GpsLon', $gpsLon);

      $stmt->execute();
      echo '{"notice": {"text": "Venta Rechazada"}';
      //Exportar y mostrar JSON

  } catch (PDOException $e) {
      echo '{"error": {"text": ' . $e->getMessage() . '}';
  }

});

//Eliminar notificación
$app->delete('/api/notificaciones/ventas/eliminar/{idTablaValor}', function (Request $request, Response $response) {

    $idTablaValor = $request->getAttribute('idTablaValor');

    $consulta = "DELETE FROM tabla_valor 
                 WHERE idTablaValor = :idTablaValor";

    try {

        //Instanciacion de base de datos
        $db = new db();
        $db = $db->conectar();
        $stmt = $db->prepare($consulta);

        $stmt->bindParam(':idTablaValor', $idTablaValor);

        $stmt->execute();
        $db = null;
        echo '{"notice": {"text": "Notificación de venta borrada"}';
    } catch (PDOException $e) {
        echo '{"error": {"text": ' . $e->getMessage() . '}';
    }

});


?>
