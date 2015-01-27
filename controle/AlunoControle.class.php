<?php
class AlunoControle extends GeralControle {
	public function roteamento($arrayUrl) {
		$pagina = (!empty($arrayUrl[1])) ? $arrayUrl[1] : 'home';
		
		if (self::autenticadoAluno() and self::autenticado()) {
			if(is_file(DIR_ACAO_ALUNO.$pagina.'.php'))
				include(DIR_ACAO_ALUNO.$pagina.'.php');
			else
				include(DIR_ACAO_ALUNO.'404.php');
		} else {
			if ($pagina == 'ajax_login_aluno') {
				
				include(DIR_ACAO_ALUNO.'ajax_login_aluno.php');
			} else {
				include(DIR_ACAO_ALUNO.'login.php');
			}
		}
	}
	
	public function autenticadoAluno() {
		if (isset($_SESSION['aluno']) and is_array($_SESSION['aluno'])) {
			if (!empty($_SESSION['aluno']['id'])) {
				return true;
			}
		} else
			return false;
	}
}
?>
