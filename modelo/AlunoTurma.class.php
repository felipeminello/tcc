<?php
class AlunoTurma {
	private $id;
	private $data;

	private $Aluno;
	private $Turma;
	
	public function __construct($id = 0, $data = null) {
		$this->id = $id;
		$this->data = $data;
		
		$this->Aluno = new Aluno();
		$this->Turma = new Turma();
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
		if (isset($arrayPost['id_aluno'])) {
			self::__set('Aluno', new Aluno($arrayPost['id_aluno']));
		}
		if (isset($arrayPost['id_turma'])) {
			self::__set('Turma', new Turma($arrayPost['id_turma']));
		}
	}
	
	public function validarCadastro() {
		$arrayValida = array();
		
		$idAluno = $this->Aluno->__get('id');
		$idTurma = $this->Turma->__get('id');
		
		if (empty($idAluno)) {
			$arrayValida['r'] = false;
			$arrayValida['c'] = 'aluno';
			$arrayValida['m'] = 'Por favor, selecione o <strong>Aluno</strong>';
		} elseif (empty($idTurma)) {
			$arrayValida['r'] = false;
			$arrayValida['c'] = 'turma';
			$arrayValida['m'] = 'Por favor, selecione a <strong>Turma</strong>';
		} else {
			$arrayValida['r'] = true;
			$arrayValida['c'] = null;
			$arrayValida['m'] = 'Campos validados';
		}
		
		return $arrayValida;
	}
	
}
?>