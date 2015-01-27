<?
header('Content-Type: text/html; charset='.CODING);

$mVisao = new MensagemVisao();
$mDados = new MensagemDados();
$m = new Mensagem();
$tDados = new TurmaDados();

$cDados = new CoordenadorDados();

$c = $cDados->selecionar($_SESSION['coordenador']['id']);

$arrayValida = array();



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$arrayPost = Requisicao::decode($_POST);
	
	$arrayTurma = ($arrayPost['destino'] == 1) ? $tDados->listar($arrayPost['id_curso']) : $tDados->listar();
	
	$m->receberFormulario($arrayPost, $arrayTurma);
	$m->__set('Coordenador', $c);
	
	$arrayValida = $m->validaCadastro();
	
	if ($arrayValida['r']) {
		$ins = $mDados->inserir($m);
		
		if ($ins) {
			$arrayValida['r'] = 't';
			$arrayValida['c'] = '';
			$arrayValida['m'] = 'Mensagem enviada em '.date('d/m/Y').' às '.date('H:i:s');
		} else {
			$arrayValida['r'] = 'f';
			$arrayValida['c'] = '';
			$arrayValida['m'] = 'Erro ao enviar mensagem';
			
		}
	}
}

header('Content-type:application/json; charset='.CODING);
echo '{"r":"'.$arrayValida['r'].'", "m":"'.$arrayValida['m'].'", "c":"'.$arrayValida['c'].'"}';
?>