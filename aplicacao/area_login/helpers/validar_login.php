<?php
if(!array_key_exists('email',$_SESSION) or !array_key_exists('senha',$_SESSION)) {
	session_destroy();
	header("Location:../");
	exit;
}else {
	if(!array_key_exists('chave',$_SESSION) or !array_key_exists('id',$_SESSION)) {
		session_destroy();
		header("Location:../");
		exit;
	}else {
		require_once '../../../config/banco_login.php';
		require_once '../../../config/config_login.php';
		require_once '../models/repositorio_usuario.php';
	
		$login = false;
	
		$repositorio_usuario = new RepositorioUsuario($pdo);
	
		$login = $repositorio_usuario->verificarLogin($_SESSION['chave'], $_SESSION['email'], $_SESSION['senha'], $_SESSION['id']);
	
		if($login == false) {	
			session_destroy();
			header("Location:../");
			exit;
		}
	}
}

if(!array_key_exists('logado',$_SESSION)) {
	session_destroy();
	header("Location:../");
	exit;
}else {
	if($_SESSION['logado'] !== true) {
		session_destroy();
		header("Location:../");
		exit;
	}
}
	
if(!array_key_exists('token_usuario',$_SESSION)) {
	session_destroy();
	header("Location:../");
	exit;
}	

//primeiro verifique a mensagem original depois o dado em forma de hash
$token_usuario = $_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT'];

if(!password_verify($token_usuario,$_SESSION['token_usuario'])) {
	session_destroy();
	header("Location:../");
	exit;
}
?>