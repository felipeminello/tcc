<?
$tDados = new TurmaDados();
$t = new Turma();

$arrayValida = array();
$nomeTurma = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$arrayPost = Requisicao::checkString($_POST);
	
	$arrayValida = $t->validarCadastro($arrayPost);
	
	if ($arrayValida['r'] === false) {
		$arrayValida['r'] = 'f';
	}
	
	if ($arrayValida['r'] === true) {
		$ins = $tDados->inserir($t);
		
		if ($ins) {
			$arrayValida['r'] = 't';
			$arrayValida['m'] = 'Turma inserida com sucesso';
			$nomeTurma = $t->__get('nome');
			$arrayValida['c'] = null;
		} else {
			$arrayValida['r'] = 'f';
			$arrayValida['m'] = 'Erro ao inserir turma';
			$arrayValida['c'] = null;
		}
	}
}

header('Content-type:application/json; charset='.CODING);
echo '{"r":"'.$arrayValida['r'].'", "m":"'.$arrayValida['m'].'", "c":"'.$arrayValida['c'].'", "nome":"'.$nomeTurma.'"}';
?>