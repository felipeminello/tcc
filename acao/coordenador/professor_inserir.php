<?php
$pVisao = new ProfessorVisao('Inserir Professor');
$pDados = new ProfessorDados();
$cVisao = new CoordenadorVisao();
$cDados = new CoordenadorDados();
$cuDados = new CursoDados();
$p = new Professor();

$idCurso = (isset($arrayUrl[2])) ? Requisicao::checkInt($arrayUrl[2]) : 0;
$idTurma = (isset($arrayUrl[3])) ? Requisicao::checkInt($arrayUrl[3]) : 0;

$c = $cDados->selecionar($_SESSION['coordenador']['id']);
$cVisao->setCoordenador($c);
$menuAdmin = $cVisao->menuAdmin('professor');

$arrayValida = array('r' => null, 'm' => null);
$arrayCurso = $cuDados->listarTodos();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$arrayPost = Requisicao::checkString($_POST);
	
	$p->receberFormulario($arrayPost);
	
	$arrayValida = $p->validarCadastro($arrayPost);
	
	if ($arrayValida['r']) {
		$existeEmail = $pDados->existeEmail($p->__get('email'));
		
		if ($existeEmail) {
			$arrayValida['r'] = false;
			$arrayValida['c'] = 'email';
			$arrayValida['m'] = 'Email já cadastrado';
		} else {
			$res = $pDados->inserir($p);

			if ($res) {
				$arrayValida['r'] = true;
				$arrayValida['m'] = 'Professor inserido com sucesso';
			} else {
				$arrayValida['r'] = false;
				$arrayValida['m'] = 'Erro ao inserir Professor';
			}
		}
	}
}

$pVisao->setProfessor($p);

$conteudo = $pVisao->geraCabecalho(null, null, $c, $menuAdmin);
$conteudo .= $pVisao->cadastro($arrayValida, DIR_ROOT_COORDENADOR.$arrayUrl[1].'/'.$idCurso.'/'.$idTurma, $arrayCurso, $idCurso, $idTurma);
$conteudo .= $pVisao->geraRodape();

$pVisao->geraHeaderHtml();
$pVisao->geraFooterHtml();
$pVisao->setCorpo($conteudo);

echo $pVisao->saida();
?>