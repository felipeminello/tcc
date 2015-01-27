<?php
class ProfessorDados {
	private $con;
	
	public function __construct() {
		$this->con = Conexao::getInstance();
	}
	
	public function selecionar($id) {
		$sql = "SELECT id, nome, sexo, email, telefone, foto FROM professor WHERE id = :id LIMIT 0,1";
		try {
			$stmt = $this->con->prepare($sql);
		
			$stmt->bindValue(':id', $id);
			$stmt->execute();
			$linha = $stmt->fetch(PDO::FETCH_ASSOC);
			
			if (is_array($linha)) {
				$p = new Professor($linha['id'], $linha['nome'], $linha['sexo'], $linha['email'], null, $linha['telefone'], $linha['foto']);
				
				return $p;
			} else {
				return false;
			}
		} catch (PDOException $e) {
			print('Erro ao executar a consulta: '.$e);
		}
	}
	
	public function selecionarTurmaDisciplina($idTurma, $idDisciplina) {
		$sql = "SELECT p.id, p.nome, p.sexo, p.email, p.telefone, p.foto FROM professor p ";
		$sql .= "INNER JOIN (professor_turma pt) ON p.id = pt.id_professor ";
		$sql .= "INNER JOIN (professor_disciplina pd) ON p.id = pd.id_professor ";
		$sql .= "WHERE pt.id_turma = :id_turma AND pd.id_disciplina = :id_disciplina LIMIT 0,1";
		try {
			$stmt = $this->con->prepare($sql);
		
			$stmt->bindValue(':id_turma', $idTurma, PDO::PARAM_INT);
			$stmt->bindValue(':id_disciplina', $idDisciplina, PDO::PARAM_INT);
			$stmt->execute();
			$linha = $stmt->fetch(PDO::FETCH_ASSOC);
			
			if (is_array($linha)) {
				$p = new Professor($linha['id'], $linha['nome'], $linha['sexo'], $linha['email'], null, $linha['telefone'], $linha['foto']);
				
				return $p;
			} else {
				return false;
			}
		} catch (PDOException $e) {
			print('Erro ao executar a consulta: '.$e);
		}
	}
	
	public function listarTurmas($idProfessor) {
		$sql = "SELECT t.id AS t_id, t.nome AS t_nome, t.periodo AS t_periodo, DATE_FORMAT(t.data_inicio, '%d/%m/%Y') AS t_data_inicio, ";
		$sql .= "DATE_FORMAT(t.data_fim, '%d/%m/%Y') AS t_data_fim, c.id AS c_id, c.nome AS c_nome ";
		$sql .= "FROM professor_turma pt ";
		$sql .= "INNER JOIN (professor p) ON p.id = pt.id_professor ";
		$sql .= "INNER JOIN (turma t) ON pt.id_turma = t.id INNER JOIN (curso c) ON c.id = t.id_curso ";
		$sql .= "WHERE p.id = :id_professor ORDER BY t.nome DESC";
		try {
			$stmt = $this->con->prepare($sql);
			$stmt->bindValue(':id_professor', $idProfessor, PDO::PARAM_INT);
			$stmt->execute();
			
			$array = array();
			
			while ($linha = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$t = new Turma($linha['t_id'], $linha['t_nome'], $linha['t_periodo'], $linha['t_data_inicio'], $linha['t_data_fim']);
				$c = new Curso($linha['c_id'], $linha['c_nome']);
				$t->__set('Curso', $c);
				
				$array[] = $t;
			}
			
			return $array;
		} catch (PDOException $e) {
			print('Erro ao executar a consulta: '.$e);
		}
	}
	
	public function listarDisciplina($idProfessor) {
		$sql = "SELECT d.id AS d_id, d.nome AS d_nome, c.id AS c_id, c.nome AS c_nome ";
		$sql .= "FROM professor_disciplina pd ";
		$sql .= "INNER JOIN (disciplina d) ON pd.id_disciplina = d.id INNER JOIN (curso c) ON c.id = d.id_curso ";
		$sql .= "WHERE pd.id_professor = :id_professor GROUP BY d.id ORDER BY d.nome DESC";
		try {
			$stmt = $this->con->prepare($sql);
			$stmt->bindValue(':id_professor', $idProfessor, PDO::PARAM_INT);
			$stmt->execute();
			
			$array = array();
			
			while ($linha = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$d = new Disciplina($linha['d_id'], $linha['d_nome']);
				$c = new Curso($linha['c_id'], $linha['c_nome']);
				$d->__set('Curso', $c);
				
				$array[] = $d;
			}
			
			return $array;
		} catch (PDOException $e) {
			print('Erro ao executar a consulta: '.$e);
		}
	}
	
	public function excluir($id) {
		$sql = "SELECT foto FROM professor WHERE id = :id";
		try {
			$stmt = $this->con->prepare($sql);
			$stmt->bindValue(':id', $id);
			$stmt->execute();
			$linha = $stmt->fetch(PDO::FETCH_ASSOC);
			if (is_array($linha)) {
				unlink(DIR_IMG_FIS_PROFESSOR.$linha['foto']);
			}
			
			$sql = "DELETE FROM professor WHERE id = :id";
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
		$sql = "SELECT foto FROM professor WHERE id = :id AND (foto IS NOT NULL OR foto != '')";
		try {
			$stmt = $this->con->prepare($sql);
			foreach ($ids as $id) {
				$stmt->bindValue(':id', $id, PDO::PARAM_INT);
				if ($stmt->execute()) {
					$linha = $stmt->fetch(PDO::FETCH_ASSOC);
					unlink(DIR_IMG_FIS_PROFESSOR.$linha['foto']);
				}
			}
		} catch (PDOException $e) {
			print('Erro ao executar a consulta: '.$e);
		}
		
		$sql = "DELETE FROM professor WHERE id = :id";
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
	
	
	public function excluirFoto($foto = null) {
		if (!empty($foto))
			return unlink(DIR_IMG_FIS_PROFESSOR.$foto);
	}
	
	public function inserir(Professor $p) {
/*		
		try {
		    $stmt = $this->con->prepare("INSERT INTO log (query) VALUES (:query)"); 
		
		    try { 
		        $this->con->beginTransaction();

		        for ($i = 0 ; $i<100000 ; $i++) {
		        	if ($i == 200) $i = 'teste';
		        	$stmt->bindValue(':query', $i);
		        	$stmt->execute();
		        } 
		        
		        $this->con->commit(); 
		        print $this->con->lastInsertId(); 
		    } catch(PDOExecption $e) { 
		        $this->con->rollback(); 
		        print "Error!: " . $e->getMessage() . "</br>"; 
		    } 
		} catch( PDOExecption $e ) { 
		    print "Error!: " . $e->getMessage() . "</br>"; 
		}		
*/		
		$sql = "INSERT INTO professor (nome, sexo, email, senha, telefone) VALUES (:nome, :sexo, :email, :senha, :telefone)";
		try {
			$stmt = $this->con->prepare($sql);
		
			$stmt->bindValue(':nome', $p->__get('nome'));
			$stmt->bindValue(':sexo', $p->__get('sexo'));
			$stmt->bindValue(':email', $p->__get('email'));
			$stmt->bindValue(':senha', $p->__get('senha'));
			$stmt->bindValue(':telefone', $p->__get('telefone'));
			
			if ($stmt->execute()) {
				$idProfessor = $this->con->lastInsertId(); 
				$arrayTurma = $p->__get('arrayTurma');
				$countTurma = count($arrayTurma);
				
				if ($countTurma > 0) {
					$sql = "INSERT INTO professor_turma (id_professor, id_turma) VALUES (:id_professor, :id_turma)";
					try {
						$stmt = $this->con->prepare($sql);
					
						foreach ($arrayTurma as $t) {
							$stmt->bindValue(':id_professor', $idProfessor, PDO::PARAM_INT);
							$stmt->bindValue(':id_turma', $t->__get('id'), PDO::PARAM_INT);
							if (!$stmt->execute())
								return false;
						}
						return true;
					} catch (PDOException $e) {
						print('Erro ao executar a consulta: '.$e);
					}
				}
				return true;
			} else {
				return false;
			}
		} catch (PDOException $e) {
			print('Erro ao executar a consulta: '.$e);
		}
	}
	
	public function inserirTurma($idProfessor, $idTurma) {
		$sql = "INSERT INTO professor_turma (id_professor, id_turma) VALUES (:id_professor, :id_turma)";
		try {
			$stmt = $this->con->prepare($sql);
		
			$stmt->bindValue(':id_professor', $idProfessor, PDO::PARAM_INT);
			$stmt->bindValue(':id_turma', $idTurma, PDO::PARAM_INT);
			
			return $stmt->execute();
		} catch (PDOException $e) {
			print('Erro ao executar a consulta: '.$e);
		}
	}
	
	public function inserirDisciplina($idProfessor, $idDisciplina) {
		$sql = "INSERT INTO professor_disciplina (id_professor, id_disciplina) VALUES (:id_professor, :id_disciplina)";
		try {
			$stmt = $this->con->prepare($sql);
		
			$stmt->bindValue(':id_professor', $idProfessor, PDO::PARAM_INT);
			$stmt->bindValue(':id_disciplina', $idDisciplina, PDO::PARAM_INT);
			
			return $stmt->execute();
		} catch (PDOException $e) {
			print('Erro ao executar a consulta: '.$e);
		}
	}
	
	public function listarPorCurso($idCurso, $limite = 0) {
		$strLimite = ($limite > 0) ? "LIMIT 0,$limite" : "";
		
		$sql = "SELECT p.id AS id, p.nome AS nome FROM professor p ";
		$sql .= "INNER JOIN (professor_turma pt, turma t, curso c) ON p.id = pt.id_professor AND pt.id_turma = t.id AND t.id_curso = c.id ";
		$sql .= "WHERE c.id = :id_curso GROUP BY p.id ORDER BY p.nome $strLimite";
		try {
			$stmt = $this->con->prepare($sql);
		
			$stmt->bindValue(':id_curso', $idCurso);
			$stmt->execute();
			
			$linhas = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
			$array = array();
			
			foreach ($linhas as $linha) {
				$array[$linha['id']] = new Professor($linha['id'], $linha['nome']);
			}
			
			return $array;
		} catch (PDOException $e) {
			print('Erro ao executar a consulta: '.$e->getMessage());
		}
	}
	

	public function atualizar(Professor $p) {
/*		
		try {
		    $stmt = $this->con->prepare("INSERT INTO log (query) VALUES (:query)"); 
		
		    try { 
		        $this->con->beginTransaction();

		        for ($i = 0 ; $i<100000 ; $i++) {
		        	if ($i == 200) $i = 'teste';
		        	$stmt->bindValue(':query', $i);
		        	$stmt->execute();
		        } 
		        
		        $this->con->commit(); 
		        print $this->con->lastInsertId(); 
		    } catch(PDOExecption $e) { 
		        $this->con->rollback(); 
		        print "Error!: " . $e->getMessage() . "</br>"; 
		    } 
		} catch( PDOExecption $e ) { 
		    print "Error!: " . $e->getMessage() . "</br>"; 
		}
*/		
		$senha = $p->__get('senha');
		
		$sql = "UPDATE professor SET nome = :nome, sexo = :sexo, email = :email";
		if (!empty($senha) or $senha != md5(''))
			$sql .= ", senha = :senha";
		$sql .= ", telefone = :telefone, foto = :foto WHERE id = :id";
		try {
			$stmt = $this->con->prepare($sql);
		
			$stmt->bindValue(':id', $p->__get('id'));
			$stmt->bindValue(':nome', $p->__get('nome'));
			$stmt->bindValue(':sexo', $p->__get('sexo'));
			$stmt->bindValue(':email', $p->__get('email'));
			if (!empty($senha) or $senha != md5(''))
				$stmt->bindValue(':senha', $p->__get('senha'));
			$stmt->bindValue(':telefone', $p->__get('telefone'));
			$stmt->bindValue(':foto', $p->__get('foto'));
			
			return $stmt->execute();
		} catch (PDOException $e) {
			print('Erro ao executar a consulta: '.$e);
		}
	}

	public function inserirProfessorTurma(Professor $p) {
		
	}
	
	public function excluirProfessorTurma($idProfessor, $idTurma) {
		$sql = "DELETE FROM professor_turma WHERE id_professor = :id_professor AND id_turma = :id_turma";
		try {
			$stmt = $this->con->prepare($sql);
			
			$stmt->bindValue(':id_professor', $idProfessor, PDO::PARAM_INT);
			$stmt->bindValue(':id_turma', $idTurma, PDO::PARAM_INT);
			
			return $stmt->execute();
		} catch (PDOException $e) {
			print('Erro ao executar a consulta: '.$e);
		}
	}
	
	public function excluirProfessorDisciplina($idProfessor, $idDisciplina) {
		$sql = "DELETE FROM professor_disciplina WHERE id_professor = :id_professor AND id_disciplina = :id_disciplina";
		try {
			$stmt = $this->con->prepare($sql);
			
			$stmt->bindValue(':id_professor', $idProfessor, PDO::PARAM_INT);
			$stmt->bindValue(':id_disciplina', $idDisciplina, PDO::PARAM_INT);
			
			return $stmt->execute();
		} catch (PDOException $e) {
			print('Erro ao executar a consulta: '.$e);
		}
	}
	
	public function quantidadePorTurma() {
		$sql = "SELECT t.id AS id, COUNT(p.id) AS total FROM professor p INNER JOIN (professor_turma pt, turma t) ";
		$sql .= "ON p.id = pt.id_professor AND pt.id_turma = t.id ";
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
	
	
	public function existeEmail($email, $idProfessor = 0) {
		$strId = (!empty($idProfessor)) ? " AND id != :id " : "";
			
		$sql = "SELECT id FROM professor WHERE email = :email $strId LIMIT 0,1";
		try {
			$stmt = $this->con->prepare($sql);
			
			$stmt->bindValue(':email', $email);
			if (!empty($idProfessor)) {
				$stmt->bindValue(':id',$idProfessor);
			}
			
			$stmt->execute();
			$num = $stmt->fetchColumn();
			
			return ($num > 0) ? true : false;
		} catch (PDOException $e) {
			print('Erro ao executar a consulta: '.$e);
		}
	}
	
	public function login($email, $senha) {
		$sql = "SELECT id, nome, email, telefone, DATE_FORMAT(ultimo_login, '%d/%m/%Y %H:%i') AS ultimo_login FROM professor WHERE email = :email AND senha = :senha LIMIT 0,1";
		try {
			$stmt = $this->con->prepare($sql);
			

			$stmt->bindValue(':email', $email);
			$stmt->bindValue(':senha', $senha);
			$stmt->execute();
						
			$linha = $stmt->fetch(PDO::FETCH_ASSOC);
			
			if (is_array($linha)) {
				$_SESSION['professor']['id'] = $linha['id'];
				$_SESSION['professor']['nome'] = $linha['nome'];
				
				return new Professor($linha['id'], $linha['nome'], $linha['sexo'], $linha['email'], null, null, $linha['ultimo_login']);;
			} else {
				return false;
			}
		} catch (PDOException $e) {
			print('Erro ao executar a consulta: '.$e);
		}
	}
		
	public function atualizarDataLogin() {
		try {
			$sql = "UPDATE aluno SET ultimo_login = NOW() WHERE id = :id";
			$stmt = $this->con->prepare($sql);
		
			$stmt->bindValue(':id', $this->Professor->__get('id'));
			$stmt->execute();
			
			return true;
		} catch (Exception $e) {
			print('Erro ao executar a consulta');
		}
	}

	public function listar($idCurso = 0, $idTurma = 0, $limite = 0) {
		$strCurso = (!empty($idCurso)) ? " AND c.id = :id_curso " : "";
		$strTurma = (!empty($idTurma)) ? " AND t.id = :id_turma " : "";
		$strLimite = ($limite > 0) ? "LIMIT 0,$limite" : "";
		
		$sql = "SELECT p.id AS id, p.nome AS nome, p.email AS email, p.telefone AS telefone FROM professor p ";
		$sql .= "LEFT JOIN (professor_turma pt, turma t, curso c) ON pt.id_professor = p.id AND pt.id_turma = t.id AND t.id_curso = c.id ";
		$sql .= "WHERE 1=1 $strCurso $strTurma GROUP BY p.id ORDER BY p.nome $strLimite";
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
				$array[$linha['id']] = new Professor($linha['id'], $linha['nome'], null, $linha['email'], null, $linha['telefone']);
			}
			
			return $array;
		} catch (PDOException $e) {
			print('Erro ao executar a consulta: '.$e->getMessage());
		}
	}
	
	public function quantidadePorCurso() {
		$sql = "SELECT pt.id_professor, t.id_curso ".
		"FROM professor_turma pt ".
		"INNER JOIN (turma t) ON pt.id_turma = t.id";
		try {
			$stmt = $this->con->prepare($sql);
			$stmt->execute();
			
			$array = array();
			
			while ($linha = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$array[$linha['id_curso']][$linha['id_professor']] = true;
			}
			
			return $array;
		} catch (PDOException $e) {
			die('Erro ao executar a consulta: '.$e);
		}
	}
	
	public function total() {
		$sql = "SELECT COUNT(id) AS total FROM professor";
		
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