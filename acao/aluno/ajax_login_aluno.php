<?
$aDados = new AlunoDados();

$arrayValida = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$ra = Requisicao::post('fra');
	$senha = Requisicao::post('fsenha');
	
	$a = $aDados->login($ra, $senha);
	
	if ($a) {
		$aDados->setAluno($a);
		$aDados->atualizarDataLogin();
		
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