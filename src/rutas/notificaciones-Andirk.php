<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


$fkVendedorParaSubVenta;

$app->get('/api/andrik', function (Request $request, Response $response) {

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
                                WHERE clave = 'NOTI-CLIENTE'
                                LIMIT $limit
                                OFFSET $offset";  

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
                                WHERE clave ='NOTI-VENTA'
                                LIMIT $limit
                                OFFSET $offset";

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
                                WHERE clave = 'NOTI-SUBVENTA'
                                LIMIT $limit
                                OFFSET $offset"; 


  
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

        switch ( $columnaGenerica ) {
            case "estatusAprobacion":
                $columnaGenerica = "dato13";
                break;
            case "idTablaValor":
                $columnaGenerica = "idTablaValor";
                break;
            case "fkVendedor":
                $columnaGenerica = "dato5";
                break;
            default:
                $mErrorResponse = new ErrorResponse(200, 'Hubo un problema con la solicitud. Intentelo de nuevo.', false);
                return $mCustomHelper -> returnCatchAsJson($mErrorResponse );
        }

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
                        WHERE clave = 'NOTI-VENTA'
                        AND ".$columnaGenerica." = '$parametroColumnaGenerica' 
                        LIMIT $limit
                        OFFSET $offset";
                        
                        echo "==========================================";
                        echo json_encode($consultaGenerica, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
                        echo "==========================================";
                        
        $totalConsultaGenerica = "SELECT
                        COUNT(tabla_valor.clave) as Total
                        FROM
                        tabla_valor
                        INNER JOIN usuario ON usuario.IdUsuario = tabla_valor.dato5
                        WHERE clave = 'NOTI-VENTA' AND
                        ".$columnaGenerica." = '$parametroColumnaGenerica'  
                        LIMIT $limit
                        OFFSET $offset";

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


 ?>