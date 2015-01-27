<?php
class Chamada {
	private $id;
	private $presenca;
	private $data;
	private $hora;
	
	private $AlunoTurma;
	private $Professor;
	private $Disciplina;
	
	public function __construct($id = 0, $presenca = 0, $data = null, $hora = null, $idAlunoTurma = 0, $idDisciplina = 0, $idProfessor = 0) {
		$this->id = $id;
		$this->presenca = $presenca;
		$this->data = $data;
		$this->hora = $hora;
		
		$this->AlunoTurma = new AlunoTurma($idAlunoTurma);
		$this->Disciplina = new Disciplina($idDisciplina);
		$this->Professor = new Professor($idProfessor);
	}
	
	public function __set($nome, $valor) {
		if (property_exists(get_class($this), $nome))
			$this->$nome = $valor;
	}
	
	public function __get($nome) {
		if (property_exists(get_class($this), $nome))
			return $this->$nome;
	}
	
	public function calcularFaltas(array $arrayAluno, array $arrayChamada) {
		$arrayFalta = array();
		
		foreach ($arrayAluno as $a) {
			$idAluno = $a->__get('id');
			$arrayFalta[$idAluno] = 0;
			foreach ($arrayChamada as $c) {
				$aChamada = $c->__get('AlunoTurma')->__get('Aluno');
				if ($aChamada->__get('id') == $idAluno) {
					if ($c->__get('presenca') == 0)
						$arrayFalta[$idAluno]++;
				}
			}
		}
		
		return $arrayFalta;
	}
}
?>