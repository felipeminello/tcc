<?php
class DisciplinaDados {
	private $con;
	
	public function __construct() {
		$this->con = Conexao::getInstance();
	}
	
	public function selecionar($id) {
		$sql = "SELECT d.id AS id, d.nome AS nome, c.id AS c_id, c.nome AS c_nome FROM disciplina d ";
		$sql .= "INNER JOIN (curso c) ON c.id = d.id_curso WHERE d.id = :id LIMIT 0,1";
		try {
			$stmt = $this->con->prepare($sql);
		
			$stmt->bindValue(':id', $id, PDO::PARAM_INT);
			$stmt->execute();
			$linha = $stmt->fetch(PDO::FETCH_ASSOC);
			
			if (is_array($linha)) {
				$d = new Disciplina($linha['id'], $linha['nome']);
				$c = new Curso($linha['c_id'], $linha['c_nome']);
				$d->__set('Curso', $c);
				
				return $d;
			} else {
				return false;
			}
		} catch (PDOException $e) {
			print('Erro ao executar a consulta: '.$e);
		}
	}
	
	public function inserir(Disciplina $d) {
		$sql = "INSERT INTO disciplina (id_curso, nome) VALUES (:id_curso, :nome)";
		try {
			$stmt = $this->con->prepare($sql);
			
			$stmt->bindValue(':id_curso', $d->__get('Curso')->__get('id'), PDO::PARAM_INT);
			$stmt->bindValue(':nome', $d->__get('nome'));
			
			return $stmt->execute();
		} catch (PDOException $e) {
			print('Erro ao executar a consulta: '.$e);
		}
	}
	
	public function atualizar(Disciplina $d) {
		$sql = "UPDATE disciplina SET id_curso = :id_curso, nome = :nome WHERE id = :id";
		try {
			$stmt = $this->con->prepare($sql);
			
			$stmt->bindValue(':id', $d->__get('id'), PDO::PARAM_INT);
			$stmt->bindValue(':id_curso', $d->__get('Curso')->__get('id'), PDO::PARAM_INT);
			$stmt->bindValue(':nome', $d->__get('nome'));
			
			return $stmt->execute();
		} catch (PDOException $e) {
			print('Erro ao executar a consulta: '.$e);
		}
	}
	
	public function excluir($idDisciplina) {
		$sql = "DELETE FROM disciplina WHERE id = :id";
		try {
			$stmt = $this->con->prepare($sql);
			
			$stmt->bindValue(':id', $idDisciplina, PDO::PARAM_INT);
			
			return $stmt->execute();
		} catch (PDOException $e) {
			print('Erro ao executar a consulta: '.$e);
		}
	}
	
	public function excluirLote(array $ids) {
		$sql = "DELETE FROM disciplina WHERE id = :id";
		try {
			$stmt = $this->con->prepare($sql);
			
			foreach ($ids as $id) {
				$stmt->bindValue(':id', $id, PDO::PARAM_INT);
				if (!$stmt->execute()) {
					return false;
				}
			}
			return true;
			
		} catch (PDOException $e) {
			print('Erro ao executar a consulta: '.$e);
		}
	}
	
	
	public function listar($idCurso = 0) {
		$strCurso = (!empty($idCurso)) ? " AND d.id_curso = :id_curso " : "";
		
		$sql = "SELECT d.id AS id, d.nome AS nome, c.id AS c_id, c.nome AS c_nome FROM disciplina d INNER JOIN (curso c) ON c.id = d.id_curso WHERE 1=1 $strCurso GROUP BY d.id ORDER BY d.nome ASC";
		try {
			$stmt = $this->con->prepare($sql);
			if (!empty($idCurso))
				$stmt->bindValue(':id_curso', $idCurso);
			$stmt->execute();
			
			$array = array();
			while ($linha = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$d = new Disciplina($linha['id'], $linha['nome']);
				$c = new Curso($linha['c_id'], $linha['c_nome']);
				$d->__set('Curso', $c);
				
				$array[$linha['id']] = $d;
			}
			
			return $array;
			
		} catch (PDOException $e) {
			print('Erro ao executar a consulta: '.$e);
		}
	}
	
	
	public function listarPorTurma($idTurma) {
		try {
			$str = "SELECT d.id AS id, d.nome AS nome FROM disciplina d INNER JOIN (turma t, curso c) ON c.id = t.id_curso AND c.id = d.id_curso ";
			$str .= "WHERE t.id = :id_turma";
			$stmt = $this->con->prepare($str);
		
			$stmt->bindValue(':id_turma', $idTurma);
			$stmt->execute();
			
			$array = array();
			while ($linha = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$array[$linha['id']] = new Disciplina($linha['id'], $linha['nome']);
			}
			
			return $array;
			
		} catch (PDOException $e) {
			print('Erro ao executar a consulta: '.$e);
		}
	}
		
	public function listarPorCurso($idCurso) {
		$sql = "SELECT d.id AS id, d.nome AS nome FROM disciplina d WHERE d.id_curso = :id_curso";
		try {
			$stmt = $this->con->prepare($sql);
		
			$stmt->bindValue(':id_curso', $idCurso);
			$stmt->execute();
			
			$array = array();
			while ($linha = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$array[$linha['id']] = new Disciplina($linha['id'], $linha['nome']);
			}
			
			return $array;
			
		} catch (PDOException $e) {
			print('Erro ao executar a consulta: '.$e);
		}
	}
	
	public function listarPorCursoProfessor($idCurso, $idProfessor) {
		$sql = "SELECT d.id, d.id_curso, d.nome FROM disciplina d ";
		$sql .= "WHERE d.id_curso = :id_curso AND d.id NOT IN (SELECT pd2.id_disciplina FROM professor_disciplina pd2 WHERE pd2.id_professor = :id_professor AND pd2.id_disciplina = d.id) ORDER BY d.nome ASC";
		try {
			$stmt = $this->con->prepare($sql);
		
			$stmt->bindValue(':id_curso', $idCurso, PDO::PARAM_INT);
			$stmt->bindValue(':id_professor', $idProfessor, PDO::PARAM_INT);
			$stmt->execute();
			
			$array = array();
			
			while ($linha = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$d = new Disciplina($linha['id'], $linha['nome']);
				$d->__set('Curso', new Curso($linha['id_curso']));
				
				$array[] = $d;
			}
			
			return $array;
		} catch (PDOException $e) {
			print('Erro ao executar a consulta: '.$e);
		}
	}
	
	
}
?>