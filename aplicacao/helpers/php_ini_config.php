<?php
#configurações do php.ini
ini_set('allow_url_fopen','0');
ini_set('allow_url_include','0');
ini_set('cgi.force_redirect','1');
ini_set('date.timezone','America/Sao_Paulo');
ini_set('display_erros','1'); #produção é 0
ini_set('display_startup_errors','1'); //produção é 0
//error_reporting(0); produção é 0
ini_set('expose_php','0');
#ini_set('memory_limit','16');
ini_set('doc_root','public_html');
ini_set('session.cookie_httponly','1');
ini_set('session.use_only_cookies','1');
ini_set('session.use_strict_mode','1');
#ini_set('cgi.fix_pathinfo','0');
