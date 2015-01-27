<?
header('Content-type:text/html; charset='.CODING);

$tDados = new TurmaDados();
$atVisao = new AlunoTurmaVisao();
$aDados = new AlunoDados();

$idTurma = Requisicao::checkInt(Requisicao::post('id_turma'));

$t = $tDados->selecionar($idTurma);
if (!$t) $t = null;

$arrayAluno = $aDados->listarPorTurma($idTurma);

$conteudo = $atVisao->gridAlunos($arrayAluno, $t);

echo $conteudo;
?>