<?php
class NotaVisao extends GeralVisao {
	private $Nota;
	
	public function setNota(Nota $n) {
		$this->Nota = $n;
	}

	public function home($arrayCurso) {
		$strCurso = '<option value="0">Selecione</option>';
		
		foreach ($arrayCurso as $c) {
			$strCurso .= '<option value="'.$c->__get('id').'">'.$c->__get('nome').'</option>';
		}
		
		$str = '
		<div id="page-wrapper">
			<div class="container-fluid">

				<!-- Page Heading -->
				<div class="row">
					<div class="col-lg-12">
						<h1 class="page-header">
							Notas e Faltas
						</h1>
						
						<ol class="breadcrumb">
							<li>
								<i class="fa fa-dashboard"></i>  <a href="'.DIR_ROOT_ALUNO.'">Início</a>
							</li>
							<li class="active">
								<i class="fa fa-bar-chart-o"></i> Notas e Faltas
							</li>
						</ol>
						<div class="col-lg-6" style="padding-left:0;">
							<div class="form-group">
								<label>Selecione o Curso</label>
								<select id="curso" class="form-control">
									'.$strCurso.'
								</select>
							</div>
						</div>
						<div class="col-lg-6" style="padding-right:0;">				  
							<div class="form-group">
								<label>Selecione a Turma</label>
								<select id="turma" class="form-control">
									<option value="0">Selecione primeiro o Curso</option>
								</select>
							</div>						
						</div>
						<div style="clear:both;"></div>
						<div class="table-responsive" id="show_notas"></div>
					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript">
		$(document).ready(function() {
			$("#curso").change(function() {
				$("#turma").load("'.DIR_ROOT_ALUNO.'ajax_turma_listar/"+$(this).val());
			});
			
			$("#turma").change(function() {
				$.ajax({
					type: "POST",
					url: "'.DIR_ROOT_ALUNO.'ajax_notas-e-faltas_listar/",
					data: { id_turma: $(this).val() },
					beforeSend: function() {
						$("#show_notas").html(\'<div align="center"><img src="'.DIR_WWW.'imgs/layout/ajax-loader.gif"></div>\');
					},
					contentType: "application/x-www-form-urlencoded; charset='.CODING.'"
				}).done(function(data) {
					$("#show_notas").html(data);
				}).fail(function() {
					$("#show_notas").text("Erro ao carregar");
				});
			});
		});
		</script>
		';
		
		return $str;
	}
	
	public function tabelaNotas($arrayNotas, $arrayFaltas) {
		$strNotas = '';
		
		foreach ($arrayNotas as $n) {
			$strNotas .= '<tr>';
			$strNotas .= '<td>'.$n->__get('Disciplina')->__get('nome').'</td>';
			$strNotas .= '<td>'.number_format($n->__get('nota'), 1, ',', '.').'</td>';
			$strNotas .= '<td>'.$n->__get('nota').'</td>';
			$strNotas .= '</tr>';
		}
		
		$str = '
		<table class="table table-bordered table-hover table-striped">
			<thead>
				<tr>
					<th>Disciplina</th>
					<th>Nota</th>
					<th>Faltas</th>
				</tr>
			</thead>
			<tbody>
				'.$strNotas.'
				<tr class="active">
					<td>/index.html</td>
					<td>1265</td>
					<td>32.3%</td>
				</tr>
				<tr class="success">
					<td>/about.html</td>
					<td>261</td>
					<td>33.3%</td>
				</tr>
				<tr class="warning">
					<td>/sales.html</td>
					<td>665</td>
					<td>21.3%</td>
				</tr>
				<tr class="danger">
					<td>/blog.html</td>
					<td>9516</td>
					<td>89.3%</td>
				</tr>
				<tr>
					<td>/404.html</td>
					<td>23</td>
					<td>34.3%</td>
				</tr>
				<tr>
					<td>/services.html</td>
					<td>421</td>
					<td>60.3%</td>
				</tr>
				<tr>
					<td>/blog/post.html</td>
					<td>1233</td>
					<td>93.2%</td>
				</tr>
			</tbody>
		</table>
		';
		
		return $str;
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
	
	public function graficoNotas(array $arrayDisciplina) {
		$strDisciplina = '';
		
		$countDisciplina = count($arrayDisciplina);
		
		if ($countDisciplina > 0) {
			foreach ($arrayDisciplina as $d) {
				$strDisciplina .= '"'.$d->__get('nome').'", ';
			}
			$strDisciplina = rtrim($strDisciplina, ', ');
		}
		
		$str = '
		<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
		<script type="text/javascript" class="code">
		$(document).ready(function(){
			$("#container").highcharts({
				chart: {
					type: "column"
				},
				exporting: {
					enabled: false
				},
				title: {
					text: "Comparativo de Notas"
				},
				xAxis: {
		  			categories: ['.$strDisciplina.']
				},
				yAxis: {
					allowDecimals: true,
					title: {
						text: "Notas"
					}
				},
				tooltip: {
		            formatter: function () {
		                return "<strong>"+this.x+"</strong><br />"+this.series.name+": "+this.y;
		            }
		        },
				series: [{
					name: "Minha Nota",
					data: [1, 0, 4, 10]
				}, {
					name: "Média da Turma",
					data: [5, 7, 3, 5]
				}],
			});
		})
		</script>
		
		';
		
		return $str;
	}
		
	public function graficoNotasTurma(array $arrayNota, array $arrayAluno, Disciplina $d) {
		$strNota = $strAluno = '';
		
		$countNota = count($arrayNota);
		$countAluno = count($arrayAluno);
		$arrayN = array();
		
		if ($countAluno > 0) {
			$arrayNotasAlunos = $this->Nota->calcularNota($arrayAluno, $arrayNota);
			
			foreach ($arrayAluno as $a) {	
				$strAluno .= '"'.$a->__get('nome').'", ';
			}
			$strAluno = rtrim($strAluno, ', ');
		}
		
		$strNota = implode(',', $arrayNotasAlunos);
		if ($countNota > 0) {
			$str = '
			<div id="graf_nota" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
			<script type="text/javascript" class="code">
			$(document).ready(function(){
				$("#graf_nota").highcharts({
					chart: {
						type: "column"
					},
					exporting: {
						enabled: false
					},
					title: {
						text: "Notas dos alunos em '.$d->__get('nome').'"
					},
					xAxis: {
			  			categories: ['.$strAluno.']
					},
					yAxis: {
						allowDecimals: true,
						title: {
							text: "Nota"
						}
					},
					tooltip: {
			            formatter: function () {
			                return "<strong>"+this.x+"</strong><br />"+this.series.name+": "+this.y;
			            }
			        },
					series: [{
						name: "Alunos",
						data: ['.$strNota.']
					}],
				});
			})
			</script>
			
			';
		} else {
			$str = '<div class="alert alert-warning">Nenhuma nota disponível em <strong>'.$d->__get('nome').'</strong></div>';
		}
		
		return $str;
	}
}


?>