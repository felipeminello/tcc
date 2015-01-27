<?
$pDados = new ProfessorDados();

$idTurma = Requisicao::checkInt(Requisicao::post('id_turma'));
$idProfessor = Requisicao::checkInt(Requisicao::post('id_professor'));

$arrayValida = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$del = $pDados->excluirProfessorTurma($idProfessor, $idTurma);
		
	if ($del) {
		$arrayValida['r'] = 't';
		$arrayValida['m'] = 'Professor excluído da turma';
		$arrayValida['c'] = null;
	} else {
		$arrayValida['r'] = 'f';
		$arrayValida['m'] = 'Não é possível remover o professor dessa turma. Verifique dependências';
		$arrayValida['c'] = null;
	}
}

header('Content-type:application/json; charset='.CODING);
echo '{"r":"'.$arrayValida['r'].'", "m":"'.$arrayValida['m'].'", "c":"'.$arrayValida['c'].'"}';
?>