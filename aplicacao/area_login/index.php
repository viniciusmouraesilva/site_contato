<?php
require_once '../helpers/php_ini_config.php';
		
session_start();
	
require_once 'helpers/token.php';
	
if(array_key_exists('logado',$_SESSION)) {
	if($_SESSION['logado'] == true) {
		header("Location:controllers/index.php");
		exit;
	}else {
		session_destroy();
		header("Location:index.php");
		exit;
	}
}

require_once 'models/repositorio_usuario.php';

$resultado = [];

#controle de erros
$erro_indice = [];
$tem_erro = false;

#mensagem de tpken e sessao expirada
$token_mensagem = '';
$sessao_expirada = '';
	
$usuario_guardado = false;	
	
if(array_key_exists('token_mensagem',$_SESSION)) {	
	$token_mensagem = htmlentities($_SESSION['token_mensagem']);
	unset($_SESSION['token_mensagem']);
}
	
if(array_key_exists('sessao_expirada',$_SESSION)) {	
	$sessao_expirada = htmlentities($_SESSION['sessao_expirada']);
	unset($_SESSION['sessao_expirada']);
}
$senha = '';

$email_valido = false;
	
$email = array_key_exists('email',$_POST)?htmlentities($_POST['email']):'';
	
if($_SERVER['REQUEST_METHOD'] == "POST") {
	
	require_once '../../config/banco_login.php';

	require_once '../../config/config_login.php';	
	
		
	if(array_key_exists('email',$_POST)) {
		$email = filter_input(INPUT_POST,'email',FILTER_SANITIZE_EMAIL);
		
		if(!empty(trim($email))) {
			if(filter_var($email,FILTER_VALIDATE_EMAIL)) {
				$email_valido = true;
			}else {
				$tem_erro = true;
				$erro_indice['email'] = " * Email inválido.";
		}
	}else {
		$tem_erro = true;
		$erro_indice['email'] = " * O email precisa ser informado.";
	}	
}
	
	if(array_key_exists('senha',$_POST)) {
		$senha = filter_input(INPUT_POST,'senha',FILTER_SANITIZE_STRING); 
		
		if(empty(trim($senha))) {
			$tem_erro = true;
			$erro_indice['senha'] = " * A senha precisa ser informada.";
		}
	}
		
	if(array_key_exists('token',$_POST)) {
		$token = $_POST['token'];
	}else {
		$token = '';
	}	
		
	if(array_key_exists('token',$_SESSION)) {
			
		$tokens_em_sessao = sizeof($_SESSION['token']);
			
		$token_valido = 0;
		$i = 0;
			
		while($i<$tokens_em_sessao) {
			if($_SESSION['token'][$i] == $token) {
				$token_valido = 1; 
			}
			$i++;
		}
			
		if(!$tem_erro) {
			if($token_valido == 1) {
					
				$repositorio_usuario = new RepositorioUsuario($pdo);	
					
				if($email_valido) {
					$resultado = $repositorio_usuario->verificarUsuario($email, $senha);
				}
					
				if(count($resultado) == 3) {
					
					$chave = password_hash(mt_rand(),CRYPT_BLOWFISH,['cost'=>10]);
					
					$usuario_guardado = $repositorio_usuario->guardarUsuario($email, $senha, $chave);
					
					if($usuario_guardado > 0) {
					
						$_SESSION['chave'] = $chave;
						
						$_SESSION['id'] = $usuario_guardado;
						
						$_SESSION['email'] = password_hash($email,CRYPT_BLOWFISH,['cost'=>10]);
						
						$_SESSION['senha'] = password_hash($senha,CRYPT_BLOWFISH,['cost'=>10]);
						
						unset($_SESSION['token']);
					
						$_SESSION['token_usuario'] = password_hash($_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT'],CRYPT_BLOWFISH,['cost'=>10]);
					
						$_SESSION['logado'] = true;
					
						header("Location:controllers/index.php");
						exit;
					}else { 
						$erro_indice['login'] = "* Não foi possível fazer login.";
					}
				}else {
					$erro_indice['usuario_invalido'] = "Usuário e senha inválidos.";
				}
			}else {
				$_SESSION['token_mensagem'] = "Token inválido!";
				if(array_key_exists('token',$_SESSION)) {
					unset($_SESSION['token']);
				}
				header("Location:index.php");
				exit;
			}
		}
	}	
}

require 'views/template_login.php';
