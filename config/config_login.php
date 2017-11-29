<?php 
try {
	$pdo = new PDO(DSN,USER,SENHA);
}catch(PDOException $ex) {
	exit('Não foi possivél encontrar um banco de dados');
}