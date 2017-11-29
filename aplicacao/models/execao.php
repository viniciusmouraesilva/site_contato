<?php
class MinhasExcecoes {

public function verificarChave($chave) {
	try {
		if($chave == 0) {
			throw new NaoGerouChave();
		}
		return '';
	}catch(NaoGerouChave $ex) {
		return 'Não foi possível enviar seu contato';
	}	
}
}