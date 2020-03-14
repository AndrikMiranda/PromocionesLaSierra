<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


$fkVendedorParaSubVenta;
$insertVentaok = false;
$insertSubventaOk = false;
$consultaUltimaVentaVendedorOk = false;
$insertSubventaDesdeTablaValor = false;

$app->get('/api/notificaciones', function (Request $request, Response $response) {

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
    
    $consultaTodosNotiCliente = "SELECT
                                tabla_valor.idTablaValor,
                                tabla_valor.clave,
                                tabla_valor.dato1 AS Nombre,
                                tabla_valor.dato2 AS AMaterno,
                                tabla_valor.dato3 AS APaterno,
                                tabla_valor.dato4 AS FechaNacimiento,
                                tabla_valor.dato5 AS Sexo,
                                tabla_valor.dato6 AS Telefono,
                                tabla_valor.dato7 AS Celular,
                                tabla_valor.dato8 AS CasaPropia,
                                tabla_valor.dato9 AS AutoPropio,
                                tabla_valor.dato10 AS LugarTrabajo,
                                tabla_valor.dato11 AS TelTrabajo,
                                tabla_valor.dato12 AS Antiguedad,
                                tabla_valor.dato13 AS FkDireccion,
                                tabla_valor.dato15 AS Estatus,
                                direccion.NumExterior,
                                direccion.NumInterior,
                                cat_colonia.NomColonia,
                                cat_colonia.CP,
                                cat_estado.NomEstado,
                                cat_municipio.NomMunicipio,
                                tabla_valor.dato14 AS FkDireccionCobro
                                FROM
                                tabla_valor
                                INNER JOIN direccion ON direccion.IdDireccion = tabla_valor.dato13
                                INNER JOIN cat_colonia ON direccion.FkColonia = cat_colonia.IdColonia
                                INNER JOIN cat_estado ON direccion.FkEstado = cat_estado.IdEstado
                                INNER JOIN cat_municipio ON direccion.FkMunicipio = cat_municipio.IdMunicipio
                                WHERE clave = 'NOTI-CLIENTE'
                                LIMIT $limit
                                OFFSET $offset";  

    $totalConsultaTodosNotiCliente = "SELECT
                                COUNT(tabla_valor.idTablaValor) as Total
                                FROM
                                tabla_valor
                                INNER JOIN direccion ON direccion.IdDireccion = tabla_valor.dato13
                                INNER JOIN cat_colonia ON direccion.FkColonia = cat_colonia.IdColonia
                                INNER JOIN cat_estado ON direccion.FkEstado = cat_estado.IdEstado
                                INNER JOIN cat_municipio ON direccion.FkMunicipio = cat_municipio.IdMunicipio
                                WHERE clave = 'NOTI-CLIENTE'";  

    $consultaTodosNotiVenta = "SELECT
                                tabla_valor.idTablaValor,
                                tabla_valor.clave,
                                tabla_valor.dato1 AS FkCuenta,
                                tabla_valor.dato2 AS TotalVenta,
                                tabla_valor.dato3 AS Enganche,
                                tabla_valor.dato4 AS Fecha,
                                tabla_valor.dato5 AS FkVendedor,
                                usuario.Nombre as NombreVendedor,
                                tabla_valor.dato6 AS PeriodoPago,
                                tabla_valor.dato7 AS CantidadAbono,
                                tabla_valor.dato8 AS SaldoPendiente,
                                tabla_valor.dato9 AS HorarioCobro,
                                tabla_valor.dato10 AS TipoVenta,
                                tabla_valor.dato11 AS GpsLat,
                                tabla_valor.dato12 AS GpsLon,
                                tabla_valor.dato13 AS EstatusAprobacion
                                FROM
                                tabla_valor
                                INNER JOIN usuario ON usuario.IdUsuario = tabla_valor.dato5
                                WHERE clave ='NOTI-VENTA'
                                LIMIT $limit
                                OFFSET $offset";  

    $totalConsultaTodosNotiVenta = "SELECT
                                COUNT(tabla_valor.idTablaValor) as Total
                                FROM
                                tabla_valor
                                INNER JOIN usuario ON usuario.IdUsuario = tabla_valor.dato5
                                WHERE clave ='NOTI-VENTA'";

    $consultaTodosNotiSubventa = "SELECT
                                tabla_valor.idTablaValor,
                                tabla_valor.clave AS Clave,
                                tabla_valor.dato1 AS FkArticulo,
                                articulo.Codigo,
                                articulo.NombreArticulo,
                                articulo.PrecioVenta,
                                cat_categoriaarticulos.NombreCategoria,
                                tabla_valor.dato2 AS Cantidad,
                                tabla_valor.dato3 AS SubTotal,
                                tabla_valor.dato4 AS FkVenta
                                FROM
                                tabla_valor
                                INNER JOIN articulo ON articulo.IdArticulo = tabla_valor.dato1
                                INNER JOIN cat_categoriaarticulos ON articulo.FkCategoria = cat_categoriaarticulos.IdCategoria
                                WHERE clave = 'NOTI-SUBVENTA'
                                LIMIT $limit
                                OFFSET $offset";  

    $totalConsultaTodosNotiSubventa = "SELECT
                                COUNT(tabla_valor.idTablaValor) as Total
                                FROM
                                tabla_valor
                                INNER JOIN articulo ON articulo.IdArticulo = tabla_valor.dato1
                                INNER JOIN cat_categoriaarticulos ON articulo.FkCategoria = cat_categoriaarticulos.IdCategoria
                                WHERE clave = 'NOTI-SUBVENTA'"; 
  
    try {
        //Si solamente traemos un likeSearch, lo evaluamos para ejecutar su respectiva consulta.
        if($likeSearch != null && $columnaGenerica == null && $parametroColumnaGenerica == null){

            switch ( $likeSearch ) {
                case "NOTI-CLIENTE":
                    $consultaCase = $consultaTodosNotiCliente;
                    $totalConsultaCase = $totalConsultaTodosNotiCliente;
                    break;
                case "NOTI-VENTA":
                    $consultaCase = $consultaTodosNotiVenta;
                    $totalConsultaCase = $totalConsultaTodosNotiVenta;
                    break;
                case "NOTI-SUBVENTA":
                    $consultaCase = $consultaTodosNotiSubventa;
                    $totalConsultaCase = $totalConsultaTodosNotiSubventa;
                    break;
                default:
                    $mErrorResponse = new ErrorResponse(200, 'Hubo un problema con la solicitud. Intentelo de nuevo.', false);
                    return $mCustomHelper -> returnCatchAsJson($mErrorResponse );

            }

            $db = new db();
            $db = $db -> conectar();
            $ejecutar = $db -> query($consultaCase);
            $clientes = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
            $db = null;
            
            $db = new db();
            $db = $db -> conectar();
            $ejecutar = $db -> query($totalConsultaCase);
            $mTotal = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
            $db = null;
            
            $mTotal = json_decode( json_encode($total[0], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) , true );
            
            $mCustomResponse = new CustomResponse(200,  $clientes, null, (int)$pageForReturn, (int)$mTotal['Total'] );
            
            return $response->withStatus(200)
                  ->withHeader('Content-Type', 'application/json')
                  ->write( $mCustomHelper -> returnCatchAsJson($mCustomResponse ) );

        //Esta la usamos para traer las peticiones genericas. En este caso se usaria para NOTI-VENTA: Por Estatus, IdTablaValor, IdVendedor. 
      } else if($columnaGenerica != null && $parametroColumnaGenerica != null){
        $consultaGenerica = "SELECT
                        tabla_valor.idTablaValor as idTablaValor,
                        tabla_valor.clave as clave,
                        tabla_valor.dato1 AS FkCuenta,
                        tabla_valor.dato2 AS TotalVenta,
                        tabla_valor.dato3 AS Enganche,
                        tabla_valor.dato4 AS Fecha,
                        tabla_valor.dato5 AS FkVendedor,
                        usuario.Nombre as NombreVendedor,
                        tabla_valor.dato6 AS PeriodoPago,
                        tabla_valor.dato7 AS CantidadAbono,
                        tabla_valor.dato8 AS SaldoPendiente,
                        tabla_valor.dato9 AS HorarioCobro,
                        tabla_valor.dato10 AS TipoVenta,
                        tabla_valor.dato11 AS GpsLat,
                        tabla_valor.dato12 AS GpsLon,
                        tabla_valor.dato13 AS EstatusAprobacion
                        FROM
                        tabla_valor
                        INNER JOIN usuario ON usuario.IdUsuario = tabla_valor.dato5
                        WHERE clave = 'NOTI-VENTA'";
        $columnaGenericaArray = json_decode($columnaGenerica);
        $parametroColumnaGenericaArray = json_decode($parametroColumnaGenerica);
        for($i=0; $i<count($columnaGenericaArray); $i++){
            switch ( $columnaGenericaArray[$i] ) {
            case "estatusAprobacion":
                $columnaGenericaArray[$i] = "dato13";
                break;
            case "idTablaValor":
                $columnaGenericaArray[$i] = "idTablaValor";
                break;
            case "fkVendedor":
                $columnaGenericaArray[$i] = "dato5";
                break;
            default:
                $mErrorResponse = new ErrorResponse(200, 'Hubo un problema con la solicitud. Intentelo de nuevo.', false);
                return $mCustomHelper -> returnCatchAsJson($mErrorResponse );
            }
        }
        $key = null;
        if(in_array("idTablaValor", $columnaGenericaArray)){
            $key = array_search('idTablaValor', $columnaGenericaArray);
        }
        $secondQueryPart = "";
        for($i=0; $i<count($columnaGenericaArray); $i++){
            if($key!==$i){
                $secondQueryPart = $secondQueryPart .
                " AND ".$columnaGenericaArray[$i]. " = ". $parametroColumnaGenericaArray[$i];
            }
        }
        if(isset($key)){
            $secondQueryPart = $secondQueryPart .
            " HAVING ".$columnaGenericaArray[$key]." = ".$parametroColumnaGenericaArray[$key];
        }
        $consultaGenerica = $consultaGenerica.$secondQueryPart;
        $consultaGenerica = $consultaGenerica .
                        " LIMIT $limit
                        OFFSET $offset";
        $totalConsultaGenerica = "SELECT
                        COUNT(tabla_valor.idTablaValor) as Total
                        FROM
                        tabla_valor
                        WHERE clave = 'NOTI-VENTA'".$secondQueryPart;

        $db = new db();
        $db = $db -> conectar();
        $ejecutar = $db -> query($consultaGenerica);
        $clientes = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
        $db = null;
        
        $db = new db();
        $db = $db -> conectar();
        $ejecutar = $db -> query($totalConsultaGenerica);
        $total = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
        $db = null;
    
        $mTotal = json_decode( json_encode($total[0], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) , true );
        
        $mCustomResponse = new CustomResponse(200,  $clientes, null, (int)$pageForReturn, (int)$mTotal['Total']);
  
        return $response->withStatus(200)
                  ->withHeader('Content-Type', 'application/json')
                  ->write( $mCustomHelper -> returnCatchAsJson($mCustomResponse ) );
                  
      } else {
        $mErrorResponse = new ErrorResponse(200, 'Hubo un problema con la solicitud. Intentelo de nuevo.', false);
        return $mCustomHelper -> returnCatchAsJson($mErrorResponse );
  
      }
  
    } catch (PDOException $e) {
      $mErrorResponse = new ErrorResponse(500, $e -> getMessage(), true);
      return $mCustomHelper -> returnCatchAsJson($mErrorResponse );
    }
  

});


// ========= REVISAR QUE FUNCIONE, ESTA MAL 29/02/2020
//agregar notificaciones de clientes
/*
clave(string) - NOTI-CLIE
Nombre(string)
APaterno
AMaterno
FechaNacimiento(date) - dd/mm/aa
Sexo(char) - M/F
Telefono(int 10)
Celular(int 10)
CasaPropia(int) 1/0
AutoPropio(int) 1/0
LugarTrabajo(string)
TelTrabajo(int 10)
Antiguedad(int)
FkDireccion(int) - Requiere la ruta de direcciones, revisarla.
FkDireccionCobro - Requiere la ruta de direcciones, revisarla.
Estatus 1/0 - Revisar
 */
$app->post('/api/notificaciones/agregarCliente', function (Request $request, Response $response) {

    $mCustomHelper = new MyCustomHelper();

    $clave = $request->getParam('clave');
    $nombre = $request->getParam('Nombre');
    $aPaterno = $request->getParam('APaterno');
    $aMaterno = $request->getParam('AMaterno');
    $fechaNacimiento = $request->getParam('FechaNacimiento');
    $sexo = $request->getParam('Sexo');
    $telefono = $request->getParam('Telefono');
    $celular = $request->getParam('Celular');
    $casaPropia = $request->getParam('CasaPropia');
    $autoPropio = $request->getParam('AutoPropio');
    $lugarTrabajo = $request->getParam('LugarTrabajo');
    $telTrabajo = $request->getParam('TelTrabajo');
    $antiguedad = $request->getParam('Antiguedad');
    $fkDireccion = $request->getParam('FkDireccion');
    $fkDireccionCobro = $request->getParam('FkDireccionCobro');
    $estatus = $request->getParam('Estatus');

    $consulta0 = "SELECT `cliente`.`IdCliente`
                  FROM `cliente`
                  WHERE `Nombre` = '" . $nombre . "' AND `APaterno` = '" . $aPaterno . "'  AND `AMaterno` = '" . $aMaterno . "' AND `FechaNacimiento` = '" . $fechaNacimiento . "'
                  OR `Telefono` = '" . $telefono . "' OR `Celular` = '" . $celular . "'";

    try {

        //Instanciacion de base de datos
        $db = new db();
        $db = $db->conectar();
        $ejecutar = $db->query($consulta0);
        $notificaciones = $ejecutar->fetchAll(PDO::FETCH_OBJ);
        $db = null;
       
        $json = json_encode($notificaciones);

        return $response->withStatus(200)
                  ->withHeader('Content-Type', 'application/json')
                  ->write( $mCustomHelper -> returnCatchAsJson($mCustomResponse ) );

    } catch (PDOException $e) {
        return '{"error": {"text": ' . $e->getMessage() . '} }';
    }

    if ($notificaciones == null) {
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
            $db = $db->conectar();
            $stmt = $db->prepare($consulta);
            $stmt->bindParam(':clave', $clave);
            $stmt->bindParam(':Nombre', $nombre);
            $stmt->bindParam(':APaterno', $aPaterno);
            $stmt->bindParam(':AMaterno', $aMaterno);
            $stmt->bindParam(':FechaNacimiento', $fechaNacimiento);
            $stmt->bindParam(':Sexo', $sexo);
            $stmt->bindParam(':Telefono', $telefono);
            $stmt->bindParam(':Celular', $celular);
            $stmt->bindParam(':CasaPropia', $casaPropia);
            $stmt->bindParam(':AutoPropio', $autoPropio);
            $stmt->bindParam(':LugarTrabajo', $lugarTrabajo);
            $stmt->bindParam(':TelTrabajo', $telTrabajo);
            $stmt->bindParam(':Antiguedad', $antiguedad);
            $stmt->bindParam(':FkDireccion', $fkDireccion);
            $stmt->bindParam(':FkDireccionCobro', $fkDireccionCobro);
            $stmt->bindParam(':Estatus', $estatus);
            $stmt->execute();


            if ($stmt) {
                return $response->withStatus(200)
                    ->withHeader('Content-Type', 'application/json')
                    ->write('{"notice": {"text": "Cliente agregado"}');
            }

        } catch (PDOException $e) {
            return '{"error": {"text": ' . $e->getMessage() . '} }';
        }
    } else {
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

            $decode = json_decode($json, true);
            $idCliente = $decode[0]['IdCliente'];
            //Instanciacion de base de datos
            $db = new db();
            $db = $db->conectar();
            $stmt = $db->prepare($consulta);
            $stmt->bindParam(':clave', $clave);
            $stmt->bindParam(':Nombre', $nombre);
            $stmt->bindParam(':APaterno', $aPaterno);
            $stmt->bindParam(':AMaterno', $aMaterno);
            $stmt->bindParam(':FechaNacimiento', $fechaNacimiento);
            $stmt->bindParam(':Sexo', $sexo);
            $stmt->bindParam(':Telefono', $telefono);
            $stmt->bindParam(':Celular', $celular);
            $stmt->bindParam(':CasaPropia', $casaPropia);
            $stmt->bindParam(':AutoPropio', $autoPropio);
            $stmt->bindParam(':LugarTrabajo', $lugarTrabajo);
            $stmt->bindParam(':TelTrabajo', $telTrabajo);
            $stmt->bindParam(':Antiguedad', $antiguedad);
            $stmt->bindParam(':FkDireccion', $fkDireccion);
            $stmt->bindParam(':FkDireccionCobro', $fkDireccionCobro);
            $stmt->bindParam(':Estatus', $estatus);
            $stmt->bindParam(':Coincidencias', $coincidencia);
            $stmt->bindParam(':IdCliente', $idCliente);
            $stmt->execute();

            if ($notificaciones) {
                return $response->withStatus(200)
                    ->withHeader('Content-Type', 'application/json')
                    ->write('{"notice": {"text": "Cliente agregado"} }');
            }

        } catch (PDOException $e) {
            return '{"error": {"text": ' . $e->getMessage() . '} }';
        }
    }
});


// ========= REVISAR QUE FUNCIONE, ESTA MAL 29/02/2020
//Actualizar notificaciones de clientes
/*
clave(string) - NOTI-CLIE
Nombre(string)
APaterno
AMaterno
FechaNacimiento(date) - dd/mm/aa
Sexo(char) - M/F
Telefono(int 10)
Celular(int 10)
CasaPropia(int) 1/0
AutoPropio(int) 1/0
LugarTrabajo(string)
TelTrabajo(int 10)
Antiguedad(int)
FkDireccion(int) - Requiere la ruta de direcciones, revisarla.
FkDireccionCobro - Requiere la ruta de direcciones, revisarla.
Estatus 1/0 - Revisar
 */
$app->put('/api/notificaciones/actualizar/{idNotificaciones}', function (Request $request, Response $response) {

    $mCustomHelper = new MyCustomHelper();

    $idNotificaciones = $request->getAttribute('idTablaValor');
    $nombre = $request->getParam('Nombre');
    $aPaterno = $request->getParam('APaterno');
    $aMaterno = $request->getParam('AMaterno');
    $fechaNacimiento = $request->getParam('FechaNacimiento');
    $sexo = $request->getParam('Sexo');
    $telefono = $request->getParam('Telefono');
    $celular = $request->getParam('Celular');
    $casaPropia = $request->getParam('CasaPropia');
    $autoPropio = $request->getParam('AutoPropio');
    $lugarTrabajo = $request->getParam('LugarTrabajo');
    $telTrabajo = $request->getParam('TelTrabajo');
    $antiguedad = $request->getParam('Antiguedad');
    $fkDireccion = $request->getParam('FkDireccion');
    $fkDireccionCobro = $request->getParam('FkDireccionCobro');
    $estatus = $request->getParam('Estatus');

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
  WHERE idTablaValor = $idNotificaciones";

    try {

        //Instanciacion de base de datos
        $db = new db();
        $db = $db->conectar();
        $stmt = $db->prepare($consulta);
        $stmt->bindParam(':Nombre', $nombre);
        $stmt->bindParam(':APaterno', $aPaterno);
        $stmt->bindParam(':AMaterno', $aMaterno);
        $stmt->bindParam(':FechaNacimiento', $fechaNacimiento);
        $stmt->bindParam(':Sexo', $sexo);
        $stmt->bindParam(':Telefono', $telefono);
        $stmt->bindParam(':Celular', $celular);
        $stmt->bindParam(':CasaPropia', $casaPropia);
        $stmt->bindParam(':AutoPropio', $autoPropio);
        $stmt->bindParam(':LugarTrabajo', $lugarTrabajo);
        $stmt->bindParam(':TelTrabajo', $telTrabajo);
        $stmt->bindParam(':Antiguedad', $antiguedad);
        $stmt->bindParam(':FkDireccion', $fkDireccion);
        $stmt->bindParam(':FkDireccionCobro', $fkDireccionCobro);
        $stmt->bindParam(':Estatus', $estatus);
        $stmt->execute();

        if ($stmt) {
            return $response->withStatus(201)
                ->withHeader('Content-Type', 'application/json')
                ->write(json_encode($stmt));
        }

    } catch (PDOException $e) {
        return '{"error": {"text": ' . $e->getMessage() . '} }';
    }

});

//Actualizar estatus de la notificaciones de venta
$app->put('/api/notificaciones/actualizarEstatus/{idTablaValor}', function (Request $request, Response $response) {

    $mCustomHelper = new MyCustomHelper();

    $id = $request->getAttribute('idTablaValor');
    $estatus = $request->getParam('Estatus');

    $consulta = "UPDATE  tabla_valor SET
    dato13 =  :Estatus
    WHERE idTablaValor = $id AND
    clave = 'NOTI-VENTA'";

    try {

        //Instanciacion de base de datos
        $db = new db();
        $db = $db->conectar();
        $stmt = $db->prepare($consulta);
        $stmt->bindParam(':Estatus', $estatus);
        $stmt->execute();

        if ($stmt) {
            $mCustomResponse = new CustomResponse(201,  "Se actualizó el estatus de la venta.", null, null, null );

            return $response->withStatus(201)
                ->withHeader('Content-Type', 'application/json')
                ->write( $mCustomHelper -> returnCatchAsJson($mCustomResponse ) );
        }else{
            $mErrorResponse = new ErrorResponse(500, "Hubo un problema inesperado.", true);

            return $response->withStatus(500)
                ->withHeader('Content-Type', 'application/json')
                ->write( $mCustomHelper -> returnCatchAsJson($mErrorResponse ) );
        }

    } catch (PDOException $e) {
        $mErrorResponse = new ErrorResponse(500, $e -> getMessage(), true);
        return $mCustomHelper -> returnCatchAsJson($mErrorResponse );
    }

});

//Eliminar notificación
$app->delete('/api/notificaciones/eliminar/{idTablaValor}', function (Request $request, Response $response) {
   
    $mCustomHelper = new MyCustomHelper();

    $id = $request->getAttribute('idTablaValor');

    $consulta = "DELETE FROM tabla_valor WHERE idTablaValor = '$id';";

    try {

        //Instanciacion de base de datos
        $db = new db();
        $db = $db->conectar();
        $stmt = $db->query($consulta);
        $stmt->execute();
        $db = null;

        if ($stmt) {
            $mCustomResponse = new CustomResponse(200,  "Se eliminó la notificación.", null, null, null );

            return $response->withStatus(200)
                ->withHeader('Content-Type', 'application/json')
                ->write( $mCustomHelper -> returnCatchAsJson($mCustomResponse ) );
        }else{
            $mErrorResponse = new ErrorResponse(500, "Hubo un problema inesperado.", true);

            return $response->withStatus(500)
                ->withHeader('Content-Type', 'application/json')
                ->write( $mCustomHelper -> returnCatchAsJson($mErrorResponse ) );
        }

    } catch (PDOException $e) {
        $mErrorResponse = new ErrorResponse(500, $e -> getMessage(), true);
        return $mCustomHelper -> returnCatchAsJson($mErrorResponse );
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
$app->post('/api/notificaciones/venta/agregar', function (Request $request, Response $response) {

    try{
        $mCustomHelper = new MyCustomHelper();
        $json = $request->getParsedBody();
        
        $insertVentaok = false;
        $insertSubventaOk = false;
        $consultaUltimaVentaVendedorOk = false;

        foreach ($json as $notificacion) {
            if ($notificacion["tipo_notificacion"] == "venta") {

                 $insertVentaok = insert_tabla_valor_venta('NOTI-VENTA', $notificacion["datos"]["FkCuenta"], $notificacion["datos"]["TotalVenta"],
                    $notificacion["datos"]["Enganche"], $notificacion["datos"]["FkVendedor"], $notificacion["datos"]["PeriodoPago"],
                    $notificacion["datos"]["CantidadAbono"], $notificacion["datos"]["SaldoPendiente"], $notificacion["datos"]["HorarioCobro"],
                    $notificacion["datos"]["TipoVenta"], $notificacion["datos"]["GpsLat"], $notificacion["datos"]["GpsLon"]);

                $fkVendedorParaSubVenta = $notificacion["datos"]["FkVendedor"];
                
            }
        
            if ($notificacion["tipo_notificacion"] == "subventa") {
                
                //Consultar ultima fkVenta de tablavalor
                
                foreach ($notificacion["datos"] as $subventa) {
                    $insertSubventaOk = insert_tabla_valor_subventa('NOTI-SUBVENTA', $subventa["FkArticulo"], $subventa["Cantidad"], $subventa["SubTotal"], $fkVendedorParaSubVenta);
                }
            }
            
        }
        
        
        if($insertVentaok && $insertSubventaOk){
            $mCustomResponse = new CustomResponse(200,  "Se agrego la venta y su subventa", null, null, null);
 
            return $response->withStatus(200)
                      ->withHeader('Content-Type', 'application/json')
                      ->write( $mCustomHelper -> returnCatchAsJson($mCustomResponse ) );
        } else {
            $mErrorResponse = new ErrorResponse(200, 'Hubo un problema con la solicitud. Intentelo de nuevo.', false);
            return $mCustomHelper -> returnCatchAsJson($mErrorResponse );
        }
      
    
    } catch (PDOException $e) {
        $mErrorResponse = new ErrorResponse(500, $e -> getMessage(), true);
        return $mCustomHelper -> returnCatchAsJson($mErrorResponse );
    }
    
});

function insert_tabla_valor_venta($clave, $fkCuenta, $totalVenta, $enganche, $fkVendedor, $periodoPago, $cantidadAbono, $saldoPendiente, $horarioCobro, $tipoVenta, $gpsLat, $gpsLon){
  
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
        
        if ($stmt) {
            return true;
        }else{
            return false;
        }
            
    } catch (PDOException $e) {
        $mErrorResponse = new ErrorResponse(500, $e -> getMessage(), true);
        return $mCustomHelper -> returnCatchAsJson($mErrorResponse );
    }

}

function consulta_ultima_venta_de_vendedor_tabla_valor($FkVendedor){

    $mCustomHelper = new MyCustomHelper();
    
    $consulta = "SELECT idTablaValor
                        FROM tabla_valor
                        WHERE tabla_valor.clave = 'NOTI-VENTA' AND
                        dato5 = $FkVendedor
                        ORDER BY idTablaValor
                        DESC LIMIT 1";

    try {

        //Instanciacion de base de datos
        $db = new db();
        $db = $db->conectar();
        $ejecutar = $db->query($consulta);
        $stmt = $ejecutar->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        
        $encode = json_encode($stmt);
        $decode = json_decode($encode, true);
        
        $idTablaValorDelVendedor = $decode[0]['idTablaValor'];
        
        if ($stmt) {
            $consultaUltimaVentaVendedorOk = true;
            return $idTablaValorDelVendedor;
        }else{
            $consultaUltimaVentaVendedorOk = false;
            return null;
        }


    } catch (PDOException $e) {
        return '{"error": {"text": ' . $e->getMessage() . '} }';
    }
}

function insert_tabla_valor_subventa($clave, $FkArticulo, $Cantidad, $SubTotal, $FkVendedor){

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
        
        if($idTablaValorDeVendedor != null){
             //Instanciacion de base de datos
             //Agregar comprobacion de rowCount para respnse
            $db = new db();
            $db = $db->conectar();
            $stmt = $db->prepare($consulta);
    
            $stmt->bindParam(':clave', $clave);
            $stmt->bindParam(':FkArticulo', $FkArticulo);
            $stmt->bindParam(':Cantidad', $Cantidad);
            $stmt->bindParam(':SubTotal', $SubTotal);
            $stmt->bindParam(':idTablaValorDeVendedor', $idTablaValorDeVendedor);
    
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                return true;
            } else if($stmt->rowCount() == 0) {
                return false;
            }
            
        }else{
            return false;
        }
        
    } catch (PDOException $e) {
        $mErrorResponse = new ErrorResponse(500, $e -> getMessage(), true);
        return $mCustomHelper -> returnCatchAsJson($mErrorResponse );
    }

}

function update_tabla_valor_subventa(){
    
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

        if ($stmt) {
            return $response->withStatus(200)
                ->withHeader('Content-Type', 'application/json')
                ->write(json_encode($stmt));
        }

    } catch (PDOException $e) {
       $mErrorResponse = new ErrorResponse(500, $e -> getMessage(), true);
        return $mCustomHelper -> returnCatchAsJson($mErrorResponse );
    }

}

//APROBAR o REchazar VENTA
$app->put('/api/notificaciones/venta/aprobar/', function (Request $request, Response $response) {

    $mCustomHelper = new MyCustomHelper();

    $idTablaValor = $request->getParam('idTablaValor');
    $razonRechazo = $request->getParam('razonRechazo');

    $consultaRechazo = "UPDATE  tabla_valor SET
                      dato13 = 3,
                      dato14 = :razonRechazo,
                      descripcion14 = 'RazonRechazo'
                  WHERE idTablaValor = $idTablaValor AND
                        clave = 'NOTI-VENTA'";

    $consultaAprobar = "UPDATE tabla_valor
               SET dato13 = 2
               WHERE clave = 'NOTI-VENTA' AND
                     idTablaValor = :idTablaValor";
    
    $consulta;
    
    try {
        
        if($razonRechazo != null){
            $consulta = $consultaRechazo;
        }else{
            $consulta = $consultaAprobar;
        }
        
        //Instanciacion de base de datos
        $db = new db();
        $db = $db->conectar();
        $stmt = $db->prepare($consulta);

        $stmt->bindParam(':idTablaValor', $idTablaValor);

        $stmt->execute();

        if ($stmt) {
            $mCustomResponse = new CustomResponse(200,  "Se actualizo el estatus de la venta.", null, null, null);
 
            return $response->withStatus(200)
                      ->withHeader('Content-Type', 'application/json')
                      ->write( $mCustomHelper -> returnCatchAsJson($mCustomResponse ) );
        } else {
             $mCustomResponse = new CustomResponse(200,  "Hubo un problema con la solicitud", null, null, null);
 
            return $response->withStatus(200)
                      ->withHeader('Content-Type', 'application/json')
                      ->write( $mCustomHelper -> returnCatchAsJson($mCustomResponse ) );
        }

    } catch (PDOException $e) {
        $mErrorResponse = new ErrorResponse(500, $e -> getMessage(), true);
        return $mCustomHelper -> returnCatchAsJson($mErrorResponse );
    }

});

//agregar venta desde tablaValor a tabla Venta
//IdTablaValor se manda desde la tabla de notificaciones
$app->post('/api/notificaciones/venta/completar', function (Request $request, Response $response) {
    
    $mCustomHelper = new MyCustomHelper();
    
    $idTablaValor = $request->getParam('idTablaValor');

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

        if ($stmt) {

            $mCustomResponse = new CustomResponse(200,  "Se agrego correctamente.", null, null, null );

            return $response->withStatus(200)
                ->withHeader('Content-Type', 'application/json')
                ->write( $mCustomHelper -> returnCatchAsJson($mCustomResponse ) );
        }

    } catch (PDOException $e) {
       $mErrorResponse = new ErrorResponse(500, $e -> getMessage(), true);
        return $mCustomHelper -> returnCatchAsJson($mErrorResponse );
    }

});












//Actualizar notificaciones de venta
$app->put('/api/notificaciones/venta/actualizar', function (Request $request, Response $response) {

    $mCustomHelper = new MyCustomHelper();

    $idTablaValor = $request->getParam('idTablaValor');
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

        
        return $mCustomHelper -> returnCatchAsJson($mCustomResponse );

        if ($stmt) {
            $mCustomResponse = new CustomResponse(200,  "Se actualizó correctamente.", null, null, null );

            return $response->withStatus(200)
                ->withHeader('Content-Type', 'application/json')
                ->write( $mCustomHelper -> returnCatchAsJson($mCustomResponse ) );
        }

    } catch (PDOException $e) {
        $mErrorResponse = new ErrorResponse(500, $e -> getMessage(), true);
        return $mCustomHelper -> returnCatchAsJson($mErrorResponse );
    }

});

//Eliminar notificación
$app->delete('/api/notificaciones/ventas/eliminar/{idTablaValor}', function (Request $request, Response $response) {

    $mCustomHelper = new MyCustomHelper();

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

        if ($stmt) {
            $mCustomResponse = new CustomResponse(200,  null, null, null, null );

            return $response->withStatus(200)
                ->withHeader('Content-Type', 'application/json')
                ->write( $mCustomHelper -> returnCatchAsJson($mCustomResponse ) );
        }

    } catch (PDOException $e) {
        $mErrorResponse = new ErrorResponse(500, $e -> getMessage(), true);
        return $mCustomHelper -> returnCatchAsJson($mErrorResponse );
    }

});

/*
FkVenta -> Tomado de la tabla venta. Ees al venta real.
idTablaValor -> Id de la subventa de la venta que se acaba de aprobar en tablaValor.
*/
//Update NOTI-SUBVENTA con  FkVenta de la tabla Venta.
$app->put('/api/notificaciones/venta/actualizar/subventa', function (Request $request, Response $response) {

    $mCustomHelper = new MyCustomHelper();

    $FkVenta = $request->getParam('FkVenta'); //FkVentaReal
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

        if ($stmt) {
            $mCustomResponse = new CustomResponse(200,  "Se actualizó correctamente.", null, null, null );

            return $response->withStatus(200)
                ->withHeader('Content-Type', 'application/json')
                ->write( $mCustomHelper -> returnCatchAsJson($mCustomResponse ) );
        } else {
            $mCustomResponse = new CustomResponse(200,  "Hubo un problema con la solicitud.", null, null, null );

            return $response->withStatus(200)
                ->withHeader('Content-Type', 'application/json')
                ->write( $mCustomHelper -> returnCatchAsJson($mCustomResponse ) );
        }

    } catch (PDOException $e) {
        $mErrorResponse = new ErrorResponse(500, $e -> getMessage(), true);
        return $mCustomHelper -> returnCatchAsJson($mErrorResponse );
    }

});

//agregar subventa desde tablaValor a tabla subVenta
        
$app->post('/api/notificaciones/subventa/agregar', function (Request $request, Response $response) {

    try {
        $mCustomHelper = new MyCustomHelper();
        $insertSubventaDesdeTablaValor = false;
        
        $json = $request->getParsedBody();

        foreach ($json["subventa"] as $notificacion) {
            $insertSubventaDesdeTablaValor = insert_subventa_desde_tabla_valor($notificacion["FkArticulo"], $notificacion["Cantidad"], $notificacion["SubTotal"], $notificacion["FkVenta"]);
        }
        
        
        if ($insertSubventaDesdeTablaValor) {
            $mCustomResponse = new CustomResponse(200,  "Se agregó correctamente.", null, null, null );

            return $response->withStatus(200)
                ->withHeader('Content-Type', 'application/json')
                ->write( $mCustomHelper -> returnCatchAsJson($mCustomResponse ) );
        }else{
            $mCustomResponse = new CustomResponse(200,  "Hubo un error inesperado.", null, null, null );

            return $response->withStatus(200)
                ->withHeader('Content-Type', 'application/json')
                ->write( $mCustomHelper -> returnCatchAsJson($mCustomResponse ) );
        }    
 
    } catch (PDOException $e) {
        $mErrorResponse = new ErrorResponse(500, $e -> getMessage(), true);
        return $mCustomHelper -> returnCatchAsJson($mErrorResponse );
    }

});

function insert_subventa_desde_tabla_valor($FkArticulo, $Cantidad, $SubTotal, $FkVenta){

    $consultaNotificacionVenta = "INSERT INTO subventa(FkArticulo, Cantidad, SubTotal, FkVenta)
                                VALUES( :FkArticulo, :Cantidad, :SubTotal, :FkVenta)";

    try {
        $mCustomHelper = new MyCustomHelper();

        //Instanciacion de base de datos
        $db = new db();
        $db = $db->conectar();
        $stmt = $db->prepare($consultaNotificacionVenta);

        $stmt->bindParam(':FkArticulo', $FkArticulo);
        $stmt->bindParam(':Cantidad', $Cantidad);
        $stmt->bindParam(':SubTotal', $SubTotal);
        $stmt->bindParam(':FkVenta', $FkVenta);

        $stmt->execute();

        if ($stmt) {
            return true;
        } else {
            return false;
        }

    } catch (PDOException $e) {
        $mErrorResponse = new ErrorResponse(500, $e -> getMessage(), true);
        return $mCustomHelper -> returnCatchAsJson($mErrorResponse );
    }

}

//RECHAZAR VENTA CON MOTIVO
$app->put('/api/notificaciones/venta/rechazar', function (Request $request, Response $response) {

    $mCustomHelper = new MyCustomHelper();

    $idTablaValor = $request->getParam('idTablaValor');
    $razonRechazo = $request->getParam('razonRechazo');

    $consulta = "UPDATE  tabla_valor SET
                      dato13 = 3,
                      dato14 = :razonRechazo,
                      descripcion14 = 'RazonRechazo'
                  WHERE idTablaValor = $idTablaValor AND
                        clave = 'NOTI-VENTA'";

    try {

        //Instanciacion de base de datos
        $db = new db();
        $db = $db->conectar();
        $stmt = $db->prepare($consulta);
        $stmt->bindParam(':razonRechazo', $razonRechazo);
        $stmt->execute();
        $db = null;

        if ($stmt) {
            $mCustomResponse = new CustomResponse(201,  "Se actualizó correctamente.", null, null, null );

            return $response->withStatus(201)
                ->withHeader('Content-Type', 'application/json')
                ->write( $mCustomHelper -> returnCatchAsJson($mCustomResponse ) );
        } else {
            $mCustomResponse = new CustomResponse(200,  "Hubo un problema con la petición", null, null, null );

            return $response->withStatus(201)
                ->withHeader('Content-Type', 'application/json')
                ->write( $mCustomHelper -> returnCatchAsJson($mCustomResponse ) );
        }

    } catch (PDOException $e) {
        $mErrorResponse = new ErrorResponse(500, $e -> getMessage(), true);
        return $mCustomHelper -> returnCatchAsJson($mErrorResponse );
    }

});





























$app->post('/api/notificaciones/venta/proceso-aprobar', function (Request $request, Response $response) {
    
    $mCustomHelper = new MyCustomHelper();

    //Aprobar/Rechazar params
    $idTablaValorVenta = $request->getParam('idTablaValorVenta');
    $razonRechazo = $request->getParam('razonRechazo');
    $fkVendedor = $request->getParam('fkVendedor');
    $fkCuenta = $request->getParam('fkCuenta');
    
    //TODO Verificar que exista vendedor, cuenta y idTablaValorVenta
    
    try {
        $db = new db();
        $db = $db->conectar();
        $db->beginTransaction();
        
        if( aprobarRechazarVenta( $idTablaValorVenta,$razonRechazo,$db ) ){
            
            if( requestIngresarVenta($idTablaValorVenta, $db) ){
                $consultaIdVenta = "SELECT IdVenta
                                    FROM venta
                                    WHERE FkVendedor = $fkVendedor AND
                                          FkCuenta = $fkCuenta
                                    ORDER BY IdVenta DESC 
                                    LIMIT 1";

                    $ejecutar = $db->query($consultaIdVenta);
                    $idVenta = $ejecutar->fetchAll(PDO::FETCH_OBJ);
                    
                    $idVenta = json_decode( json_encode($idVenta[0], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) , true );
                    $fkVenta = (int)$idVenta['IdVenta'];
                   
                if( updateFkVentaTablaValor($fkVenta, $idTablaValorVenta, $db) ){
                    
                    $consultaSubVentaTablaValor = "SELECT
                                                   CAST(tabla_valor.dato1 AS INT) AS FkArticulo,
                                                   CAST(tabla_valor.dato2 AS INT) AS Cantidad,
                                                   CAST(tabla_valor.dato3 AS INT) AS SubTotal,
                                                   CAST(tabla_valor.dato4 AS INT) AS FkVenta
                                                   FROM
                                                   tabla_valor
                                                   WHERE
                                                   tabla_valor.clave = 'NOTI-SUBVENTA' AND
                                                   tabla_valor.dato4 = $fkVenta";

                    $ejecutar = $db -> query($consultaSubVentaTablaValor);
                    $subVentaArray = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
                    
                    if( requestIngresarSubVenta($subVentaArray, $fkVenta, $db) ){
                        $db->commit();
                            
                        $mCustomResponse = new CustomResponse(200,  "Se autorizo la venta correctamente.", null, null, null );

                        return $response->withStatus(200)
                            ->withHeader('Content-Type', 'application/json')
                            ->write( $mCustomHelper -> returnCatchAsJson($mCustomResponse ) );
                    }else{
                        //Respuesta de fallo de requestIngresarSubVenta
                        $db->rollBack();

                        $mErrorResponse = new ErrorResponse(500, $e -> getMessage(), true);
                        return $mCustomHelper -> returnCatchAsJson($mErrorResponse );
                    }
                }else{
                    //Respuesta de fallo de updateFkVentaTablaValor
                    $db->rollBack();

                    $mErrorResponse = new ErrorResponse(500, $e -> getMessage(), true);
                    return $mCustomHelper -> returnCatchAsJson($mErrorResponse );
                }
            } else {
                 //Respuesta de fallo de requestIngresarVenta
                 $db->rollBack();

                 $mErrorResponse = new ErrorResponse(500, $e -> getMessage(), true);
                 return $mCustomHelper -> returnCatchAsJson($mErrorResponse );
            }
        }else{
            //Respuesta de fallo de aprobarRechazarVenta
            $db->rollBack();

            $mErrorResponse = new ErrorResponse(500, $e -> getMessage(), true);
            return $mCustomHelper -> returnCatchAsJson($mErrorResponse );
        }

        $db = null;



    } catch (PDOException $e) {
        $db->rollBack();
        $mErrorResponse = new ErrorResponse(500, $e -> getMessage(), true);
        return $mCustomHelper -> returnCatchAsJson($mErrorResponse );
    }

});

//1
function aprobarRechazarVenta($idTablaValor, $razonRechazo, $db){
    
    $consulta;
    try {
        if($razonRechazo != null){
            $consultaRechazo = "UPDATE  tabla_valor SET
                      dato13 = 3,
                      dato14 = :razonRechazo,
                      descripcion14 = 'RazonRechazo'
                  WHERE idTablaValor = $idTablaValor AND
                        clave = 'NOTI-VENTA'";

            $consulta = $consultaRechazo;
        }else{
            $consultaAprobar = "UPDATE tabla_valor
               SET dato13 = 2
               WHERE clave = 'NOTI-VENTA' AND
                     idTablaValor = :idTablaValor";
            $consulta = $consultaAprobar;
        }
        $stmt = $db->prepare($consulta);

        $stmt->bindParam(':idTablaValor', $idTablaValor);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return true;
        } else if($stmt->rowCount() == 0) {
            return false;
        }

    } catch (PDOException $e) {
        $mErrorResponse = new ErrorResponse(500, $e -> getMessage(), true);
        return $mCustomHelper -> returnCatchAsJson($mErrorResponse );
    }
}

//2
function requestIngresarVenta($idTablaValor, $db){
    
    try {

        $consulta = "INSERT INTO venta(FkCuenta, TotalVenta, Enganche, Fecha, FkVendedor, PeriodoPago, CantidadAbono, SaldoPendiente, HorarioCobro, TipoVenta, GpsLat, GpsLon, EstatusAprobacion)
                    SELECT CAST(dato1 AS INT), CAST(dato2 AS DOUBLE), CAST(dato3 AS DOUBLE), DATE(dato4), CAST(dato5 AS INT), dato6, CAST(dato7 AS DOUBLE), CAST(dato8 AS DOUBLE), CAST(dato9 AS INT), CAST(dato10 AS INT), CAST(dato11 AS DOUBLE), CAST(dato12 AS DOUBLE), CAST(dato13 AS CHAR)
                    FROM tabla_valor
                    WHERE tabla_valor.clave = 'NOTI-VENTA' AND
                          tabla_valor.idTablaValor = $idTablaValor AND
                          tabla_valor.dato13 = 2";

        //Instanciacion de base de datos
        $stmt = $db->prepare($consulta);
        $stmt->bindParam(':idTablaValor', $idTablaValor);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            return true;
        } else if($stmt->rowCount() == 0) {
            return false;
        }

    } catch (PDOException $e) {
       $mErrorResponse = new ErrorResponse(500, $e -> getMessage(), true);
        return $mCustomHelper -> returnCatchAsJson($mErrorResponse );
    }
}

//3
function updateFkVentaTablaValor($fkVenta, $idTablaValor, $db){
    try {
        

        $consulta = "UPDATE tabla_valor
               SET dato4 = :FkVenta
               WHERE clave = 'NOTI-SUBVENTA' AND
               dato4 = :idTablaValor";

        $stmt = $db->prepare($consulta);

        $stmt->bindParam(':idTablaValor', $idTablaValor);
        $stmt->bindParam(':FkVenta', $fkVenta);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return true;
        } else if($stmt->rowCount() == 0) {
            return false;
        }

    } catch (PDOException $e) {
        $mErrorResponse = new ErrorResponse(500, $e -> getMessage(), true);
        return $mCustomHelper -> returnCatchAsJson($mErrorResponse );
    }
}

//4
function requestIngresarSubVenta($subVentaArray, $fkVenta, $db){

    try {
        
        $mCustomHelper = new MyCustomHelper();

        $consultaNotificacionVenta = "INSERT INTO subventa(FkArticulo, Cantidad, SubTotal, FkVenta)
                                        VALUES( :FkArticulo, :Cantidad, :SubTotal, :FkVenta)";


        $json = json_encode($subVentaArray , JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
        $mArray = json_decode($json, true);

        foreach ($mArray as $value) {
            $stmt = $db->prepare($consultaNotificacionVenta);

            $stmt->bindParam(':FkArticulo', $notificacion["FkArticulo"]);
            $stmt->bindParam(':Cantidad', $notificacion["Cantidad"]);
            $stmt->bindParam(':SubTotal', $notificacion["SubTotal"]);
            $stmt->bindParam(':FkVenta', $fkVenta);

            $stmt->execute();
        }

        if ($stmt->rowCount() > 0) {
            return true;
        } else if($stmt->rowCount() == 0) {
            return false;
        }

    } catch (PDOException $e) {
        $mErrorResponse = new ErrorResponse(500, $e->getMessage(), true);
        return $mCustomHelper->returnCatchAsJson($mErrorResponse);
    }
}







