<?php
class RepositorioMensagens {
	
public function __construct($pdo) {
	$this->pdo = $pdo;
}

public function buscarMensagens() {

$sqlBuscar = <<<BUSCARCONTATO
		SELECT * FROM contato ORDER BY data DESC
BUSCARCONTATO;

$query = $this->pdo->prepare($sqlBuscar);

$query->execute();

return $query->fetchAll(PDO::FETCH_CLASS,'Mensagens'); 

}	
	
public function verificarId($id) {
try {
		
	$sqlVerificar = "SELECT * FROM contato WHERE id = :id LIMIT 1";
	
	$query = $this->pdo->prepare($sqlVerificar);
	
	$query->bindValue(':id', $id, PDO::PARAM_INT);
	
	$query->execute();
	
	$erros = $query->errorInfo();
	
	if($erros[0] != 00000) {
		throw new Exception;
	}
	
	if($query->rowCount() == 1) {
		return true;
	}
	
	return false;
}catch(Exception $ex) {
	return false;
}
	
}

public function buscarChave($id) {
try {
		
	$sqlVerificar = "SELECT id_chave FROM contato WHERE id = :id LIMIT 1";
	
	$query = $this->pdo->prepare($sqlVerificar);
	
	$query->bindValue(':id', $id, PDO::PARAM_INT);
	
	$query->execute();
	
	$erros = $query->errorInfo();
	
	if($erros[0] != 00000) {
		throw new Exception;
	}
	
	if($query->rowCount() == 1) {
		return $query->fetch(PDO::FETCH_ASSOC);
	}
	
	return 0;
}catch(Exception $ex) {
	return false;
}
	
}

public function buscarMensagem($id, $conteudo_chave) {

try {
$sqlBuscar = <<<DESCRIPTOGRAFAR
	SELECT CAST(
	AES_DECRYPT(email, UNHEX(SHA2(:chave,512))) AS CHAR(60))email,
	CAST(AES_DECRYPT(mensagem, UNHEX(SHA2(:chave,512))) AS CHAR(2000))mensagem  
	FROM contato WHERE id = :id LIMIT 1
DESCRIPTOGRAFAR;

$query = $this->pdo->prepare($sqlBuscar);

$query->bindValue(':id', $id, PDO::PARAM_INT);
$query->bindValue(':chave', $conteudo_chave);
$query->bindValue(':chave', $conteudo_chave);

$query->execute();

$erros = $query->errorInfo();

if($erros[0] != 00000) {
	throw new Exception();
}

if($query->rowCount() == 1) {
	return $query->FetchObject('Mensagens');
}

return '';
}catch(Exception $ex) {
	return '';
}

}	
	
}