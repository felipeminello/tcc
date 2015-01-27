<?
ini_set('session.cookie_httponly', true);

ob_start();

error_reporting(E_ALL);
// error_reporting(0);
// ini_set('display_errors', 0);

include_once('config.php');

header('Content-type: text/html; charset='.CODING);

/****************************** AUTOLOAD ******************************/
spl_autoload_register(null, false);
spl_autoload_extensions('.php, .class.php');

function autoloadModelo($class) {
	$arquivo = DIR_CLASS_MODELO.$class.'.class.php';
	if (is_readable($arquivo)) {
		include_once($arquivo);
	} else {
		return false;
	}
}

function autoloadVisao($class) {
	$arquivo = DIR_CLASS_VISAO.$class.'.class.php';
	if (is_readable($arquivo)) {
		include_once($arquivo);
	} else {
		return false;
	}
}

function autoloadControle($class) {
	$arquivo = DIR_CLASS_CONTROLE.$class.'.class.php';
	if (is_readable($arquivo)) {
		include_once($arquivo);
	} else {
		return false;
	}
}

function autoloadDados($class) {
	$arquivo = DIR_CLASS_DADOS.$class.'.class.php';
	if (file_exists($arquivo)) {
		include_once($arquivo);
	} else {
		return false;
	}
}

function autoloadPHPMailer($class) {
	$arquivo = DIR_CLASS_MODELO.'phpmailer'.DS.'class.phpmailer.php';
	if (file_exists($arquivo)) {
		include_once($arquivo);
	} else {
		return false;
	}
}

function autoloadUpload($class) {
	$arquivo = DIR_CLASS_MODELO.'classupload'.DS.'class.upload.php';
	if (file_exists($arquivo)) {
		include_once($arquivo);
	} else {
		return false;
	}
}


spl_autoload_register('autoloadModelo');
spl_autoload_register('autoloadVisao');
spl_autoload_register('autoloadControle');
spl_autoload_register('autoloadDados');
spl_autoload_register('autoloadPHPMailer');
spl_autoload_register('autoloadUpload');

$pag = Requisicao::checkString(Requisicao::get('pag'));

$arrayUrl = explode('/', $pag);

$area = (!empty($arrayUrl[0])) ? $arrayUrl[0] : 'aluno';

switch($area) {
	case 'coordenador':
		$cControle = new CoordenadorControle('coordenador');
		$cControle->roteamento($arrayUrl);
		break;
	default:
		$aControle = new AlunoControle('aluno');
		$aControle->roteamento($arrayUrl);
		break;
}

// session_regenerate_id(true);

ob_end_flush();
?>
