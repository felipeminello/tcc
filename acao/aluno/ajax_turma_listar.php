<?
header('Content-type: text/html; charset='.CODING);

$tDados = new TurmaDados();

$idCurso = (isset($arrayUrl[2])) ? Requisicao::checkInt($arrayUrl[2]) : 0;

if (!empty($idCurso)) {
	$arrayTurma = $tDados->listarPorCurso($idCurso);
	$countTurma = count($arrayTurma);
	
	if ($countTurma <= 0) {
		$str = '<option value="0">Nenhuma turma disponível</option>';
	} else {
		$str = '<option value="0">Selecione a turma</option>';
		
		foreach ($arrayTurma as $t) {
			$str .= '<option value="'.$t->__get('id').'">'.$t->__get('nome').'</option>';
		}
	}
} else {
	$str = '<option value="0">Selecione o curso</option>';
}

echo $str;
?>