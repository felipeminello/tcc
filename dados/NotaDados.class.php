<?php
class NotaDados {
	private $con;
	private $Nota;
	
	public function __construct() {
		$this->con = Conexao::getInstance();
	}
	
	public function setNota(Nota $t) {
		$this->Nota = $t;
	}
	
	public function selecionar($id) {
		try {
			$sql = "SELECT id, id_curso, nome, periodo, DATE_FORMAT(data_inicio, '%d/%m/%Y') AS data_inicio, DATE_FORMAT(data_fim, '%d/%m/%Y') AS data_fim FROM turma WHERE id = :id LIMIT 0,1";
			$stmt = $this->con->prepare($sql);
		
			$stmt->bindValue(':id', $id);
			$stmt->execute();
			$linha = $stmt->fetch(PDO::FETCH_ASSOC);
			
			if (is_array($linha)) {
				$t = new Nota($linha['id'], $linha['nome'], $linha['periodo'], $linha['data_inicio'], $linha['data_fim'], $linha['id_curso']);
				self::setNota($t);
				
				return $t;
			} else {
				return false;
			}
		} catch (PDOException $e) {
			print('Erro ao executar a consulta: '.$e);
		}
	}
	
	public function listarPorAlunoTurma($idAluno, $idTurma) {
		$sql = "SELECT n.id, n.nota, n.id_disciplina, d.nome AS disciplina FROM nota n ";
		$sql .= "INNER JOIN (disciplina d) ON d.id = n.id_disciplina ";
		$sql .= "INNER JOIN (aluno_turma at) ON at.id = n.id_aluno_turma ";
		$sql .= "WHERE at.id_aluno = :id_aluno AND at.id_turma = :id_turma GROUP BY n.id ORDER BY d.nome ASC";
		try {
			$stmt = $this->con->prepare($sql);
		
			$stmt->bindValue(':id_aluno', $idAluno);
			$stmt->bindValue(':id_turma', $idTurma);
			$stmt->execute();
			
//			var_dump($stmt->errorInfo());
			
//			$stmt->debugDumpParams();
			
			$array = array();
			
			while ($linha = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$d = new Disciplina($linha['id_disciplina'], $linha['disciplina']);
				$n = new Nota($linha['id'], $linha['nota']);
				$n->__set('Disciplina', $d);
				
				$array[] = $n;
			}
			
			return $array;
		} catch (PDOException $e) {
			print('Erro ao executar a consulta: '.$e);
		}
	}	
		
	public function listarPorTurma($idTurma, $idDisciplina) {
		$sql = "SELECT n.id, n.nota, n.id_disciplina, d.nome AS disciplina, a.id AS a_id, a.ra AS a_ra, a.nome AS a_nome FROM nota n ";
		$sql .= "INNER JOIN (disciplina d) ON d.id = n.id_disciplina ";
		$sql .= "INNER JOIN (aluno_turma at, aluno a) ON at.id = n.id_aluno_turma AND a.id = at.id_aluno ";
		$sql .= "WHERE d.id = :id_disciplina AND at.id_turma = :id_turma GROUP BY n.id ORDER BY d.nome ASC";
		try {
			$stmt = $this->con->prepare($sql);
		
			$stmt->bindValue(':id_turma', $idTurma);
			$stmt->bindValue(':id_disciplina', $idDisciplina);
			$stmt->execute();
			
//			var_dump($stmt->errorInfo());
			
//			$stmt->debugDumpParams();
			
			$array = array();
			
			while ($linha = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$d = new Disciplina($linha['id_disciplina'], $linha['disciplina']);
				$a = new Aluno($linha['a_id'], $linha['a_ra'], $linha['a_nome']);
				$at = new AlunoTurma();
				$at->__set('Aluno', $a);
				$n = new Nota($linha['id'], $linha['nota']);
				$n->__set('Disciplina', $d);
				$n->__set('AlunoTurma', $at);
				
				$array[] = $n;
			}
			
			return $array;
		} catch (PDOException $e) {
			print('Erro ao executar a consulta: '.$e);
		}
	}	
}
?>