<?php
class RepositorioUsuario {
	
private $pdo;	
	
public function __construct($pdo) {
	$this->pdo = $pdo;
}	
	
public function verificarUsuario($email,$senha) {
		
	$sqlBuscar = "SELECT * FROM adm LIMIT 1";

	$query = $this->pdo->prepare($sqlBuscar);
		
	$query->execute();
		
	$usuario = $query->fetch(PDO::FETCH_ASSOC);

	if($query->rowCount() == 1) {
		if(password_verify($senha,$usuario['senha']) && 
			password_verify($email,$usuario['email'])) {
			
			return $usuario;
			
		}elseif(is_file("../../senhas_esquecidas/{$usuario['id']}.txt")) {	
			
			$arquivo = fopen("../../senhas_esquecidas/{$usuario['id']}.txt","r");
			$senha_randomica = (string)fgets($arquivo,4096);
			fclose($arquivo);
				
			if(count($senha_randomica)>0) {
				if($senha === $senha_randomica) {
					return $usuario;
				}else {
					return "";
				}
			}else {
				return "";
			}
		}	
	}else {
		return "";
	}
}

public function verificarEmailExistente($email){
		
	$sqlVerificar = "SELECT * FROM adm LIMIT 1";
		
	$query = $this->pdo->prepare($sqlVerificar);
		
	$query->execute();
		
	$usuario = $query->fetch(PDO::FETCH_ASSOC);
		
	if($query->rowCount()==1){
		if(password_verify($email,$usuario['email'])){
			return $usuario;
		}else{
			return "";
		}
	}else{
		return "";
	}	
}

public function guardarUsuario($email, $senha, $chave) {

$resultado = false;

while($resultado == false) {
	$id = mt_rand();
	$resultado = $this->verificarId($id);
}

try{
	
	$sqlGuardar = <<<GUARDARLOGIN
		INSERT INTO login (id, email,senha) VALUES (
		:id,
		AES_ENCRYPT(:email,UNHEX(SHA2(:chave,512))),
		AES_ENCRYPT(:senha,UNHEX(SHA2(:chave,512)))
		)
GUARDARLOGIN;
	
	$query = $this->pdo->prepare($sqlGuardar);
	
	$query->execute(['id'=>$id,
		'email'=>$email,
		'chave'=>$chave,
		'senha'=>$senha,
		'chave'=>$chave]);
	
	$erros = $query->errorInfo();
	
	if($erros[0] != 00000) {
		throw new Exception;
	}
	
	if($query->rowCount() == 1) {
		return $id;
	}
	
	return 0;
}catch(Exception $ex) {
	return 0;
}
	
}

private function verificarId($id) {

try {
	$sqlVerificar = "SELECT * FROM login WHERE id = :id LIMIT 1";
	
	$query = $this->pdo->prepare($sqlVerificar);
	
	$query->bindValue(':id', $id, PDO::PARAM_INT);

	$erros = $query->errorInfo();
	
	if($erros[0] != 00000) {
		throw new Exception();
	}
	
	if($query->rowCount() == 1) {
		return false;
	}
	
	return true;
}catch(Exception $ex) {
	return false;
}

}

public function verificarLogin($chave, $email, $senha, $id) {
	
$chave = filter_var($chave,FILTER_SANITIZE_STRING);

try {
	$sqlVerificar = <<<VERIFICARLOGIN
		SELECT CAST(AES_DECRYPT(email,UNHEX(SHA2(:chave,512)))AS CHAR(100))email,
		CAST(AES_DECRYPT(senha,UNHEX(SHA2(:chave,512)))AS CHAR(100))senha
		FROM login WHERE id = :id
VERIFICARLOGIN;

	$query = $this->pdo->prepare($sqlVerificar);

	$query->execute(['chave'=>$chave,'chave'=>$chave,'id'=>$id]);

	$erros = $query->errorInfo();

	if($erros[0] != 00000) {
		throw new Exception;
	}

	if($query->rowCount() == 1) {
		$usuario = $query->fetch(PDO::FETCH_ASSOC);
		
		if(password_verify($usuario['email'],$email) && password_verify($usuario['senha'],$senha)) {
			return true;
		}else {
			throw new Exception;
		}
	}

	return false;
	
}catch(Exception $ex) {
	return false;	
}
		
}

public function verificarExclusaoSessao($id, $chave) {
	$chave = filter_var($chave,FILTER_SANITIZE_STRING);
	
try {
	
	$sqlVerificar = <<<VERIFICARPARAEXCLUIR
		SELECT CAST(AES_DECRYPT(email,UNHEX(SHA2(:chave,512)))AS CHAR(100))email,
		CAST(AES_DECRYPT(senha,UNHEX(SHA2(:chave,512)))AS CHAR(100))senha
		FROM login WHERE id = :id
VERIFICARPARAEXCLUIR;

	$query = $this->pdo->prepare($sqlVerificar);

	$query->execute(['chave'=>$chave,'chave'=>$chave,'id'=>$id]);
	
	if($query->rowCount() == 1) {
		
		$resultado = false;
		
		$resultado = $this->excluirSessao($id);
	
		if($resultado)
			return true;
		else 
			return false;
	}
	
}catch(Exception $ex) {
	return false;
}

}

private function excluirSessao($id) {

try {
	$sqlExcluir = "DELETE FROM login WHERE id = :id LIMIT 1";
	
	$query = $this->pdo->prepare($sqlExcluir);
	
	$query->bindValue(':id',$id, PDO::PARAM_INT);
	
	$query->execute();
	
	$erros = $query->errorInfo();
	
	if($erros[0] != 00000) {
		throw new Exception;
	}
	
	if($query->rowCount() == 1){
		return true;
	}
	
	return false;
}catch(Exception $ex) {
	return false;
}

}

}
	