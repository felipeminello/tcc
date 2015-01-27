<?
$atDados = new AlunoTurmaDados();
$at = new AlunoTurma();

$idAlunoTurma = Requisicao::checkInt(Requisicao::post('id_at'));

$arrayValida = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$del = $atDados->excluir($idAlunoTurma);
		
	if ($del) {
		$arrayValida['r'] = 't';
		$arrayValida['m'] = 'Aluno exclu�do da turma';
		$arrayValida['c'] = null;
	} else {
		$arrayValida['r'] = 'f';
		$arrayValida['m'] = 'N�o � poss�vel remover o aluno dessa turma. Verifique depend�ncias';
		$arrayValida['c'] = null;
	}
}

header('Content-type:application/json; charset='.CODING);
echo '{"r":"'.$arrayValida['r'].'", "m":"'.$arrayValida['m'].'", "c":"'.$arrayValida['c'].'"}';
?>