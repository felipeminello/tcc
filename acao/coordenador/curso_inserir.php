<?php
$cuVisao = new CursoVisao('Inserir Curso');
$cDados = new CoordenadorDados();
$cVisao = new CoordenadorVisao();
$cuDados = new CursoDados();

$arrayValida = array('r' => null, 'm' => null);

$c = $cDados->selecionar($_SESSION['coordenador']['id']);
$cVisao->setCoordenador($c);
$menuAdmin = $cVisao->menuAdmin('curso');

$cu = new Curso();
$cuVisao->setCurso($cu);


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$arrayPost = Requisicao::checkString($_POST);
	
	$arrayValida = $cu->validarCadastro($arrayPost);
	
	if ($arrayValida['r']) {
		$res = $cuDados->inserir($cu);

		if ($res) {
			$arrayValida['r'] = true;
			$arrayValida['m'] = 'Curso inserido com sucesso';
		} else {
			$arrayValida['r'] = false;
			$arrayValida['m'] = 'Erro ao inserir Curso';
		}
	}
}

$conteudo = $cuVisao->geraCabecalho(null, null, $c, $menuAdmin);
$conteudo .= $cuVisao->cadastro($arrayValida, DIR_ROOT_COORDENADOR.$arrayUrl[1]);
$conteudo .= $cuVisao->geraRodape();

$cuVisao->geraHeaderHtml();
$cuVisao->geraFooterHtml();
$cuVisao->setCorpo($conteudo);

echo $cuVisao->saida();
?>