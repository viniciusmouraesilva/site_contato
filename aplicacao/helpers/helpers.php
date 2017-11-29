<?php
//closure
$definir_assunto = function() use ($assunto) {

switch($assunto) {	
		
	case '1':
		return 'mensagem';
		break;
			
	case '2':
		return 'serviços';
		break;
			
	case '3':	
		return 'orçamento';
		break;
			
	default:
		return 'sem assunto';
		break;
}
};

function gerar_chave() {
	$chave = mt_rand();
	
	while(is_file("../chaves_contato/{$chave}.txt")) {
		$chave = mt_rand();
	}
	
	$hash_chave = password_hash($chave,CRYPT_BLOWFISH,['cost'=>10]);
	
	$arquivo = fopen("../chaves_contato/{$chave}.txt",'a');
	fwrite($arquivo,$hash_chave);
	fclose($arquivo);
	
	if(is_file("../chaves_contato/{$chave}.txt")) {
		return $chave;
	}else {
		return 0;
	}
}