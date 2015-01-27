<?php
$aVisao = new AlunoVisao('Home');
$aDados = new AlunoDados();

$a = $aDados->selecionar($_SESSION['aluno']['id']);
$aVisao->setAluno($a);

$menuAdmin = $aVisao->menuAdmin('inicio');

$conteudo = $aVisao->geraCabecalho($a, null, null, $menuAdmin);
$conteudo .= $aVisao->dashboard();
$conteudo .= $aVisao->geraRodape();

$aVisao->geraHeaderHtml();
$aVisao->geraFooterHtml();
$aVisao->setCorpo($conteudo);

echo $aVisao->saida();
?>