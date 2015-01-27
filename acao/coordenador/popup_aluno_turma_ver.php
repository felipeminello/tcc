<?php
$aVisao = new AlunoVisao();
$atDados = new AlunoTurmaDados();
$a = new Aluno();

$idAluno = (isset($arrayUrl[2])) ? Requisicao::checkInt($arrayUrl[2]) : 0;

$arrayAlunoTurma = $atDados->listarPorAluno($idAluno);

$arrayValida = array('r' => null, 'm' => null);

$conteudo = $aVisao->tabelaTurmas($arrayAlunoTurma);

echo $conteudo;
?>