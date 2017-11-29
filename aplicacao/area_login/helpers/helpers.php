<?php
function enviar_email($resposta_final, Comentario $mensagem){
		
	$corpo = preparar_corpo($resposta_final,$mensagem);
		
	require __DIR__ .'/../bibliotecas/PHPMailer/PHPMailerAutoload.php';
		
	$email = new PHPMailer();
		
	$email->isSMTP();
	$email->Host = "smtp.gmail.com";
	$email->Port = 587;
	$email->SMTPSecure = "tls";
	$email->SMTPAuth = true;
	$email->CharSet = "UTF-8";
	$email->Username = "viniciusmouraenviaemail@gmail.com";
	$email->Password = "paistropical052";
	$email->setFrom($mensagem->getEmail(),"Vinícius do Blog do Vinícius");
	$email->Subject = "{$mensagem->getMensagem()}";
	$email->addReplyTo("viniciusmouraenviaemail@gmail.com","Vitor");
	$email->addAddress($mensagem->getEmail());
	$email->msgHTML($corpo);
		
	if($email->send()){
		return true;
	}else{
		gravar_erro($email->ErrorInfo);
	}
}

function preparar_corpo($resposta_final,Comentario $mensagem){
		
	ob_start();

	include 'corpo_email.php';
		
	$corpo = ob_get_clean();
		
	return $corpo;
}