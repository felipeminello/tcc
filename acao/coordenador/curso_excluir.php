<?php
$cuVisao = new CursoVisao('Excluir Curso');
$cDados = new CoordenadorDados();
$cVisao = new CoordenadorVisao();
$cuDados = new CursoDados();

$idCurso = (isset($arrayUrl[2])) ? Requisicao::checkInt($arrayUrl[2]) : 0;

$c = $cDados->selecionar($_SESSION['coordenador']['id']);
$cVisao->setCoordenador($c);
$menuAdmin = $cVisao->menuAdmin('curso');

$arrayValida = array('r' => null, 'm' => null);

if (!empty($idCurso)) {
	$del = $cuDados->excluir($idCurso);
	if ($del) {
		$arrayValida['r'] = true;
		$arrayValida['m'] = 'Curso excluído com sucesso';
	} else {
		$arrayValida['r'] = false;
		$arrayValida['m'] = 'Erro ao excluir o curso';
	}
}

$conteudo = $cuVisao->geraCabecalho(null, null, $c, $menuAdmin);
$conteudo .= $cuVisao->excluir($arrayValida);
$conteudo .= $cuVisao->geraRodape();

$cuVisao->geraHeaderHtml();
$cuVisao->geraFooterHtml();
$cuVisao->setCorpo($conteudo);

echo $cuVisao->saida();
?>