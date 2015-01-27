<?
$cDados = new CoordenadorDados();

$arrayValida = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$email = Requisicao::checkEmail(Requisicao::post('femail'));
	$senha = md5(Requisicao::post('fsenha'));
	
	$c = $cDados->login($email, $senha);
	
	if ($c) {
		$cDados->setCoordenador($c);
		$cDados->atualizarDataLogin();
		
		$arrayValida['r'] = 't';
		$arrayValida['m'] = 'Login efetuado com sucesso';
		$arrayValida['c'] = null;
	} else {
		$arrayValida['r'] = 'f';
		$arrayValida['m'] = 'Usuário inválido';
		$arrayValida['c'] = 'fra';
	}
}

header('Content-type:application/json; charset='.CODING);
echo '{"r":"'.$arrayValida['r'].'", "m":"'.$arrayValida['m'].'", "c":"'.$arrayValida['c'].'"}';
?>