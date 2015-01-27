<?
header('Content-type: text/html; charset='.CODING);

$dDados = new DisciplinaDados();

$idCurso = (isset($arrayUrl[2])) ? Requisicao::checkInt($arrayUrl[2]) : 0;
$idProfessor = (isset($arrayUrl[3])) ? Requisicao::checkInt($arrayUrl[3]) : 0;
$idDisciplina = (isset($arrayUrl[4])) ? Requisicao::checkInt($arrayUrl[4]) : 0;

if (!empty($idCurso) and !empty($idProfessor)) {
	$arrayDisciplina = $dDados->listarPorCursoProfessor($idCurso, $idProfessor);
	$countDisciplina = count($arrayDisciplina);
	
	if ($countDisciplina <= 0) {
		$str = '<option value="0">Nenhuma disciplina disponível</option>';
	} else {
		$str = '<option value="0">Selecione a disciplina</option>';
		
		foreach ($arrayDisciplina as $t) {
			$check = ($idDisciplina == $t->__get('id')) ? 'selected="selected"' : '';
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