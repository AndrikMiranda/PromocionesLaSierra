<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

//$app = new \Slim\App;

//INCOMPLETO. Estructura de otra ruta (para guiarse).

//obetener todoscliente
$app -> get('/api/clientes', function(Request $request, Response $response){

  $consulta = "SELECT
  `cliente`.`IdCliente`,
  `cliente`.`Nombre`,
  `cliente`.`APaterno`,
  `cliente`.`AMaterno`,
  `cliente`.`FechaNacimiento`,
  `cliente`.`Sexo`,
  `cliente`.`Telefono`,
  `cliente`.`Celular`,
  `cliente`.`CasaPropia`,
  `cliente`.`AutoPropio`,
  `cliente`.`LugarTrabajo`,
  `cliente`.`TelTrabajo`,
  `cliente`.`Antiguedad`,
  `cliente`.`Estatus`,
  `cat_calle`.`NomCalle`,
  `direccion`.`NumExterior`,
  `direccion`.`NumInterior`,
  `cat_colonia`.`NomColonia`,
  `cat_colonia`.`CP`,
  `cat_municipio`.`NomMunicipio`,
  `cat_estado`.`NomEstado`
FROM
  `cliente`
  INNER JOIN `direccion` ON `direccion`.`IdDireccion` = `cliente`.`FkDireccion`
    AND `direccion`.`IdDireccion` = `cliente`.`FkDireccionCobro`
  INNER JOIN `cat_estado` ON `cat_estado`.`IdEstado` = `direccion`.`FkEstado`
  INNER JOIN `cat_municipio` ON `cat_municipio`.`IdMunicipio` =
    `direccion`.`FkMunicipio`
  INNER JOIN `cat_colonia` ON `cat_colonia`.`IdColonia` =
    `direccion`.`FkColonia`
  INNER JOIN `cat_calle` ON `cat_calle`.`IdCalle` = `direccion`.`FkCalle`";

  try {

    //Instanciacion de base de datos
      $db = new db();
      $db = $db -> conectar();
      $ejecutar = $db -> query($consulta);
      $clientes = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
      $db = null;

      //Exportar y mostrar JSON
      echo json_encode($clientes);

  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e -> getMessage().'}';
  }

});

//obetener clientes para ventas
$app -> get('/api/clientes/ventas', function(Request $request, Response $response){

  $consulta = "SELECT
  cliente.`IdCliente`,
  cliente.`Nombre`,
  cliente.`APaterno`,
  cliente.`AMaterno`,
  cuenta.`EstatusPagador`,
  cuenta.`NumeroCuenta`
  FROM
  cuenta
  INNER JOIN cliente ON cuenta.`FkCliente` = cliente.`IdCliente`";

  try {

    //Instanciacion de base de datos
      $db = new db();
      $db = $db -> conectar();
      $ejecutar = $db -> query($consulta);
      $clientes = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
      $db = null;

      //Exportar y mostrar JSON
      echo json_encode($clientes);

  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e -> getMessage().'}';
  }

});

//obetener cliente por id
$app -> get('/api/clientes/{IdCliente}', function(Request $request, Response $response){

$id = $request -> getAttribute('IdCliente');

  $consulta = "SELECT
  `cliente`.`IdCliente`,
  `cliente`.`Nombre`,
  `cliente`.`APaterno`,
  `cliente`.`AMaterno`,
  `cliente`.`FechaNacimiento`,
  `cliente`.`Sexo`,
  `cliente`.`Telefono`,
  `cliente`.`Celular`,
  `cliente`.`CasaPropia`,
  `cliente`.`AutoPropio`,
  `cliente`.`LugarTrabajo`,
  `cliente`.`TelTrabajo`,
  `cliente`.`Antiguedad`,
  `cliente`.`Estatus`,
  `cat_calle`.`NomCalle`,
  `direccion`.`NumExterior`,
  `direccion`.`NumInterior`,
  `cat_colonia`.`NomColonia`,
  `cat_colonia`.`CP`,
  `cat_municipio`.`NomMunicipio`,
  `cat_estado`.`NomEstado`
FROM
  `cliente`
  INNER JOIN `direccion` ON `direccion`.`IdDireccion` = `cliente`.`FkDireccion`
    AND `direccion`.`IdDireccion` = `cliente`.`FkDireccionCobro`
  INNER JOIN `cat_estado` ON `cat_estado`.`IdEstado` = `direccion`.`FkEstado`
  INNER JOIN `cat_municipio` ON `cat_municipio`.`IdMunicipio` =
    `direccion`.`FkMunicipio`
  INNER JOIN `cat_colonia` ON `cat_colonia`.`IdColonia` =
    `direccion`.`FkColonia`
  INNER JOIN `cat_calle` ON `cat_calle`.`IdCalle` = `direccion`.`FkCalle`
  WHERE `cliente`.`IdCliente` = $id";

  try {

    //Instanciacion de base de datos
      $db = new db();
      $db = $db -> conectar();
      $ejecutar = $db -> query($consulta);
      $clientes = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
      $db = null;

      //Exportar y mostrar JSON
      echo json_encode($clientes);

  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e -> getMessage().'}';
  }

});

//agregar Cliente
$app -> post('/api/clientes/agregar', function(Request $request, Response $response){

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


$consulta = "INSERT INTO cliente(Nombre, APaterno, AMaterno, FechaNacimiento,
Sexo, Telefono, Celular, CasaPropia, AutoPropio, LugarTrabajo, TelTrabajo, Antiguedad,
FkDireccion, FkDireccionCobro, Estatus)
values (:Nombre, :APaterno, :AMaterno, :FechaNacimiento,
:Sexo, :Telefono, :Celular, :CasaPropia, :AutoPropio, :LugarTrabajo, :TelTrabajo, :Antiguedad,
:FkDireccion, :FkDireccionCobro, :Estatus)";

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
      echo '{"notice": {"text": "Cliente agregado"}';
      //Exportar y mostrar JSON

  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e -> getMessage().'}';
  }


});


//Actualizar cliente
$app -> put('/api/clientes/actualizar/{IdCliente}', function(Request $request, Response $response){

  $id = $request -> getAttribute('IdCliente');
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



  $consulta = "UPDATE  Cliente SET
      Nombre =                       :Nombre,
      APaterno =                   :APaterno,
      AMaterno =                   :AMaterno,
      FechaNacimiento =     :FechaNacimiento,
      Sexo =                           :Sexo,
      Telefono =                   :Telefono,
      Celular =                     :Celular,
      CasaPropia =               :CasaPropia,
      AutoPropio =               :AutoPropio,
      LugarTrabajo =           :LugarTrabajo,
      TelTrabajo =               :TelTrabajo,
      Antiguedad =               :Antiguedad,
      FkDireccion =             :FkDireccion,
      FkDireccionCobro =   :FkDireccionCobro,
      Estatus =                      :Estatus

  WHERE IdCliente = $id";

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
      echo '{"notice": {"text": "Cliente actualizado"}';
      //Exportar y mostrar JSON

  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e -> getMessage().'}';
  }


});

//Eliminar cliente
$app -> delete('/api/clientes/eliminar/{IdCliente}', function(Request $request, Response $response){

$id = $request -> getAttribute('IdCliente');

  $consulta = "DELETE FROM Cliente WHERE IdCliente = '$id';";

  try {

    //Instanciacion de base de datos
      $db = new db();
      $db = $db -> conectar();
      $stmt = $db -> query($consulta);
      $stmt -> execute();
      $db = null;
      echo '{"notice": {"text": "Cliente borrado"}';
  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e -> getMessage().'}';
  }


});

/*

//Verificar coincidencias de cliente registrado y nuevo
$app -> get('/api/clientes', function(Request $request, Response $response){

  $consulta = "SELECT
  `cliente`.`IdCliente`,
  `cliente`.`Nombre`,
  `cliente`.`APaterno`,
  `cliente`.`AMaterno`,
  `cliente`.`FechaNacimiento`,
  `cliente`.`Sexo`,
  `cliente`.`Telefono`,
  `cliente`.`Celular`,
  `cliente`.`CasaPropia`,
  `cliente`.`AutoPropio`,
  `cliente`.`LugarTrabajo`,
  `cliente`.`TelTrabajo`,
  `cliente`.`Antiguedad`,
  `cliente`.`Estatus`,
  `cat_calle`.`NomCalle`,
  `direccion`.`NumExterior`,
  `direccion`.`NumInterior`,
  `cat_colonia`.`NomColonia`,
  `cat_colonia`.`CP`,
  `cat_municipio`.`NomMunicipio`,
  `cat_estado`.`NomEstado`
FROM
  `cliente`
  INNER JOIN `direccion` ON `direccion`.`IdDireccion` = `cliente`.`FkDireccion`
    AND `direccion`.`IdDireccion` = `cliente`.`FkDireccionCobro`
  INNER JOIN `cat_estado` ON `cat_estado`.`IdEstado` = `direccion`.`FkEstado`
  INNER JOIN `cat_municipio` ON `cat_municipio`.`IdMunicipio` =
    `direccion`.`FkMunicipio`
  INNER JOIN `cat_colonia` ON `cat_colonia`.`IdColonia` =
    `direccion`.`FkColonia`
  INNER JOIN `cat_calle` ON `cat_calle`.`IdCalle` = `direccion`.`FkCalle`";

  $consulta2 = "SELECT
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
WHERE `tabla_valor`.`clave` = 'NOTI_CLIE'";

  try {

    //Instanciacion de base de datos
      $db = new db();
      $db = $db -> conectar();
      $ejecutar = $db -> query($consulta);
      $clientes = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
      $db = null;

      //Exportar y mostrar JSON
      echo json_encode($clientes);

  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e -> getMessage().'}';
  }

});
*/
?>
