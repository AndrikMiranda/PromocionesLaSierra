<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

//Obtener Lista Negra General
$app -> get('/api/RepListaNegra/', function(Request $request, Response $response){

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