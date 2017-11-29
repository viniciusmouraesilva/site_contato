<?php
function formatar_data($data) {
	
	if($data == null or $data == '0000-00-00') {
		return '';
	}
	
	$partes = explode('-', $data);
	
	return "{$partes[2]}/{$partes[1]}/{$partes[0]}";
}

function buscar_chave($id_chave) {	
	if(file_exists("../../../chaves_contato/{$id_chave['id_chave']}.txt")) {
		$arquivo = fopen("../../../chaves_contato/{$id_chave['id_chave']}.txt","r");
		$conteudo = fgets($arquivo, 4092);
		fclose($arquivo);
		
		if(strlen($conteudo)>0) {
			return $conteudo;
		}else {
			return '';
		}
	}else {
		return '';
	}
}