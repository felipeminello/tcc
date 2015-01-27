<?php
$cuVisao = new CursoVisao('Editar Curso');
$cDados = new CoordenadorDados();
$cVisao = new CoordenadorVisao();
$cuDados = new CursoDados();

$idCurso = (isset($arrayUrl[2])) ? Requisicao::checkInt($arrayUrl[2]) : 0;

$c = $cDados->selecionar($_SESSION['coordenador']['id']);
$cVisao->setCoordenador($c);
$menuAdmin = $cVisao->menuAdmin('curso');

$cu = $cuDados->selecionar($idCurso);
$cuVisao->setCurso($cu);

$arrayValida = array('r' => null, 'm' => null);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$arrayPost = Requisicao::checkString($_POST);
	
	$arrayValida = $cu->validarCadastro($arrayPost);
	
	if ($arrayValida['r']) {
		$res = $cuDados->atualizar($cu);

		if ($res) {
			$arrayValida['r'] = true;
			$arrayValida['m'] = 'Curso alterado com sucesso';
		} else {
			$arrayValida['r'] = false;
			$arrayValida['m'] = 'Erro ao alterar o curso';
		}
	}
}

$conteudo = $cuVisao->geraCabecalho(null, null, $c, $menuAdmin);
$conteudo .= $cuVisao->cadastro($arrayValida, DIR_ROOT_COORDENADOR.$arrayUrl[1].'/'.$idCurso);
$conteudo .= $cuVisao->geraRodape();

$cuVisao->geraHeaderHtml();
$cuVisao->geraFooterHtml();
$cuVisao->setCorpo($conteudo);

echo $cuVisao->saida();
?>