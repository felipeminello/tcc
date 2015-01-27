<?php
$aVisao = new AlunoVisao();
$aDados = new AlunoDados();

$idTurma = (isset($_POST['id_turma'])) ? Requisicao::checkInt($_POST['id_turma']) : 0;
$idCurso =(isset($_POST['id_curso'])) ? Requisicao::checkInt($_POST['id_curso']) : 0;

$arrayAluno = $aDados->listar($idCurso, $idTurma);

$conteudo = $aVisao->tabelaAlunos($arrayAluno, $idCurso, $idTurma);

echo $conteudo;
?>