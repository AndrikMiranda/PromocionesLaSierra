<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

//$app = new \Slim\App;

//INCOMPLETO. Estructura de otra ruta (para guiarse).

$fkVendedorParaSubVenta;

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

$consulta0 = "SELECT `cliente`.`IdCliente`
             FROM `cliente`
             WHERE `Nombre` = '".$nombre."' AND `APaterno` = '".$aPaterno."'  AND `AMaterno` = '".$aMaterno."' AND `FechaNacimiento` = '".$fechaNacimiento."'
              OR `Telefono` = '".$telefono."' OR `Celular` = '".$celular."'";

              try {

                //Instanciacion de base de datos
                  $db = new db();
                  $db = $db -> conectar();
                  $ejecutar = $db -> query($consulta0);
                  $notificaciones = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
                  $db = null;
                  $row_cnt = $notificaciones->num_rows;
                  //echo json_encode($notificaciones);
                  $json = json_encode($notificaciones);

              } catch (PDOException $e) {
                echo '{"error": {"text": '.$e -> getMessage().'}';
              }

if ($notificaciones == null) {
  echo '{"notice": {"text": "No se encontraron coincidencias."}';
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
      echo '{"notice": {"text": "Cliente agregado"}';
      //Exportar y mostrar JSON

  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e -> getMessage().'}';
  }
} else{
  echo '{"notice": {"text": se encontraron coincidencias = "'.$json.'"}';
  $coincidencia = '1';
  $consulta = ("INSERT INTO tabla_valor (
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
    `tabla_valor`.`descripcion15`, `tabla_valor`.`dato15`,
    `tabla_valor`.`descripcion16`, `tabla_valor`.`dato16`,
    `tabla_valor`.`descripcion17`, `tabla_valor`.`dato17`)
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
                'Estatus', :Estatus,
                'Coincidencias', :Coincidencias,
                'IdCliente', :IdCliente)");


try {

$decode=json_decode($json, true);
$idCliente = $decode[0]['IdCliente'];
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
$stmt -> bindParam(':Coincidencias', $coincidencia);
$stmt -> bindParam(':IdCliente', $idCliente);
$stmt -> execute();
echo '{"notice": {"text": "Cliente agregado"}';
//Exportar y mostrar JSON

} catch (PDOException $e) {
echo '{"error": {"text": '.$e -> getMessage().'}';
}
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
  $json = $request->getParsedBody();
  
  foreach ($json as $notificacion) {
    echo($notificacion["tipo_notificacion"]);
    if ($notificacion["tipo_notificacion"] == "venta"){
      echo 'FkCuenta: ' . ($notificacion["datos"]["FkCuenta"]);
      echo 'TotalVenta: ' . ($notificacion["datos"]["TotalVenta"]);
      echo 'Enganche: ' . ($notificacion["datos"]["Enganche"]);
      echo 'FkVendedor: ' . ($notificacion["datos"]["FkVendedor"]);
      echo 'PeriodoPago: ' . ($notificacion["datos"]["PeriodoPago"]);
      echo 'CantidadAbono: ' . ($notificacion["datos"]["CantidadAbono"]);
      echo 'SaldoPendiente: ' . ($notificacion["datos"]["SaldoPendiente"]);
      echo 'HorarioCobro: ' . ($notificacion["datos"]["HorarioCobro"]);
      echo 'TipoVenta: ' . ($notificacion["datos"]["TipoVenta"]);
      echo 'GpsLat: ' . ($notificacion["datos"]["GpsLat"]);
      echo 'GpsLon: ' . ($notificacion["datos"]["GpsLon"]);
      echo 'EstatusAprobacion: ' . ($notificacion["datos"]["EstatusAprobacion"]);
      
      insert_tabla_valor_venta('NOTI-VENTA',$notificacion["datos"]["FkCuenta"],$notificacion["datos"]["TotalVenta"],
                                            $notificacion["datos"]["Enganche"],$notificacion["datos"]["FkVendedor"],$notificacion["datos"]["PeriodoPago"],
                                            $notificacion["datos"]["CantidadAbono"],$notificacion["datos"]["SaldoPendiente"],$notificacion["datos"]["HorarioCobro"],
                                            $notificacion["datos"]["TipoVenta"],$notificacion["datos"]["GpsLat"],$notificacion["datos"]["GpsLon"]);
                                            
      $fkVendedorParaSubVenta = $notificacion["datos"]["FkVendedor"];
                                            
  }
    if ($notificacion["tipo_notificacion"] == "subventa"){
      foreach ($notificacion["datos"] as $subventa) {
        echo'FkArticulo: ' . ($subventa["FkArticulo"]);
        echo'Cantidad: ' . ($subventa["Cantidad"]);
        echo'SubTotal: ' . ($subventa["SubTotal"]);
        echo'FkVenta: ' . ($subventa["FkVenta"]);
        echo'--------------------------------------------------------------------------------------------';
        insert_tabla_valor_subventa('NOTI-SUBVENTA', $subventa["FkArticulo"], $subventa["Cantidad"], $subventa["SubTotal"], $fkVendedorParaSubVenta);
      }  
    }
  }
    
});

function insert_tabla_valor_venta ($clave,$fkCuenta,$totalVenta,$enganche,$fkVendedor,$periodoPago,$cantidadAbono,$saldoPendiente,$horarioCobro, $tipoVenta,$gpsLat, $gpsLon){
 
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
                                `tabla_valor`.`descripcion13`, `tabla_valor`.`dato13`)
                  values (:clave,
                          'FkCuenta', :fkCuenta, 
                          'TotalVenta', :totalVenta, 
                          'Enganche', :enganche, 
                          'Fecha', CURDATE(),
                          'FkVendedor', :fkVendedor, 
                          'PeriodoPago', :periodoPago, 
                          'CantidadAbono', :cantidadAbono, 
                          'SaldoPendiente', :saldoPendiente, 
                          'HorarioCobro', :horarioCobro, 
                          'TipoVenta', :tipoVenta, 
                          'GpsLat', :gpsLat, 
                          'GpsLon', :gpsLon,
                          'EstatusAprobacion', 1)";
                            
                        try {
                        
                              //Instanciacion de base de datos
                              $db = new db();
                              $db = $db->conectar();
                              $stmt = $db->prepare($consulta);
                        
                              $stmt->bindParam(':clave', $clave);
                              $stmt->bindParam(':fkCuenta', $fkCuenta);
                              $stmt->bindParam(':totalVenta', $totalVenta);
                              $stmt->bindParam(':enganche', $enganche);
                              $stmt->bindParam(':fkVendedor', $fkVendedor);
                              $stmt->bindParam(':periodoPago', $periodoPago);
                              $stmt->bindParam(':cantidadAbono', $cantidadAbono);
                              $stmt->bindParam(':saldoPendiente', $saldoPendiente);
                              $stmt->bindParam(':horarioCobro', $horarioCobro);
                              $stmt->bindParam(':tipoVenta', $tipoVenta);
                              $stmt->bindParam(':gpsLat', $gpsLat);
                              $stmt->bindParam(':gpsLon', $gpsLon);
                        
                              $stmt->execute();
                              echo '{"notice": {"text": "Venta aprobada"}';
                              //Exportar y mostrar JSON
                        
                          } catch (PDOException $e) {
                              echo '{"error": {"text": ' . $e->getMessage() . '}';
                          }
           
}

function consulta_ultima_venta_de_vendedor_tabla_valor($FkVendedor){
    
    echo '\n
         {"$FkVendedor": {" --> ": '.$FkVendedor.'}'; 
    
    $consulta = "SELECT idTablaValor 
                        FROM tabla_valor 
                        WHERE tabla_valor.clave = 'NOTI-VENTA' AND
                        dato5 = $FkVendedor
                        ORDER BY idTablaValor 
                        DESC LIMIT 1";
                        
                        try {
                        
                              //Instanciacion de base de datos
                              $db = new db();
                              $db = $db -> conectar();
                              $ejecutar = $db -> query($consulta);
                              $stmt = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
                              $db = null;
                              echo '\n
                              {"notice": {"text": "Venta aprobada"}';
                              
                              //Exportar y mostrar JSON
                              $encode = json_encode($stmt);
                              echo '\n
                              {"$encode": {" --> ": ' . $encode . '}';
                              
                              $decode = json_decode($encode ,true);
                              echo '\n
                              {"$decode": {" --> ": ' . $decode . '}';
                              
                              $idTablaValorDelVendedor = $decode[0]['idTablaValor'];
                              echo '\n
                              {"$idTablaValorDelVendedor": {" --> ": ' . $idTablaValorDelVendedor . '}';
                              
                              return $idTablaValorDelVendedor;
                        
                          } catch (PDOException $e) {
                              echo '{"error": {"text": ' . $e->getMessage() . '}';
                          }
}


function insert_tabla_valor_subventa ($clave, $FkArticulo, $Cantidad, $SubTotal, $FkVendedor){
 
 $idTablaValorDeVendedor = consulta_ultima_venta_de_vendedor_tabla_valor($FkVendedor);
 
 
  $consulta = "INSERT INTO tabla_valor(clave,
                                       descripcion1, dato1,
                                       descripcion2, dato2,
                                       descripcion3, dato3,
                                       descripcion4, dato4)
                                VALUES (:clave,
                                       'FkArticulo', :FkArticulo, 
                                       'Cantidad', :Cantidad, 
                                       'SubTotal', :SubTotal, 
                                       'FkVenta',  :idTablaValorDeVendedor)";
                            
                        try {
                        
                              //Instanciacion de base de datos
                              $db = new db();
                              $db = $db->conectar();
                              $stmt = $db->prepare($consulta);
                        
                              $stmt->bindParam(':clave', $clave);
                              $stmt->bindParam(':FkArticulo', $FkArticulo);
                              $stmt->bindParam(':Cantidad', $Cantidad);
                              $stmt->bindParam(':SubTotal', $SubTotal);
                              $stmt->bindParam(':idTablaValorDeVendedor', $idTablaValorDeVendedor);
                              

                              $stmt->execute();
                              echo '{"notice": {"text": "Venta aprobada"}';
                              //Exportar y mostrar JSON
                        
                          } catch (PDOException $e) {
                              echo '{"error": {"text": ' . $e->getMessage() . '}';
                          }
           
}

function update_tabla_valor_subventa (){
 
  $consulta = "INSERT INTO tabla_valor(clave,
                                       descripcion1, dato1,
                                       descripcion2, dato2,
                                       descripcion3, dato3,
                                       descripcion4, dato4)
                                VALUES (:clave,
                                       'FkArticulo', :FkArticulo, 
                                       'Cantidad', :Cantidad, 
                                       'SubTotal', :SubTotal, 
                                       'FkVenta', :FkVenta)";
                            
                        try {
                        
                              //Instanciacion de base de datos
                              $db = new db();
                              $db = $db->conectar();
                              $stmt = $db->prepare($consulta);
                        
                              $stmt->bindParam(':clave', $clave);
                              $stmt->bindParam(':FkArticulo', $FkArticulo);
                              $stmt->bindParam(':Cantidad', $Cantidad);
                              $stmt->bindParam(':SubTotal', $SubTotal);
                              $stmt->bindParam(':FkVenta', $FkVenta);
                        
                              $stmt->execute();
                              echo '{"notice": {"text": "Venta aprobada"}';
                              //Exportar y mostrar JSON
                        
                          } catch (PDOException $e) {
                              echo '{"error": {"text": ' . $e->getMessage() . '}';
                          }
           
}

//APROBAR VENTA
$app->put('/api/notificaciones/ventas/aprobar/{idTablaValor}', function (Request $request, Response $response) {

  $idTablaValor = $request->getAttribute('idTablaValor');

  $consulta = "UPDATE tabla_valor
               SET dato13 = 2
               WHERE clave = 'NOTI-VENTA' AND
                     idTablaValor = :idTablaValor";

  try {

      //Instanciacion de base de datos
      $db = new db();
      $db = $db->conectar();
      $stmt = $db->prepare($consulta);

      $stmt->bindParam(':idTablaValor', $idTablaValor);

      $stmt->execute();
      echo '{"notice": {"text": "Venta aprobada"}';
      //Exportar y mostrar JSON

  } catch (PDOException $e) {
      echo '{"error": {"text": ' . $e->getMessage() . '}';
  }

});



//agregar venta desde tablaValor a tabla Venta
//IdTablaValor se manda desde la tabla de notificaciones 
$app -> post('/api/notificaciones/venta/completar', function(Request $request, Response $response){

  $idTablaValor = $request -> getParam('idTablaValor');
  
  $consulta = "INSERT INTO venta(FkCuenta, TotalVenta, Enganche, Fecha, FkVendedor, PeriodoPago, CantidadAbono, SaldoPendiente, HorarioCobro, TipoVenta, GpsLat, GpsLon, EstatusAprobacion)
                SELECT CAST(dato1 AS INT), CAST(dato2 AS DOUBLE), CAST(dato3 AS DOUBLE), DATE(dato4), CAST(dato5 AS INT), dato6, CAST(dato7 AS DOUBLE), CAST(dato8 AS DOUBLE), CAST(dato9 AS INT), CAST(dato10 AS INT), CAST(dato11 AS DOUBLE), CAST(dato12 AS DOUBLE), CAST(dato13 AS CHAR)
                FROM tabla_valor
                WHERE tabla_valor.clave = 'NOTI-VENTA' AND
                      tabla_valor.idTablaValor = :idTablaValor AND 
                      tabla_valor.dato13 = 2";
  
  try {
    //Instanciacion de base de datos
    $db = new db();
    $db = $db->conectar();
    $stmt = $db->prepare($consulta);

    $stmt->bindParam(':idTablaValor', $idTablaValor);

    $stmt->execute();
    echo '{"notice": {"text": "Venta agregada a tabla venta" ' . $numRows . '}';
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

//Update NOTI-SUBVENTA con  FkVenta de la tabla Venta.
$app->put('/api/notificaciones/ventas/actualizar/subventa/', function (Request $request, Response $response) {

  $FkVenta = $request->getParam('FkVenta');//FkVentaReal
  $idTablaValor = $request->getParam('idTablaValor');

  $consulta = "UPDATE tabla_valor
               SET dato4 = :FkVenta
               WHERE clave = 'NOTI-SUBVENTA' AND
               dato4 = :idTablaValor";

  try {

      //Instanciacion de base de datos
      $db = new db();
      $db = $db->conectar();
      $stmt = $db->prepare($consulta);

      $stmt->bindParam(':idTablaValor', $idTablaValor);
      $stmt->bindParam(':FkVenta', $FkVenta);

      $stmt->execute();
      echo '{"notice": {"text": "Update realizado de subventa"}';
      //Exportar y mostrar JSON

  } catch (PDOException $e) {
      echo '{"error": {"text": ' . $e->getMessage() . '}';
  }

});

//agregar subventa desde tablaValor a tabla subVenta
$app->post('/api/notificaciones/subventa/agregar/', function (Request $request, Response $response) {

   $json = $request->getParsedBody();
  
  foreach ($json["subventa"] as $notificacion) {
   
      echo 'FkCuenta: ' . ($notificacion["FkArticulo"]);
      echo 'TotalVenta: ' . ($notificacion["Cantidad"]);
      echo 'Enganche: ' . ($notificacion["SubTotal"]);
      echo 'FkVendedor: ' . ($notificacion["FkVenta"]);
      
      insert_subventa_desde_tabla_valor( $notificacion["FkArticulo"], $notificacion["Cantidad"], $notificacion["SubTotal"], $notificacion["FkVenta"] );
        
  }
  

});


function insert_subventa_desde_tabla_valor ($FkArticulo, $Cantidad, $SubTotal, $FkVenta){
 
  $consultaNotificacionVenta = "INSERT INTO subventa(FkArticulo, Cantidad, SubTotal, FkVenta)
                                VALUES( :FkArticulo, :Cantidad, :SubTotal, :FkVenta)";
                            
                        try {
                        
                              //Instanciacion de base de datos
                              $db = new db();
                              $db = $db->conectar();
                              $stmt = $db->prepare($consultaNotificacionVenta);
                        
                              $stmt->bindParam(':FkArticulo', $FkArticulo);
                              $stmt->bindParam(':Cantidad', $Cantidad);
                              $stmt->bindParam(':SubTotal', $SubTotal);
                              $stmt->bindParam(':FkVenta', $FkVenta);
                        
                              $stmt->execute();
                              echo '{"notice": {"text": "Venta aprobada"}';
                              //Exportar y mostrar JSON
                        
                          } catch (PDOException $e) {
                              echo '{"error": {"text": ' . $e->getMessage() . '}';
                          }
           
}



//obetener notificaciones de vendedor por id.
$app -> get('/api/notificaciones/ventas/{IdVendedor}', function(Request $request, Response $response){

  $fKVendedor = $request -> getAttribute('IdVendedor');

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
    tabla_valor.clave = 'NOTI-VENTA'
    tabla_valor.dato5 = $fKVendedor";

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

//RECHAZAR VENTA CON MOTIVO
$app->put('/api/notificaciones/ventas/rechazar/{idTablaValor}', function (Request $request, Response $response) {

  $idTablaValor = $request->getAttribute('idTablaValor');
  $fkCuenta = $request->getParam('FkCuenta');
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

  $razonRechazo = $request->getParam('razonRechazo');

  $consulta = "UPDATE  tabla_valor SET
                  dato1 = :FkCuenta,
                  dato2 = :TotalVenta,
                  dato3 = :Enganche,
                  dato4 = :Fecha,
                  dato5 = :FkVendedor,
                  dato6 = :PeriodoPago,
                  dato7 = :CantidadAbono,
                  dato8 = :SaldoPendiente,
                  dato9 = :HorarioCobro,
                  dato10 = :TipoVenta,
                  dato11 = :GpsLat,
                  dato12 = :GpsLon,
                  dato13 = 3,
                  dato14 = :razonRechazo
              WHERE idTablaValor = $idTablaValor AND 
                    clave = 'NOTI-VENTA'";

  try {

      //Instanciacion de base de datos
      $db = new db();
      $db = $db->conectar();
      $stmt = $db->prepare($consulta);

      $stmt->bindParam(':FkCuenta', $fkCuenta);
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
      $stmt->bindParam(':razonRechazo', $razonRechazo);

      $stmt->execute();
      echo '{"notice": {"text": "Venta Rechazada"}';
      //Exportar y mostrar JSON

  } catch (PDOException $e) {
      echo '{"error": {"text": ' . $e->getMessage() . '}';
  }

});

?>
