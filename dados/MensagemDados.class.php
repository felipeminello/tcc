<?php
class MensagemDados {
	private $con;
	
	public function __construct() {
		$this->con = Conexao::getInstance();
	}
	
	public function inserir(Mensagem $m) {
		$arrayMD = $m->__get('arrayMensagemDestino');
		
		$sql = "INSERT INTO mensagem (id_aluno, id_professor, id_coordenador, texto) VALUES (:id_aluno, :id_professor, :id_coordenador, :texto)";
		try {
			$stmt = $this->con->prepare($sql);
			
			$stmt->bindValue(':id_aluno', $m->__get('Aluno')->__get('id'));
			$stmt->bindValue(':id_professor', $m->__get('Professor')->__get('id'));
			$stmt->bindValue(':id_coordenador', $m->__get('Coordenador')->__get('id'));
			$stmt->bindValue(':texto', $m->__get('texto'));
			
			if ($stmt->execute()) {
				$m->__set('id', $this->con->lastInsertId());
				
				$sql = "INSERT INTO mensagem_destino (id_mensagem, id_aluno, id_professor, id_coordenador, id_turma) VALUES (:id_mensagem, :id_aluno, :id_professor, :id_coordenador, :id_turma)";
				try {
					foreach ($arrayMD as $md) {
						$stmt = $this->con->prepare($sql);
						
						$idAluno = $md->__get('Aluno')->__get('id');
						$idProfessor = $md->__get('Professor')->__get('id');
						$idCoordenador = $md->__get('Coordenador')->__get('id');
						$idTurma = $md->__get('Turma')->__get('id');
						
						$stmt->bindValue(':id_mensagem', $m->__get('id'));
						$stmt->bindValue(':id_aluno', (!empty($idAluno)) ? $idAluno : null);
						$stmt->bindValue(':id_professor', (!empty($idProfessor)) ? $idProfessor : null);
						$stmt->bindValue(':id_coordenador', (!empty($idCoordenador)) ? $idCoordenador : null);
						$stmt->bindValue(':id_turma', (!empty($idTurma)) ? $idTurma : null);
						
						if (!$stmt->execute()) return false;
					}
				} catch (PDOException $e) {
					print('Erro ao executar a consulta: '.$e);
				}
				
				return true;
			} else {
				return false;
			}
		} catch (PDOException $e) {
			print('Erro ao executar a consulta: '.$e);
		}
	}
	
	public function excluir($idMensagem) {
		$sql = "DELETE FROM mensagem WHERE id = :id";
		try {
			$stmt = $this->con->prepare($sql);
			
			$stmt->bindValue(':id', $idMensagem);
			
			return $stmt->execute();
		} catch (PDOException $e) {
			print('Erro ao executar a consulta: '.$e);
		}
	}
	
	public function totalCoordenadorData($idCoordenador, $data) {
		$sql = "SELECT COUNT(m.id) AS total FROM mensagem m INNER JOIN (mensagem_destino md) ON m.id = md.id_mensagem ";
		$sql .= "WHERE md.id_coordenador = :id_coordenador AND DATE(m.data) = :data";
		
		try {
			$stmt = $this->con->prepare($sql);
			
			$stmt->bindValue(':id_coordenador', $idCoordenador, PDO::PARAM_INT);
			$stmt->bindValue(':data', $data);
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
	
	public function listarTodos($idAluno = 0, $idProfessor = 0, $idCoordenador = 0, $inicio = 0, $limite = 0) {
		$strAluno = (!empty($idAluno)) ? " AND a.id = :id_aluno " : "";
		$strProfessor = (!empty($idProfessor)) ? " AND p.id = :id_professor " : "";
		$strCoordenador = (!empty($idCoordenador)) ? " AND c.id = :id_coordenador " : "";
		$strLimite = ($limite > 0) ? "LIMIT $inicio,$limite" : "";
		
		$sql = "SELECT a.id AS a_id, a.nome AS a_nome, a.ra AS a_ra, p.id AS p_id, p.nome AS p_nome, c.id AS c_id, c.nome AS c_nome, ";
		$sql .= "m.id AS id, DATE_FORMAT(m.data, '%d/%m/%Y') AS data, DATE_FORMAT(m.data, '%H:%i:%s') AS hora, m.texto AS texto ";
		$sql .= "FROM mensagem m LEFT JOIN (aluno a) ON a.id = m.id_aluno LEFT JOIN (professor p) ON p.id = m.id_professor ";
		$sql .= "LEFT JOIN (coordenador c) ON c.id = m.id_coordenador WHERE 1=1 $strAluno $strProfessor $strCoordenador GROUP BY m.id ORDER BY m.data ASC $strLimite";
		
		try {
			$stmt = $this->con->prepare($sql);
			
			if (!empty($idAluno))
				$stmt->bindValue(':id_aluno', $idAluno, PDO::PARAM_INT);
			if (!empty($idProfessor))
				$stmt->bindValue(':id_professor', $idProfessor, PDO::PARAM_INT);
			if (!empty($idCoordenador))
				$stmt->bindValue(':id_coordenador', $idCoordenador, PDO::PARAM_INT);
				
			if ($stmt->execute()) {
				$linhas = $stmt->fetchAll(PDO::FETCH_ASSOC);
				
				$array = array();
				
				foreach ($linhas as $linha) {
					$sql = "SELECT md.id AS md_id, a.id AS a_id, a.nome AS a_nome, a.ra AS a_ra, p.id AS p_id, p.nome AS p_nome, c.id AS c_id, c.nome AS c_nome, cu.id AS cu_id, cu.nome AS cu_nome, t.id AS t_id, t.nome AS t_nome ";
					$sql .= "FROM mensagem_destino md LEFT JOIN (aluno a) ON a.id = md.id_aluno LEFT JOIN (professor p) ON p.id = md.id_professor ";
					$sql .= "LEFT JOIN (coordenador c) ON c.id = md.id_coordenador LEFT JOIN (curso cu, turma t) ON md.id_turma = t.id AND cu.id = t.id_curso ";
					$sql .= "WHERE md.id_mensagem = '".$linha['id']."' GROUP BY md.id";
					
					
					
					try {
						$stmt = $this->con->prepare($sql);
						if ($stmt->execute()) {
							$linhasMD = $stmt->fetchAll(PDO::FETCH_ASSOC);
				
							$arrayMD = array();
							
							foreach ($linhasMD as $linhaMD) {
								$c = new Curso($linhaMD['cu_id'], $linhaMD['cu_nome']);
								$t = new Turma($linhaMD['t_id'], $linhaMD['t_nome']);
								$t->__set('Curso', $c);
								
								$md = new MensagemDestino($linhaMD['md_id']);
								$md->__set('Aluno', new Aluno($linhaMD['a_id'], $linhaMD['a_ra'], $linhaMD['a_nome']));
								$md->__set('Professor', new Professor($linhaMD['p_id'], $linhaMD['p_nome']));
								$md->__set('Coordenador', new Coordenador($linhaMD['c_id'], $linhaMD['c_nome']));
								$md->__set('Turma', $t);
								
								$arrayMD[] = $md;
							}
						} else {
							return false;
						}
					} catch (PDOException $e) {
						print('Erro ao executar a consulta: '.$e);
					}
					
					$m = new Mensagem($linha['id'], $linha['texto'], $linha['data'], $linha['hora']);
					$m->__set('Aluno', new Aluno($linha['a_id'], $linha['a_ra'], $linha['a_nome']));
					$m->__set('Professor', new Professor($linha['p_id'], $linha['p_nome']));
					$m->__set('Coordenador', new Coordenador($linha['c_id'], $linha['c_nome']));
					$m->__set('arrayMensagemDestino', $arrayMD);
					
					$array[$linha['id']] = $m;
				}
				
				return $array;
			} else {
				return false;
			}
		} catch (PDOException $e) {
			print('Erro ao executar a consulta: '.$e);
		}
	}
}
?>