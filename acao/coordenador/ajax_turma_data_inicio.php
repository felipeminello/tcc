<?php
$tDados = new TurmaDados();

$idTurma = (isset($arrayUrl[2])) ? Requisicao::checkInt($arrayUrl[2]) : 0;

$t = $tDados->selecionar($idTurma);

echo $t->__get('dataInicio');
?>