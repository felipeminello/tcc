<?php
class Disciplina {
	private $id;
	private $nome;
	
	private $Curso;
	
	public function __construct($id = 0, $nome = null) {
		$this->id = $id;
		$this->nome = $nome;
		
		$this->Curso = new Curso();
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
		foreach ($arrayPost as $nome => $valor) {
			self::__set($nome, $valor);
		}
		
		if (isset($arrayPost['curso']))
			self::__set('Curso', new Curso($arrayPost['curso']));	
	}
	
	public function validarCadastro() {
		$arrayValida = array();
		
		$idCurso = $this->Curso->__get('id');
		
		if (empty($idCurso)) {
			$arrayValida['r'] = false;
			$arrayValida['c'] = 'curso';
			$arrayValida['m'] = 'Por favor, selecione o <strong>Curso</strong>';
		} elseif (empty($this->nome)) {
			$arrayValida['r'] = false;
			$arrayValida['c'] = 'nome';
			$arrayValida['m'] = 'Por favor, preencha o <strong>Nome</strong>';
		} else {
			$arrayValida['r'] = true;
			$arrayValida['c'] = null;
			$arrayValida['m'] = 'Campos validados';
		}
		
		return $arrayValida;
	}
	
}
?>