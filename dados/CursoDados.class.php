<?php
class CursoDados {
	private $con;
	private $Curso;
	
	public function __construct() {
		$this->con = Conexao::getInstance();
	}
	
	public function setCurso(Curso $c) {
		$this->Curso = $c;
	}
	
	public function selecionar($id) {
		$sql = "SELECT id, nome FROM curso WHERE id = :id";
		try {
			$stmt = $this->con->prepare($sql);
		
			$stmt->bindValue(':id', $id, PDO::PARAM_INT);
			$stmt->execute();
			$linha = $stmt->fetch(PDO::FETCH_ASSOC);
			
			if (is_array($linha)) {
				$c = new Curso($linha['id'], $linha['nome']);

				return $c;
			} else {
				return false;
			}
		} catch (PDOException $e) {
			print('Erro ao executar a consulta: '.$e);
		}
	}
	
	public function inserir(Curso $cu) {
		$sql = "INSERT INTO curso (nome) VALUES (:nome)";
		try {
			$stmt = $this->con->prepare($sql);
		
			$stmt->bindValue(':nome', $cu->__get('nome'));
			
			return $stmt->execute();
		} catch (PDOException $e) {
			print('Erro ao executar a consulta: '.$e);
		}
	}
	
	public function atualizar(Curso $cu) {
		$sql = "UPDATE curso SET nome = :nome WHERE id = :id";
		try {
			$stmt = $this->con->prepare($sql);
		
			$stmt->bindValue(':nome', $cu->__get('nome'));
			$stmt->bindValue(':id', $cu->__get('id'));
			
			return $stmt->execute();
		} catch (PDOException $e) {
			print('Erro ao executar a consulta: '.$e);
		}
	}
	
	public function excluir($id) {
		$sql = "DELETE FROM curso WHERE id = :id";
		try {
			$stmt = $this->con->prepare($sql);
		
			$stmt->bindValue(':id', $id, PDO::PARAM_INT);
			return $stmt->execute();
		} catch (PDOException $e) {
			print('Erro ao executar a consulta: '.$e);
		}
	}
	
	
	
	public function excluirLote(array $ids) {
		$sql = "DELETE FROM curso WHERE id = :id";
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
	
	public function listarPorAluno($idAluno) {
		try {
			$str = "SELECT c.id AS id, c.nome AS nome FROM curso c INNER JOIN (turma t, aluno_turma at, aluno a) ON c.id = t.id_curso AND t.id = at.id_turma AND at.id_aluno = a.id ";
			$str .= "WHERE a.id = :id_aluno";
			$stmt = $this->con->prepare($str);
		
			$stmt->bindValue(':id_aluno', $idAluno);
			$stmt->execute();
			
			$array = array();
			while ($linha = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$array[$linha['id']] = new Curso($linha['id'], $linha['nome']);
			}
			
			return $array;
			
		} catch (PDOException $e) {
			print('Erro ao executar a consulta: '.$e);
		}
	}
		
	public function listarTodos() {
		$str = "SELECT id, nome FROM curso ORDER BY nome ASC";
		try {
			$stmt = $this->con->prepare($str);
			$stmt->execute();
			
			$linhas = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$array = array();
			
			foreach ($linhas as $linha) {
				$array[$linha['id']] = new Curso($linha['id'], $linha['nome']);
			}
			
			return $array;
			
		} catch (PDOException $e) {
			print('Erro ao executar a consulta: '.$e);
		}
	}
	
	public function listarArrayTodos() {
		$str = "SELECT id, nome FROM curso ORDER BY nome ASC";
		try {
			$stmt = $this->con->prepare($str);
			$stmt->execute();
			
			$linhas = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$array = array();
			
			foreach ($linhas as $linha) {
				$array[$linha['id']] = $linha['nome'];
			}
			
			return $array;
			
		} catch (PDOException $e) {
			print('Erro ao executar a consulta: '.$e);
		}
	}
}
?>