<?php
class ChamadaDados {
	private $con;
	private $Chamada;
	
	public function __construct() {
		$this->con = Conexao::getInstance();
	}
	
	public function setChamada(Chamada $c) {
		$this->Chamada = $c;
	}
		
	public function listarPorTurmaDisciplina($idTurma, $idDisciplina, $dataInicial = null, $dataFinal = null) {
		$strDataInicial = (!empty($dataInicial)) ? " AND DATE(c.data) >= :data_inicial " : "";
		$strDataFinal = (!empty($dataFinal)) ? " AND DATE(c.data) <= :data_final " : "";
		
		$sql = "SELECT c.id, c.presenca, DATE_FORMAT(c.data, '%d/%m/%Y') data, DATE_FORMAT(c.hora, '%H:%i') AS hora, a.id AS a_id, a.ra AS a_ra, a.nome AS a_nome FROM chamada c ";
		$sql .= "INNER JOIN (disciplina d) ON d.id = c.id_disciplina ";
		$sql .= "INNER JOIN (aluno_turma at, aluno a) ON at.id = c.id_aluno_turma AND a.id = at.id_aluno ";
		$sql .= "WHERE d.id = :id_disciplina AND at.id_turma = :id_turma $strDataInicial $strDataFinal GROUP BY c.id ORDER BY c.data ASC, c.hora ASC";
		try {
			$stmt = $this->con->prepare($sql);
		
			$stmt->bindValue(':id_turma', $idTurma, PDO::PARAM_INT);
			$stmt->bindValue(':id_disciplina', $idDisciplina, PDO::PARAM_INT);
			if (!empty($dataInicial))
				$stmt->bindValue(':data_inicial', $dataInicial);
			if (!empty($dataFinal))
				$stmt->bindValue(':data_final', $dataFinal);
			
			$stmt->execute();
			
//			var_dump($stmt->errorInfo());
			
//			$stmt->debugDumpParams();
			
			$array = array();
			
			while ($linha = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$a = new Aluno($linha['a_id'], $linha['a_ra'], $linha['a_nome']);
				$at = new AlunoTurma();
				$at->__set('Aluno', $a);
				$c = new Chamada($linha['id'], $linha['presenca'], $linha['data'], $linha['hora']);
				$c->__set('AlunoTurma', $at);
				
				$array[] = $c;
			}
			
			return $array;
		} catch (PDOException $e) {
			print('Erro ao executar a consulta: '.$e);
		}
	}	
}
?>