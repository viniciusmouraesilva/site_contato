<?php		
	$token_conteudo = password_hash(uniqid(mt_rand(),true),CRYPT_BLOWFISH,['cost'=>8]);
	
	$_SESSION["token"][] = $token_conteudo;	
?>