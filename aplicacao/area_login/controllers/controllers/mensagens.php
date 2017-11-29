<?php
require_once '../../helpers/php_ini_config.php';
require_once '../helpers/validar_login.php';
require 'models/mensagens.php';
require 'helpers/helpers.php';

$mensagens = new Mensagens(); 

require 'models/repositorio_mensagens.php';

$repositorio_mensagens = new RepositorioMensagens($pdo);

$mensagens = $repositorio_mensagens->buscarMensagens();

require 'views/template_mensagens.php';