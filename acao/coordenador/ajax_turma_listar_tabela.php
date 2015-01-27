<?php
$tVisao = new TurmaVisao();
$tDados = new TurmaDados();
$t = new Turma;

$dataInicio = (isset($_POST['data_inicio'])) ? Requisicao::checkData(Requisicao::checkString($_POST['data_inicio']), 2) : 0;
$dataFim = (isset($_POST['data_fim'])) ? Requisicao::checkData(Requisicao::checkString($_POST['data_fim']), 2) : 0;
$periodo =(isset($_POST['periodo'])) ? Requisicao::checkInt($_POST['periodo']) : 0;
$idCurso =(isset($_POST['curso'])) ? Requisicao::checkInt($_POST['curso']) : 0;


$arrayPeriodo = $t->__get('arrayPeriodo');
$arrayTurma = $tDados->listar($idCurso, 0, $dataInicio, $dataFim, $periodo);

$conteudo = $tVisao->tabelaTurmas($arrayTurma, $arrayPeriodo, $idCurso);

echo $conteudo;
?>