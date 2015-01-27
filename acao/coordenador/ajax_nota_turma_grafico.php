<?php
$nVisao = new NotaVisao();
$nDados = new NotaDados();
$dDados = new DisciplinaDados();
$aDados = new AlunoDados();
$n = new Nota();

$nVisao->setNota($n);

$idTurma = (isset($arrayUrl[2])) ? Requisicao::checkInt($arrayUrl[2]) : 0;
$idDisciplina = (isset($arrayUrl[3])) ? Requisicao::checkInt($arrayUrl[3]) : 0;

if ($idTurma > 0 and $idDisciplina > 0) {
	$arrayNotas = $nDados->listarPorTurma($idTurma, $idDisciplina);
	$arrayAluno = $aDados->listarPorTurma($idTurma);
	
	$d = $dDados->selecionar($idDisciplina);
	
	$conteudo = $nVisao->graficoNotasTurma($arrayNotas, $arrayAluno, $d);
} else {
	if (empty($idTurma))
		$conteudo = $nVisao->alertaTurma();
	elseif (empty($idDisciplina))
		$conteudo = $nVisao->alertaDisciplina();
}

echo $conteudo;
?>