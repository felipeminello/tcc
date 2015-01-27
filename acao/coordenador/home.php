<?php
/*
require DIR_ACAO.'password.php';

echo password_hash('teste');
*/
$cVisao = new CoordenadorVisao('Home');
$cDados = new CoordenadorDados();
$cuDados = new CursoDados();
$mDados = new MensagemDados();
$tDados = new TurmaDados();
$pDados = new ProfessorDados();
$aDados = new AlunoDados();

$c = $cDados->selecionar($_SESSION['coordenador']['id']);
$cVisao->setCoordenador($c);

$menuAdmin = $cVisao->menuAdmin('inicio');

$arrayCurso = $cuDados->listarArrayTodos();

$totalMensagem = $mDados->totalCoordenadorData($_SESSION['coordenador']['id'], date('Y-m-d'));
$totalTurma = $tDados->total();
$totalProfessor = $pDados->total();
$totalAluno = $aDados->total();

$conteudo = $cVisao->geraCabecalho(null, null, $c, $menuAdmin);
$conteudo .= $cVisao->dashboard($arrayCurso, $totalMensagem, $totalTurma, $totalProfessor, $totalAluno);
$conteudo .= $cVisao->geraRodape();

$cVisao->addScript(DIR_WWW.'js/highcharts/highcharts.js');
$cVisao->addScript(DIR_WWW.'js/highcharts/modules/data.js');
$cVisao->addScript(DIR_WWW.'js/highcharts/modules/exporting.js');

$cVisao->geraHeaderHtml();
$cVisao->geraFooterHtml();
$cVisao->setCorpo($conteudo);

echo $cVisao->saida();
?>