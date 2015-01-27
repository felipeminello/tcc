<?php
$chVisao = new ChamadaVisao('Ver chamada');
$cVisao = new CoordenadorVisao();
$cDados = new CoordenadorDados();
$chDados = new ChamadaDados();
$cuDados = new CursoDados();

$idCurso = (isset($arrayUrl[2])) ? Requisicao::checkInt($arrayUrl[2]) : 0;
$idTurma = (isset($arrayUrl[3])) ? Requisicao::checkInt($arrayUrl[3]) : 0;
$idDisciplina = (isset($arrayUrl[4])) ? Requisicao::checkInt($arrayUrl[4]) : 0;

$c = $cDados->selecionar($_SESSION['coordenador']['id']);
$menuAdmin = $cVisao->menuAdmin('chamada');

$arrayCurso = $cuDados->listarTodos();

$conteudo = $chVisao->geraCabecalho(null, null, $c, $menuAdmin);
$conteudo .= $chVisao->listar($arrayCurso, array(), $idCurso, $idTurma, $idDisciplina);
$conteudo .= $chVisao->geraRodape();

$chVisao->addScript(DIR_WWW.'js/jquery-ui/jquery-ui.min.js');
$chVisao->addScript(DIR_WWW.'js/jquery-ui/jquery.ui.datepicker-pt-BR.js');

$chVisao->addCSS(DIR_WWW.'js/jquery-ui/jquery-ui.min.css');

$chVisao->geraHeaderHtml();
$chVisao->geraFooterHtml();
$chVisao->setCorpo($conteudo);

echo $chVisao->saida();
?>