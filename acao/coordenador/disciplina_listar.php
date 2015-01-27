<?php
$dVisao = new DisciplinaVisao('Listar Disciplinas');
$cVisao = new CoordenadorVisao();
$cDados = new CoordenadorDados();
$dDados = new DisciplinaDados();
$cuDados = new CursoDados();

$idCurso = (isset($arrayUrl[2])) ? Requisicao::checkInt($arrayUrl[2]) : 0;

$c = $cDados->selecionar($_SESSION['coordenador']['id']);
$cVisao->setCoordenador($c);
$menuAdmin = $cVisao->menuAdmin('disciplina');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$arrayIdDisciplina = Requisicao::checkInt(Requisicao::post('apagar'));
	
	$dDados->excluirLote($arrayIdDisciplina);
}

$arrayCurso = $cuDados->listarTodos();
$arrayDisciplina = $dDados->listar($idCurso);

$conteudo = $dVisao->geraCabecalho(null, null, $c, $menuAdmin);
$conteudo .= $dVisao->listar($arrayCurso, $arrayDisciplina, $idCurso);
$conteudo .= $dVisao->geraRodape();

$dVisao->geraHeaderHtml();
$dVisao->geraFooterHtml();
$dVisao->setCorpo($conteudo);

echo $dVisao->saida();
?>