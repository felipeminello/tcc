<?
$i = new Imagem();

$dataUrl = Requisicao::checkString(Requisicao::post('dataUrl'));

$i->setBase64($dataUrl);

$nomeImagem = $i->geraNomeArquivo().'.png';

$salvar = $i->salvarBase64(DIR_IMG_FIS_COORDENADOR, $nomeImagem);

if ($salvar) {
	$_SESSION['coordenador']['foto'] = $nomeImagem;
}
?>