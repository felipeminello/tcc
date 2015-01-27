<?php
$dVisao = new DisciplinaVisao('Inserir Disciplina');
$dDados = new DisciplinaDados();
$cVisao = new CoordenadorVisao();
$cDados = new CoordenadorDados();
$cuDados = new CursoDados();
$d = new Disciplina();

$idCurso = (isset($arrayUrl[2])) ? Requisicao::checkInt($arrayUrl[2]) : 0;

$c = $cDados->selecionar($_SESSION['coordenador']['id']);
$cVisao->setCoordenador($c);
$menuAdmin = $cVisao->menuAdmin('disciplina');

$arrayValida = array('r' => null, 'm' => null);
$arrayCurso = $cuDados->listarTodos();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$arrayPost = Requisicao::checkString($_POST);
	
	$d->receberFormulario($arrayPost);
	
	$arrayValida = $d->validarCadastro();
	
	if ($arrayValida['r']) {
		$res = $dDados->inserir($d);

		if ($res) {
			$arrayValida['r'] = true;
			$arrayValida['m'] = 'Disciplina inserida com sucesso';
		} else {
			$arrayValida['r'] = false;
			$arrayValida['m'] = 'Erro ao inserir Disciplina';
		}
	}
}

$dVisao->setDisciplina($d);

$conteudo = $dVisao->geraCabecalho(null, null, $c, $menuAdmin);
$conteudo .= $dVisao->cadastro($arrayValida, DIR_ROOT_COORDENADOR.$arrayUrl[1].'/'.$idCurso, $arrayCurso, $idCurso);
$conteudo .= $dVisao->geraRodape();

$dVisao->geraHeaderHtml();
$dVisao->geraFooterHtml();
$dVisao->setCorpo($conteudo);

echo $dVisao->saida();
?>