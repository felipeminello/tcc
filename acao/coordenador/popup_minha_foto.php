<?php
$cVisao = new CoordenadorVisao('Minha foto', false);
$cDados = new CoordenadorDados();
$i = new Imagem();

$c = $cDados->selecionar($_SESSION['coordenador']['id']);
$cVisao->setCoordenador($c);

$arrayValida = array('r' => null, 'm' => null);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if ($_FILES['foto']['size'] > 0) {
		$arquivo = Requisicao::checkString($_FILES['foto']);
	} elseif (!empty($_SESSION['coordenador']['foto'])) {
		$arquivo = DIR_IMG_FIS_COORDENADOR.$_SESSION['coordenador']['foto'];
	} else {
		$arquivo = null;
	}
	
	if (!empty($arquivo)) {
		$upload = new upload($arquivo, 'pt_BR');
		
		$nomeArquivo = $i->geraNomeArquivo();
		
		
		if ($upload->uploaded) {
			$upload->file_new_name_body = $nomeArquivo;
			$upload->allowed = array('image/*');
			$upload->image_resize = true;
			$upload->image_ratio_crop = true;
			$upload->image_x = 128;
			$upload->image_y = 128;
			$upload->process(DIR_IMG_FIS_COORDENADOR);
			
			if ($upload->processed) {
				$arrayValida['r'] = 't';
				$arrayValida['m'] = 'Foto atualizada';
				
				$c->__set('foto', $upload->file_dst_name);
				
				$cDados->atualizarFoto($c);
				
				$upload->clean();
				
				if (isset($_SESSION['coordenador']['foto']))
					unset($_SESSION['coordenador']['foto']);
			} else {
				$arrayValida['r'] = 'f';
				$arrayValida['m'] = utf8_decode($upload->error);
			}
		} else {
			$arrayValida['r'] = 'f';
			$arrayValida['m'] = utf8_decode($upload->error);
		}
	} else {
		$arrayValida['r'] = 'f';
		$arrayValida['m'] = 'Tire um foto ou selecione uma imagem em seu computador';
	}
}
$conteudo = $cVisao->cadastroFoto($arrayValida, $arrayUrl[1]);

$cVisao->addScript(DIR_WWW.'js/jquery.min.js');
$cVisao->addScript(DIR_WWW.'js/jquery-migrate.min.js');
$cVisao->addScript(DIR_WWW.'js/photobooth_min.js');
$cVisao->addCSS(DIR_WWW.'css/iframe.css');

$cVisao->geraHeaderHtml();
$cVisao->geraFooterHtml();
$cVisao->setCorpo($conteudo);

echo $cVisao->saida();
?>