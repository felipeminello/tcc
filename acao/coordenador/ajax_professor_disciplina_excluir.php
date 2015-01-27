<?
$pDados = new ProfessorDados();

$idDisciplina = Requisicao::checkInt(Requisicao::post('id_disciplina'));
$idProfessor = Requisicao::checkInt(Requisicao::post('id_professor'));

$arrayValida = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$del = $pDados->excluirProfessorDisciplina($idProfessor, $idDisciplina);
		
	if ($del) {
		$arrayValida['r'] = 't';
		$arrayValida['m'] = 'Professor excluído da disciplina';
		$arrayValida['c'] = null;
	} else {
		$arrayValida['r'] = 'f';
		$arrayValida['m'] = 'Não é possível remover o professor dessa disciplina. Verifique dependências';
		$arrayValida['c'] = null;
	}
}

header('Content-type:application/json; charset='.CODING);
echo '{"r":"'.$arrayValida['r'].'", "m":"'.$arrayValida['m'].'", "c":"'.$arrayValida['c'].'"}';
?>