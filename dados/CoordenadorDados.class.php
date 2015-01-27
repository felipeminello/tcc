<?php
class CoordenadorDados {
	private $con;
	private $Coordenador;
	
	public function __construct() {
		$this->con = Conexao::getInstance();
	}
	
	public function setCoordenador(Coordenador $c) {
		$this->Coordenador = $c;
	}
	
	public function selecionar($id) {
		try {
			$sql = "SELECT id, nome, email, foto, DATE_FORMAT(ultimo_login, '%d/%m/%Y %H:%i') AS ultimo_login FROM coordenador WHERE id = :id";
			$stmt = $this->con->prepare($sql);
		
			$stmt->bindValue(':id', $id);
			$stmt->execute();
			$linha = $stmt->fetch(PDO::FETCH_ASSOC);
			
			if (is_array($linha)) {
				$c = new Coordenador($linha['id'], $linha['nome'], $linha['email'], null, $linha['ultimo_login'], $linha['foto']);
				self::setCoordenador($c);
				
				return $c;
			} else {
				return false;
			}
		} catch (Exception $e) {
			print('Erro ao executar a consulta: '.$e);
		}
	}
	
	public function atualizar(Coordenador $c) {
		$senha = $c->__get('senha');
		
		$sql = "UPDATE coordenador SET nome = :nome, email = :email ";
		if ($senha != md5(''))
			$sql .= ", senha = :senha ";
		$sql .= "WHERE id = :id";
		try {
			$stmt = $this->con->prepare($sql);
		
			$stmt->bindValue(':id', $c->__get('id'), PDO::PARAM_INT);
			$stmt->bindValue(':nome', $c->__get('nome'));
			$stmt->bindValue(':email', $c->__get('email'));
			if ($senha != md5(''))
				$stmt->bindValue(':senha', $c->__get('senha'));
			$stmt->execute();
			
			return true;
		} catch (Exception $e) {
			print('Erro ao executar a consulta: '.$e);
		}
	}
	
	public function atualizarFoto(Coordenador $c) {
		$sql = "UPDATE coordenador SET foto = :foto WHERE id = :id";
		try {
			$stmt = $this->con->prepare($sql);
		
			$stmt->bindValue(':id', $c->__get('id'), PDO::PARAM_INT);
			$stmt->bindValue(':foto', $c->__get('foto'));
			$stmt->execute();
			
			return true;
		} catch (Exception $e) {
			print('Erro ao executar a consulta: '.$e);
		}
	}
	
	public function login($email, $senha) {
		$sql = "SELECT id, nome, email, DATE_FORMAT(ultimo_login, '%d/%m/%Y %H:%i') AS ultimo_login FROM coordenador WHERE email = :email AND senha = :senha LIMIT 0,1";
		try {
			$stmt = $this->con->prepare($sql);
			

			$stmt->bindValue(':email', $email);
			$stmt->bindValue(':senha', $senha);
			$stmt->execute();
						
			$linha = $stmt->fetch(PDO::FETCH_ASSOC);
			
			if (is_array($linha)) {
				$_SESSION['coordenador']['id'] = $linha['id'];
				$_SESSION['coordenador']['nome'] = $linha['nome'];
				
				return new Coordenador($linha['id'], $linha['nome'], $linha['email'], null, $linha['ultimo_login']);;
			} else {
				return false;
			}
		} catch (PDOException $e) {
			print('Erro ao executar a consulta: '.$e);
		}
	}
	
	public function listar() {
		$sql = "SELECT id, nome, email, foto, DATE_FORMAT(ultimo_login, '%d/%m/%Y %H:%i:%s') AS ultimo_login FROM coordenador ORDER BY nome ASC";
		try {
			$stmt = $this->con->prepare($sql);
			$stmt->execute();
			
			$linhas = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
			$array = array();
			
			foreach ($linhas as $linha) {
				$array[] = $c = new Coordenador($linha['id'], $linha['nome'], $linha['email'], null, $linha['ultimo_login'], $linha['foto']);
			}
			
			return $array;
		} catch (PDOException $e) {
			print('Erro ao executar a consulta: '.$e->getMessage());
		}
	}
	
	
	public function atualizarDataLogin() {
		try {
			$sql = "UPDATE coordenador SET ultimo_login = NOW() WHERE id = :id";
			$stmt = $this->con->prepare($sql);
		
			$stmt->bindValue(':id', $this->Coordenador->__get('id'));
			$stmt->execute();
			
			return true;
		} catch (Exception $e) {
			print('Erro ao executar a consulta');
		}
	}
}
?>