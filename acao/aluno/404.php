<?php
$gVisao = new GeralVisao('Página não encontrada');
$aVisao = new AlunoVisao();
$aDados = new AlunoDados();

$a = $aDados->selecionar($_SESSION['aluno']['id']);

$menuAdmin = $aVisao->menuAdmin();

$conteudo = $gVisao->geraCabecalho($a, null, null, $menuAdmin);
$conteudo .= $gVisao->pagina404();
$conteudo .= $gVisao->geraRodape();

$gVisao->geraHeaderHtml();
$gVisao->geraFooterHtml();
$gVisao->setCorpo($conteudo);

echo $gVisao->saida();
?>