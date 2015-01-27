<?php
class Grupo {
	private $id;
	private $nome;
	private $descricao;
	private $aberto;
	
	private $Aluno;
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
}
?>