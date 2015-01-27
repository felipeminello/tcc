<?php
$aVisao = new AlunoVisao('Inserir Aluno');
$aDados = new AlunoDados();
$cVisao = new CoordenadorVisao();
$cDados = new CoordenadorDados();
$cuDados = new CursoDados();
$a = new Aluno();

$idCurso = (isset($arrayUrl[2])) ? Requisicao::checkInt($arrayUrl[2]) : 0;
$idTurma = (isset($arrayUrl[3])) ? Requisicao::checkInt($arrayUrl[3]) : 0;

$c = $cDados->selecionar($_SESSION['coordenador']['id']);
$cVisao->setCoordenador($c);
$menuAdmin = $cVisao->menuAdmin('aluno');

$arrayValida = array('r' => null, 'm' => null);
$arrayCurso = $cuDados->listarTodos();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$arrayPost = Requisicao::checkString($_POST);
	
	if (isset($arrayPost['curso'])) $idCurso = $arrayPost['curso'];
	if (isset($arrayPost['turma'])) $idTurma = $arrayPost['turma'];
	
	$a->receberFormulario($arrayPost);
	
	$arrayValida = $a->validarCadastro($arrayPost);
	
	if ($arrayValida['r']) {
		$existeEmail = $aDados->existeRA($a->__get('ra'));
		
		if ($existeEmail) {
			$arrayValida['r'] = false;
			$arrayValida['c'] = 'email';
			$arrayValida['m'] = 'Email já cadastrado';
		} else {
			$res = $aDados->inserir($a);

			if ($res) {
				$arrayValida['r'] = true;
				$arrayValida['m'] = 'Aluno inserido com sucesso';
			} else {
				$arrayValida['r'] = false;
				$arrayValida['m'] = 'Erro ao inserir Aluno';
			}
		}
	}
}

$aVisao->setAluno($a);

$conteudo = $aVisao->geraCabecalho(null, null, $c, $menuAdmin);
$conteudo .= $aVisao->cadastro($arrayValida, DIR_ROOT_COORDENADOR.$arrayUrl[1].'/'.$idCurso.'/'.$idTurma, $arrayCurso, $idCurso, $idTurma);
$conteudo .= $aVisao->geraRodape();

$aVisao->geraHeaderHtml();
$aVisao->geraFooterHtml();
$aVisao->setCorpo($conteudo);

echo $aVisao->saida();
?>