<?php
require_once '../../helpers/php_ini_config.php';
require_once '../helpers/validar_login.php';

$resultado = false;

$resultado = $repositorio_usuario->verificarExclusaoSessao($_SESSION['id'], $_SESSION['chave']);

if(!$resultado) {
	$data = date('Y-m-d');
	$chave = filter_var($_SESSION['chave'],FILTER_SANITIZE_STRING);
	file_put_contents(
	"log_saida/log.txt","Não foi possível excluir a sessão de chave {$chave} {$data}.".PHP_EOL,FILE_APPEND);
}else {
	$data = date('Y-m-d');
	$chave = filter_var($_SESSION['chave'],FILTER_SANITIZE_STRING);
	file_put_contents(
"log_saida/log.txt","Sessão de chave : {$chave} foi excluída com sucesso. {$data}".PHP_EOL,FILE_APPEND);
}

session_destroy();

header('Location:../');
exit;