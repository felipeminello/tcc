<?php
class Curso {
	private $id;
	private $nome;
	
	public function __construct($id = 0, $nome = null) {
		$this->id = $id;
		$this->nome = $nome;
	}
	
	public function __set($nome, $valor) {
		if (property_exists(get_class($this), $nome))
			$this->$nome = $valor;
	}
	
	public function __get($nome) {
		if (property_exists(get_class($this), $nome))
			return $this->$nome;
	}
	
	public function validarCadastro($arrayPost) {
		$arrayValida = array();
		
		if (empty($arrayPost['nome'])) {
			$arrayValida['r'] = false;
			$arrayValida['c'] = 'nome';
			$arrayValida['m'] = 'Por favor, preencha o <strong>Nome do curso</strong>';
		} else {
			$arrayValida['r'] = true;
			$arrayValida['c'] = null;
			$arrayValida['m'] = 'Campos validados';
			
			self::__construct($arrayPost['id'], $arrayPost['nome']);
		}
		
		return $arrayValida;
	}
}
?>