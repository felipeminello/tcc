<?php
class AlunoTurmaDados {
	private $con;
	
	public function __construct() {
		$this->con = Conexao::getInstance();
	}
	
	public function inserir(AlunoTurma $at) {
		$sql = "INSERT INTO aluno_turma (id_aluno, id_turma, data) VALUES (:id_aluno, :id_turma, NOW())";
		try {
			$stmt = $this->con->prepare($sql);
			$stmt->bindValue(':id_aluno', $at->__get('Aluno')->__get('id'), PDO::PARAM_INT);
			$stmt->bindValue(':id_turma', $at->__get('Turma')->__get('id'), PDO::PARAM_INT);
			return $stmt->execute();
		} catch (PDOException $e) {
			print('Erro ao executar a consulta: '.$e);
		}
	}
		
	public function excluir($idAlunoTurma) {
		$sql = "DELETE FROM aluno_turma WHERE id = :id_at";
		try {
			$stmt = $this->con->prepare($sql);
			$stmt->bindValue(':id_at', $idAlunoTurma, PDO::PARAM_INT);
			return $stmt->execute();
		} catch (PDOException $e) {
			print('Erro ao executar a consulta: '.$e);
		}
	}
		
	public function listarPorAluno($idAluno) {
		$sql = "SELECT t.id AS t_id, t.nome AS t_nome, t.periodo AS t_periodo, DATE_FORMAT(t.data_inicio, '%d/%m/%Y') AS t_data_inicio, ";
		$sql .= "DATE_FORMAT(t.data_fim, '%d/%m/%Y') AS t_data_fim, DATE_FORMAT(at.data, '%d/%m/%Y') AS at_data, c.id AS c_id, ";
		$sql .= "c.nome AS c_nome, at.id AS at_id FROM aluno_turma at ";
		$sql .= "INNER JOIN (turma t) ON at.id_turma = t.id INNER JOIN (curso c) ON c.id = t.id_curso ";
		$sql .= "WHERE at.id_aluno = :id_aluno ORDER BY at.data DESC";
		try {
			$stmt = $this->con->prepare($sql);
			$stmt->bindValue(':id_aluno', $idAluno, PDO::PARAM_INT);
			$stmt->execute();
			
			$array = array();
			
			while ($linha = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$t = new Turma($linha['t_id'], $linha['t_nome'], $linha['t_periodo'], $linha['t_data_inicio'], $linha['t_data_fim']);
				$c = new Curso($linha['c_id'], $linha['c_nome']);
				$t->__set('Curso', $c);
				
				$a = new Aluno($idAluno);
				
				$at = new AlunoTurma($linha['at_id'], $linha['at_data']);
				$at->__set('Aluno', $a);
				$at->__set('Turma', $t);
				
				$array[] = $at;
			}
			
			return $array;
		} catch (PDOException $e) {
			print('Erro ao executar a consulta: '.$e);
		}
	}
}
?>