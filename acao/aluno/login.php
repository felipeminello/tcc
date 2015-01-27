<?php
$aVisao = new AlunoVisao('Login');
$aDados = new AlunoDados();

$conteudo = $aVisao->corpoLogin();

$js = $aVisao->scriptLogin();




$aVisao->addCSS(DIR_WWW.'css/estilo.css');
$aVisao->setScript($js);

$aVisao->geraHeaderHtml();
$aVisao->geraFooterHtml();
$aVisao->setCorpo($conteudo);

echo $aVisao->saida();
?>
