<?php
class RepositorioContato {

public static function salvarContato(Contato $contato, PDO $pdo, $chave, $conteudo_arquivo_chave) {
		
try {
	$sqlSalvar = <<<SALVARCONTATO
		INSERT INTO contato(nome,email,assunto,mensagem,data,id_chave) 
		VALUES (:nome,
				AES_ENCRYPT(:email,UNHEX(SHA2(:chave,512))),
				:assunto,
				AES_ENCRYPT(:mensagem,UNHEX(SHA2(:chave,512))),
				:data,
				:id_chave
		)
SALVARCONTATO;

$query = $pdo->prepare($sqlSalvar);

$query->bindValue(':nome',$contato->getNome());
$query->bindValue(':email',$contato->getEmail());
$query->bindValue(':chave',$conteudo_arquivo_chave);
$query->bindValue(':assunto',$contato->getAssunto());
$query->bindValue(':mensagem',$contato->getMensagem());
$query->bindValue(':chave',$conteudo_arquivo_chave);
$query->bindValue(':data',date('Y-m-d'));
$query->bindValue(':id_chave',$chave);

$query->execute();

$erros = $query->errorInfo();

if($erros[0] != 00000) {
	throw new Exception();
}

return 'Contato enviado com sucesso.';

}catch(Exception $ex) {
	return 'Não foi possível enviar o seu contato. Tente novamente.';	
}
		
}

}
