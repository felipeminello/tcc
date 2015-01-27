<?
header('Content-type: text/html; charset='.CODING);

$dDados = new DisciplinaDados();

$idCurso = (isset($arrayUrl[2])) ? Requisicao::checkInt($arrayUrl[2]) : 0;
$idDisciplina = (isset($arrayUrl[3])) ? Requisicao::checkInt($arrayUrl[3]) : 0;

if (!empty($idCurso)) {
	$arrayDisciplina = $dDados->listarPorCurso($idCurso);
	$countDisciplina = count($arrayDisciplina);
	
	if ($countDisciplina <= 0) {
		$str = '<option value="0">Nenhuma disciplina disponível</option>';
	} else {
		$str = '<option value="0">Selecione a disciplina</option>';
		
		foreach ($arrayDisciplina as $d) {
			$check = ($idDisciplina == $d->__get('id')) ? 'selected="selected"' : '';
			$str .= '<option value="'.$d->__get('id').'" '.$check.'>'.$d->__get('nome').'</option>';
		}
	}
} else {
	$str = '<option value="0">Selecione o curso</option>';
}

echo $str;
?>