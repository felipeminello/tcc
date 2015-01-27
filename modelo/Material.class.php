<?php
class Chamada {
	private $id;
	private $titulo;
	private $arquivo;
	private $data;
	private $observacao;
	
	private $Aluno;
	private $Professor;
	
	private $arrayTurma;
	private $arrayProva;
	
	public function __construct($id = 0, $titulo = null, $arquivo = null, $data = null, $observacao = null) {
		$this->id = $id;
		$this->titulo = $titulo;
		$this->arquivo = $arquivo;
		$this->data = $data;
		$this->observacao = $observacao;
		
		$this->Aluno = new Aluno();
		$this->Professor = new Professor();
		
		$this->arrayTurma = array();
		$this->arrayProva = array();
	}
	
	public function __set($nome, $valor) {
		if (property_exists(get_class($this), $nome))
			$this->$nome = $valor;
	}
	
	public function __get($nome) {
		if (property_exists(get_class($this), $nome))
			return $this->$nome;
	}
	
	public function getExt() {
		$path = pathinfo(DIR_FIS_MATERIAL.$this->arquivo, PATHINFO_EXTENSION);
		
		var_dump($path);
		
		return $path;
	}
}
?>