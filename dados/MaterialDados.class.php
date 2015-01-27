<?php
class MaterialDados {
	private $con;
	
	public function __construct() {
		$this->con = Conexao::getInstance();
	}

	public function listarPorProfessor($idProfessor) {
		$sql = "SELECT m.id, m.titulo, m.arquivo, DATE_FORMAT(m.data, '%d/%m/%Y') data, m.observacao FROM material m ";
		$sql .= "WHERE m.id_professor = :id_professor ORDER BY m.data ASC";
		try {
			$stmt = $this->con->prepare($sql);
		
			$stmt->bindValue(':id_professor', $idProfessor, PDO::PARAM_INT);
			
			if ($stmt->execute()) {
				$array = array();
				
				while ($linha = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
					$m = new Material($linha['id'], $linha['titulo'], $linha['arquivo'], $linha['data'], $linha['observacao']);
					
					$array[] = $m;
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