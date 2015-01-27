<?php
class Turma {
	private $id;
	private $nome;
	private $periodo;
	private $dataInicio;
	private $dataFim;
	
	private $Curso;
	
	private $arrayPeriodo;
	
	public function __construct($id = 0, $nome = null, $periodo = 0, $dataInicio = null, $dataFim = null, $idCurso = 0) {
		$this->id = $id;
		$this->nome = $nome;
		$this->periodo = $periodo;
		$this->dataInicio = $dataInicio;
		$this->dataFim = $dataFim;
		
		$this->Curso = new Curso($idCurso);
		$this->arrayPeriodo = array(1 => 'Manhã', 2 => 'Tarde', 3 => 'Noite');
	}
	
	public function __set($nome, $valor) {
		if (property_exists(get_class($this), $nome))
			$this->$nome = $valor;
	}
	
	public function __get($nome) {
		if (property_exists(get_class($this), $nome))
			return $this->$nome;
	}
	
	public function getNomePeriodo() {
		return $this->arrayPeriodo[$this->periodo];
	}
	
	public function receberFormulario($arrayPost) {
		$arrayPost['dataInicio'] = isset($arrayPost['data_inicio']) ? $arrayPost['data_inicio'] : null;
		$arrayPost['dataFim'] = isset($arrayPost['data_fim']) ? $arrayPost['data_fim'] : null;
		
		foreach ($arrayPost as $nome => $valor) {
			self::__set($nome, $valor);
		}
		
		self::__set('Curso', new Curso($arrayPost['curso']));
	}	
	
	public function validarCadastro($arrayPost) {
		$arrayValida = array();
		
		$arrayPost['data_inicio'] = Requisicao::checkData($arrayPost['data_inicio']);
		
		if (empty($arrayPost['curso'])) {
			$arrayValida['r'] = false;
			$arrayValida['c'] = 'curso';
			$arrayValida['m'] = 'Por favor, selecione o <strong>Curso</strong>';
		} elseif (empty($arrayPost['periodo'])) {
			$arrayValida['r'] = false;
			$arrayValida['c'] = 'periodo';
			$arrayValida['m'] = 'Por favor, selecione o <strong>Período</strong>';
		} elseif (empty($arrayPost['nome'])) {
			$arrayValida['r'] = false;
			$arrayValida['c'] = 'nome';
			$arrayValida['m'] = 'Por favor, preencha o <strong>Nome da turma</strong>';
		} elseif (empty($arrayPost['data_inicio'])) {
			$arrayValida['r'] = false;
			$arrayValida['c'] = 'data_inicio';
			$arrayValida['m'] = 'Por favor, preencha a <strong>Data de início</strong>';
		} else {
			$arrayValida['r'] = true;
			$arrayValida['c'] = null;
			$arrayValida['m'] = 'Campos validados';
			
			self::__construct($arrayPost['id'], $arrayPost['nome'], $arrayPost['periodo'], $arrayPost['data_inicio'], $arrayPost['data_fim'], $arrayPost['curso']);
		}
		
		return $arrayValida;
	}

	public function validarListagem() {
		$arrayValida = array();
		
		$dataInicio = Requisicao::checkData($this->dataInicio, 2);
		$dataFim = Requisicao::checkData($this->dataFim, 2);
		
		if (empty($arrayPost['curso'])) {
			$arrayValida['r'] = false;
			$arrayValida['c'] = 'curso';
			$arrayValida['m'] = 'Por favor, selecione o <strong>Curso</strong>';
		} elseif (empty($arrayPost['periodo'])) {
			$arrayValida['r'] = false;
			$arrayValida['c'] = 'periodo';
			$arrayValida['m'] = 'Por favor, selecione o <strong>Período</strong>';
		} elseif (empty($arrayPost['nome'])) {
			$arrayValida['r'] = false;
			$arrayValida['c'] = 'nome';
			$arrayValida['m'] = 'Por favor, preencha o <strong>Nome da turma</strong>';
		} elseif (empty($arrayPost['data_inicio'])) {
			$arrayValida['r'] = false;
			$arrayValida['c'] = 'data_inicio';
			$arrayValida['m'] = 'Por favor, preencha a <strong>Data de início</strong>';
		} else {
			$arrayValida['r'] = true;
			$arrayValida['c'] = null;
			$arrayValida['m'] = 'Campos validados';
			
			self::__construct($arrayPost['id'], $arrayPost['nome'], $arrayPost['periodo'], $arrayPost['data_inicio'], $arrayPost['data_fim'], $arrayPost['curso']);
		}
		
		return $arrayValida;
	}
}
?>