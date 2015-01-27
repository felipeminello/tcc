<?
$pDados = new ProfessorDados();
$p = new Professor();

$arrayValida = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$arrayPost = Requisicao::checkString($_POST);
	
	$p->receberFormulario($arrayPost);
	
	$arrayValida = $p->validarCadastroDisciplina($arrayPost);
	
	if ($arrayValida['r'] === true) {
		$ins = $pDados->inserirDisciplina($arrayPost['id_professor'], $arrayPost['id_disciplina']);
		
		if ($ins) {
			$arrayValida['r'] = 't';
			$arrayValida['m'] = 'Professor cadastrado na disciplina com sucesso';
			$arrayValida['c'] = null;
		} else {
			$arrayValida['r'] = 'f';
			$arrayValida['m'] = 'Erro ao cadastrar o professor na disciplina';
			$arrayValida['c'] = null;
		}
	} else {
		$arrayValida['r'] = 'f';
	}
}

header('Content-type:application/json; charset='.CODING);
echo '{"r":"'.$arrayValida['r'].'", "m":"'.$arrayValida['m'].'", "c":"'.$arrayValida['c'].'"}';
?>