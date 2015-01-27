<?php
$gVisao = new GeralVisao('Página não encontrada');
$cVisao = new CoordenadorVisao();
$cDados = new CoordenadorDados();

$c = $cDados->selecionar($_SESSION['coordenador']['id']);

$menuAdmin = $cVisao->menuAdmin();

$conteudo = $gVisao->geraCabecalho(null, null, $c, $menuAdmin);
$conteudo .= $gVisao->pagina404();
$conteudo .= $gVisao->geraRodape();

$gVisao->geraHeaderHtml();
$gVisao->geraFooterHtml();
$gVisao->setCorpo($conteudo);

echo $gVisao->saida();
?>