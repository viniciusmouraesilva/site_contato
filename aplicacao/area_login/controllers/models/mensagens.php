<?php
class Mensagens {
	
private $id = 0;
private $nome;
private $email;
private $mensagem;
private $assunto;
private $data;
	
public function setId($id) {
	$this->id = $id;
}

public function getId() {
	return $this->id;
}

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
	
public function setData($data) {
	$this->data = $data;
}

public function getData() {
	return $this->data;
}

}