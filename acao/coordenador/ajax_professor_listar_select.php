<?php
$pVisao = new ProfessorVisao();
$pDados = new ProfessorDados();

$idCurso = (isset($arrayUrl[2])) ? Requisicao::checkInt($arrayUrl[2]) : 0;
$idTurma = (isset($arrayUrl[3])) ? Requisicao::checkInt($arrayUrl[3]) : 0;
$idProfessor = (isset($arrayUrl[4])) ? Requisicao::checkInt($arrayUrl[4]) : 0;

$arrayProfessor = $pDados->listar($idCurso, $idTurma);

$array = array();
$array[0] = 'Selecione o professor';

foreach ($arrayProfessor as $p) {
	$array[$p->__get('id')] = $p->__get('nome'); 
}

echo Elementos::popularSelect($array, $idProfessor);
?>