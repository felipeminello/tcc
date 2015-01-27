<?php
$cVisao = new CoordenadorVisao('Meus dados');
$cDados = new CoordenadorDados();

$c = $cDados->selecionar($_SESSION['coordenador']['id']);

$arrayValida = array('r' => null, 'm' => null);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$arrayPost = Requisicao::checkString($_POST);
	
	$arrayValida = $c->validarCadastro($arrayPost);
	$c->__set('id', $_SESSION['coordenador']['id']);
	
	
	
	if ($arrayValida['r']) {
		if ($cDados->atualizar($c)) {
			$arrayValida['m'] = 'Dados atualizados com sucesso';
		} else {
			$arrayValida['r'] = false;
			$arrayValida['m'] = 'Erro ao atualizar dados';
		}
	}
}

$cVisao->setCoordenador($c);

$menuAdmin = $cVisao->menuAdmin();

$conteudo = $cVisao->geraCabecalho(null, null, $c, $menuAdmin);
$conteudo .= $cVisao->perfil($arrayValida);
// $conteudo .= $cVisao->cadastroFoto($arrayValida);
$conteudo .= $cVisao->geraRodape();

$cVisao->addScript(DIR_WWW.'js/fancybox/jquery.fancybox.pack.js?v=2.1.5');
$cVisao->addCSS(DIR_WWW.'js/fancybox/jquery.fancybox.css?v=2.1.5');

$cVisao->geraHeaderHtml();
$cVisao->geraFooterHtml();
$cVisao->setCorpo($conteudo);

echo $cVisao->saida();
?>