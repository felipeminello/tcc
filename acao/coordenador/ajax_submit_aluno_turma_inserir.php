<?
$atDados = new AlunoTurmaDados();
$at = new AlunoTurma();

$arrayValida = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$arrayPost = Requisicao::checkString($_POST);
	
	$at->receberFormulario($arrayPost);
	
	$arrayValida = $at->validarCadastro();
	
	if (empty($arrayPost['id_curso'])) {
		$arrayValida['r'] = false;
		$arrayValida['c'] = 'curso';
		$arrayValida['m'] = 'Por favor, selecione o <strong>Curso</strong>';
	}
	
	if ($arrayValida['r'] === true) {
		$ins = $atDados->inserir($at);
		
		if ($ins) {
			$arrayValida['r'] = 't';
			$arrayValida['m'] = 'Aluno cadastrado com sucesso';
			$arrayValida['c'] = null;
		} else {
			$arrayValida['r'] = 'f';
			$arrayValida['m'] = 'Erro ao cadastrar aluno';
			$arrayValida['c'] = null;
		}
	} else {
		$arrayValida['r'] = 'f';
	}
}

header('Content-type:application/json; charset='.CODING);
echo '{"r":"'.$arrayValida['r'].'", "m":"'.$arrayValida['m'].'", "c":"'.$arrayValida['c'].'"}';
?>