<?php
class TurmaDados {
	private $con;
	private $Turma;
	
	public function __construct() {
		$this->con = Conexao::getInstance();
	}
	
	public function setTurma(Turma $t) {
		$this->Turma = $t;
	}
	
	public function selecionar($id) {
		try {
			$sql = "SELECT id, id_curso, nome, periodo, DATE_FORMAT(data_inicio, '%d/%m/%Y') AS data_inicio, DATE_FORMAT(data_fim, '%d/%m/%Y') AS data_fim FROM turma WHERE id = :id LIMIT 0,1";
			$stmt = $this->con->prepare($sql);
		
			$stmt->bindValue(':id', $id);
			$stmt->execute();
			$linha = $stmt->fetch(PDO::FETCH_ASSOC);
			
			if (is_array($linha)) {
				$t = new Turma($linha['id'], $linha['nome'], $linha['periodo'], $linha['data_inicio'], $linha['data_fim'], $linha['id_curso']);
				self::setTurma($t);
				
				return $t;
			} else {
				return false;
			}
		} catch (PDOException $e) {
			print('Erro ao executar a consulta: '.$e);
		}
	}
	
	public function inserir(Turma $t) {
		$sql = "INSERT INTO turma (id_curso, nome, periodo, data_inicio, data_fim) VALUES (:id_curso, :nome, :periodo, :data_inicio, :data_fim)";
		try {
			$stmt = $this->con->prepare($sql);
			
			$dataInic = implode("-",array_reverse(explode("/",$t->__get('dataInicio'))));
			$dataFim = implode("-",array_reverse(explode("/",$t->__get('dataFim'))));
		
			$stmt->bindValue(':id_curso', $t->__get('Curso')->__get('id'), PDO::PARAM_INT);
			$stmt->bindValue(':nome', $t->__get('nome'));
			$stmt->bindValue(':periodo', $t->__get('periodo'));
			$stmt->bindValue(':data_inicio', $dataInic);
			$stmt->bindValue(':data_fim', $dataFim);
			
			return $stmt->execute();
		} catch (PDOException $e) {
			print('Erro ao executar a consulta: '.$e);
		}
	}
	
	public function atualizar(Turma $t) {
		$sql = "UPDATE turma SET id_curso = :id_curso, nome = :nome, periodo = :periodo, data_inicio = :data_inicio, data_fim = :data_fim WHERE id = :id";
		try {
			$stmt = $this->con->prepare($sql);
			
			$dataInic = implode("-",array_reverse(explode("/",$t->__get('dataInicio'))));
			$dataFim = implode("-",array_reverse(explode("/",$t->__get('dataFim'))));
		
			$stmt->bindValue(':id', $t->__get('id'), PDO::PARAM_INT);
			$stmt->bindValue(':id_curso', $t->__get('Curso')->__get('id'), PDO::PARAM_INT);
			$stmt->bindValue(':nome', $t->__get('nome'));
			$stmt->bindValue(':periodo', $t->__get('periodo'));
			$stmt->bindValue(':data_inicio', $dataInic);
			$stmt->bindValue(':data_fim', $dataFim);
			
			return $stmt->execute();
		} catch (PDOException $e) {
			print('Erro ao executar a consulta: '.$e);
		}
	}
	
	public function listar($idCurso = 0, $limite = 0, $dataInicio = null, $dataFim = null, $periodo = 0) {
		$strCurso = (!empty($idCurso)) ? " AND c.id = :id_curso " : "";
		$strDataInicio = (!empty($dataInicio)) ? " AND DATE(t.data_inicio) >= :data_inicio " : "";
		$strDataFim = (!empty($dataFim)) ? " AND DATE(t.data_fim) <= :data_fim " : "";
		$strPeriodo = (!empty($periodo)) ? " AND t.periodo = :periodo " : "";
		
		$strLimite = ($limite > 0) ? "LIMIT 0,$limite" : "";
		
		$sql = "SELECT t.id, t.id_curso, t.nome, t.periodo, DATE_FORMAT(t.data_inicio, '%d/%m/%Y') AS data_inicio, c.id AS c_id, c.nome AS c_nome, ";
		$sql .= "DATE_FORMAT(t.data_fim, '%d/%m/%Y') AS data_fim FROM turma t LEFT JOIN (curso c) ON c.id = t.id_curso WHERE 1=1 $strCurso $strDataInicio $strDataFim $strPeriodo GROUP BY t.id ORDER BY t.nome ASC";
		$sql .= $strLimite;
		try {
			$stmt = $this->con->prepare($sql);
			if (!empty($idCurso))
				$stmt->bindValue(':id_curso', $idCurso, PDO::PARAM_INT);
			if (!empty($dataInicio))
				$stmt->bindValue(':data_inicio', $dataInicio);
			if (!empty($dataFim))
				$stmt->bindValue(':data_fim', $dataFim);
			if (!empty($periodo))
				$stmt->bindValue(':periodo', $periodo, PDO::PARAM_INT);
				
			$stmt->execute();
			
			$linhas = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
			$array = array();
			
			foreach ($linhas as $linha) {
				$c = new Curso($linha['c_id'], $linha['c_nome']);
				$t = new Turma($linha['id'], $linha['nome'], $linha['periodo'], $linha['data_inicio'], $linha['data_fim'], $linha['id_curso']);
				$t->__set('Curso', $c);
				
				$array[] = $t;
			}
			
			return $array;
		} catch (PDOException $e) {
			print('Erro ao executar a consulta: '.$e->getMessage());
		}
	}
	
	
		
	public function listarPorCurso($idCurso) {
		$sql = "SELECT id, id_curso, nome, periodo, DATE_FORMAT(data_inicio, '%d/%m/%Y') AS data_inicio, DATE_FORMAT(data_fim, '%d/%m/%Y') AS data_fim FROM turma WHERE id_curso = :id_curso";
		try {
			$stmt = $this->con->prepare($sql);
		
			$stmt->bindValue(':id_curso', $idCurso);
			$stmt->execute();
			
			$array = array();
			
			while ($linha = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$array[] = new Turma($linha['id'], $linha['nome'], $linha['periodo'], $linha['data_inicio'], $linha['data_fim'], $linha['id_curso']);
			}
			
			return $array;
		} catch (PDOException $e) {
			print('Erro ao executar a consulta: '.$e);
		}
	}
	
	public function listarPorCursoProfessor($idCurso, $idProfessor) {
		$sql = "SELECT t.id, t.id_curso, t.nome, t.periodo, DATE_FORMAT(t.data_inicio, '%d/%m/%Y') AS data_inicio, ";
		$sql .= "DATE_FORMAT(t.data_fim, '%d/%m/%Y') AS data_fim FROM turma t ";
		$sql .= "WHERE t.id_curso = :id_curso AND t.id NOT IN (SELECT pt2.id_turma FROM professor_turma pt2 WHERE pt2.id_professor = :id_professor AND pt2.id_turma = t.id) ORDER BY t.nome ASC";
		try {
			$stmt = $this->con->prepare($sql);
		
			$stmt->bindValue(':id_curso', $idCurso, PDO::PARAM_INT);
			$stmt->bindValue(':id_professor', $idProfessor, PDO::PARAM_INT);
			$stmt->execute();
			
			$array = array();
			
			while ($linha = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$array[] = new Turma($linha['id'], $linha['nome'], $linha['periodo'], $linha['data_inicio'], $linha['data_fim'], $linha['id_curso']);
			}
			
			return $array;
		} catch (PDOException $e) {
			print('Erro ao executar a consulta: '.$e);
		}
	}
	
	public function quantidadePorCurso() {
		$sql = "SELECT id_curso, COUNT(id) AS total FROM turma GROUP BY id_curso";
		try {
			$stmt = $this->con->prepare($sql);
			$stmt->execute();
			
			$array = array();
			
			while ($linha = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$array[$linha['id_curso']] = $linha['total'];
			}
			
			return $array;
		} catch (PDOException $e) {
			print('Erro ao executar a consulta: '.$e);
		}
	}
	
	public function total() {
		$sql = "SELECT COUNT(id) AS total FROM turma";
		
		try {
			$stmt = $this->con->prepare($sql);
			$stmt->execute();
			
			$linha = $stmt->fetch(PDO::FETCH_ASSOC);
			
			if (is_array($linha))
				return $linha['total'];
			else
				return 0;
			
		} catch (PDOException $e) {
			print('Erro ao executar a consulta: '.$e);
		}
	}
	
	
}
?>