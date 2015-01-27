<?php
class MensagemDestino {
	private $id;
	private $destino;
	
	private $Mensagem;
	private $Aluno;
	private $Professor;
	private $Coordenador;
	private $Turma;
	
	public function __construct($id = 0, $idMensagem = 0, $idAluno = 0, $idProfessor = 0, $idCoordenador = 0, $idTurma = 0) {
		$this->id = $id;
		
		$this->Mensagem = new Mensagem($idMensagem);
		$this->Aluno = new Aluno($idAluno);
		$this->Professor = new Professor($idProfessor);
		$this->Coordenador = new Coordenador($idCoordenador);
		$this->Turma = new Turma($idTurma);
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
		foreach ($arrayPost as $k => $v) {
			self::__set($k, $v);
		}
	}

	public function validaCadastro() {
		$arrayValida = array();
		
		$idAluno = $this->Aluno->__get('id');
		$idProfessor = $this->Professor->__get('id');
		$idCoordenador = $this->Coordenador->__get('id');
		$idTurma = $this->Turma->__get('id');
		
		if ($this->destino == 1 and empty($idAluno) and empty($idProfessor) and empty($idCoordenador) and empty($idTurma)) {
			$arrayValida['r'] = false;
			$arrayValida['c'] = '';
			$arrayValida['m'] = 'Por favor, selecione um <strong>Destinatário</strong>';
		} else {
			$arrayValida['r'] = true;
			$arrayValida['c'] = '';
			$arrayValida['m'] = 'Campos validados';
		}
		return $arrayValida;
	}
	
}
?>