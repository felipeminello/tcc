<?php
class Mensagem {
	private $id;
	private $texto;
	private $data;
	private $hora;
	private $arrayMensagemDestino;
	
	private $Aluno;
	private $Professor;
	private $Coordenador;
	
	public function __construct($id = 0, $texto = null, $data = null, $hora = null, $idAluno = 0, $idProfessor = 0, $idCoordenador = 0) {
		$this->id = $id;
		$this->texto = $texto;
		$this->data = $data;
		$this->hora = $hora;
		$this->arrayMensagemDestino = array();
		
		$this->Aluno = new Aluno($idAluno);
		$this->Professor = new Professor($idProfessor);
		$this->Coordenador = new Coordenador($idCoordenador);
	}
	
	public function __set($nome, $valor) {
		if (property_exists(get_class($this), $nome))
			$this->$nome = $valor;
	}
	
	public function __get($nome) {
		if (property_exists(get_class($this), $nome))
			return $this->$nome;
	}
	
	public function receberFormulario($arrayPost, array $arrayTurma = array()) {
		foreach ($arrayPost as $k => $v) {
			self::__set($k, $v);
		}
		
		$this->arrayMensagemDestino = array();
		if ($arrayPost['destino'] == 2 or ($arrayPost['destino'] == 1 and !empty($arrayPost['id_curso']) and empty($arrayPost['id_turma']))) { // envia para todas as turmas
			foreach ($arrayTurma as $t) {
				$md = new MensagemDestino();
				$md->__set('Turma', $t);
				$md->__set('destino', $arrayPost['destino']);
				array_push($this->arrayMensagemDestino, $md);
			}
		} else {
			$md = new MensagemDestino(0, 0, $arrayPost['id_aluno'], $arrayPost['id_professor'], $arrayPost['id_coordenador'], $arrayPost['id_turma']);
			$md->__set('destino', $arrayPost['destino']);
			array_push($this->arrayMensagemDestino, $md);
		}
	}

	public function validaCadastro() {
		$arrayValida = array();
		
		$idAluno = $this->Aluno->__get('id');
		$idProfessor = $this->Professor->__get('id');
		$idCoordenador = $this->Coordenador->__get('id');
		
		if (empty($this->texto)) {
			$arrayValida['r'] = false;
			$arrayValida['c'] = 'texto';
			$arrayValida['m'] = 'Por favor, preencha o <strong>texto</strong> da mensagem';
		} elseif (empty($idAluno) and empty($idProfessor) and empty($idCoordenador)) {
			$arrayValida['r'] = false;
			$arrayValida['c'] = '';
			$arrayValida['m'] = 'Quem está enviando?';
		} else {
			foreach ($this->arrayMensagemDestino as $md) {
				$arrayValida = $md->validaCadastro();
				
				if (!$arrayValida['r']) {
					return $arrayValida;
				}
			}
			
			$arrayValida['r'] = true;
			$arrayValida['c'] = '';
			$arrayValida['m'] = 'Campos validados';
		}
		
		return $arrayValida;
	}
}
?>