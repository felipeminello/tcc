<?php
$cuVisao = new CursoVisao('Listar Cursos');
$aDados = new AlunoDados();
$cDados = new CoordenadorDados();
$cVisao = new CoordenadorVisao();
$cuDados = new CursoDados();
$tDados = new TurmaDados();
$pDados = new ProfessorDados();

$c = $cDados->selecionar($_SESSION['coordenador']['id']);

$menuAdmin = $cVisao->menuAdmin('curso');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$arrayIdCurso = Requisicao::checkInt(Requisicao::post('apagar'));
	
	$cuDados->excluirLote($arrayIdCurso);
}

$arrayCurso = $cuDados->listarTodos();
$arrayTotalTurma = $tDados->quantidadePorCurso();
$arrayTotalAluno = $aDados->quantidadePorCurso();
$arrayTotalProfessor = $pDados->quantidadePorCurso();

$conteudo = $cuVisao->geraCabecalho(null, null, $c, $menuAdmin);
$conteudo .= $cuVisao->listar($arrayCurso, $arrayTotalTurma, $arrayTotalAluno, $arrayTotalProfessor);
$conteudo .= $cuVisao->geraRodape();

$cuVisao->addScript(DIR_WWW.'js/jquery.mousewheel.min.js');
$cuVisao->addScript(DIR_WWW.'js/fancybox/jquery.fancybox.pack.js?v=2.1.5');
$cuVisao->addScript(DIR_WWW.'js/jquery-ui/jquery-ui.min.js');
$cuVisao->addScript(DIR_WWW.'js/jquery-ui/jquery.ui.datepicker-pt-BR.js');

$cuVisao->addCSS(DIR_WWW.'js/jquery-ui/jquery-ui.min.css');
$cuVisao->addCSS(DIR_WWW.'js/fancybox/jquery.fancybox.css?v=2.1.5');

$cuVisao->geraHeaderHtml();
$cuVisao->geraFooterHtml();
$cuVisao->setCorpo($conteudo);

echo $cuVisao->saida();
?>