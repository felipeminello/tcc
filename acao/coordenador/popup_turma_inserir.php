<?php
$tVisao = new TurmaVisao('Inserir Turma');
$cDados = new CursoDados();
$t = new Turma();

$idCurso = (isset($arrayUrl[2])) ? Requisicao::checkInt($arrayUrl[2]) : 0;

$t->__set('Curso', new Curso($idCurso));

$tVisao->setTurma($t);

$arrayValida = array('r' => null, 'm' => null);

$arrayCurso = $cDados->listarTodos();

$conteudo = $tVisao->cadastro($arrayCurso, $arrayValida);
$conteudo .= $tVisao->scriptCadastroAjax();

/*
$tVisao->geraHeaderHtml();
$tVisao->geraFooterHtml();
$tVisao->setCorpo($conteudo);
*/


echo $conteudo;
?>