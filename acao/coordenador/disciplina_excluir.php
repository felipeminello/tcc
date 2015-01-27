<?php
$dVisao = new DisciplinaVisao('Excluir Disciplina');
$dDados = new DisciplinaDados();
$cVisao = new CoordenadorVisao();
$cDados = new CoordenadorDados();

$idDisciplina = (isset($arrayUrl[2])) ? Requisicao::checkInt($arrayUrl[2]) : 0;

$c = $cDados->selecionar($_SESSION['coordenador']['id']);
$cVisao->setCoordenador($c);
$menuAdmin = $cVisao->menuAdmin('disciplina');

$arrayValida = array('r' => null, 'm' => null);

if (!empty($idDisciplina)) {
	$del = $dDados->excluir($idDisciplina);
	if ($del) {
		$arrayValida['r'] = true;
		$arrayValida['m'] = 'Disciplina excluído com sucesso';
	} else {
		$arrayValida['r'] = false;
		$arrayValida['m'] = 'Erro ao excluir o professor';
	}
}

$conteudo = $dVisao->geraCabecalho(null, null, $c, $menuAdmin);
$conteudo .= $dVisao->excluir($arrayValida);
$conteudo .= $dVisao->geraRodape();

$dVisao->geraHeaderHtml();
$dVisao->geraFooterHtml();
$dVisao->setCorpo($conteudo);

echo $dVisao->saida();
?>