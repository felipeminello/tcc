<?
$pDados = new ProfessorDados();
$p = new Professor();

$arrayValida = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$arrayPost = Requisicao::checkString($_POST);
	
	$p->receberFormulario($arrayPost);
	
	$arrayValida = $p->validarCadastroTurma($arrayPost);
	
	if ($arrayValida['r'] === true) {
		$ins = $pDados->inserirTurma($arrayPost['id_professor'], $arrayPost['id_turma']);
		
		if ($ins) {
			$arrayValida['r'] = 't';
			$arrayValida['m'] = 'Professor cadastrado na turma com sucesso';
			$arrayValida['c'] = null;
		} else {
			$arrayValida['r'] = 'f';
			$arrayValida['m'] = 'Erro ao cadastrar o professor na turma';
			$arrayValida['c'] = null;
		}
	} else {
		$arrayValida['r'] = 'f';
	}
}

header('Content-type:application/json; charset='.CODING);
echo '{"r":"'.$arrayValida['r'].'", "m":"'.$arrayValida['m'].'", "c":"'.$arrayValida['c'].'"}';
?>