<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	
	<title>Login</title>
	
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<meta http-equiv="Content-Security-Policy" content="img-src 'none'; script-src 'none'; font-src 'none'; style-src 'self'; form-action 'self'">
	
	<meta name="author" content="Vinícius Moura">
	
	<meta name="robots" content="noindex">
	
	<link rel="stylesheet" href="css/css_login.css">
	<link rel="stylesheet" href="css/normalize.css">
</head>
<body>
	<hr>
	<section class="form">
		<form method="POST">
			
			<?php if(array_key_exists('login',$erro_indice)): ?>
				<p><?php echo $erro_indice['login']; ?></p>
			<?php endif; ?>
			
			<?php if(array_key_exists('usuario_invalido',$erro_indice)): ?>
				<p><?php echo $erro_indice['usuario_invalido']; ?></p>
			<?php endif; ?>
			
			<?php if($tem_erro && array_key_exists('email',$erro_indice)): ?>
				<p><?php echo $erro_indice['email']; ?></p>
			<?php endif; ?>
			
			<?php if(strlen($token_mensagem)>0): ?>
				<p><?php echo $token_mensagem; ?></p>
			<?php endif; ?>
			
			<?php if(strlen($sessao_expirada)>0): ?>
				<p><?php echo $sessao_expirada; ?></p>
			<?php endif; ?>
			
			<input type="text" name="email" placeholder="email" class="item" value="<?php echo htmlentities($email); ?>">
			
			<?php if($tem_erro && array_key_exists('senha',$erro_indice)): ?>
				<p><?php echo $erro_indice['senha']; ?></p>
			<?php endif; ?>
	
			<input type="password" name="senha" placeholder="senha" class="item">
			<input type="submit" value="Entrar" class="item button">
			<input type="hidden" name="token" value="<?php echo $token; ?>">
		</form>
	</section>
</body>
</html>