<?php
class GeralControle {
	public function __construct($sessao) {
		session_name($sessao);
		session_start();
		
		/*
		 * Proteção adicional contra roubo de sessão.
		 * Gera uma variável de sessão, contendo informações da máquina do usuário.
		 * É verifica no GeralControle, se a variável é a mesma.
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