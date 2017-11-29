<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>Mensagem</title>
	<meta charset="utf-8">
	<meta http-equiv="Content-Security-Policy" content="default-src 'self'; script-src 'none'; style-src 'self'; form-action 'self'; font-src 'self'; img-src 'none'">
	<link rel="stylesshet" href="css/normalize.css">
	<link rel="stylesheet" href="css/estilo.css">
</head>
<body>
	<div class="mensagens">
		<hr>
		<?php if(mb_strlen($mensagem_erro)>0) :?>
				<p><?php print $mensagem_erro; ?></p>
		<?php endif; ?>
		
		<p><?php print $mensagem->getEmail(); ?></p>
		
		<p class="mensagem"><?php print $mensagem->getMensagem(); ?></p>
		
		<a href="index.php">Voltar</a>
	</div>
	
	
</body>
</html>