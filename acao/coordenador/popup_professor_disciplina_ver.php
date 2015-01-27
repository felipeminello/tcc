<?php
$pVisao = new ProfessorVisao();
$pDados = new ProfessorDados();

$idProfessor = (isset($arrayUrl[2])) ? Requisicao::checkInt($arrayUrl[2]) : 0;

$p = $pDados->selecionar($idProfessor);
$pVisao->setProfessor($p);

$arrayProfessorDisciplina = $pDados->listarDisciplina($idProfessor);

$arrayValida = array('r' => null, 'm' => null);

$conteudo = $pVisao->tabelaDisciplina($arrayProfessorDisciplina);

echo $conteudo;
?>