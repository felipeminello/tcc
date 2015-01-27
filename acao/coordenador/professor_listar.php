<?php
$pVisao = new ProfessorVisao('Listar Professores');
$cVisao = new CoordenadorVisao();
$cDados = new CoordenadorDados();
$pDados = new ProfessorDados();
$cuDados = new CursoDados();

$c = $cDados->selecionar($_SESSION['coordenador']['id']);
$menuAdmin = $cVisao->menuAdmin('professor');

$idCurso = (isset($arrayUrl[2])) ? Requisicao::checkInt($arrayUrl[2]) : 0;
$idTurma = (isset($arrayUrl[3])) ? Requisicao::checkInt($arrayUrl[3]) : 0;


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$arrayIdProfessor = Requisicao::checkInt(Requisicao::post('apagar'));
	
	$pDados->excluirLote($arrayIdProfessor);
}

$arrayCurso = $cuDados->listarTodos();
$arrayProfessor = $pDados->listar($idCurso, $idTurma);

$conteudo = $pVisao->geraCabecalho(null, null, $c, $menuAdmin);
$conteudo .= $pVisao->listar($arrayCurso, $arrayProfessor, $idCurso, $idTurma);
$conteudo .= $pVisao->geraRodape();

$pVisao->addScript(DIR_WWW.'js/jquery.mousewheel.min.js');
$pVisao->addScript(DIR_WWW.'js/fancybox/jquery.fancybox.pack.js?v=2.1.5');
$pVisao->addScript(DIR_WWW.'js/jquery-ui/jquery-ui.min.js');
$pVisao->addScript(DIR_WWW.'js/jquery-ui/jquery.ui.datepicker-pt-BR.js');

$pVisao->addCSS(DIR_WWW.'js/jquery-ui/jquery-ui.min.css');
$pVisao->addCSS(DIR_WWW.'js/fancybox/jquery.fancybox.css?v=2.1.5');

$pVisao->geraHeaderHtml();
$pVisao->geraFooterHtml();
$pVisao->setCorpo($conteudo);

echo $pVisao->saida();
?>