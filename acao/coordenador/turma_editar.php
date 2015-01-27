<?php
$tVisao = new TurmaVisao('Editar Turma');
$tDados = new TurmaDados();
$cVisao = new CoordenadorVisao();
$cDados = new CoordenadorDados();
$cuDados = new CursoDados();

$idTurma = (isset($arrayUrl[2])) ? Requisicao::checkInt($arrayUrl[2]) : 0;

$c = $cDados->selecionar($_SESSION['coordenador']['id']);
$cVisao->setCoordenador($c);
$menuAdmin = $cVisao->menuAdmin('turma');

$arrayValida = array('r' => null, 'm' => null);

$arrayCurso = $cuDados->listarTodos();

$t = $tDados->selecionar($idTurma);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$arrayPost = Requisicao::checkString($_POST);
	
	$t->receberFormulario($arrayPost);
	
	$arrayValida = $t->validarCadastro($arrayPost);
	
	if ($arrayValida['r']) {
		$res = $tDados->atualizar($t);

		if ($res) {
			$arrayValida['r'] = true;
			$arrayValida['m'] = 'Turma atualizado com sucesso';
		} else {
			$arrayValida['r'] = false;
			$arrayValida['m'] = 'Erro ao atualizar Turma';
		}
	}
}

$tVisao->setTurma($t);

$conteudo = $tVisao->geraCabecalho(null, null, $c, $menuAdmin);
$conteudo .= $tVisao->cadastro($arrayCurso, $arrayValida, DIR_ROOT_COORDENADOR.$arrayUrl[1].'/'.$idTurma, 'sistema');
$conteudo .= $tVisao->geraRodape();

$tVisao->addScript(DIR_WWW.'js/jquery-ui/jquery-ui.min.js');
$tVisao->addScript(DIR_WWW.'js/jquery-ui/jquery.ui.datepicker-pt-BR.js');
$tVisao->addCSS(DIR_WWW.'js/jquery-ui/jquery-ui.min.css');

$tVisao->geraHeaderHtml();
$tVisao->geraFooterHtml();
$tVisao->setCorpo($conteudo);

echo $tVisao->saida();
?>