<?php
$pVisao = new ProfessorVisao();
$pDados = new ProfessorDados();

$idProfessor = (isset($arrayUrl[2])) ? Requisicao::checkInt($arrayUrl[2]) : 0;

$p = $pDados->selecionar($idProfessor);
$pVisao->setProfessor($p);

$arrayProfessorTurma = $pDados->listarTurmas($idProfessor);

$arrayValida = array('r' => null, 'm' => null);

$conteudo = $pVisao->tabelaTurmas($arrayProfessorTurma);

echo $conteudo;
?>