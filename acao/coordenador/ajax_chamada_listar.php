<?php
$chVisao = new ChamadaVisao();
$chDados = new ChamadaDados();
$pDados = new ProfessorDados();
$aDados = new AlunoDados();
$ch = new Chamada();

$chVisao->setChamada($ch);

$idTurma = (isset($_POST['id_turma'])) ? Requisicao::checkInt($_POST['id_turma']) : 0;
$idCurso = (isset($_POST['id_curso'])) ? Requisicao::checkInt($_POST['id_curso']) : 0;
$idDisciplina = (isset($_POST['id_disciplina'])) ? Requisicao::checkInt($_POST['id_disciplina']) : 0;
$dataInicial = (isset($_POST['data_inicial'])) ? Requisicao::checkData($_POST['data_inicial']) : null;
$dataFinal = (isset($_POST['data_final'])) ? Requisicao::checkData($_POST['data_final']) : null;

if (!empty($idTurma) and !empty($idDisciplina) and !empty($dataInicial) and !empty($dataFinal)) {
	$diferenca = Requisicao::checkDiferencaData($dataInicial, $dataFinal);
	
	if ($diferenca >= 0) {
		$dataInicTraco = implode("-",array_reverse(explode("/",$dataInicial)));
		$dataFimTraco = implode("-",array_reverse(explode("/",$dataFinal)));
		
		$arrayChamada = $chDados->listarPorTurmaDisciplina($idTurma, $idDisciplina, $dataInicTraco, $dataFimTraco);
		$arrayAluno = $aDados->listarPorTurma($idTurma);
		
		$p = $pDados->selecionarTurmaDisciplina($idTurma, $idDisciplina);

		if (!is_object($p)) $p = new Professor();
		
		$conteudo = $chVisao->tabelaChamadas($arrayChamada, $arrayAluno, $idCurso, $idTurma, $idDisciplina, $p, $dataInicial, $dataFinal);
	} else {
		$conteudo = $chVisao->alerta('A data inicial deve ser menor ou igual a data final');
	}
} else {
	if (empty($idTurma))
		$conteudo = $chVisao->alertaTurma();
	elseif (empty($idDisciplina))
		$conteudo = $chVisao->alertaDisciplina();
	elseif (empty($dataInicial))
		$conteudo = $chVisao->alertaDataInicial();
	elseif (empty($dataFinal))
		$conteudo = $chVisao->alertaDataFinal();
}

echo $conteudo;
?>