<?php
class Conexao extends PDO {
	private static $instancia;
 
	private function Conexao($dsn, $username = "", $password = "") {
		// O construtor abaixo � o do PDO
		parent::__construct($dsn, $username, $password);
		parent::setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
 
	public static function getInstance() {
		// Se o a instancia n�o existe eu fa�o uma
		if(!isset(self::$instancia)) {
			try {
				self::$instancia = new Conexao("mysql:host=".DB_LOCAL.";dbname=".DB_DATABASE, DB_USER, DB_PASSW);
			} catch ( PDOException $e ) {
				echo '<strong>Erro ao conectar:</strong> '.$e;
				exit();
			}
		}
		// Se j� existe instancia na mem�ria eu retorno ela
		return self::$instancia;
	}
	
	public function inserirLog() {
		
	}
}
?>	
