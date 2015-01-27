<?php
$nVisao = new NotaVisao('Notas e Faltas');
$aVisao = new AlunoVisao();
$aDados = new AlunoDados();
$cDados = new CursoDados();

$a = $aDados->selecionar($_SESSION['aluno']['id']);

$menuAdmin = $aVisao->menuAdmin('notas-e-faltas');

$arrayCurso = $cDados->listarPorAluno($_SESSION['aluno']['id']);

$conteudo = $nVisao->geraCabecalho($a, null, null, $menuAdmin);
$conteudo .= $nVisao->home($arrayCurso);
$conteudo .= $nVisao->geraRodape();

$nVisao->addScript(DIR_WWW.'js/highcharts/highcharts.js');
$nVisao->addScript(DIR_WWW.'js/highcharts/modules/data.js');
$nVisao->addScript(DIR_WWW.'js/highcharts/modules/exporting.js');

$nVisao->geraHeaderHtml();
$nVisao->geraFooterHtml();
$nVisao->setCorpo($conteudo);

echo $nVisao->saida();
?>