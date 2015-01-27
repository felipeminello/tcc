<?
header('Content-Type: text/html; charset='.CODING);

$mVisao = new MensagemVisao();
$mDados = new MensagemDados();

$idCurso = (isset($arrayUrl[2])) ? Requisicao::checkInt($arrayUrl[2]) : 0;
$idTurma = (isset($arrayUrl[3])) ? Requisicao::checkInt($arrayUrl[3]) : 0;
$idAluno = (isset($arrayUrl[4])) ? Requisicao::checkInt($arrayUrl[4]) : 0;
$idProfessor = (isset($arrayUrl[5])) ? Requisicao::checkInt($arrayUrl[5]) : 0;
$idGrupo = (isset($arrayUrl[6])) ? Requisicao::checkInt($arrayUrl[6]) : 0;
$idCoordenador = (isset($arrayUrl[7])) ? Requisicao::checkInt($arrayUrl[7]) : 0;

$str = '';

$arrayMensagem = $mDados->listarTodos($idAluno, $idProfessor, $idCoordenador, $idTurma, $idGrupo);

foreach ($arrayMensagem as $m) {
	$str .= $mVisao->boxMensagem($m);
}

$str .= $mVisao->scriptTooltip();
$str .= $mVisao->scriptExcluir();

echo $str;
?>