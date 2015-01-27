<?php
$nVisao = new NotaVisao();
$nDados = new NotaDados();
$dDados = new DisciplinaDados();

$idTurma = (isset($_POST['id_turma'])) ? Requisicao::checkInt($_POST['id_turma']) : 0;
$idAluno = $_SESSION['aluno']['id'];

if ($idTurma > 0) {
	$arrayNotas = $nDados->listarPorAlunoTurma($idAluno, $idTurma);
	$arrayDisciplina = $dDados->listarPorTurma($idTurma);
	
	$arrayFalta = array();
	
	$conteudo = $nVisao->tabelaNotas($arrayNotas, $arrayFalta);
	$conteudo .= $nVisao->graficoNotas($arrayDisciplina);
} else {
	$conteudo = $nVisao->alertaTurma();
}

echo $conteudo;
?>