<?php
class AlunoTurmaVisao extends GeralVisao {
	private $AlunoTurma;
	
	public function setAlunoTurma(AlunoTurma $at) {
		$this->AlunoTurma = $at;
	}
	
	public function visualizarAlunos(array $arrayCurso, array $arrayAluno, Turma $t) {
		$jsCurso = null;
		
		$idTurma = $t->__get('id');
		$idCurso = $t->__get('Curso')->__get('id');
		
		$strCurso = Elementos::popularSelect($arrayCurso, $idCurso);
		
		$strAlunos = self::gridAlunos($arrayAluno, $t);
		
		if (!empty($idCurso)) {
			$jsCurso = '$("#turma").load("'.DIR_ROOT_COORDENADOR.'ajax_turma_listar/'.$idCurso.'/'.$idTurma.'");';
		}
		
		$str = '
		<div id="page-wrapper">
			<div class="container-fluid">

				<!-- Page Heading -->
				<div class="row">
					<div class="col-lg-12">
						<h1 class="page-header">
							'.$this->titulo.'
						</h1>
						
						<ol class="breadcrumb">
							<li><a href="'.DIR_ROOT_COORDENADOR.'">Início</a></li>
							<li><a href="'.DIR_ROOT_COORDENADOR.'turma_listar">Listar turmas</a></li>
							<li class="active">'.$this->titulo.'</li>
						</ol>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-6">
						<div class="form-group">
							<label>Curso</label>
							<select id="curso" class="form-control">
								<option value="0">Selecione o Curso</option>
								'.$strCurso.'
							</select>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="form-group">
							<label>Turma</label>
							<select id="turma" class="form-control">
								<option value="0">Selecione primeiro o Curso</option>
							</select>
						</div>
					</div>
					
				</div>
				<div class="row" id="show_aluno">
					'.$strAlunos.'
				</div>
				
				<div id="alerta"></div>	
			</div>
		</div>
		<script type="text/javascript">
		$(document).ready(function() {
		
			$("#curso").change(function() {
				$("#turma").attr("disabled", true);
				$("#turma").load("'.DIR_ROOT_COORDENADOR.'ajax_turma_listar/"+$(this).val(), function() {
					$("#turma").attr("disabled", false);
					
					$("#show_aluno").load("'.DIR_ROOT_COORDENADOR.'ajax_aluno_turma_listar/");
				});
			});
			
			'.$jsCurso.'
			
			$("#turma").change(function() {
				$.ajax({
					type: "POST",
					url: "'.DIR_ROOT_COORDENADOR.'ajax_aluno_turma_listar/",
					data: { id_turma: $(this).val() },
					beforeSend: function() {
						$("#show_aluno").html(\'<div align="center"><img src="'.DIR_WWW.'imgs/layout/ajax-loader.gif"></div>\');
					},
					contentType: "application/x-www-form-urlencoded; charset='.CODING.'"
				}).done(function(data) {
					$("#show_aluno").html(data);
				}).fail(function() {
					$("#show_aluno").text("Erro ao carregar");
				});
			});
		});
		</script>
		';
		
		return $str;
	}
	
	public function gridAlunos(array $arrayAluno, Turma $t = null) {
		$countAluno = count($arrayAluno);
		
		$str = null;
		
		if (is_object($t)) {
			
			$arrayPeriodo = $t->__get('arrayPeriodo');
			
			$str = 
			'<div class="col-lg-4 text-center">'.
				'<div class="alert alert-info"><strong>Período:</strong> '.$arrayPeriodo[$t->__get('periodo')].'</div>'.
			'</div>'.
			'<div class="col-lg-4 text-center">'.
				'<div class="alert alert-info"><strong>Data Início:</strong> '.$t->__get('dataInicio').'</div>'.
			'</div>'.
			'<div class="col-lg-4 text-center">'.
				'<div class="alert alert-info"><strong>Data Término:</strong> '.$t->__get('dataFim').'</div>'.
			'</div>';
		}
		
		if ($countAluno > 0) {
			foreach ($arrayAluno as $a) {
				$str .= '
				<div class="col-lg-2 text-center">'.
					'<div><img src="'.$a->exibeImagem().'" class="img-thumbnail"></div>'.
					'<a href="'.DIR_ROOT_COORDENADOR.'aluno_editar/'.$a->__get('id').'"><img src="'.DIR_WWW.'imgs/layout/edit20.png" title="Editar Aluno"></a> '.
					'<a href="'.DIR_ROOT_COORDENADOR.'aluno_editar/'.$a->__get('id').'"><img src="'.DIR_WWW.'imgs/layout/msgm20.png" title="Enviar mensagem"></a> '.
					'<div>'.$a->__get('nome').'</div>'.
					'<div>('.$a->__get('ra').')</div>'.
				'</div>';
			}
		} else {
			$str .= '<div class="col-lg-12">'.self::alerta('Nenhum aluno encontrado').'</div>';
		}
		return $str;
	}
	
	public function boxAluno(Aluno $a) {
		
	}
}


?>