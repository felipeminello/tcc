<?php
$pVisao = new ProfessorVisao('Editar Professor');
$pDados = new ProfessorDados();
$cVisao = new CoordenadorVisao();
$cDados = new CoordenadorDados();
$cuDados = new CursoDados();
$i = new Imagem();

$idProfessor = (isset($arrayUrl[2])) ? Requisicao::checkInt($arrayUrl[2]) : 0;

$c = $cDados->selecionar($_SESSION['coordenador']['id']);
$cVisao->setCoordenador($c);
$menuAdmin = $cVisao->menuAdmin('professor');

$arrayValida = array('r' => null, 'm' => null);
$arrayBC = array(DIR_ROOT_COORDENADOR => 'Início', DIR_ROOT_COORDENADOR.'professor_litas' => 'Professores', null => 'Editar Professor');

$arrayCurso = $cuDados->listarTodos();

$p = $pDados->selecionar($idProfessor);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$arrayPost = Requisicao::checkString($_POST);
	
	$p->receberFormulario($arrayPost);
	
	$arrayValida = $p->validarCadastro($arrayPost);
	
	if ($arrayValida['r']) {
		$existeEmail = $pDados->existeEmail($p->__get('email'), $p->__get('id'));
		
		if ($existeEmail) {
			$arrayValida['r'] = false;
			$arrayValida['c'] = 'email';
			$arrayValida['m'] = 'Email já cadastrado';
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
					$upload->process(DIR_IMG_FIS_PROFESSOR);
					
					if ($upload->processed) {
						$pDados->excluirFoto($p->__get('foto'));
						
						$p->__set('foto', $upload->file_dst_name);
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
				$res = $pDados->atualizar($p);
	
				if ($res) {
					$arrayValida['r'] = true;
					$arrayValida['m'] = 'Professor atualizado com sucesso';
				} else {
					$arrayValida['r'] = false;
					$arrayValida['m'] = 'Erro ao atualizar Professor';
				}
			}
		}
	}
}

$pVisao->setProfessor($p);

$conteudo = $pVisao->geraCabecalho(null, null, $c, $menuAdmin);
$conteudo .= $pVisao->cadastro($arrayValida, DIR_ROOT_COORDENADOR.$arrayUrl[1].'/'.$idProfessor);
$conteudo .= $pVisao->geraRodape();

$pVisao->geraHeaderHtml();
$pVisao->geraFooterHtml();
$pVisao->setCorpo($conteudo);

echo $pVisao->saida();
?>