<?php
namespace conn;

#chamando definições do banco para concectar
require_once 'banco.php';

class Conexao {
	
static function conectar() {

	try {
		return new \PDO(DSN,USUARIO,SENHA);
	}catch(PDOException $ex) {
		echo "Não foi possivél conectar com o banco de dados.";
		exit;
	}
}
}