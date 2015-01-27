<?
$tDados = new TurmaDados();
$cVisao = new CursoVisao();
$cDados = new CursoDados();
$aDados = new AlunoDados();
$pDados = new ProfessorDados();

$idCurso = (isset($arrayUrl[2])) ? Requisicao::checkInt($arrayUrl[2]) : 0;

$c = $cDados->selecionar($idCurso);
$cVisao->setCurso($c);

$arrayTurma = $tDados->listarPorCurso($idCurso);
$arrayAluno = $aDados->listarPorCurso($idCurso);
$arrayProfessor = $pDados->listarPorCurso($idCurso);


$conteudo = $cVisao->infoListar($arrayTurma, $arrayAluno, $arrayProfessor);

echo $conteudo;
?>