<?php
$dVisao = new DisciplinaVisao();
$dDados = new DisciplinaDados();

$idCurso =(isset($_POST['id_curso'])) ? Requisicao::checkInt($_POST['id_curso']) : 0;

$arrayDisciplina = $dDados->listar($idCurso);

$conteudo = $dVisao->tabelaDisciplinas($arrayDisciplina, $idCurso);

echo $conteudo;
?>