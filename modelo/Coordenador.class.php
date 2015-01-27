<?php
class Coordenador {
	private $id;
	private $nome;
	private $email;
	private $senha;
	private $ultimoLogin;
	private $foto;
	
	public function __construct($id = 0, $nome = null, $email = null, $senha = null, $ultimoLogin = null, $foto = null) {
		$this->id = $id;
		$this->nome = $nome;
		$this->email = $email;
		$this->senha = $senha;
		$this->ultimoLogin = $ultimoLogin;
		$this->foto = $foto;
	}
	
	public function __set($nome, $valor) {
		if (property_exists(get_class($this), $nome))
			$this->$nome = $valor;
	}
	
	public function __get($nome) {
		if (property_exists(get_class($this), $nome))
			return $this->$nome;
	}
	
	public function exibeImagem($largura = 128) {
		if (empty($this->foto)) {
			$str = DIR_WWW.'imgs/layout/masculino'.$largura.'.png';
		} else {
			$str = DIR_WWW.'imgs/coordenador/'.$this->foto;
		}
		
		return $str;
	}
	
	public function validarCadastro($arrayPost) {
		$arrayValida = array();
		
		$arrayPost['senha'] = md5($arrayPost['senha']);
		$arrayPost['conf_senha'] = md5($arrayPost['conf_senha']);
		$arrayPost['email'] = Requisicao::checkEmail($arrayPost['email']);
		
		if (empty($arrayPost['nome'])) {
			$arrayValida['r'] = false;
			$arrayValida['c'] = 'nome';
			$arrayValida['m'] = 'Por favor, preencha o <strong>Nome</strong>';
		} elseif (empty($arrayPost['email'])) {
			$arrayValida['r'] = false;
			$arrayValida['c'] = 'email';
			$arrayValida['m'] = 'Por favor, preencha o <strong>Email</strong> corretamente';
		} elseif ($arrayPost['senha'] != $arrayPost['conf_senha']) {
			$arrayValida['r'] = false;
			$arrayValida['c'] = 'conf_senha';
			$arrayValida['m'] = 'Por favor, confirme sua <strong>Senha</strong> corretamente';
		} else {
			$arrayValida['r'] = true;
			$arrayValida['c'] = null;
			$arrayValida['m'] = 'Campos validados';
			
			self::__construct($arrayPost['id'], $arrayPost['nome'], $arrayPost['email'], $arrayPost['senha']);
		}
		
		return $arrayValida;
	}
	public function logout() {
		session_regenerate_id(true);
		session_destroy();
		
		return true;
	}
}
?>