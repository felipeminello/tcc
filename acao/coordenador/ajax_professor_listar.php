<?php
$pVisao = new ProfessorVisao();
$pDados = new ProfessorDados();

$idTurma = (isset($_POST['id_turma'])) ? Requisicao::checkInt($_POST['id_turma']) : 0;
$idCurso =(isset($_POST['id_curso'])) ? Requisicao::checkInt($_POST['id_curso']) : 0;

$arrayProfessor = $pDados->listar($idCurso, $idTurma);

$conteudo = $pVisao->tabelaProfessores($arrayProfessor, $idCurso, $idTurma);

echo $conteudo;
?>