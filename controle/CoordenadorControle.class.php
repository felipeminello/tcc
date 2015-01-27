<?php
class CoordenadorControle extends GeralControle {
	public function roteamento($arrayUrl) {
		$arrayAberto = array('ajax_login_coordenador', 'popup_recuperar_senha');
		
		$pagina = (!empty($arrayUrl[1])) ? $arrayUrl[1] : 'home';
		
		if (self::autenticadoCoordenador() and self::autenticado()) {
			if(is_file(DIR_ACAO_COORDENADOR.$pagina.'.php'))
				include(DIR_ACAO_COORDENADOR.$pagina.'.php');
			else
				include(DIR_ACAO_COORDENADOR.'404.php');
		} else {
			if (in_array($pagina, $arrayAberto)) {
				include(DIR_ACAO_COORDENADOR.$pagina.'.php');
			} else {
				include(DIR_ACAO_COORDENADOR.'login.php');
			}
		}
	}
	
	public function autenticadoCoordenador() {
		if (isset($_SESSION['coordenador']) and is_array($_SESSION['coordenador'])) {
			if (!empty($_SESSION['coordenador']['id'])) {
				return true;
			}
		} else
			return false;
	}
}
?>
