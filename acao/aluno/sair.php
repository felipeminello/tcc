<?
$aVisao = new AlunoVisao('Logout');
$a = new Aluno();

$a->logout();

$conteudo = $aVisao->mensagemLogout();

$aVisao->geraHeaderHtml();
$aVisao->geraFooterHtml();
$aVisao->setCorpo($conteudo);

echo $aVisao->saida();
?>