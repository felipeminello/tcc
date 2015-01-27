<?php
$pVisao = new ProfessorVisao('Excluir Professor');
$pDados = new ProfessorDados();
$cVisao = new CoordenadorVisao();
$cDados = new CoordenadorDados();
$cuDados = new CursoDados();
$p = new Professor();

$idProfessor = (isset($arrayUrl[2])) ? Requisicao::checkInt($arrayUrl[2]) : 0;

$c = $cDados->selecionar($_SESSION['coordenador']['id']);
$cVisao->setCoordenador($c);
$menuAdmin = $cVisao->menuAdmin('professor');

$arrayValida = array('r' => null, 'm' => null);

if (!empty($idProfessor)) {
	$del = $pDados->excluir($idProfessor);
	if ($del) {
		$arrayValida['r'] = true;
		$arrayValida['m'] = 'Professor excluído com sucesso';
	} else {
		$arrayValida['r'] = false;
		$arrayValida['m'] = 'Erro ao excluir o professor';
	}
}

$pVisao->setProfessor($p);

$conteudo = $pVisao->geraCabecalho(null, null, $c, $menuAdmin);
$conteudo .= $pVisao->excluir($arrayValida);
$conteudo .= $pVisao->geraRodape();

$pVisao->geraHeaderHtml();
$pVisao->geraFooterHtml();
$pVisao->setCorpo($conteudo);

echo $pVisao->saida();
?>