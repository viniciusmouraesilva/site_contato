<?php 
require_once '../../helpers/php_ini_config.php';

session_start();

require_once '../helpers/validar_login.php';

require_once '../../../config/banco_login.php';

require_once '../../../config/config_login.php';

$rota = 'mensagens';

if(array_key_exists('rota',$_GET)) {
	$rota = (string)filter_input(INPUT_GET,'rota',FILTER_SANITIZE_STRING);
	
	$verificar = function() {
		switch($rota) {
			case 'visualizar_mensagem':
				$rota = 'visualizar_mensagem';
				break;
			default: 
				$rota = 'mensagens';
				break;
		}
	};
}

if(is_file("controllers/{$rota}.php")) {
	require "controllers/{$rota}.php";
}else{
	exit('Rota inexistente. Tente outra.');
}

