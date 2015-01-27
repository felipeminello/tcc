<?
$cVisao = new CoordenadorVisao('Logout');
$c = new Coordenador();

$c->logout();

$conteudo = $cVisao->mensagemLogout();

$cVisao->geraHeaderHtml();
$cVisao->geraFooterHtml();
$cVisao->setCorpo($conteudo);

echo $cVisao->saida();
?>