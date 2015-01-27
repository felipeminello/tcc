<?php
$cVisao = new CoordenadorVisao('Área do Coordenador');

$conteudo = $cVisao->corpoLogin();

$cVisao->addCSS(DIR_WWW.'css/estilo.css');
$cVisao->addCSS(DIR_WWW.'js/fancybox/jquery.fancybox.css?v=2.1.5');
$cVisao->addScript(DIR_WWW.'js/fancybox/jquery.fancybox.pack.js?v=2.1.5');

$cVisao->geraHeaderHtml();
$cVisao->geraFooterHtml();
$cVisao->setCorpo($conteudo);

echo $cVisao->saida();
?>
