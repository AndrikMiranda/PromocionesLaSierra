<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

//Obtener Cuentas con saldo Pendiente
$app -> get('/api/RepSaldoPendiente', function(Request $request, Response $response){

    $consulta = "SELECT a.IdCuenta,a.NumeroCuenta,a.SaldoTotal,a.ContadorVencidos,a.ContadorAtrasados,
                 b.IdCliente,b.Nombre,b.APaterno,b.AMaterno
                 FROM cuenta a,cliente b
                 WHERE a.FkCliente=b.IdCliente
                 AND a.SaldoTotal>0
                 ORDER BY a.SaldoTotal DESC";
 
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