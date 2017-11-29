<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<title>Mensagens</title>
	<meta http-equiv="Content-Security-Policy" content="default-src 'self'; script-src 'none'; style-src 'self'; img-src 'none'; font-src 'self'; form-action 'none'">
	
	<meta name="author" content="Vinícius Moura">
	
	<meta name="robots" content="noindex">
	
	<link rel="stylesheet" href="css/normalize.css">
	
	<link rel="stylesheet" href="css/estilo.css">
</head>
<body>
	<div class="menu">
		<a href="index.php?rota=sair">Sair</a>
	</div>
	<div class="mensagens">
		<h2>Mensagens</h2>
		<?php foreach($mensagens as $mensagem): ?>
				<p>Nome: <?php print $mensagem->getNome(); ?></p>
				<p>Assunto: <?php print $mensagem->getAssunto(); ?></p>
				<p>Data: <?php print formatar_data($mensagem->getData()); ?></p>
				<p><a href="index.php?rota=visualizar_mensagem&id=<?php print $mensagem->getId(); ?>">Visualizr Mensagem</a></p>
				<hr>
		<?php endforeach; ?>
	</div>
</body>
</html>