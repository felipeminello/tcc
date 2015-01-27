<?php
/****************************** DEFINE AS CONFIGURAÇÕES REGIONAIS ******************************/
setlocale(LC_ALL, 'pt_BR', 'ptb');
setlocale(LC_MONETARY, 'pt_BR');
date_default_timezone_set('America/Sao_Paulo');
define('default_language','pt-br');
/******************************** DEFINE AS CONFIGURAÇÕES DO SITE ********************************/
define('DOMINIO', 'minello.com.br');
define('SESSAO', 'erp');
define('NOME', 'ERP Escolar');
define('CODING', 'iso-8859-1');
define('EMAIL', 'contato@'.DOMINIO);
define('URL', 'www.'.DOMINIO);
define('SMTP_HOST', 'smtp.'.DOMINIO);
define('SMTP_PORT', 587);
define('SMTP_USER', 'smtp_tcc@'.DOMINIO);
define('SMTP_SENHA', 'k465sfga5sd');

/******************************** DEFINE AS CONFIGURAÇÕES DO BD ********************************/
if ($_SERVER['SERVER_NAME'] == '192.168.1.4') {
	define('DB_LOCAL', 'localhost');
	define('DB_USER', 'root');
	define('DB_PASSW', 'camarao');
	define('DB_DATABASE', 'uniso_tcc');
	
	define('DB_USER_CEP', 'root');
	define('DB_PASSW_CEP', 'camarao');
	define('DB_DATABASE_CEP', 'cep');

	define('HTTP_HOST', 'http://'.$_SERVER['HTTP_HOST'].'/tcc/');
	define('HTTPS_HOST', 'https://'.$_SERVER['HTTP_HOST'].'/tcc/');
	
	define('DIR_ROOT', '/tcc/');
	define('DIR_WWW', '/tcc/www/');
} else {	
	define('DB_LOCAL', 'localhost');
	define('DB_USER', 'uniso_tcc');
	define('DB_PASSW', 'gas546sa4f');
	define('DB_DATABASE', 'uniso_tcc');

	define('DB_USER_CEP', '');
	define('DB_PASSW_CEP', '');
	define('DB_DATABASE_CEP', '');

	define('HTTP_HOST', 'http://'.$_SERVER['HTTP_HOST'].'/');
	define('HTTPS_HOST', 'https://'.$_SERVER['HTTP_HOST'].'/');
	
	define('DIR_ROOT', '/tcc/');
	define('DIR_WWW', '/tcc/www/');
}

/***************************** DEFINE AS CONFIGURAÇÕES DE DIRETÓRIO ****************************/
define('DIR_ROOT_ALUNO', DIR_ROOT.'aluno/');
define('DIR_ROOT_COORDENADOR', DIR_ROOT.'coordenador/');
define('DIR_ROOT_PROFESSOR', DIR_ROOT.'professor/');

define('DS', DIRECTORY_SEPARATOR);
define('DIR_ROOT_FIS', dirname(__FILE__).DS);

define('DIR_ACAO', DIR_ROOT_FIS.'acao'.DS);
define('DIR_ACAO_ALUNO', DIR_ROOT_FIS.'acao'.DS.'aluno'.DS);
define('DIR_ACAO_COORDENADOR', DIR_ROOT_FIS.'acao'.DS.'coordenador'.DS);
define('DIR_ACAO_PROFESSOR', DIR_ROOT_FIS.'acao'.DS.'professor'.DS);

define('DIR_CLASS_MODELO', DIR_ROOT_FIS.'modelo'.DS);
define('DIR_CLASS_VISAO', DIR_ROOT_FIS.'visao'.DS);
define('DIR_CLASS_CONTROLE', DIR_ROOT_FIS.'controle'.DS);
define('DIR_CLASS_DADOS', DIR_ROOT_FIS.'dados'.DS);

define('DIR_FIS_MATERIAL', DIR_ROOT_FIS.'www'.DS.'material');

define('DIR_IMG_FIS', DIR_ROOT_FIS.'www'.DS.'imgs'.DS);
define('DIR_IMG_FIS_ALUNO', DIR_IMG_FIS.'aluno'.DS);
define('DIR_IMG_FIS_COORDENADOR', DIR_IMG_FIS.'coordenador'.DS);
define('DIR_IMG_FIS_PROFESSOR', DIR_IMG_FIS.'professor'.DS);
?>
