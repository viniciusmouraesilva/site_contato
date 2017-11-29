<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>Vinícius Moura | Desenvolvimento de Webisetes PHP, MySQL, HTML5 e CSS</title>
	
	<meta charset="UTF-8">
	
	<meta name="description" content="Contato Vinícius Moura. Desenvolvedor Web com habilidades HTML, CSS, PHP e MySQL">
	
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<meta name="author" content="Vinícius Moura">
	
	<meta name="robots" content="index,follow,archive">
	
	<!-- Content Security Policy -->
	<meta http-equiv="Content-Security-Policy" content="default-src 'self'; img-src 'self'; script-src 'self'; form-action 'self'; style-src 'self'">
	
	<!-- resetar padrões de estilo -->
	<link rel="stylesheet" href="css/normalize.css">
	
	<link rel="stylesheet" href="css/estilo.css">
</head>
<body>
	<!-- Menu de navegação -->
	<nav>
		<a href="index.php">Vinícius Moura</a>
		<ul>
			<li><a href="#sobre">Sobre</a></li>
			<li><a href="#servicos">Serviços</a></li>
			<li><a href="#contato">Contato</a></li>
		</ul>
	</nav>
	
	<!-- Cabeçalho -->
	<header>
		<h1>Vinícius Moura</h1>
		<p>Desenvolvedor WEB com habilidades HTML, CSS, PHP e MySQL.</p>
		<a href="#sobre" class="button">VER MAIS</a>
	</header>
	
	<!-- Seção de Sobre -->
	<section id="sobre" class="sobre">
		<h2>Sobre</h2>
		<p>Atualmente cursando Análise e Desenvolvimento de sistemas. Desenvolve pequenos programas e Websites que podem ser encontrados no <a href="https://github.com/viniciusmouraesilva">GitHub.</a> Em conjunto, desenvolve um Website que auxilia na segurança de aplicações Web PHP. <a href="https://viniciusmouraesilva.github.io/seguranca_aplicacoes_web/">Segurança PHP</a></p>
		<a href="#contato" class="button">ENTRE EM CONTATO</a>
	</section>
	
	<!-- Serviços -->
	<section id="servicos" class="servicos">
		<h2>Serviços</h2>
		
		<article class="servico">
			<h3>HTML5 e CSS</h3>
			<!-- <img src="imagens/html-css.jpg" alt="símbolos de HTML e CSS"> -->
			<p>Desenvolvimento de Sites em HTML5 e CSS responsivos</p>
		</article>
		
		<article class="servico">
			<h3>PHP e MySQL</h3>
			<p>Desenvolvimento de Websites interativos com PHP e MySQL</p>
		</article>
	</section>
	
	<!-- Contato -->
	<section id="contato" class="contato">
		<h2>Contato</h2>
		<p>Adoraria receber a sua mensagem. Entre em Contato com: </p>
		
		<!-- Formulário -->
		<form method="POST">
			<input type="hidden" name="token" value="<?php echo htmlentities($token_conteudo); ?>">
			
			<?php if(mb_strlen($mensagem_retorno)>0): ?>
				<?php print $mensagem_retorno; ?>
			<?php endif; ?>

			<?php if(mb_strlen($mensagem_token)>0): ?>
				<p><?php print $mensagem_token; ?></p>
			<?php endif; ?>
			
			<?php if(mb_strlen($mensagem_contato)>0): ?>
				<?php printf('<h3>%s</h3>',$mensagem_contato); ?>
			<?php endif; ?>
			
			<?php if($tem_erro && array_key_exists('nome',$erro_indice)): ?>
				<p><?php echo $erro_indice['nome']; ?></p>
			<?php endif; ?>
			<input type="text" name="nome" placeholder="nome" value="<?php print htmlentities($contato->getNome()); ?>">
			
			<?php if($tem_erro && array_key_exists('email',$erro_indice)): ?>
				<p><?php echo $erro_indice['email']; ?></p>
			<?php endif; ?>
			<input type="email" name="email" placeholder="email" value="<?php print htmlentities($contato->getEmail()); ?>">
			
			<select name="assunto">
				<option value="1" selected>mensagem</option>
				<option value="2" <?php echo ($assunto === 2)?'selected':''; ?>>serviços</option>
				<option value="3" <?php echo ($assunto === 3)?'selected':''; ?>>orçamento</option>
			</select>
			
			<?php if($tem_erro && array_key_exists('mensagem',$erro_indice)): ?>
				<p><?php echo $erro_indice['mensagem']; ?></p>
			<?php endif; ?>
			<textarea name="mensagem" placeholder="mensagem"><?php echo htmlentities($contato->getMensagem()); ?></textarea>
			
			<input type="submit" value="Enviar" class="button">
		</form>	
		<!-- -->
		
		<!-- Contato Telefone e Email-->
		<div class="icone-contato">
			<img src="imagens/phone.png" alt="telefone">
			<a href="tel:(31)999056577">(31)99056577</a>
		</div>
		
		<div class="icone-contato">
			<img src="imagens/mensagem.png" alt="balão de mensagem">
			<a href="viniciusmouraesilva2204@gmail.com">viniciusmouraesilva2204@gmail.com</a>
		</div>
	</section>
	
	<!-- rodapé -->
	<footer>
		<p>Desenvolvido por Vinícius Moura</p>
	</footer>
</body>
</html>