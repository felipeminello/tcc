<?php
class AlunoDados {
	private $con;
	private $Aluno;
	
	public function __construct() {
		$this->con = Conexao::getInstance();
	}
	
	public function setAluno(Aluno $a) {
		$this->Aluno = $a;
	}
	
	public function selecionar($id) {
		$sql = "SELECT id, ra, nome, sexo, email, telefone, foto, DATE_FORMAT(ultimo_login, '%d/%m/%Y') AS ultimo_login FROM aluno WHERE id = :id";
		try {
			$stmt = $this->con->prepare($sql);
		
			$stmt->bindValue(':id', $id);
			$stmt->execute();
			$linha = $stmt->fetch(PDO::FETCH_ASSOC);

			if (is_array($linha)) {
				$a = new Aluno($linha['id'], $linha['ra'], $linha['nome'], $linha['email'], $linha['ultimo_login'], null, $linha['telefone'], $linha['sexo'], $linha['foto']);
				self::setAluno($a);
				
				return $a;
			} else {
				return false;
			}
		} catch (Exception $e) {
			print('Erro ao executar a consulta');
		}
	}
	
	public function inserir(Aluno $a) {
		$sql = "INSERT INTO aluno (ra, senha, nome, sexo, email, telefone, foto) ";
		$sql .= "VALUES (:ra, :senha, :nome, :sexo, :email, :telefone, :foto)";
		try {
			$stmt = $this->con->prepare($sql);
			$stmt->bindValue(':ra', $a->__get('ra'));
			$stmt->bindValue(':senha', $a->__get('senha'));
			$stmt->bindValue(':nome', $a->__get('nome'));
			$stmt->bindValue(':sexo', $a->__get('sexo'));
			$stmt->bindValue(':email', $a->__get('email'));
			$stmt->bindValue(':telefone', $a->__get('telefone'));
			$stmt->bindValue(':foto', $a->__get('foto'));
			
			return $stmt->execute();
		} catch (PDOException $e) {
			print('Erro ao executar a consulta: '.$e);
		}
	}
	
	public function login($ra, $senha) {
		try {
			$sql = "SELECT id, ra, nome FROM aluno WHERE ra = :ra AND senha = MD5(:senha) LIMIT 0,1";
			$stmt = $this->con->prepare($sql);
			
			$stmt->bindValue(':ra', $ra);
			$stmt->bindValue(':senha', $senha);
			$stmt->execute();
			
			$linha = $stmt->fetch(PDO::FETCH_ASSOC);
			
			if (is_array($linha)) {
				$_SESSION['aluno']['id'] = $linha['id'];
				$_SESSION['aluno']['ra'] = $linha['ra'];
				$_SESSION['aluno']['nome'] = $linha['nome'];
				
				return new Aluno($linha['id'], $linha['ra'], $linha['nome']);
			} else {
				return false;
			}
		} catch (Exception $e) {
			print('Erro ao executar a consulta');
		}
	}
	
	public function listar($idCurso = 0, $idTurma = 0, $limite = 0) {
		$strCurso = (!empty($idCurso)) ? " AND c.id = :id_curso " : "";
		$strTurma = (!empty($idTurma)) ? " AND t.id = :id_turma " : "";
		$strLimite = ($limite > 0) ? "LIMIT 0,$limite" : "";
		
		$sql = "SELECT a.id AS id, a.nome AS nome, a.ra, a.email AS email, a.telefone AS telefone, a.sexo AS sexo, a.foto AS foto FROM aluno a ";
		$sql .= "LEFT JOIN (aluno_turma at, turma t, curso c) ON at.id_aluno = a.id AND at.id_turma = t.id AND t.id_curso = c.id ";
		$sql .= "WHERE 1=1 $strCurso $strTurma GROUP BY a.id ORDER BY a.nome $strLimite";
		try {
			$stmt = $this->con->prepare($sql);
			if (!empty($idCurso))
				$stmt->bindValue(':id_curso', $idCurso);
			if (!empty($idTurma))
				$stmt->bindValue(':id_turma', $idTurma);
			$stmt->execute();
			
			$linhas = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
			$array = array();
			
			foreach ($linhas as $linha) {
				$array[$linha['id']] = new Aluno($linha['id'], $linha['ra'], $linha['nome'], $linha['email'], null, null, $linha['telefone'],  $linha['sexo'], $linha['foto']);
			}
			
			return $array;
		} catch (PDOException $e) {
			print('Erro ao executar a consulta: '.$e->getMessage());
		}
	}
	
	
	public function atualizarDataLogin() {
		try {
			$sql = "UPDATE aluno SET ultimo_login = NOW() WHERE id = :id";
			$stmt = $this->con->prepare($sql);
		
			$stmt->bindValue(':id', $this->Aluno->__get('id'));
			$stmt->execute();
			
			return true;
		} catch (Exception $e) {
			print('Erro ao executar a consulta');
		}
	}

	public function listarPorCurso($idCurso, $limite = 0) {
		$strLimite = ($limite > 0) ? "LIMIT 0,$limite" : "";
		
		$sql = "SELECT a.id AS id, a.ra AS ra, a.nome AS nome FROM aluno a ";
		$sql .= "INNER JOIN (aluno_turma at, turma t, curso c) ON a.id = at.id_aluno AND at.id_turma = t.id AND t.id_curso = c.id ";
		$sql .= "WHERE c.id = :id_curso GROUP BY a.id ORDER BY a.nome $strLimite";
		try {
			$stmt = $this->con->prepare($sql);
		
			$stmt->bindValue(':id_curso', $idCurso);
			$stmt->execute();
			
			$linhas = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
			$array = array();
			
			foreach ($linhas as $linha) {
				$array[$linha['id']] = new Aluno($linha['id'], $linha['ra'], $linha['nome']);
			}
			
			return $array;
		} catch (PDOException $e) {
			print('Erro ao executar a consulta: '.$e->getMessage());
		}
	}
	
	public function listarPorTurma($idTurma, $limite = 0) {
		$strLimite = ($limite > 0) ? "LIMIT 0,$limite" : "";
		
		$sql = "SELECT a.id AS id, a.ra AS ra, a.nome AS nome, a.foto AS foto, a.sexo AS sexo FROM aluno a ";
		$sql .= "INNER JOIN (aluno_turma at, turma t, curso c) ON a.id = at.id_aluno AND at.id_turma = t.id AND t.id_curso = c.id ";
		$sql .= "WHERE t.id = :id_turma GROUP BY a.id ORDER BY a.nome $strLimite";
		try {
			$stmt = $this->con->prepare($sql);
		
			$stmt->bindValue(':id_turma', $idTurma);
			$stmt->execute();
			
			$linhas = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
			$array = array();
			
			foreach ($linhas as $linha) {
				$a = new Aluno($linha['id'], $linha['ra'], $linha['nome']);
				$a->__set('foto', $linha['foto']);
				$a->__set('sexo', $linha['sexo']);
				
				$array[$linha['id']] = $a;
			}
			
			return $array;
		} catch (PDOException $e) {
			print('Erro ao executar a consulta: '.$e->getMessage());
		}
	}
	
	public function quantidadePorCurso() {
		$sql = "SELECT at.id_aluno, t.id_curso FROM aluno_turma at INNER JOIN (turma t) ON at.id_turma = t.id";
		try {
			$stmt = $this->con->prepare($sql);
			$stmt->execute();
			
			$array = array();
			
			while ($linha = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$array[$linha['id_curso']][$linha['id_aluno']] = true;
			}
			
			return $array;
		} catch (PDOException $e) {
			print('Erro ao executar a consulta: '.$e);
		}
	}
	
	public function quantidadePorTurma() {
		$sql = "SELECT t.id AS id, COUNT(a.id) AS total FROM aluno a INNER JOIN (aluno_turma at, turma t) ";
		$sql .= "ON a.id = at.id_aluno AND at.id_turma = t.id ";
		$sql .= "GROUP BY t.id";
		try {
			$stmt = $this->con->prepare($sql);
			$stmt->execute();
			
			$array = array();
			
			while ($linha = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$array[$linha['id']] = $linha['total'];
			}
			
			return $array;
		} catch (PDOException $e) {
			print('Erro ao executar a consulta: '.$e);
		}
	}
	
	
	public function existeRA($ra, $idAluno = 0) {
		$strId = (!empty($idAluno)) ? " AND id != :id " : "";
			
		$sql = "SELECT id FROM aluno WHERE ra = :ra $strId LIMIT 0,1";
		try {
			$stmt = $this->con->prepare($sql);
			
			$stmt->bindValue(':ra', $ra);
			if (!empty($idAluno)) {
				$stmt->bindValue(':id',$idAluno);
			}
			
			$stmt->execute();
			$num = $stmt->fetchColumn();
			
			return ($num > 0) ? true : false;
		} catch (PDOException $e) {
			print('Erro ao executar a consulta: '.$e);
		}
	}
	
	public function excluir($id) {
		$sql = "SELECT foto FROM aluno WHERE id = :id";
		try {
			$stmt = $this->con->prepare($sql);
			$stmt->bindValue(':id', $id);
			$stmt->execute();
			$linha = $stmt->fetch(PDO::FETCH_ASSOC);
			if (is_array($linha)) {
				unlink(DIR_IMG_FIS_ALUNO.$linha['foto']);
			}
			
			$sql = "DELETE FROM aluno WHERE id = :id";
			try {
				$stmt = $this->con->prepare($sql);
			
				$stmt->bindValue(':id', $id);
				if ($stmt->execute()) {
					return true;
				} else {
					return false;
				}
			} catch (PDOException $e) {
				print('Erro ao executar a consulta: '.$e);
			}
		} catch (PDOException $e) {
			print('Erro ao executar a consulta: '.$e);
		}
	}
	
	public function excluirLote(array $ids) {
		$sql = "SELECT foto FROM aluno WHERE id = :id AND (foto IS NOT NULL OR foto != '')";
		try {
			$stmt = $this->con->prepare($sql);
			foreach ($ids as $id) {
				$stmt->bindValue(':id', $id, PDO::PARAM_INT);
				if ($stmt->execute()) {
					$linha = $stmt->fetch(PDO::FETCH_ASSOC);
					unlink(DIR_IMG_FIS_ALUNO.$linha['foto']);
				}
			}
		} catch (PDOException $e) {
			print('Erro ao executar a consulta: '.$e);
		}
		
		$sql = "DELETE FROM aluno WHERE id = :id";
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
	public function atualizar(Aluno $a) {
		$senha = $a->__get('senha');
		
		$sql = "UPDATE aluno SET nome = :nome, sexo = :sexo, email = :email";
		if (!empty($senha) or $senha != md5(''))
			$sql .= ", senha = :senha";
		$sql .= ", telefone = :telefone, foto = :foto WHERE id = :id";
		try {
			$stmt = $this->con->prepare($sql);
		
			$stmt->bindValue(':id', $a->__get('id'));
			$stmt->bindValue(':nome', $a->__get('nome'));
			$stmt->bindValue(':sexo', $a->__get('sexo'));
			$stmt->bindValue(':email', $a->__get('email'));
			if (!empty($senha) or $senha != md5(''))
				$stmt->bindValue(':senha', $a->__get('senha'));
			$stmt->bindValue(':telefone', $a->__get('telefone'));
			$stmt->bindValue(':foto', $a->__get('foto'));
			
			return $stmt->execute();
		} catch (PDOException $e) {
			print('Erro ao executar a consulta: '.$e);
		}
	}
	
	
	public function excluirFoto($foto = null) {
		if (!empty($foto))
			return unlink(DIR_IMG_FIS_ALUNO.$foto);
	}
	
	public function total() {
		$sql = "SELECT COUNT(id) AS total FROM aluno";
		
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