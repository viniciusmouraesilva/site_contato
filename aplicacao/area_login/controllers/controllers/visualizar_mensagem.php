<?php
require_once '../../helpers/php_ini_config.php';
require_once '../helpers/validar_login.php';

if(array_key_exists('id',$_GET)) {
	$id = (int)$_GET['id'];	
}

if($id <= 0 && filter_var($id,FILTER_VALIDATE_INT)) {
	header('Location:index.php');
	exit;
}

require 'models/repositorio_mensagens.php';

$repositorio_mensagens = new RepositorioMensagens($pdo);

if(!$repositorio_mensagens->verificarId($id)) {
	exit('Esse id não existe. Informe outro.');
}

require 'models/mensagens.php';
$mensagem = new Mensagens(); 
#mensagem de erro
$mensagem_erro = '';
	
$id_chave = $repositorio_mensagens->buscarChave($id);

if($id_chave == 0)
	$mensagem_erro = "Não foi possível encontrar essa mensagem.";
else 
	require 'helpers/helpers.php';

	$conteudo_chave = buscar_chave($id_chave);

	if($conteudo_chave == null) {
		$mensagem_erro = "Não foi possível encontrar essa mensagem.";
	}else {
		$mensagem = $repositorio_mensagens->buscarMensagem($id, $conteudo_chave);
		
		if(is_null($mensagem)) 
			$mensagem_erro = "Não foi possível encontrar essa mensagem.";
	}
	
require 'views/template_mensagem.php';