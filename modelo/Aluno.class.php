<?php
class Aluno {
	private $id;
	private $ra;
	private $senha;
	private $nome;
	private $sexo;
	private $email;
	private $telefone;
	private $ultimoLogin;
	private $foto;
	
	private $arrayTurma;
	
	public function __construct($id = 0, $ra = null, $nome = null, $email = null, $ultimoLogin = null, $senha = null, $telefone = null, $sexo = null, $foto = null) {
		$this->id = $id;
		$this->ra = $ra;
		$this->nome = $nome;
		$this->sexo = $sexo;
		$this->email = $email;
		$this->telefone = $telefone;
		$this->senha = $senha;
		$this->ultimoLogin = $ultimoLogin;
		$this->foto = $foto;
		
		$this->arrayTurma = array();
	}
	
	public function __set($nome, $valor) {
		if (property_exists(get_class($this), $nome))
			$this->$nome = $valor;
	}
	
	public function __get($nome) {
		if (property_exists(get_class($this), $nome))
			return $this->$nome;
	}
	
	public function receberFormulario($arrayPost) {
		if (isset($arrayPost['senha']))
			$arrayPost['senha'] = md5($arrayPost['senha']);
		
		foreach ($arrayPost as $nome => $valor) {
			self::__set($nome, $valor);
		}
	}
		
	public function setRa($valor) {
		$this->ra = $valor;
	} public function getRa() {
		return $this->ra;
	}
	
	public function setNome($valor) {
		$this->nome = $valor;
	} public function getNome() {
		return $this->nome;
	}
	
	public function setSenha($valor) {
		$this->senha = $valor;
	}
	
	public function setEmail($valor) {
		$this->email = $valor;
	} public function getEmail() {
		return $this->email;
	}
	
	public function setUltimoLogin($valor) {
		$this->ultimoLogin = $valor;
	} public function getUltimoLoing() {
		return $this->ultimoLogin;
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
		} elseif (empty($arrayPost['sexo'])) {
			$arrayValida['r'] = false;
			$arrayValida['c'] = 'sexo';
			$arrayValida['m'] = 'Por favor, selecione o <strong>Sexo</strong>';
		} elseif ($arrayPost['senha'] == md5('') and empty($arrayPost['id'])) {
			$arrayValida['r'] = false;
			$arrayValida['c'] = 'senha';
			$arrayValida['m'] = 'Por favor, preencha a <strong>Senha</strong>';
		} elseif ($arrayPost['senha'] != $arrayPost['conf_senha']) {
			$arrayValida['r'] = false;
			$arrayValida['c'] = 'conf_senha';
			$arrayValida['m'] = 'Por favor, confirme sua <strong>Senha</strong> corretamente';
		} else {
			if (!empty($arrayPost['turma'])) {
				self::__set('arrayTurma', array(new Turma($arrayPost['turma'])));
			}
			
			$arrayValida['r'] = true;
			$arrayValida['c'] = null;
			$arrayValida['m'] = 'Campos validados';
		}
		
		return $arrayValida;
	}
	
	
	public function exibeImagem($largura = 128) {
		if (empty($this->foto)) {
			$img = ($this->sexo == 'f') ? 'feminino' : 'masculino';
			
			$str = DIR_WWW.'imgs/layout/'.$img.$largura.'.png';
		} else {
			$str = DIR_WWW.'imgs/aluno/'.$this->foto;
		}
		
		return $str;
	}
	
	
	public function logout() {
		session_regenerate_id(true);
		session_destroy();
		
		return true;
	}
}
?>