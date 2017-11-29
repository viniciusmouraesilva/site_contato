<?php
class Contato {
	
private $nome;
private $email;
private $assunto;
private $mensagem;
	
public function setNome($nome) {
	$this->nome = $nome;
}
	
public function getNome() {
	return $this->nome;
}
	
public function setEmail($email) {
	$this->email = $email;
}
	
public function getEmail() {
	return $this->email;
}
	
public function setAssunto($assunto) {
	$this->assunto = $assunto;
}
	
public function getAssunto() {
	return $this->assunto;
}
	
public function setMensagem($mensagem) {
	$this->mensagem = $mensagem;
}
	
public function getMensagem() {
	return $this->mensagem;
}

}