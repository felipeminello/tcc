<?php
$dVisao = new DisciplinaVisao('Editar Disciplina');
$dDados = new DisciplinaDados();
$cVisao = new CoordenadorVisao();
$cDados = new CoordenadorDados();
$cuDados = new CursoDados();

$idDisciplina = (isset($arrayUrl[2])) ? Requisicao::checkInt($arrayUrl[2]) : 0;

$c = $cDados->selecionar($_SESSION['coordenador']['id']);
$cVisao->setCoordenador($c);
$menuAdmin = $cVisao->menuAdmin('disciplina');

$arrayValida = array('r' => null, 'm' => null);
$arrayCurso = $cuDados->listarTodos();

$d = $dDados->selecionar($idDisciplina);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$arrayPost = Requisicao::checkString($_POST);
	
	$d->receberFormulario($arrayPost);
	
	$arrayValida = $d->validarCadastro();
	
	if ($arrayValida['r']) {
		$res = $dDados->atualizar($d);

		if ($res) {
			$arrayValida['r'] = true;
			$arrayValida['m'] = 'Disciplina atualizada com sucesso';
		} else {
			$arrayValida['r'] = false;
			$arrayValida['m'] = 'Erro ao atualizar Disciplina';
		}
	}
}

$idCurso = $d->__get('Curso')->__get('id');
$dVisao->setDisciplina($d);

$conteudo = $dVisao->geraCabecalho(null, null, $c, $menuAdmin);
$conteudo .= $dVisao->cadastro($arrayValida, DIR_ROOT_COORDENADOR.$arrayUrl[1].'/'.$idDisciplina, $arrayCurso, $idCurso);
$conteudo .= $dVisao->geraRodape();

$dVisao->geraHeaderHtml();
$dVisao->geraFooterHtml();
$dVisao->setCorpo($conteudo);

echo $dVisao->saida();
?>