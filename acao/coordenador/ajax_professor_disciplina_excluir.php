<?
$pDados = new ProfessorDados();

$idDisciplina = Requisicao::checkInt(Requisicao::post('id_disciplina'));
$idProfessor = Requisicao::checkInt(Requisicao::post('id_professor'));

$arrayValida = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$del = $pDados->excluirProfessorDisciplina($idProfessor, $idDisciplina);
		
	if ($del) {
		$arrayValida['r'] = 't';
		$arrayValida['m'] = 'Professor exclu�do da disciplina';
		$arrayValida['c'] = null;
	} else {
		$arrayValida['r'] = 'f';
		$arrayValida['m'] = 'N�o � poss�vel remover o professor dessa disciplina. Verifique depend�ncias';
		$arrayValida['c'] = null;
	}
}

header('Content-type:application/json; charset='.CODING);
echo '{"r":"'.$arrayValida['r'].'", "m":"'.$arrayValida['m'].'", "c":"'.$arrayValida['c'].'"}';
?>