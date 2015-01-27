<?php
$pVisao = new ProfessorVisao();
$cDados = new CursoDados();
$pDados = new ProfessorDados();

$idProfessor = (isset($arrayUrl[2])) ? Requisicao::checkInt($arrayUrl[2]) : 0;

$p = $pDados->selecionar($idProfessor);
$pVisao->setProfessor($p);

$arrayCurso = $cDados->listarTodos();

$arrayValida = array('r' => null, 'm' => null);

$conteudo = $pVisao->inserirDisciplina($arrayCurso);

echo $conteudo;
?>