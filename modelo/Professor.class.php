<?php
class Professor {
	private $id;
	private $nome;
	private $sexo;
	private $email;
	private $senha;
	private $telefone;
	private $foto;
	private $ultimoLogin;
	
	private $arrayTurma;
	private $arrayDisciplina;
	
	public function __construct($id = 0, $nome = null, $sexo = null, $email = null, $senha = null, $telefone = null, $foto = null, $ultimoLogin = null) {
		$this->id = $id;
		$this->nome = $nome;
		$this->sexo = $sexo;
		$this->email = $email;
		$this->senha = $senha;
		$this->telefone = $telefone;
		$this->foto = $foto;
		$this->ultimoLogin = $ultimoLogin;
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
	
	public function validarCadastroTurma($arrayPost) {
		$arrayValida = array();
		
		if (empty($arrayPost['id_professor'])) {
			$arrayValida['r'] = false;
			$arrayValida['c'] = 'professor';
			$arrayValida['m'] = 'Por favor, selecione o <strong>Professor</strong>';
		} elseif (empty($arrayPost['id_curso'])) {
			$arrayValida['r'] = false;
			$arrayValida['c'] = 'curso';
			$arrayValida['m'] = 'Por favor, selecione o <strong>Curso</strong>';
		} elseif (empty($arrayPost['id_turma'])) {
			$arrayValida['r'] = false;
			$arrayValida['c'] = 'turma';
			$arrayValida['m'] = 'Por favor, selecine a <strong>Turma</strong>';
		} else {
			$arrayValida['r'] = true;
			$arrayValida['c'] = null;
			$arrayValida['m'] = 'Campos validados';
		}
		
		return $arrayValida;
	}
	
	public function validarCadastroDisciplina($arrayPost) {
		$arrayValida = array();
		
		if (empty($arrayPost['id_professor'])) {
			$arrayValida['r'] = false;
			$arrayValida['c'] = 'professor';
			$arrayValida['m'] = 'Por favor, selecione o <strong>Professor</strong>';
		} elseif (empty($arrayPost['id_curso'])) {
			$arrayValida['r'] = false;
			$arrayValida['c'] = 'curso';
			$arrayValida['m'] = 'Por favor, selecione o <strong>Curso</strong>';
		} elseif (empty($arrayPost['id_disciplina'])) {
			$arrayValida['r'] = false;
			$arrayValida['c'] = 'disciplina';
			$arrayValida['m'] = 'Por favor, selecine a <strong>Disciplina</strong>';
		} else {
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
			$str = DIR_WWW.'imgs/professor/'.$this->foto;
		}
		
		return $str;
	}
	
}
?>