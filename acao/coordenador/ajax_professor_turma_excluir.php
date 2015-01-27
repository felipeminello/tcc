<?
$pDados = new ProfessorDados();

$idTurma = Requisicao::checkInt(Requisicao::post('id_turma'));
$idProfessor = Requisicao::checkInt(Requisicao::post('id_professor'));

$arrayValida = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$del = $pDados->excluirProfessorTurma($idProfessor, $idTurma);
		
	if ($del) {
		$arrayValida['r'] = 't';
		$arrayValida['m'] = 'Professor exclu�do da turma';
		$arrayValida['c'] = null;
	} else {
		$arrayValida['r'] = 'f';
		$arrayValida['m'] = 'N�o � poss�vel remover o professor dessa turma. Verifique depend�ncias';
		$arrayValida['c'] = null;
	}
}

header('Content-type:application/json; charset='.CODING);
echo '{"r":"'.$arrayValida['r'].'", "m":"'.$arrayValida['m'].'", "c":"'.$arrayValida['c'].'"}';
?>