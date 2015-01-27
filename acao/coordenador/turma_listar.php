<?php
$tVisao = new TurmaVisao('Listar Turmas');
$aDados = new AlunoDados();
$cDados = new CoordenadorDados();
$cVisao = new CoordenadorVisao();
$tDados = new TurmaDados();
$cuDados = new CursoDados();
$pDados = new ProfessorDados();
$t = new Turma();

$c = $cDados->selecionar($_SESSION['coordenador']['id']);
$menuAdmin = $cVisao->menuAdmin('turma');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$arrayIdTurma = Requisicao::checkInt(Requisicao::post('apagar'));
	
	$tDados->excluirLote($arrayIdTurma);
}


$arrayCurso = $cuDados->listarTodos();
$arrayPeriodo = $t->__get('arrayPeriodo');
$arrayTurma = $tDados->listar();
$arrayTotalAluno = $aDados->quantidadePorTurma();
$arrayTotalProfessor = $pDados->quantidadePorTurma();

$conteudo = $tVisao->geraCabecalho(null, null, $c, $menuAdmin);
$conteudo .= $tVisao->listar($arrayCurso, $arrayPeriodo, $arrayTurma, $arrayTotalAluno, $arrayTotalProfessor);
$conteudo .= $tVisao->geraRodape();

$tVisao->addScript(DIR_WWW.'js/jquery.mousewheel.min.js');
$tVisao->addScript(DIR_WWW.'js/fancybox/jquery.fancybox.pack.js?v=2.1.5');
$tVisao->addScript(DIR_WWW.'js/jquery-ui/jquery-ui.min.js');
$tVisao->addScript(DIR_WWW.'js/jquery-ui/jquery.ui.datepicker-pt-BR.js');

$tVisao->addCSS(DIR_WWW.'js/jquery-ui/jquery-ui.min.css');
$tVisao->addCSS(DIR_WWW.'js/fancybox/jquery.fancybox.css?v=2.1.5');

$tVisao->geraHeaderHtml();
$tVisao->geraFooterHtml();
$tVisao->setCorpo($conteudo);

echo $tVisao->saida();
?>