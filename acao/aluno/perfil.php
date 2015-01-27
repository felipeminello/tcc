<?php
$aVisao = new AlunoVisao('Meus dados');
$aDados = new AlunoDados();

$a = $aDados->selecionar($_SESSION['aluno']['id']);
$aVisao->setAluno($a);

$menuAdmin = $aVisao->menuAdmin();

$conteudo = $aVisao->geraCabecalho($a, null, null, $menuAdmin);
$conteudo .= $aVisao->perfil();
$conteudo .= $aVisao->geraRodape();

$aVisao->addScript(DIR_WWW.'js/photobooth_min.js');
$aVisao->geraHeaderHtml();
$aVisao->geraFooterHtml();
$aVisao->setCorpo($conteudo);

echo $aVisao->saida();
?>