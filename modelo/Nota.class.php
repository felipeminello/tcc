<?php
class Nota {
	private $id;
	private $nota;
	
	private $AlunoTurma;
	private $Disciplina;
	
	public function __construct($id = 0, $nota = 0, $idAlunoTurma = 0, $idDisciplina = 0) {
		$this->id = $id;
		$this->nota = $nota;
		
		$this->AlunoTurma = new AlunoTurma($idAlunoTurma);
		$this->Disciplina = new Disciplina($idDisciplina);
	}
	
	public function __set($nome, $valor) {
		if (property_exists(get_class($this), $nome))
			$this->$nome = $valor;
	}
	
	public function __get($nome) {
		if (property_exists(get_class($this), $nome))
			return $this->$nome;
	}
	
	public function calcularNota(array $arrayAluno, array $arrayNota) {
		$arrayNotasAluno = array();
		
		foreach ($arrayAluno as $a) {
			$idAluno = $a->__get('id');
			$arrayNotasAluno[$idAluno] = 0;
			foreach ($arrayNota as $n) {
				$aNota = $n->__get('AlunoTurma')->__get('Aluno');
				if ($aNota->__get('id') == $idAluno) {
					$arrayNotasAluno[$idAluno] = $n->__get('nota');
				}
			}
		}
		
		return $arrayNotasAluno;
	}
	
}
?>