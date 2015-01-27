<?php
$aVisao = new AlunoVisao('Listar Alunos');
$cVisao = new CoordenadorVisao();
$cDados = new CoordenadorDados();
$aDados = new AlunoDados();
$cuDados = new CursoDados();

$idCurso = (isset($arrayUrl[2])) ? Requisicao::checkInt($arrayUrl[2]) : 0;
$idTurma = (isset($arrayUrl[3])) ? Requisicao::checkInt($arrayUrl[3]) : 0;

$c = $cDados->selecionar($_SESSION['coordenador']['id']);
$menuAdmin = $cVisao->menuAdmin('aluno');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$arrayIdAluno = Requisicao::checkInt(Requisicao::post('apagar'));
	
	$aDados->excluirLote($arrayIdAluno);
}

$arrayCurso = $cuDados->listarTodos();
$arrayAluno = $aDados->listar($idCurso, $idTurma);

$conteudo = $aVisao->geraCabecalho(null, null, $c, $menuAdmin);
$conteudo .= $aVisao->listar($arrayCurso, $arrayAluno, $idCurso, $idTurma);
$conteudo .= $aVisao->geraRodape();

$aVisao->geraHeaderHtml();
$aVisao->geraFooterHtml();
$aVisao->setCorpo($conteudo);

echo $aVisao->saida();
?>