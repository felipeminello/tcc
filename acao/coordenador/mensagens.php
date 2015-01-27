<?php
$mVisao = new MensagemVisao('Mensagens');
$cuDados = new CursoDados();
$cVisao = new CoordenadorVisao();
$cDados = new CoordenadorDados();
$aDados = new AlunoDados();
$pDados = new ProfessorDados();
$tDados = new TurmaDados();

$idCurso = (isset($arrayUrl[2])) ? Requisicao::checkInt($arrayUrl[2]) : 0;
$idTurma = (isset($arrayUrl[3])) ? Requisicao::checkInt($arrayUrl[3]) : 0;
$idAluno = (isset($arrayUrl[4])) ? Requisicao::checkInt($arrayUrl[4]) : 0;
$idProfessor = (isset($arrayUrl[5])) ? Requisicao::checkInt($arrayUrl[5]) : 0;
$idCoordenador = (isset($arrayUrl[6])) ? Requisicao::checkInt($arrayUrl[6]) : 0;

$c = $cDados->selecionar($_SESSION['coordenador']['id']);
$cVisao->setCoordenador($c);
$menuAdmin = $cVisao->menuAdmin();

$arrayValida = array('r' => null, 'm' => null);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$arrayPost = Requisicao::checkString($_POST);
	
	$arrayValida = $c->validarCadastro($arrayPost);
	$c->__set('id', $_SESSION['coordenador']['id']);
	
	if ($arrayValida['r']) {
		if ($cDados->atualizar($c)) {
			$arrayValida['m'] = 'Dados atualizados com sucesso';
		} else {
			$arrayValida['r'] = false;
			$arrayValida['m'] = 'Erro ao atualizar dados';
		}
	}
}

$arrayCurso = $cuDados->listarTodos();
$arrayTurma = $tDados->listar();
$arrayAluno = $aDados->listar();
$arrayProfessor = $pDados->listar();
$arrayCoordenador = $cDados->listar();

$conteudo = $mVisao->geraCabecalho(null, null, $c, $menuAdmin);
$conteudo .= $mVisao->mensagemCoordenacao($arrayValida, $arrayCurso, $arrayTurma, $arrayAluno, $arrayProfessor, $arrayCoordenador);
$conteudo .= $mVisao->geraRodape();

$mVisao->addScript(DIR_WWW.'js/jquery-scrolltofixed-min.js');
$mVisao->addScript(DIR_WWW.'js/jquery-ui/jquery-ui.min.js');

$mVisao->addCSS(DIR_WWW.'js/jquery-ui/jquery-ui.min.css');

$mVisao->geraHeaderHtml();
$mVisao->geraFooterHtml();
$mVisao->setCorpo($conteudo);

echo $mVisao->saida();
?>