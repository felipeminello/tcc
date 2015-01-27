<?php
class GeralControle {
	public function __construct($sessao) {
		session_name($sessao);
		session_start();
		
		/*
		 * Prote��o adicional contra roubo de sess�o.
		 * Gera uma vari�vel de sess�o, contendo informa��es da m�quina do usu�rio.
		 * � verifica no GeralControle, se a vari�vel � a mesma.
		 */
		if (!isset($_SESSION['HTTP_USER_AGENT']))
			$_SESSION['HTTP_USER_AGENT'] = md5($_SERVER['HTTP_USER_AGENT']);
	}
		
	public function autenticado() {
		if (array_key_exists('HTTP_USER_AGENT', $_SESSION)) {
		    if ($_SESSION['HTTP_USER_AGENT'] == md5($_SERVER['HTTP_USER_AGENT'])) {
		    	return true;
		    } else {
		    	return false;
		    }
		} else {
			return false;
		}
	}
}
?>