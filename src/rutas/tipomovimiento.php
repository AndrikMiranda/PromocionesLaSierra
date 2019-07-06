<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;



//obetener movimientos
$app -> get('/api/movimientos', function(Request $request, Response $response){

  $consulta = "select articulo.Codigo, articulo.NombreArticulo,
  articulo.Costo, articulo.PrecioVenta, articulo.PrecioMayoreo,
  cat_categoriaarticulos.NombreCategoria, inventarioprincipal.CantidadPrincipal,
  movimientoinventario.Cantidad, movimientoinventario.Fecha, usuario.Nombre,
  tipomovimiento.TipoMovimiento
from movimientoinventario
INNER JOIN inventarioprincipal on movimientoinventario.FkInventarioP = inventarioprincipal.IdInventarioP
INNER JOIN articulo on inventarioprincipal.FkArticulo = articulo.IdArticulo
INNER JOIN cat_categoriaarticulos on articulo.FkCategoria = cat_categoriaarticulos.IdCategoria
INNER JOIN usuario on movimientoinventario.FkUsuario = usuario.IdUsuario
INNER JOIN tipomovimiento on movimientoinventario.FkTipoMovimiento = tipomovimiento.IdTipoMovimiento";

  try {

    //Instanciacion de base de datos
      $db = new db();
      $db = $db -> conectar();
      $ejecutar = $db -> query($consulta);
      $inventario = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
      $db = null;

      //Exportar y mostrar JSON
      echo json_encode($inventario);

  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e -> getMessage().'}';
  }


});


?>
