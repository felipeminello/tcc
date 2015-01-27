<?php
class ChamadaVisao extends GeralVisao {
	private $Chamada;
	
	public function setChamada(Chamada $c) {
		$this->Chamada = $c;
	}

	
	public function alertaTurma() {
		$str = '<div class="alert alert-warning">
					<strong>Atenção!</strong> Selecione uma Turma
				</div>';
		
		return $str;
	}
	
	public function alertaDisciplina() {
		$str = '<div class="alert alert-warning">
					<strong>Atenção!</strong> Selecione uma Disciplina
				</div>';
		
		return $str;
	}
	
	public function alertaDataInicial() {
		$str = '<div class="alert alert-warning">
					<strong>Atenção!</strong> Selecione a data inicial
				</div>';
		
		return $str;
	}
	
	public function alertaDataFinal() {
		$str = '<div class="alert alert-warning">
					<strong>Atenção!</strong> Selecione a data final
				</div>';
		
		return $str;
	}
	
	public function graficoChamadaTurma(array $arrayChamada, array $arrayAluno, Disciplina $d, Turma $t) {
		$strFalta = $strAluno = '';
		
		$countChamada = count($arrayChamada);
		$countAluno = count($arrayAluno);
		
		if ($countAluno > 0) {
			$arrayFalta = $this->Chamada->calcularFaltas($arrayAluno, $arrayChamada);
			
			foreach ($arrayChamada as $c) {
				$dataFinal = $c->__get('data');
			}
			
			foreach ($arrayAluno as $a) {
				$strAluno .= '"'.$a->__get('nome').'", ';
			}
			$strAluno = rtrim($strAluno, ', ');
			
			$strFalta = implode(',', $arrayFalta);
		}
		
		
		if ($countChamada > 0) {
			$str = '
			<div id="graf_falta" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
			<script type="text/javascript" class="code">
			$(document).ready(function(){
				$("#graf_falta").highcharts({
					chart: {
						type: "column"
					},
					exporting: {
						enabled: false
					},
					title: {
						text: "Faltas dos alunos em '.$d->__get('nome').' ('.$t->__get('dataInicio').' até '.$dataFinal.')"
					},
					xAxis: {
			  			categories: ['.$strAluno.']
					},
					yAxis: {
						allowDecimals: false,
						title: {
							text: "Faltas"
						}
					},
					tooltip: {
			            formatter: function () {
			                return "<strong>"+this.x+"</strong><br />"+this.series.name+": "+this.y;
			            }
			        },
					series: [{
						name: "Alunos",
						data: ['.$strFalta.']
					}],
				});
			})
			</script>
			
			';
		} else {
			$str = '<div class="alert alert-warning">Chamada não efetuada em <strong>'.$d->__get('nome').'</strong></div>';
		}
		
		return $str;
	}
	
	public function listar(array $arrayCurso, array $arrayChamada, $idCurso = 0, $idTurma = 0, $idDisciplina = 0) {
		$strChamada = $jsTurma = '';
		
		$countChamada = count($arrayChamada);
		
		$strCurso = '<option value="0">Todos os Cursos</option>';
		foreach ($arrayCurso as $c) {
			$strCheck = ($c->__get('id') == $idCurso) ? 'selected="selected"' : '';
			
			$strCurso .= '<option value="'.$c->__get('id').'" '.$strCheck.'>'.$c->__get('nome').'</option>';
		}
		
		if (!empty($idCurso))
			$jsTurma = '$("#turma").load("'.DIR_ROOT_COORDENADOR.'ajax_turma_listar/'.$idCurso.'/'.$idTurma.'");';
		
		if ($countChamada > 0)
			$tabelaChamada = self::tabelaChamadas($arrayChamada);
		else
			$tabelaChamada = self::alertaTurma();
			
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
							<li class="active">'.$this->titulo.'</li>
						</ol>
						
							<div class="col-lg-4" style="padding-left:0;">
								<div class="form-group">
									<label>Selecione o Curso</label>
									<select id="curso" class="form-control">
										'.$strCurso.'
									</select>
								</div>
							</div>
							<div class="col-lg-4">				  
								<div class="form-group">
									<label>Selecione a Turma</label>
									<select id="turma" class="form-control">
										<option value="0">Selecione primeiro o Curso</option>
									</select>
								</div>						
							</div>
							<div class="col-lg-4" style="padding-right:0;">				  
								<div class="form-group">
									<label>Selecione a Disciplina</label>
									<select id="disciplina" class="form-control">
										<option value="0">Selecione primeiro o Curso</option>
									</select>
								</div>						
							</div>
						
						
						
							<div class="col-lg-6" style="padding-left:0;">
								<div class="form-group">
									<label>Data Inicial</label>
									<input id="data_inicial" class="form-control data">
								</div>
							</div>			
						
							<div class="col-lg-6" style="padding-right:0;">
								<div class="form-group">
									<label>Data Final</label>
									<input id="data_final" class="form-control data">
								</div>
							</div>			
						
						<div style="clear:both;"></div>
							
						<form id="lista" method="post" action="'.DIR_ROOT_COORDENADOR.'chamada_listar">
						<div class="table-responsive" id="show_chamada">
							'.$tabelaChamada.'
						</div>
						</form>
						
						<div id="retorno" class="alert"></div>
					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript">
		$(document).ready(function() {
			$(".data").datepicker({
				onSelect: function() {
					$.ajax({
						type: "POST",
						url: "'.DIR_ROOT_COORDENADOR.'ajax_chamada_listar/",
						data: { id_curso: $("#curso").val(), id_turma: $("#turma").val(), id_disciplina: $("#disciplina").val(), data_inicial: $("#data_inicial").val(), data_final: $("#data_final").val() },
						beforeSend: function() {
							$("#show_chamada").html(\'<div align="center"><img src="'.DIR_WWW.'imgs/layout/ajax-loader.gif"></div>\');
						},
						contentType: "application/x-www-form-urlencoded; charset='.CODING.'"
					}).done(function(data) {
						$("#show_chamada").html(data);
					}).fail(function() {
						$("#show_chamada").text("Erro ao carregar");
					});
				
				}
			});
			
			'.$jsTurma.'
			
			$("#lista").submit(function() {
				var total = $(":checkbox:checked").length;
				
				if (total > 0) {
					return confirm("Deseja excluir os itens selecionados?");
				} else {
					$("#retorno").addClass("alert-danger").text("Nenhum item marcado");
					return false;
				}
			});
			
			$("#curso").change(function() {
				$.ajax({
					type: "POST",
					url: "'.DIR_ROOT_COORDENADOR.'ajax_chamada_listar/",
					data: { id_curso: $(this).val(), data_inicial: $("#data_inicial").val(), data_final: $("#data_final").val() },
					beforeSend: function() {
						$("#turma, #disciplina").attr("disabled", true);
					
						$("#show_chamada").html(\'<div align="center"><img src="'.DIR_WWW.'imgs/layout/ajax-loader.gif"></div>\');
					},
					contentType: "application/x-www-form-urlencoded; charset='.CODING.'"
				}).done(function(data) {
					$("#show_chamada").html(data);
				}).fail(function() {
					$("#show_chamada").text("Erro ao carregar");
				});
				
				$("#turma").load("'.DIR_ROOT_COORDENADOR.'ajax_turma_listar/"+$(this).val(), function() {
					$(this).attr("disabled", false);
					$("#disciplina").load("'.DIR_ROOT_COORDENADOR.'ajax_disciplina_listar/"+$("#curso").val()+"/"+$(this).val(), function() {
						$(this).attr("disabled", false);
					});
				});
			});
			
			$("#turma").change(function() {
				$.ajax({
					type: "POST",
					url: "'.DIR_ROOT_COORDENADOR.'ajax_chamada_listar/",
					data: { id_curso: $("#curso").val(), id_turma: $(this).val(), id_disciplina: $("#disciplina").val(), data_inicial: $("#data_inicial").val(), data_final: $("#data_final").val() },
					beforeSend: function() {
						$("#show_chamada").html(\'<div align="center"><img src="'.DIR_WWW.'imgs/layout/ajax-loader.gif"></div>\');
					},
					contentType: "application/x-www-form-urlencoded; charset='.CODING.'"
				}).done(function(data) {
					$("#show_chamada").html(data);
/*
					$("#data_inicial").val(function() {
						var o = $.get("'.DIR_ROOT_COORDENADOR.'ajax_turma_data_inicio/"+$("#turma").val());
						return o.responseText;
					});
*/
				}).fail(function() {
					$("#show_chamada").text("Erro ao carregar");
				});
			});
						
			$("#disciplina").change(function() {
				$.ajax({
					type: "POST",
					url: "'.DIR_ROOT_COORDENADOR.'ajax_chamada_listar/",
					data: { id_curso: $("#curso").val(), id_turma: $("#turma").val(), id_disciplina: $(this).val(), data_inicial: $("#data_inicial").val(), data_final: $("#data_final").val() },
					beforeSend: function() {
						$("#show_chamada").html(\'<div align="center"><img src="'.DIR_WWW.'imgs/layout/ajax-loader.gif"></div>\');
					},
					contentType: "application/x-www-form-urlencoded; charset='.CODING.'"
				}).done(function(data) {
					$("#show_chamada").html(data);
				}).fail(function() {
					$("#show_chamada").text("Erro ao carregar");
				});
			});
		});
		</script>
		';
		
		return $str;
	}
	
	public function tabelaChamadas(array $arrayChamada, array $arrayAluno, $idCurso = 0, $idTurma = 0, $idDisciplina = 0, Professor $p = null, $dataInicial = null, $dataFinal = null) {
		$strChamada = '';
		$countChamada = count($arrayChamada);

		if (!is_object($p))
			$p = new Professor();
		
		$arrayFalta = $this->Chamada->calcularFaltas($arrayAluno, $arrayChamada);
		
		foreach ($arrayAluno as $a) {
			$idAluno = $a->__get('id');

			$strChamada .= '<tr>';
			$strChamada .= '<td>'.$a->__get('nome').'</td>';
			$strChamada .= '<td>'.$arrayFalta[$idAluno].'</td>';
		}
					
		$str = '
		<div class="alert alert-info">
		<div class="row">
			<div class="col-lg-4">
				Professor: <strong>'.$p->__get('nome').'</strong>
			</div>
			<div class="col-lg-4">
				Data Inicial: <strong>'.$dataInicial.'</strong>
			</div>
			<div class="col-lg-4">
				Data Final: <strong>'.$dataFinal.'</strong>
			</div>
		</div>
		</div>
		
		<table id="lista_aluno" class="table table-bordered table-hover table-striped">
			<thead>
				<tr>
					<th>Aluno</th>
					<th>Faltas</th>
				</tr>
			</thead>
			<tbody>
				'.$strChamada.'
			</tbody>
		</table>';
		
		return $str;
	}
	
}


?>