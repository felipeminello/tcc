<?php
$atVisao = new AlunoTurmaVisao('Visualizar Alunos');
$atDados = new AlunoTurmaDados();
$cVisao = new CoordenadorVisao();
$cDados = new CoordenadorDados();
$cuDados = new CursoDados();
$tDados = new TurmaDados();
$aDados = new AlunoDados();

$idTurma = (isset($arrayUrl[2])) ? Requisicao::checkInt($arrayUrl[2]) : 0;

$c = $cDados->selecionar($_SESSION['coordenador']['id']);
$cVisao->setCoordenador($c);
$menuAdmin = $cVisao->menuAdmin('turma');

$arrayValida = array('r' => null, 'm' => null);

$arrayCurso = $cuDados->listarArrayTodos();

$t = $tDados->selecionar($idTurma);

$arrayAluno = $aDados->listarPorTurma($idTurma);

$conteudo = $atVisao->geraCabecalho(null, null, $c, $menuAdmin);
$conteudo .= $atVisao->visualizarAlunos($arrayCurso, $arrayAluno, $t);
$conteudo .= $atVisao->geraRodape();

$atVisao->addScript(DIR_WWW.'js/jquery-ui/jquery-ui.min.js');
$atVisao->addScript(DIR_WWW.'js/jquery-ui/jquery.ui.datepicker-pt-BR.js');
$atVisao->addCSS(DIR_WWW.'js/jquery-ui/jquery-ui.min.css');

$atVisao->geraHeaderHtml();
$atVisao->geraFooterHtml();
$atVisao->setCorpo($conteudo);

echo $atVisao->saida();
?>