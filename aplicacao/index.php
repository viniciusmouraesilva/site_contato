<?php
require_once 'helpers/php_ini_config.php';

session_start();

require_once 'helpers/token.php';

require_once '../config/config.php';	
use conn as c;

#variáveis sobre token
$mensagem_token = '';
$token_valido = 0;
$tokens_em_sessao = 0;

#controle de erros formulário
$erro_indice = [];
$tem_erro = false;
$mensagem_retorno = '';
$mensagem_contato = '';

#enviou_contato do email
$enviou_contato = false;

#verificar a existencia de mensagem contato
if(array_key_exists('mensagem_contato',$_SESSION)) {
	$mensagem_contato = filter_var($_SESSION['mensagem_contato'],FILTER_SANITIZE_STRING);
	unset($_SESSION['mensagem_contato']);
}

#verificar a existencia de mensagem sobre token
if(array_key_exists('mensagem_token',$_SESSION)) {
	$mensagem_token = filter_var($_SESSION['mensagem_token'],FILTER_SANITIZE_STRING);
	unset($_SESSION['mensagem_token']);
}

#classe Contato
require_once 'models/contato.php';
$contato = new Contato();

#classe de Exceções
require_once 'models/execao.php';
$excecoes = new MinhasExcecoes();

$assunto = (array_key_exists('assunto',$_POST)?(int)$_POST['assunto']:1);
	
if($_SERVER['REQUEST_METHOD'] == "POST") {

#existência do token
if(array_key_exists('token',$_POST)) {
	$token = $_POST['token'];
}else {
	$token = '';
}

#validação do token de segurança 
if(array_key_exists('token',$_SESSION)) {

	$tokens_em_sessao = sizeof($_SESSION['token']);
			
	$i = 0;

	while($i<$tokens_em_sessao) {
		if($_SESSION["token"][$i] == $token) {
			$token_valido = 1;
		}
		$i++;
	}
}

if(array_key_exists('nome',$_POST)) {
	$nome = filter_input(INPUT_POST,'nome',FILTER_SANITIZE_STRING);
	if(mb_strlen(trim($nome))>=3) {
		$contato->setNome($nome);
	}else {
		$contato->setNome($nome);
		$tem_erro = true;
		$erro_indice['nome'] = "* O nome precisa ter no minímo 3 caracteres.";
	}
		
	if(mb_strlen(trim($contato->getNome()))>17) {
		$tem_erro = true;
		$erro_indice['nome'] = "* Para nome é permitido no máximo 17 caracteres.";
	}
}else {
	$tem_erro = true;
	$erro_indice['nome'] = "* O nome precisa ser enviado.";
}
	
if(array_key_exists('email',$_POST)) {
	$email = filter_input(INPUT_POST,'email',FILTER_SANITIZE_EMAIL);
	if(filter_var($email,FILTER_VALIDATE_EMAIL)) {
		$contato->setEmail($email);
	}else {
		$contato->setEmail($email);
		$tem_erro = true;
		$erro_indice['email'] = "* Email inválido.";
	}
}
	
if(array_key_exists('assunto',$_POST)) {
		
	if(filter_input(INPUT_POST,'assunto',FILTER_VALIDATE_INT)>0) {
		$assunto = (int)$_POST['assunto'];
			
		require_once 'helpers/helpers.php';
			
		$contato->setAssunto($definir_assunto($assunto));	
	}
}
	
if(array_key_exists('mensagem',$_POST)) {
		
	if(!empty(trim($_POST['mensagem']))) {
		$mensagem = filter_input(INPUT_POST,'mensagem',FILTER_SANITIZE_STRING);
		$contato->setMensagem($mensagem);
	}else{
		$contato->setMensagem('');
		$tem_erro = true;
		$erro_indice['mensagem'] = "* A mensagem precisa ser preencida.";
	}
}else{
	$tem_erro = true;
	$erro_indice['mensagem'] = "* A mensagem precisa ser enviada.";
}
	
if(!$tem_erro) {
	
	if($token_valido == 1) {
		
		$pdo = c\Conexao::conectar();
		$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_SILENT);
	
		require_once 'models/repositorio_contato.php';
		
		$repositorio_contato = new RepositorioContato();
	
		$chave = gerar_chave(); #gerar chave de criptografia para contato
		$mensagem_retorno = $excecoes->verificarChave($chave);
	
		if(mb_strlen($mensagem_retorno)>0) {
			$_SESSION['mensagem_contato'] = $mensagem_retorno;
			header("Location:index.php#contato");
			exit;
		}
	
		#a variavel chamada $chave vai ser o nome do arquivo txt
		#$conteudo_arquivo_chave é conteúdo para futuramente descriptografar
		$conteudo_arquivo_chave = file_get_contents("../chaves_contato/{$chave}.txt");
	
		$mensagem_retorno = $repositorio_contato::salvarContato($contato, $pdo, $chave, $conteudo_arquivo_chave);	
		
		$_SESSION['mensagem_contato'] = $mensagem_retorno;
		
		unset($_SESSION['token']);
		
		header("Location:index.php#contato");
		exit;	
	}else {
		$_SESSION['mensagem_token'] = "Token inválido. Tente enviar novamente.";
		if(array_key_exists('token',$_SESSION)) {
			unset($_SESSION['token']);
		}
		header("Location:index.php#contato");
		exit;
	}
}
}
require 'view/template_index.php';