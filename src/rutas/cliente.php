<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;


/*idUser int
* page - (int) Pagina a consultar
* pageSize - (int) Tamano de pagina
* likeSearch (string) Para busquqeda con %like%
* columnaGenerica - Columna para hacer busqueda generica, requiere columna como esta en la tabla de la DB.
* parametroGenerico - Condicion de busqueda generica
*/
/*Ruta general de GET glientes*/
$app -> get('/api/clientes', function(Request $request, Response $response){
  
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
                    *
                    FROM
                    cliente
                    WHERE ".$columnaGenerica." = '$parametroColumnaGenerica' 
                    LIMIT $limit
                    OFFSET $offset";
  
  $totalConsultaGenerica = "SELECT
                    (cliente.IdCliente)
                    FROM
                    cliente
                    WHERE ".$columnaGenerica." = '$parametroColumnaGenerica'";
  
  $consultaTodos = "SELECT
                    cliente.IdCliente,
                    CONCAT(cliente.Nombre,' ',cliente.APaterno,' ',cliente.AMaterno) as Nombre,
                    cliente.FechaNacimiento,
                    cliente.Sexo,
                    cliente.Telefono,
                    cliente.Celular,
                    cliente.CasaPropia,
                    cliente.AutoPropio,
                    cliente.LugarTrabajo,
                    cliente.TelTrabajo,
                    cliente.Antiguedad,
                    cliente.Estatus,
                    cat_calle.NomCalle,
                    direccion.NumExterior,
                    direccion.NumInterior,
                    cat_colonia.NomColonia,
                    cat_colonia.CP,
                    cat_municipio.NomMunicipio,
                    cat_estado.NomEstado,
                    cuenta.NumeroCuenta,
                    cuenta.EstatusPagador
                    FROM
                    cliente
                    INNER JOIN direccion ON direccion.IdDireccion = cliente.FkDireccion AND direccion.IdDireccion = cliente.FkDireccionCobro
                    INNER JOIN cat_estado ON cat_estado.IdEstado = direccion.FkEstado
                    INNER JOIN cat_municipio ON cat_municipio.IdMunicipio = direccion.FkMunicipio
                    INNER JOIN cat_colonia ON cat_colonia.IdColonia = direccion.FkColonia
                    INNER JOIN cat_calle ON cat_calle.IdCalle = direccion.FkCalle
                    INNER JOIN cuenta ON cuenta.FkCliente = cliente.IdCliente
                    LIMIT $limit
                    OFFSET $offset";

  $consultaLikeSearch = "SELECT
                        cliente.IdCliente,
                        CONCAT(cliente.Nombre,' ',cliente.APaterno,' ',cliente.AMaterno) as Nombre,
                        cliente.FechaNacimiento,
                        cliente.Sexo,
                        cliente.Telefono,
                        cliente.Celular,
                        cliente.CasaPropia,
                        cliente.AutoPropio,
                        cliente.LugarTrabajo,
                        cliente.TelTrabajo,
                        cliente.Antiguedad,
                        cliente.Estatus,
                        cat_calle.NomCalle,
                        direccion.NumExterior,
                        direccion.NumInterior,
                        cat_colonia.NomColonia,
                        cat_colonia.CP,
                        cat_municipio.NomMunicipio,
                        cat_estado.NomEstado,
                        cuenta.NumeroCuenta,
                        cuenta.EstatusPagador
                        FROM
                        cliente
                        INNER JOIN direccion ON direccion.IdDireccion = cliente.FkDireccion AND direccion.IdDireccion = cliente.FkDireccionCobro
                        INNER JOIN cat_estado ON cat_estado.IdEstado = direccion.FkEstado
                        INNER JOIN cat_municipio ON cat_municipio.IdMunicipio = direccion.FkMunicipio
                        INNER JOIN cat_colonia ON cat_colonia.IdColonia = direccion.FkColonia
                        INNER JOIN cat_calle ON cat_calle.IdCalle = direccion.FkCalle
                        INNER JOIN cuenta ON cuenta.FkCliente = cliente.IdCliente
                        WHERE Nombre LIKE '%$likeSearch%' OR
                              APaterno LIKE '%$likeSearch%' OR
                              AMaterno LIKE '%$likeSearch%' 
                        LIMIT $limit
                        OFFSET $offset";

$totalConsultaTodos = "SELECT
                    COUNT(cliente.IdCliente) as Total
                    FROM
                    cliente
                    INNER JOIN direccion ON direccion.IdDireccion = cliente.FkDireccion AND direccion.IdDireccion = cliente.FkDireccionCobro
                    INNER JOIN cat_estado ON cat_estado.IdEstado = direccion.FkEstado
                    INNER JOIN cat_municipio ON cat_municipio.IdMunicipio = direccion.FkMunicipio
                    INNER JOIN cat_colonia ON cat_colonia.IdColonia = direccion.FkColonia
                    INNER JOIN cat_calle ON cat_calle.IdCalle = direccion.FkCalle
                    INNER JOIN cuenta ON cuenta.FkCliente = cliente.IdCliente";
                    
$totalConsultaLikeSearch = "SELECT
                    COUNT(cliente.IdCliente) as Total
                    FROM
                    cliente
                    INNER JOIN direccion ON direccion.IdDireccion = cliente.FkDireccion AND direccion.IdDireccion = cliente.FkDireccionCobro
                    INNER JOIN cat_estado ON cat_estado.IdEstado = direccion.FkEstado
                    INNER JOIN cat_municipio ON cat_municipio.IdMunicipio = direccion.FkMunicipio
                    INNER JOIN cat_colonia ON cat_colonia.IdColonia = direccion.FkColonia
                    INNER JOIN cat_calle ON cat_calle.IdCalle = direccion.FkCalle
                    INNER JOIN cuenta ON cuenta.FkCliente = cliente.IdCliente
                    WHERE Nombre LIKE '%$likeSearch%' OR
                              APaterno LIKE '%$likeSearch%' OR
                              AMaterno LIKE '%$likeSearch%' ";  

  try {
      /* Si la tura trae algun parametro para busqueda generica, se utiliza la consulta generica. Si no, se va al ELSE IF */
      if($columnaGenerica != null){
          $db = new db();
          $db = $db -> conectar();
          $ejecutar = $db -> query($consultaGenerica);
          $clientes = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
          $db = null;
          
          $db = new db();
          $db = $db -> conectar();
          $ejecutar = $db -> query($totalConsultaGenerica);
          $mTotal = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
          $db = null;
          
          $mTotal = json_decode( json_encode($total[0]) , true );
          if ($clientes) {
          $mCustomResponse = new CustomResponse(200,  $clientes, null, (int)$pageForReturn, (int)$mTotal['Total'] );
          return $response->withStatus(200)
                ->withHeader('Content-Type', 'application/json')
                ->write( $mCustomHelper -> returnCatchAsJson($mCustomResponse ) );
          }
    } else if($likeSearch != null){
      /* Si la ruta NO contiene CONSULTA GENERICA y tampoco lleva parametro para la busqueda con LIKE */    
      $db = new db();
      $db = $db -> conectar();
      $ejecutar = $db -> query($consultaLikeSearch);
      $clientes = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
      $db = null;
      
      $db = new db();
      $db = $db -> conectar();
      $ejecutar = $db -> query($totalConsultaLikeSearch);
      $total = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
      $db = null;
      
      $mTotal = json_decode( json_encode($total[0]) , true );
      
      if ($clientes) {
      $mCustomResponse = new CustomResponse(200,  $clientes, null, (int)$pageForReturn, (int)$mTotal['Total']);
      return $response->withStatus(200)
                ->withHeader('Content-Type', 'application/json')
                ->write( $mCustomHelper -> returnCatchAsJson($mCustomResponse ) );
      }        
    } else if ($likeSearch == null) {
        /* Si la ruta NO contiene CONSULTA GENERICA, NI parametro de busqueda LIKE, se toma la busqueda SIN parametros y se regresa GET ALL */
        $db = new db();
        $db = $db -> conectar();
        $ejecutar = $db -> query($consultaTodos);
        $clientes = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
        $db = null;
        
        $db = new db();
        $db = $db -> conectar();
        $ejecutar = $db -> query($totalConsultaTodos);
        $total = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
        $db = null;
      
        $mTotal = json_decode( json_encode($total[0]) , true );

        if ($clientes) {
        $mCustomResponse = new CustomResponse(200,  $clientes, null, (int)$pageForReturn, (int)$mTotal['Total']);
        return $response->withStatus(200)
                ->withHeader('Content-Type', 'application/json')
                ->write( $mCustomHelper -> returnCatchAsJson($mCustomResponse ) );
        }
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
    $mErrorResponse = new ErrorResponse(500, $e -> getMessage(), true);
    return $mCustomHelper -> returnCatchAsJson($mErrorResponse );
  }

});
*/
/*
//obetener todoscliente
$app -> get('/api/clientes/like', function(Request $request, Response $response){

  $like = $request -> getParam('busqueda');
  $like2 = $request -> getParam('busqueda');
  $like3= $request -> getParam('busqueda');
  

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
  WHERE `cliente`.`Nombre` LIKE '%$like%' OR
   `cliente`.`APaterno` LIKE '%$like2%' OR
   `cliente`.`AMaterno` LIKE '%$like3%' ";

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
    $mErrorResponse = new ErrorResponse(500, $e -> getMessage(), true);
    return $mCustomHelper -> returnCatchAsJson($mErrorResponse );
  }

});
*/

//obetener clientes para ventas
/*
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
    $mErrorResponse = new ErrorResponse(500, $e -> getMessage(), true);
    return $mCustomHelper -> returnCatchAsJson($mErrorResponse );
  }

});
*/
//obetener cliente por id
/*
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
*/
//agregar Cliente
$app -> post('/api/clientes/agregar', function(Request $request, Response $response){
    $mCustomHelper = new MyCustomHelper();
    
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
       
      if ($stmt) { 
      $mCustomResponse = new CustomResponse(200,  null, null, null, null );
      return $mCustomHelper -> returnCatchAsJson($mCustomResponse );
      }
  } catch (PDOException $e) {
    $mErrorResponse = new ErrorResponse(500, $e -> getMessage(), true);
    return $mCustomHelper -> returnCatchAsJson($mErrorResponse );
  }


});


//Actualizar cliente
$app -> put('/api/clientes/actualizar/{IdCliente}', function(Request $request, Response $response){
  $mCustomHelper = new MyCustomHelper();
  
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
      
      if ($stmt) { 
      $mCustomResponse = new CustomResponse(201,  null, null, null, null );
      return $mCustomHelper -> returnCatchAsJson($mCustomResponse );
      }
  } catch (PDOException $e) {
    $mErrorResponse = new ErrorResponse(500, $e -> getMessage(), true);
    return $mCustomHelper -> returnCatchAsJson($mErrorResponse );
  }


});

//Eliminar cliente
$app -> delete('/api/clientes/eliminar/{IdCliente}', function(Request $request, Response $response){
  $mCustomHelper = new MyCustomHelper();
  
  $id = $request -> getAttribute('IdCliente');

  $consulta = "DELETE FROM Cliente WHERE IdCliente = '$id';";

  try {

    //Instanciacion de base de datos
      $db = new db();
      $db = $db -> conectar();
      $stmt = $db -> query($consulta);
      $stmt -> execute();
      $db = null;
      if ($stmt) { 
      $mCustomResponse = new CustomResponse(200,  null, null, null, null );
      return $mCustomHelper -> returnCatchAsJson($mCustomResponse );
      }
  } catch (PDOException $e) {
    $mErrorResponse = new ErrorResponse(500, $e -> getMessage(), true);
    return $mCustomHelper -> returnCatchAsJson($mErrorResponse );
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
