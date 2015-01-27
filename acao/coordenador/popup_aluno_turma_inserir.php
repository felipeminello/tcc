<?php
$aVisao = new AlunoVisao();
$cDados = new CursoDados();
$aDados = new AlunoDados();

$idAluno = (isset($arrayUrl[2])) ? Requisicao::checkInt($arrayUrl[2]) : 0;

$a = $aDados->selecionar($idAluno);

$aVisao->setAluno($a);

$arrayCurso = $cDados->listarTodos();

$arrayValida = array('r' => null, 'm' => null);

$conteudo = $aVisao->inserirTurma($arrayCurso);

echo $conteudo;
?>