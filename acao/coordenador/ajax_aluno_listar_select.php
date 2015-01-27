<?php
$aVisao = new AlunoVisao();
$aDados = new AlunoDados();

$idCurso = (isset($arrayUrl[2])) ? Requisicao::checkInt($arrayUrl[2]) : 0;
$idTurma = (isset($arrayUrl[3])) ? Requisicao::checkInt($arrayUrl[3]) : 0;
$idAluno = (isset($arrayUrl[4])) ? Requisicao::checkInt($arrayUrl[4]) : 0;

$arrayAluno = $aDados->listar($idCurso, $idTurma);

$array = array();
$array[0] = 'Selecione o aluno';

foreach ($arrayAluno as $a) {
	$array[$a->__get('id')] = $a->__get('nome'); 
}

echo Elementos::popularSelect($array, $idAluno);
?>