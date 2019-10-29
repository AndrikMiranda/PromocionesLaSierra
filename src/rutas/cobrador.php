<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

//$app = new \Slim\App;

// REVISAR FUNCIONAMIENTO DE RUTAS ACTUALIZADAS DE COBRADOR.

//obetener todos los cobradores
$app -> get('/api/cobradores', function(Request $request, Response $response){

  $consulta = "SELECT
  usuario.Nombre,
  usuario.IdUsuario,
  cat_tipousuario.TipoUsuario,
  cat_estatus_usuarios.Estatus,
  cat_estatus_usuarios.Descripcion
  FROM
  usuario
  INNER JOIN cat_tipousuario ON usuario.FkCat_TipoUsuario = cat_tipousuario.IdTipoUsuario ,
  cat_estatus_usuarios
  WHERE
  cat_tipousuario.IdTipoUsuario = 2";

  try {

    //Instanciacion de base de datos
      $db = new db();
      $db = $db -> conectar();
      $ejecutacobradoresr = $db -> query($consulta);
      $cobradores = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
      $db = null;

      //Exportar y mostrar JSON
      echo json_encode($cobradores);

  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e -> getMessage().'}';
  }

});


//obetener un cobradores por id
$app -> get('/api/cobradores/{IdUsuario}', function(Request $request, Response $response){

  $id = $request -> getAttribute('IdUsuario');
  $consulta = "SELECT
  usuario.Nombre,
  usuario.IdUsuario,
  cat_tipousuario.TipoUsuario,
  cat_estatus_usuarios.Estatus,
  cat_estatus_usuarios.Descripcion
  FROM
  usuario
  INNER JOIN cat_tipousuario ON usuario.FkCat_TipoUsuario = cat_tipousuario.IdTipoUsuario ,
  cat_estatus_usuarios
  WHERE
  cat_tipousuario.IdTipoUsuario = 2
  AND IdUsuario = $id";

  try {

    //Instanciacion de base de datos
      $db = new db();
      $db = $db -> conectar();
      $ejecutar = $db -> query($consulta);
      $cobradores = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
      $db = null;

      //Exportar y mostrar JSON
      echo json_encode($cobradores);

  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e -> getMessage().'}';
  }

});

//obtener un cobrador por nombre
$app -> get('/api/cobradores/nombre/{Nombre}', function(Request $request, Response $response){

  $nombre = $request -> getAttribute('Nombre');

  $consulta = "SELECT
  usuario.Nombre,
  usuario.IdUsuario,
  cat_tipousuario.TipoUsuario,
  cat_estatus_usuarios.Estatus,
  cat_estatus_usuarios.Descripcion
  FROM
  usuario
  INNER JOIN cat_tipousuario ON usuario.FkCat_TipoUsuario = cat_tipousuario.IdTipoUsuario ,
  cat_estatus_usuarios
  WHERE
  cat_tipousuario.IdTipoUsuario = 2 
  AND usuario.Nombre LIKE '%$nombre%'";

  try {

    //Instanciacion de base de datos
      $db = new db();
      $db = $db -> conectar();
      $ejecutar = $db -> query($consulta);
      $cobradores = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
      $db = null;

      //Exportar y mostrar JSON
      echo json_encode($cobradores);

  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e -> getMessage().'}';
  }

});

//Actualizar cobradores
$app -> put('/api/cobradores/actualizar/{IdUsuario}', function(Request $request, Response $response){

  $id = $request -> getAttribute('IdUsuario');
  $nombre = $request -> getParam('Nombre');
  $tipo = $request -> getParam('FkCat_TipoUsuario');
  $estatus = $request -> getParam('FkCat_Estatus_Usuario');

 $consulta = "UPDATE usuario 
  SET Nombre = :Nombre,
  AMateFkCat_TipoUsuario = :FkCat_TipoUsuario,
  FkCat_Estatus_Usuario = :FkCat_Estatus_Usuario
  WHERE IdUsuario = $id";

  try {

    //Instanciacion de base de datos
      $db = new db();
      $db = $db -> conectar();
      $stmt = $db -> prepare($consulta);
      $stmt -> bindParam(':Nombre', $nombre);
      $stmt -> bindParam(':FkCat_TipoUsuario', $tipo);
      $stmt -> bindParam(':FkCat_Estatus_Usuario', $estatus);
      $stmt -> execute();
      echo '{"notice": {"text": "Cobrador actualizado"}';
      //Exportar y mostrar JSON

  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e -> getMessage().'}';
  }


});

//Eliminar cobradores
$app -> delete('/api/cobradores/eliminar/{IdUsuario}', function(Request $request, Response $response){

$id = $request -> getAttribute('IdUsuario');

  $consulta = "DELETE FROM usuario WHERE IdUsuario = '$id'";

  try {

    //Instanciacion de base de datos
      $db = new db();
      $db = $db -> conectar();
      $stmt = $db -> query($consulta);
      $stmt -> execute();
      $db = null;
      echo '{"notice": {"text": "Cobrador borrado"}';
  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e -> getMessage().'}';
  }


});


//Todas las rutas con todos sus cobradores, ordenados por ruta.
$app->get('/api/rutaCobrador/todos', function (Request $request, Response $response) {

    $consulta = "SELECT
                ruta_cobrador.fkRuta,
                ruta.NumeroRuta,
                ruta_cobrador.fkUsuario,
                usuario.Nombre,
                usuario.FkCat_Estatus_Usuario
                FROM
                ruta_cobrador
                INNER JOIN ruta ON ruta_cobrador.fkRuta = ruta.IdRuta
                INNER JOIN usuario ON ruta_cobrador.fkUsuario = usuario.IdUsuario
                WHERE usuario.FkCat_TipoUsuario = 2
                ORDER BY ruta.NumeroRuta DESC";

    try {

        $db = new db();
        $db = $db->conectar();
        $ejecutar = $db->query($consulta);
        $resultado = $ejecutar->fetchAll(PDO::FETCH_OBJ);
        $db = null;

        echo json_encode($resultado);

    } catch (PDOException $e) {
        echo '{"error": {"text": ' . $e->getMessage() . '}';
    }

});
