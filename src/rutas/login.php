<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

//obetener login
$app -> post('/api/login', function(Request $request, Response $response){
  $nombre = $request -> getParam('Nombre');
  $password = $request -> getParam('Contrasena');
  $contrasena = md5(base64_encode($password));
      try{
        $db = new db();
        $db = $db -> conectar();
        $consulta = "SELECT usuario.IdUsuario, usuario.Nombre, usuario.FkCat_TipoUsuario,
        usuario.FkCat_Estatus_Usuario, cat_tipousuario.TipoUsuario
        FROM usuario
        INNER JOIN cat_tipousuario on usuario.FkCat_TipoUsuario = cat_tipousuario.IdTipoUsuario
        WHERE usuario.Nombre = :Nombre
        AND usuario.Contrasena = :Contrasena";
        $auth = $db->prepare($consulta);
        $auth->bindParam(':Nombre', $nombre);
        $auth->bindParam(':Contrasena', $contrasena);
        $auth->execute();
        $rows=$auth->rowCount();
        if($rows > 0){
        	$responseData['status'] = 1;
            $responseData['response'] = $auth->fetchAll(PDO::FETCH_ASSOC);
        	// $responseData['response'] = $auth->fetchAll();
        }else{
        	$responseData['status'] = 0;
        	$responseData['msg'] = 'Usuario o contraseña incorrectos.';
        }
        return $this->response->withJson($responseData, 200);
    } catch (PDOException $e) {
      echo '{"error": {"text": '.$e -> getMessage().'}';
    }
});
?>