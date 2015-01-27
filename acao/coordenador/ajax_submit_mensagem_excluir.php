<?
header('Content-Type: text/html; charset='.CODING);

$mDados = new MensagemDados();

$arrayValida = array();


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$idMensagem = Requisicao::checkInt(Requisicao::post('id_mensagem'));
	
	if (!empty($idMensagem)) {
		$del = $mDados->excluir($idMensagem);
		
		if ($del) {
			$arrayValida['r'] = 't';
			$arrayValida['c'] = '';
			$arrayValida['m'] = 'Mensagem excluída com sucesso';
		} else {
			$arrayValida['r'] = 'f';
			$arrayValida['c'] = '';
			$arrayValida['m'] = 'Erro ao excluir mensagem';
			
		}
	}
}

header('Content-type:application/json; charset='.CODING);
echo '{"r":"'.$arrayValida['r'].'", "m":"'.$arrayValida['m'].'", "c":"'.$arrayValida['c'].'"}';
?>