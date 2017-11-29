<?php	
	$token = password_hash(uniqid(mt_rand(),true),CRYPT_BLOWFISH,['cost'=>10]);

	if(!array_key_exists('token',$_SESSION)){
		$_SESSION['tempo'] = time();
	}
	
	$_SESSION['token'][] = $token;
	
	if(array_key_exists('tempo',$_SESSION)){
	
		if($_SESSION['tempo'] < time() - 180){
			session_unset($_SESSION['token']);
			session_regenerate_id();
			$_SESSION['sessao_expirada'] = "Sessão expirada. Tente novamente.";
			header("Location:index.php");
			exit();
		}
	}
?>