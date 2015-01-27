<?php
$cVisao = new ChamadaVisao();
$cDados = new ChamadaDados();
$dDados = new DisciplinaDados();
$aDados = new AlunoDados();
$tDados = new TurmaDados();
$c = new Chamada();

$cVisao->setChamada($c);

$idTurma = (isset($arrayUrl[2])) ? Requisicao::checkInt($arrayUrl[2]) : 0;
$idDisciplina = (isset($arrayUrl[3])) ? Requisicao::checkInt($arrayUrl[3]) : 0;

if ($idTurma > 0 and $idDisciplina > 0) {
	$arrayChamada = $cDados->listarPorTurmaDisciplina($idTurma, $idDisciplina);
	$arrayAluno = $aDados->listarPorTurma($idTurma);
	
	$d = $dDados->selecionar($idDisciplina);
	$t = $tDados->selecionar($idTurma);
	
	$arrayFalta = $c->calcularFaltas($arrayAluno, $arrayChamada);
	
	$conteudo = $cVisao->graficoChamadaTurma($arrayChamada, $arrayAluno, $d, $t);
} else {
	if (empty($idTurma))
		$conteudo = $cVisao->alertaTurma();
	elseif (empty($idDisciplina))
		$conteudo = $cVisao->alertaDisciplina();
}

echo $conteudo;
?>