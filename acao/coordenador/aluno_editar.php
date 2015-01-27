<?php
$aVisao = new AlunoVisao('Editar Aluno');
$aDados = new AlunoDados();
$cVisao = new CoordenadorVisao();
$cDados = new CoordenadorDados();
$cuDados = new CursoDados();
$i = new Imagem();

$idAluno = (isset($arrayUrl[2])) ? Requisicao::checkInt($arrayUrl[2]) : 0;

$c = $cDados->selecionar($_SESSION['coordenador']['id']);
$cVisao->setCoordenador($c);
$menuAdmin = $cVisao->menuAdmin('aluno');

$arrayValida = array('r' => null, 'm' => null);
$arrayBC = array(DIR_ROOT_COORDENADOR => 'Início', DIR_ROOT_COORDENADOR.'aluno_listar' => 'Alunos', null => 'Editar Aluno');

$arrayCurso = $cuDados->listarTodos();

$a = $aDados->selecionar($idAluno);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$arrayPost = Requisicao::checkString($_POST);
	
	$a->receberFormulario($arrayPost);
	
	$arrayValida = $a->validarCadastro($arrayPost);
	
	if ($arrayValida['r']) {
		$existeEmail = $aDados->existeRA($a->__get('ra'), $a->__get('id'));
		
		if ($existeEmail) {
			$arrayValida['r'] = false;
			$arrayValida['c'] = 'email';
			$arrayValida['m'] = 'RA já cadastrado';
		} else {
			if ($_FILES['foto']['size'] > 0) {
				$upload = new upload($_FILES['foto'], 'pt_BR');
				
				$nomeArquivo = $i->geraNomeArquivo();
				
				if ($upload->uploaded) {
					
					$upload->file_new_name_body = $nomeArquivo;
					$upload->allowed = array('image/*');
					$upload->image_resize = true;
					$upload->image_ratio_crop = true;
					$upload->image_x = 128;
					$upload->image_y = 128;
					$upload->process(DIR_IMG_FIS_ALUNO);
					
					if ($upload->processed) {
						$aDados->excluirFoto($a->__get('foto'));
						
						$a->__set('foto', $upload->file_dst_name);
						$upload->clean();
					} else {
						$arrayValida['r'] = false;
						$arrayValida['m'] = utf8_decode($upload->error);
					}
				} else {
					$arrayValida['r'] = false;
					$arrayValida['m'] = utf8_decode($upload->error);
				}
			}
			
			if ($arrayValida['r']) {
				$res = $aDados->atualizar($a);
	
				if ($res) {
					$arrayValida['r'] = true;
					$arrayValida['m'] = 'Aluno atualizado com sucesso';
				} else {
					$arrayValida['r'] = false;
					$arrayValida['m'] = 'Erro ao atualizar Aluno';
				}
			}
		}
	}
}

$aVisao->setAluno($a);

$conteudo = $aVisao->geraCabecalho(null, null, $c, $menuAdmin);
$conteudo .= $aVisao->cadastro($arrayValida, DIR_ROOT_COORDENADOR.$arrayUrl[1].'/'.$idAluno);
$conteudo .= $aVisao->geraRodape();

$cVisao->addScript(DIR_WWW.'js/fancybox/jquery.fancybox.pack.js?v=2.1.5');
$cVisao->addCSS(DIR_WWW.'js/fancybox/jquery.fancybox.css?v=2.1.5');

$aVisao->geraHeaderHtml();
$aVisao->geraFooterHtml();
$aVisao->setCorpo($conteudo);

echo $aVisao->saida();
?>