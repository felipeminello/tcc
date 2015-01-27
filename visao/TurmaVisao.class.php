<?php
class TurmaVisao extends GeralVisao {
	private $Turma;
	
	public function setTurma(Turma $t) {
		$this->Turma = $t;
	}
	/*
	public function cadastroAjax(array $arrayCurso, array $arrayValida) {
		$alerta = $jsFocus = $strCurso = $strPeriodo = null;
		$arrayPeriodo = $this->Turma->__get('arrayPeriodo');
		
		if ($arrayValida['r'] === true) {
			$alerta = '<div class="alert alert-success">'.$arrayValida['m'].'</div>';
		} elseif ($arrayValida['r'] === false) {
			$alerta = '<div class="alert alert-danger">'.$arrayValida['m'].'</div>';
		}
		
		if (isset($arrayValida['c'])) {
			if (!empty($arrayValida['c'])) {
				$jsFocus = '$("#'.$arrayValida['c'].'").focus()';
			}
		}
		
		foreach ($arrayCurso as $c) {
			$strSelect = ($this->Turma->__get('Curso')->__get('id') == $c->__get('id')) ? 'selected="selected"' : '';
			
			$strCurso .= '<option value="'.$c->__get('id').'" '.$strSelect.'>'.$c->__get('nome').'</option>';
		}
		
		foreach ($arrayPeriodo as $idPeriodo => $nome) {
			$strPeriodo .= '<option value="'.$idPeriodo.'">'.$nome.'</option>';
		}
		
		$str = '
		<div id="page-wrapper">
			<div class="container-fluid">

				<!-- Page Heading -->
				<div class="row">
					<div class="col-lg-12">
						<h1 class="page-header">
							Inserir Turma
						</h1>
						<form role="form" id="cadastro" style="margin-bottom:15px;">
							<input type="hidden" name="id" id="id" value="'.$this->Turma->__get('id').'">
							<div class="form-group" style="float:left;width:390px; margin: 0 20px 20px 0;">
								<label for="curso">Curso</label>
								<select class="form-control" id="curso" readonly="true">
                                    '.$strCurso.'
                                </select>
							</div>
							
							<div class="form-group" style="float:left;width:390px;">
								<label for="curso">Período</label>
								<select class="form-control" id="periodo">
                                    '.Elementos::popularSelect($arrayPeriodo, $this->Turma->__get('periodo')).'
                                </select>
							</div>
							
							<div style="clear:both;"></div>
							
							<div class="form-group" style="margin: 0 20px 20px 0;">
								<label for="nome">Nome</label>
								<input class="form-control" name="nome" id="nome" value="'.$this->Turma->__get('nome').'">
							</div>
							
							<div class="form-group" style="float:left;width:390px; margin: 0 20px 20px 0;">
								<label for="nome">Data de Início</label>
								<input class="form-control data" name="data_inicio" id="data_inicio" value="'.$this->Turma->__get('dataInicio').'">
							</div>
							
							<div class="form-group" style="float:left;width:390px;">
								<label for="nome">Data de Término</label>
								<input class="form-control data" name="data_fim" id="data_fim" value="'.$this->Turma->__get('dataFim').'">
							</div>
							
							<div style="clear:both;"></div>

							<button class="btn btn-default" type="submit" id="btn_enviar">Enviar</button>

						</form>
						<div id="retorno" class="alert"></div>	
					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript">
		$(document).ready(function() {
			$(".data").datepicker();
		
			$("#cadastro").submit(function() {
				$("#btn_enviar").attr("disabled", true).text("Enviando");
				
				var id = $("#id").val();
				var curso = $("#curso").val();
				var periodo = $("#periodo").val();
				var nome = $("#nome").val();
				var data_inicio = $("#data_inicio").val();
				var data_fim = $("#data_fim").val();
				
				$.ajax({
					type: "POST",
					url: "'.DIR_ROOT_COORDENADOR.'ajax_submit_turma_cadastro",
					data: "id="+id+"&curso="+curso+"&periodo="+periodo+"&nome="+nome+"&data_inicio="+data_inicio+"&data_fim="+data_fim,
					dataType: "json",
					beforeSend: function () {
						$("div#retorno").removeClass("alert-danger alert-success");
						$("div#retorno").html("<img src=\"'.DIR_WWW.'imgs/layout/ajax-loader.gif\" \/>");
					}
				}).done(function(o) {
					$("div#retorno").html(o.m);
					if (o.r == "f") {
						$("div#retorno").addClass("alert-danger");
		
						$("#"+o.c).focus();
					} else {
						$("div#retorno").addClass("alert-success");
						$("#lista_turma").append(\'<a class="list-group-item" href="javascript:void(0)">\'+o.nome+\'</a>\');
						
						setTimeout(function() {
							$.fancybox.close();
						}, 1000);
					}
					$("div#retorno").html(o.m);
				}).fail(function() {
					$("div#retorno").text("Erro ao enviar");
				}).always(function() {
					$("#btn_enviar").attr("disabled", false).text("Enviar");
				});
				return false;
			});
			
			$("#link_listar").click(function() {
				location.href = "'.DIR_ROOT_COORDENADOR.'curso_listar";
			});
			'.$jsFocus.'
		});
		</script>

		';
		
		return $str;
	}
	*/
	public function cadastro(array $arrayCurso, array $arrayValida, $acao = null, $area = null) {
		$alerta = $jsFocus = $strCurso = $strPeriodo = $strBread = $strBotoes = null;
		$arrayPeriodo = $this->Turma->__get('arrayPeriodo');
		
		$idTurma = $this->Turma->__get('id');
		
		if ($arrayValida['r'] === true) {
			$alerta = '<div class="alert alert-success">'.$arrayValida['m'].'</div>';
		} elseif ($arrayValida['r'] === false) {
			$alerta = '<div class="alert alert-danger">'.$arrayValida['m'].'</div>';
		}
		
		if (isset($arrayValida['c'])) {
			if (!empty($arrayValida['c'])) {
				$jsFocus = '$("#'.$arrayValida['c'].'").focus()';
			}
		}
		
		foreach ($arrayCurso as $c) {
			$strSelect = ($this->Turma->__get('Curso')->__get('id') == $c->__get('id')) ? 'selected="selected"' : '';
			
			$strCurso .= '<option value="'.$c->__get('id').'" '.$strSelect.'>'.$c->__get('nome').'</option>';
		}
		
		foreach ($arrayPeriodo as $idPeriodo => $nome) {
			$strPeriodo .= '<option value="'.$idPeriodo.'">'.$nome.'</option>';
		}
		
		if ($area == 'sistema') {
			$strBread = '
			<ol class="breadcrumb">
				<li>
					<a href="'.DIR_ROOT_COORDENADOR.'">Início</a>
				</li>
				<li>
					<a href="'.DIR_ROOT_COORDENADOR.'turma_listar">Listar turmas</a>
				</li>
				<li class="active">
					'.$this->titulo.'
				</li>
			</ol>
			';
			
			if (!empty($idTurma)) {
				$strBotoes = '
				
				';
			}
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
						'.$strBread.'
						<form role="form" id="cadastro" method="post" action="'.$acao.'" style="margin-bottom:15px;">
							<input type="hidden" name="id" id="id" value="'.$this->Turma->__get('id').'">
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group">
										<label for="curso">Curso</label>
										<select class="form-control" id="curso" name="curso">
		                                    '.$strCurso.'
		                                </select>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label for="curso">Período</label>
										<select class="form-control" id="periodo" name="periodo">
		                                    '.Elementos::popularSelect($arrayPeriodo, $this->Turma->__get('periodo')).'
		                                </select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-12">
									<div class="form-group">
										<label for="nome">Nome</label>
										<input class="form-control" name="nome" id="nome" value="'.$this->Turma->__get('nome').'">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group">
										<label for="nome">Data de Início</label>
										<input class="form-control data" name="data_inicio" id="data_inicio" value="'.$this->Turma->__get('dataInicio').'">
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label for="nome">Data de Término</label>
										<input class="form-control data" name="data_fim" id="data_fim" value="'.$this->Turma->__get('dataFim').'">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-12">
									<button class="btn btn-default" type="submit" id="btn_enviar">Enviar</button>
								</div>
							</div>

						</form>
						<div id="retorno_turma" class="alert"></div>	
					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript">
		$(document).ready(function() {
			$(".data").datepicker();
			
			$("#link_listar").click(function() {
				location.href = "'.DIR_ROOT_COORDENADOR.'curso_listar";
			});
			'.$jsFocus.'
		});
		</script>

		';
		
		return $str;
	}
	
	public function scriptCadastroAjax() {
		$str = '
		<script type="text/javascript">
		$(document).ready(function() {
			$("#cadastro").submit(function() {
				$("#btn_enviar").attr("disabled", true).text("Enviando");
				
				var id = $("#id").val();
				var curso = $("#curso").val();
				var periodo = $("#periodo").val();
				var nome = $("#nome").val();
				var data_inicio = $("#data_inicio").val();
				var data_fim = $("#data_fim").val();
				
				$.ajax({
					type: "POST",
					url: "'.DIR_ROOT_COORDENADOR.'ajax_submit_turma_cadastro",
					data: "id="+id+"&curso="+curso+"&periodo="+periodo+"&nome="+nome+"&data_inicio="+data_inicio+"&data_fim="+data_fim,
					dataType: "json",
					beforeSend: function () {
						$("div#retorno_turma").removeClass("alert-danger alert-success");
						$("div#retorno_turma").html("<img src=\"'.DIR_WWW.'imgs/layout/ajax-loader.gif\" \/>");
					}
				}).done(function(o) {
					$("div#retorno_turma").html(o.m);
					if (o.r == "f") {
						$("div#retorno_turma").addClass("alert-danger");
		
						$("#"+o.c).focus();
					} else {
						$("div#retorno_turma").addClass("alert-success");
						$("#lista_turma").append(\'<a class="list-group-item" href="javascript:void(0)">\'+o.nome+\'</a>\');
						
						setTimeout(function() {
							$.fancybox.close();
						}, 1000);
					}
					$("div#retorno_turma").html(o.m);
				}).fail(function() {
					$("div#retorno_turma").text("Erro ao enviar");
				}).always(function() {
					$("#btn_enviar").attr("disabled", false).text("Enviar");
				});
				return false;
			});
		});
		</script>
		
		';
		
		return $str;
	}
	
	public function listar(array $arrayCurso, array $arrayPeriodo, array $arrayTurma, array $arrayTotalAluno = array(), array $arrayTotalProfessor = array()) {
		$strTurma = $strCurso = $strPeriodo = '';

		
		foreach ($arrayCurso as $c) {
			$strCurso .= '<option value="'.$c->__get('id').'">'.$c->__get('nome').'</option>';
		}
		
		$strPeriodo = Elementos::popularSelect($arrayPeriodo);
		
		$tabelaTurma = self::tabelaTurmas($arrayTurma, $arrayPeriodo);
		
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
						
						
						<p align="right"><button class="btn btn-default" id="link_inserir" type="button">Inserir Turma</button></p>
						<form id="filtro">
							<div class="col-lg-3" style="padding-left:0;">
								<div class="form-group">
									<label>Data de início</label>
									<input id="data_inicio" class="form-control data">
								</div>
							</div>
							<div class="col-lg-3">				  
								<div class="form-group">
									<label>Data de término</label>
									<input id="data_fim" class="form-control data">
								</div>						
							</div>
							<div class="col-lg-2">				  
								<div class="form-group">
									<label>Selecione o Curso</label>
									<select id="curso" class="form-control">
										<option value="0">Todos</option>
										'.$strCurso.'
									</select>
								</div>						
							</div>
							<div class="col-lg-2" style="padding-right:0;">				  
								<div class="form-group">
									<label>Selecione o Período</label>
									<select id="periodo" class="form-control">
										<option value="0">Todos</option>
										'.$strPeriodo.'
									</select>
								</div>						
							</div>
							<div class="col-lg-2 text-center" style="padding-right:0;">				  
								<div class="form-group" style="padding-top:25px;">
									<button class="btn btn-default" style="width:100%;" type="submit">Filtrar</button>
								</div>						
							</div>
							<div style="clear:both;"></div>
						</form>
						
						<form id="lista" method="post" action="'.DIR_ROOT_COORDENADOR.'professor_listar">
						<div class="table-responsive" id="show_turma">
							'.$tabelaTurma.'
						</div>
						</form>

						<div id="retorno" class="alert"></div>
					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript">
		$(document).ready(function() {
			$("#select_all").change(function() {
				var checkboxes = $(this).closest("form#lista").find(":checkbox");
				if($(this).is(":checked")) {
					checkboxes.attr("checked", "checked");
				} else {
					checkboxes.removeAttr("checked");
				}
			});
			
			$(".excluir").on("click", function() {
				return confirm("Confirma a exclusão?");
			});
			
			$(".data").datepicker();
			
			
			$("td.check").click(function(e) {
				var chk = $(this).closest("tr").find("input:checkbox").get(0);
				if(e.target != chk)	{
					chk.checked = !chk.checked;
				}
			});
			
			$("#lista").submit(function() {
				var total = $(":checkbox:checked").length;
				
				if (total > 0) {
					return confirm("Deseja excluir os itens selecionados?");
				} else {
					$("#retorno").addClass("alert-danger").text("Nenhum item marcado");
					return false;
				}
			});
			
			$(".abrir_info").click(function() {
				var id = $(this).attr("id").substr(1);
				
				
				if ($("#show_info_"+id).is(":hidden")) {
					$("#show_info_"+id).load("'.DIR_ROOT_COORDENADOR.'ajax_turma_listar_info/"+id, function() {
						$(this).slideDown("fast");
					});
				} else {
					$("#show_info_"+id).slideUp("fast");
				}
			});
			
			$("#link_inserir").click(function() {
				location.href = "'.DIR_ROOT_COORDENADOR.'turma_inserir";
			});
			
			$("#add_turma").fancybox({
				minWidth	: 700
			});
			
			$("form#filtro").submit(function() {
				var dataInicio = $("#data_inicio").val();
				var dataFim = $("#data_fim").val();
				var periodo = $("#periodo").val();
				var curso = $("#curso").val();
				
				$.ajax({
					type: "POST",
					url: "'.DIR_ROOT_COORDENADOR.'ajax_turma_listar_tabela/",
					data: { data_inicio: dataInicio, data_fim: dataFim, periodo: periodo, curso: curso },
					contentType: "application/x-www-form-urlencoded; charset='.CODING.'"
				}).done(function(data) {
					$("#show_turma").html(data);
				}).fail(function() {
					$("#show_turma").text("Erro ao carregar");
				});
								
				return false;
			});
		});
		</script>
		';
		
		return $str;
	}

	public function tabelaTurmas(array $arrayTurma, array $arrayPeriodo, $idCurso = 0) {
		$strTurma = '';
		$countTurma = count($arrayTurma);
		
		if ($countTurma > 0) {
			foreach ($arrayTurma as $idTurma => $t) {
				$strTurma .= '<tr>';
				$strTurma .= '<td align="center" class="check" style="cursor:pointer;"><input type="checkbox" name="apagar[]" value="'.$t->__get('id').'"></td>';
				$strTurma .= '<td>'.$t->__get('nome').'</td>';
				$strTurma .= '<td align="center">'.$t->__get('Curso')->__get('nome').'</td>';
				$strTurma .= '<td align="center">'.$arrayPeriodo[$t->__get('periodo')].'</td>';
				$strTurma .= '<td align="center">'.$t->__get('dataInicio').'</td>';
				$strTurma .= '<td align="center">'.$t->__get('dataFim').'</td>';
				$strTurma .= '<td align="center"><a href="'.DIR_ROOT_COORDENADOR.'aluno_turma_ver/'.$t->__get('id').'" style="text-decoration:none;" title="Ver alunos"><img src="'.DIR_WWW.'imgs/layout/alunos24.png" /></a> <a href="'.DIR_ROOT_COORDENADOR.'aluno_professor_ver/'.$t->__get('id').'" style="text-decoration:none;" title="Ver professores"><img src="'.DIR_WWW.'imgs/layout/professores24.png" /></a> <a href="'.DIR_ROOT_COORDENADOR.'turma_editar/'.$t->__get('id').'" style="text-decoration:none;" title="Editar"><img src="'.DIR_WWW.'imgs/layout/edit24.png" /></a> <a href="'.DIR_ROOT_COORDENADOR.'turma_excluir/'.$t->__get('id').'" style="text-decoration:none;" class="excluir" title="Excluir"><img src="'.DIR_WWW.'imgs/layout/del24.png" /></a></td>';
				$strTurma .= '</tr>';
				
				$strTurma .= '<tr>';
				$strTurma .= '<td colspan="6" style="padding:0;"><div style="display:none;padding-top:20px;" id="show_info_'.$t->__get('id').'"></div></td>';
				$strTurma .= '</tr>';
			}
			$str = '
			<table id="lista_turma" class="table table-bordered table-hover table-striped">
				<thead>
					<tr>
						<th style="text-align:center;width:50px;"><input type="checkbox" id="select_all" value="1"></th>
						<th>Turma</th>
						<th style="text-align:center;">Curso</th>
						<th style="text-align:center;">Período</th>
						<th style="text-align:center;">Data Início</th>
						<th style="text-align:center;">Data Término</th>
						<th style="text-align:center;width:140px;">Ação</th>
					</tr>
				</thead>
				<tfoot>
					<td align="center"><button class="btn btn-sm btn-danger" type="submit">Excluir</button></td>
					<td colspan="6"></td>
				</tfoot>
				<tbody>
					'.$strTurma.'
				</tbody>
			</table>';
		} else {
			$str = self::alerta('Nenhuma turma encontrada');
		}

		return $str;
	}
	
}
?>