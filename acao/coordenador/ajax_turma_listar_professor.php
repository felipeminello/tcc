<?
header('Content-type: text/html; charset='.CODING);

$tDados = new TurmaDados();

$idCurso = (isset($arrayUrl[2])) ? Requisicao::checkInt($arrayUrl[2]) : 0;
$idProfessor = (isset($arrayUrl[3])) ? Requisicao::checkInt($arrayUrl[3]) : 0;
$idTurma = (isset($arrayUrl[4])) ? Requisicao::checkInt($arrayUrl[4]) : 0;

if (!empty($idCurso) and !empty($idProfessor)) {
	$arrayTurma = $tDados->listarPorCursoProfessor($idCurso, $idProfessor);
	$countTurma = count($arrayTurma);
	
	if ($countTurma <= 0) {
		$str = '<option value="0">Nenhuma turma disponível</option>';
	} else {
		$str = '<option value="0">Selecione a turma</option>';
		
		foreach ($arrayTurma as $t) {
			$check = ($idTurma == $t->__get('id')) ? 'selected="selected"' : '';
			$str .= '<option value="'.$t->__get('id').'" '.$check.'>'.$t->__get('nome').'</option>';
		}
	}
} else {
	if (empty($idCurso))
		$str = '<option value="0">Selecione o curso</option>';
	elseif (empty($idProfessor))
		$str = '<option value="0">Selecione o professor</option>';
}

echo $str;
?>