<?php
class ProfessorVisao extends GeralVisao {
	private $Professor;
	
	public function setProfessor(Professor $p) {
		$this->Professor = $p;
	}
	
	public function cadastro(array $arrayValida, $acao, $arrayCurso = array(), $idCurso = 0, $idTurma = 0) {
		$alerta = $jsFocus = $jsTurma = $strCombo = $strBotoes = null;
		$strCheckSexo = array();
		$idProfessor = $this->Professor->__get('id');
		
		$strCurso = '<option value="0">Selecione o curso</option>';
		
		foreach ($arrayCurso as $c) {
			$check = ($idCurso == $c->__get('id')) ? 'selected="selected"' : '';
			$strCurso .= '<option value="'.$c->__get('id').'" '.$check.'>'.$c->__get('nome').'</option>';
		}
		
		if (!empty($idTurma))
			$jsTurma = '$("#turma").load("'.DIR_ROOT_COORDENADOR.'ajax_turma_listar/'.$idCurso.'/'.$idTurma.'");';
		
		
		$strCheckSexo['m'] = ($this->Professor->__get('sexo') == 'm') ? 'selected="selected"' : '';
		$strCheckSexo['f'] = ($this->Professor->__get('sexo') == 'f') ? 'selected="selected"' : '';
		
		if ($arrayValida['r'] === true) {
			$alerta = '<div class="alert alert-success">'.$arrayValida['m'].'</div>';
		} elseif ($arrayValida['r'] === false) {
			$alerta = '<div class="alert alert-danger">'.$arrayValida['m'].'</div>';
		}
		
		if (isset($arrayValida['c'])) {
			if (!empty($arrayValida['c'])) {
				$jsFocus = '$("#'.$arrayValida['c'].'").focus();';
			}
		}
		
		if (!empty($idCurso) and !empty($idTurma)) {
			$strCombo = '
			<div class="row" style="margin-bottom:20px;">
				<div class="col-lg-6">
					<label>Curso</label>
					<select class="form-control" name="curso" id="curso">
						'.$strCurso.'
					</select>
					
				</div>
				<div class="col-lg-6">
					<label>Turma</label>
					<select class="form-control" name="turma" id="turma">
						<option value="0">Selecione o curso primeiro</option>
					</select>
					
				</div>
			</div>
			';
		}
		
		if (!empty($idProfessor)) {
			$strBotoes = '
			<button class="btn btn-primary" id="link_turma_ver" type="button">Ver Turmas</button>
			<button class="btn btn btn-success" id="link_turma_ins" type="button">Inserir na Turma</button>
			<button class="btn btn-info" id="link_disciplina_ver" type="button">Ver Disciplinas</button>
			<button class="btn btn-warning" id="link_disciplina_ins" type="button">Inserir Disciplina</button>
			<button class="btn btn-danger" id="link_material_ver" type="button">Material</button>
			<button class="btn btn-primary" id="link_disciplina_var" type="button">Notas e Faltas</button>
			';			
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
							<li>
								<a href="'.DIR_ROOT_COORDENADOR.'">Início</a>
							</li>
							<li>
								<a href="'.DIR_ROOT_COORDENADOR.'professor_listar">Professores</a>
							</li>
							<li class="active">
								'.$this->titulo.'
							</li>
						</ol>
						<p align="right"><button class="btn btn-default" id="link_listar" type="button">Listar Professores</button>
						'.$strBotoes.'
						</p>
						<form role="form" method="post" action="'.$acao.'" id="cadastro" style="margin-bottom:15px;" enctype="multipart/form-data">
							<input type="hidden" name="id" value="'.$this->Professor->__get('id').'">
							'.$strCombo.'
							<div class="row" style="margin-bottom:20px;">
								<div class="col-lg-3">
									<label>Nome</label>
									<input class="form-control" type="text" id="nome" name="nome" value="'.$this->Professor->__get('nome').'">
								</div>
								<div class="col-lg-3">
									<label>Sexo</label>
									<select class="form-control" name="sexo" id="sexo">
										<option value="m" '.$strCheckSexo['m'].'>Masculino</option>
										<option value="f" '.$strCheckSexo['f'].'>Feminino</option>
									</select>
								</div>
								<div class="col-lg-3">
									<label>Email</label>
									<input class="form-control" type="text" id="email" name="email" value="'.$this->Professor->__get('email').'">
								</div>
								<div class="col-lg-3">
									<label>Telefone</label>
									<input class="form-control telefone" type="text" id="telefone" name="telefone" value="'.$this->Professor->__get('telefone').'">
								</div>
							</div>
							<div class="row" style="margin-bottom:20px;">
								<div class="col-lg-6">
									<label>Senha</label>
									<input class="form-control" type="password" id="senha" name="senha">
								</div>
								<div class="col-lg-6">
									<label>Confirma a senha</label>
									<input class="form-control" type="password" id="conf_senha" name="conf_senha">
								</div>
							</div>
							
							<div class="row" style="margin-bottom:20px;">
								<div class="col-lg-6">
									<div><img src="'.$this->Professor->exibeImagem().'"></div>
                                	<label>Foto</label>
                                	<input type="file" name="foto" accept="image/*">
                                </div>
                            </div>							
							
							<div class="row" style="margin-bottom:20px;">
								<div class="col-lg-1">
									<button class="btn btn-default" type="submit">Enviar</button>
								</div>
							</div>
						</form>
						<div id="alerta">'.$alerta.'</div>
					</div>	
				</div>
			</div>
		</div>
		<script type="text/javascript">
		$(document).ready(function() {
			$("#link_turma_ver").fancybox({
				minWidth : 700,
				minHeight : 460,
				type : "ajax",
				href : "'.DIR_ROOT_COORDENADOR.'popup_professor_turma_ver/'.$this->Professor->__get('id').'"
			});

			$("#link_turma_ins").fancybox({
				minWidth : 700,
				minHeight : 360,
				type : "ajax",
				scrolling: "no",
				href : "'.DIR_ROOT_COORDENADOR.'popup_professor_turma_inserir/'.$this->Professor->__get('id').'"
			});
		
			$("#link_disciplina_ver").fancybox({
				minWidth : 700,
				minHeight : 460,
				type : "ajax",
				href : "'.DIR_ROOT_COORDENADOR.'popup_professor_disciplina_ver/'.$this->Professor->__get('id').'"
			});

			$("#link_disciplina_ins").fancybox({
				minWidth : 700,
				minHeight : 360,
				type : "ajax",
				scrolling: "no",
				href : "'.DIR_ROOT_COORDENADOR.'popup_professor_disciplina_inserir/'.$this->Professor->__get('id').'"
			});
			
		
			$("#link_material_ver").fancybox({
				minWidth : 700,
				minHeight : 460,
				type : "ajax",
				href : "'.DIR_ROOT_COORDENADOR.'popup_professor_material_ver/'.$this->Professor->__get('id').'"
			});
			
		
			$(".telefone").keydown(function(e) {
				if($(this).val().substring(5,6) == "9"){
					$(this).setMask("(99) 9.9999.9999");
				} else {
					$(this).setMask("(99) 9999.9999");
				}
				$(this).setMask();
			});
			
			$("#curso").change(function() {
				$("#turma").load("'.DIR_ROOT_COORDENADOR.'ajax_turma_listar/"+$(this).val());
			});

			$("#cadastro").submit(function() {
				$("#btn_enviar").attr("disabled", true).text("Enviando");
			});
			
			$("#link_listar").click(function() {
				location.href = "'.DIR_ROOT_COORDENADOR.'professor_listar";
			});
			
			'.$jsFocus.'
			
			'.$jsTurma.'
		});
		</script>
		';
		
		return $str;
	}

	public function excluir(array $arrayValida) {
		$alerta = $jsFocus = $jsTurma = null;
		$strCheckSexo = array();
		
		
		
		if ($arrayValida['r'] === true) {
			$alerta = '<div class="alert alert-success">'.$arrayValida['m'].'</div>';
		} elseif ($arrayValida['r'] === false) {
			$alerta = '<div class="alert alert-danger">'.$arrayValida['m'].'</div>';
		}
		
		if (isset($arrayValida['c'])) {
			if (!empty($arrayValida['c'])) {
				$jsFocus = '$("#'.$arrayValida['c'].'").focus();';
			}
		}
		
		$str = '
		<div id="page-wrapper">
			<div class="container-fluid">

				<!-- Page Heading -->
				<div class="row">
					<div class="col-lg-12">
						<h1 class="page-header">
							Excluir Professor
						</h1>
						
						<ol class="breadcrumb">
							<li>
								<i class="fa fa-dashboard"></i>  <a href="'.DIR_ROOT_COORDENADOR.'">Início</a>
							</li>
							<li>
								<i class="fa fa-bar-chart-o"></i> <a href="'.DIR_ROOT_COORDENADOR.'professor_listar">Professores</a>
							</li>
							<li class="active">
								<i class="fa fa-bar-chart-o"></i> Excluir Professor
							</li>
						</ol>
						<p align="right"><button class="btn btn-default" id="link_listar" type="button">Listar Professores</button></p>
						'.$alerta.'
					</div>	
				</div>
			</div>
		</div>
		<script type="text/javascript">
		$(document).ready(function() {
			$("#link_listar").click(function() {
				location.href = "'.DIR_ROOT_COORDENADOR.'professor_listar";
			});
		});
		</script>
		';
		
		return $str;
	}

	public function listar(array $arrayCurso, array $arrayProfessor, $idCurso = 0, $idTurma = 0) {
		$strProfessor = $jsTurma = '';
		$strCurso = '<option value="0">Todos os Cursos</option>';
		
		foreach ($arrayCurso as $c) {
			$strCheck = ($c->__get('id') == $idCurso) ? 'selected="selected"' : '';
			
			$strCurso .= '<option value="'.$c->__get('id').'" '.$strCheck.'>'.$c->__get('nome').'</option>';
		}
		
		if (!empty($idCurso))
			$jsTurma = '$("#turma").load("'.DIR_ROOT_COORDENADOR.'ajax_turma_listar/'.$idCurso.'/'.$idTurma.'");';
		
		$tabelaProfessor = self::tabelaProfessores($arrayProfessor);
			
		$str = '
		<div id="page-wrapper">
			<div class="container-fluid">

				<!-- Page Heading -->
				<div class="row">
					<div class="col-lg-12">
						<h1 class="page-header">
							Professores
						</h1>
						<ol class="breadcrumb">
							<li>
								<i class="fa fa-dashboard"></i>  <a href="'.DIR_ROOT_COORDENADOR.'">Início</a>
							</li>
							<li class="active">
								<i class="fa fa-bar-chart-o"></i> Professores
							</li>
						</ol>
						
						<p align="right"><button class="btn btn-default" id="link_inserir" type="button">Inserir Professor</button></p>
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
						
						<form id="lista" method="post" action="'.DIR_ROOT_COORDENADOR.'professor_listar">
						<div class="table-responsive" id="show_professor">
							'.$tabelaProfessor.'
						</div>
						</form>
						
						<div id="retorno" class="alert"></div>
					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript">
		$(document).ready(function() {
			$("#select_all").on("click", function() {
				var checkboxes = $(this).closest("form#lista").find(":checkbox");
				if($(this).is(":checked")) {
					checkboxes.attr("checked", "checked");
				} else {
					checkboxes.removeAttr("checked");
				}
			});
			
			'.$jsTurma.'
			
			$(".excluir").on("click", function() {
				return confirm("Confirma a exclusão?");
			});
			
			$("td.check").on("click", function(e) {
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
			
			$("#curso").change(function() {
				$.ajax({
					type: "POST",
					url: "'.DIR_ROOT_COORDENADOR.'ajax_professor_listar/",
					data: { id_curso: $(this).val() },
					beforeSend: function() {
						$("#show_professor").html(\'<div align="center"><img src="'.DIR_WWW.'imgs/layout/ajax-loader.gif"></div>\');
					},
					contentType: "application/x-www-form-urlencoded; charset='.CODING.'"
				}).done(function(data) {
					$("#show_professor").html(data);
				}).fail(function() {
					$("#show_professor").text("Erro ao carregar");
				});
				
				$("#turma").load("'.DIR_ROOT_COORDENADOR.'ajax_turma_listar/"+$(this).val());
			});
			
			$("#turma").change(function() {
				$.ajax({
					type: "POST",
					url: "'.DIR_ROOT_COORDENADOR.'ajax_professor_listar/",
					data: { id_curso: $("#curso").val(), id_turma: $(this).val() },
					beforeSend: function() {
						$("#show_professor").html(\'<div align="center"><img src="'.DIR_WWW.'imgs/layout/ajax-loader.gif"></div>\');
					},
					contentType: "application/x-www-form-urlencoded; charset='.CODING.'"
				}).done(function(data) {
					$("#show_professor").html(data);
				}).fail(function() {
					$("#show_professor").text("Erro ao carregar");
				});
			});
						
			$("#link_inserir").click(function() {
				location.href = "'.DIR_ROOT_COORDENADOR.'professor_inserir";
			});
		});
		</script>
		';
		
		return $str;
	}
	
	public function tabelaProfessores(array $arrayProfessor, $idCurso = 0, $idTurma = 0) {
		$strProfessor = '';
		$countProfessor = count($arrayProfessor);
		
		if ($countProfessor > 0) {
			foreach ($arrayProfessor as $idProfessor => $p) {
				$strProfessor .= '<tr>';
				$strProfessor .= '<td align="center" class="check" style="cursor:pointer;"><input type="checkbox" name="apagar[]" value="'.$p->__get('id').'"></td>';
				$strProfessor .= '<td class="abrir_info" id="c'.$p->__get('id').'" style="cursor:pointer;">'.$p->__get('nome').'</td>';
				$strProfessor .= '<td align="center">'.$p->__get('email').'</td>';
				$strProfessor .= '<td align="center">'.$p->__get('telefone').'</td>';
				$strProfessor .= '<td align="center"><a href="'.DIR_ROOT_COORDENADOR.'professor_editar/'.$p->__get('id').'" style="text-decoration:none;"><img src="'.DIR_WWW.'imgs/layout/edit24.png" /></a> <a href="'.DIR_ROOT_COORDENADOR.'professor_excluir/'.$p->__get('id').'" style="text-decoration:none;" class="excluir"><img src="'.DIR_WWW.'imgs/layout/del24.png" /></a></td>';
				$strProfessor .= '</tr>';
				
				$strProfessor .= '<tr>';
				$strProfessor .= '<td colspan="6" style="padding:0;"><div style="display:none;padding-top:20px;" id="show_info_'.$p->__get('id').'"></div></td>';
				$strProfessor .= '</tr>';
			}
		} else {
			$strProfessor .= '<tr><td colspan="10" align="center" style="color: #8a6d3b; background-color: #fcf8e3;"><a href="'.DIR_ROOT_COORDENADOR.'professor_inserir/'.$idCurso.'/'.$idTurma.'" style="color: #8a6d3b; font-weight: bold;">Nenhum professor encontrado. Clique aqui para inserir o Professor.</td></td>';
		}
					
		$str = '
		<table id="lista_professor" class="table table-bordered table-hover table-striped">
			<thead>
				<tr>
					<th style="text-align:center;width:50px;"><input type="checkbox" id="select_all" value="1"></th>
					<th>Nome</th>
					<th style="text-align:center;">Email</th>
					<th style="text-align:center;">Telefone</th>
					<th style="text-align:center;">Acao</th>
				</tr>
			</thead>
			<tfoot>
				<td align="center"><button class="btn btn-sm btn-danger" type="submit">Excluir</button></td>
				<td colspan="6"></td>
			</tfoot>
			<tbody>
				'.$strProfessor.'
			</tbody>
		</table>';
		
		return $str;
	}
	
	public function inserirTurma(array $arrayCurso) {
		$strCurso = '<option value="0">Selecione o Curso</option>';
		
		foreach ($arrayCurso as $c) {
			$strCurso .= '<option value="'.$c->__get('id').'">'.$c->__get('nome').'</option>';
		}
		
		$str = '
		<h1 class="page-header">
			Inserir Turma
		</h1>
		<form role="form" id="inserir_turma">
		<div class="row">
			<div class="col-lg-6">
				<div class="form-group">
					<label>Curso</label>
					<select class="form-control" id="curso">
						'.$strCurso.'
					</select>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="form-group">
					<label>Turma</label>
					<select class="form-control" id="turma">
						<option value="0">Selecione primeiro o Curso</option>
					</select>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<button class="btn btn-default" type="submit" id="enviar">Cadastrar</button>
			</div>
		</div>
		</form>
		<div id="retorno" class="alert" style="margin-top:15px;"></div>
		<script type="text/javascript">
		$(document).ready(function() {
			$("#curso").change(function() {
				$("#turma").load("'.DIR_ROOT_COORDENADOR.'ajax_turma_listar_professor/"+$(this).val()+"/'.$this->Professor->__get('id').'");
			});
			
			$("form#inserir_turma").submit(function() {
				var curso = $("#curso").attr("value");
				var turma = $("#turma").attr("value");
				
				$("#enviar").attr("disabled", true);
				
				$.ajax({
					type: "POST",
					url: "'.DIR_ROOT_COORDENADOR.'ajax_submit_professor_turma_inserir",
					data: "id_professor='.$this->Professor->__get('id').'&id_curso="+curso+"&id_turma="+turma,
					dataType: "json",
					beforeSend: function () {
						$("#retorno").removeClass("alert-danger alert-success");
						$("div#retorno").html("<img src=\"'.DIR_WWW.'imgs/layout/ajax-loader.gif\" \/>");
					}
				}).done(function(o) {
					if (o.r == "f") {
						$("#retorno").addClass("alert-danger");
						$("#"+o.c).focus();
					} else {
						$("#retorno").addClass("alert-success");
					}
					$("#retorno").html(o.m);
				}).fail(function() {
					$("#retorno").addClass("alert-danger").text("Erro ao enviar");
				}).always(function() {
					$("#enviar").attr("disabled", false);
				});
				return false;
			
			});
		});
		</script>
		';
		
		return $str;
	}
	
	public function inserirDisciplina(array $arrayCurso) {
		$strCurso = '<option value="0">Selecione o Curso</option>';
		
		foreach ($arrayCurso as $c) {
			$strCurso .= '<option value="'.$c->__get('id').'">'.$c->__get('nome').'</option>';
		}
		
		$str = '
		<h1 class="page-header">
			Inserir Turma
		</h1>
		<form role="form" id="inserir_disciplina">
		<div class="row">
			<div class="col-lg-6">
				<div class="form-group">
					<label>Curso</label>
					<select class="form-control" id="curso">
						'.$strCurso.'
					</select>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="form-group">
					<label>Disciplina</label>
					<select class="form-control" id="disciplina">
						<option value="0">Selecione primeiro o Curso</option>
					</select>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<button class="btn btn-default" type="submit" id="enviar">Cadastrar</button>
			</div>
		</div>
		</form>
		<div id="retorno" class="alert" style="margin-top:15px;"></div>
		<script type="text/javascript">
		$(document).ready(function() {
			$("#curso").change(function() {
				$("#disciplina").load("'.DIR_ROOT_COORDENADOR.'ajax_disciplina_listar_professor/"+$(this).val()+"/'.$this->Professor->__get('id').'");
			});
			
			$("form#inserir_disciplina").submit(function() {
				var curso = $("#curso").attr("value");
				var disciplina = $("#disciplina").attr("value");
				
				$("#enviar").attr("disabled", true);
				
				$.ajax({
					type: "POST",
					url: "'.DIR_ROOT_COORDENADOR.'ajax_submit_professor_disciplina_inserir",
					data: "id_professor='.$this->Professor->__get('id').'&id_curso="+curso+"&id_disciplina="+disciplina,
					dataType: "json",
					beforeSend: function () {
						$("#retorno").removeClass("alert-danger alert-success");
						$("div#retorno").html("<img src=\"'.DIR_WWW.'imgs/layout/ajax-loader.gif\" \/>");
					}
				}).done(function(o) {
					if (o.r == "f") {
						$("#retorno").addClass("alert-danger");
						$("#"+o.c).focus();
					} else {
						$("#retorno").addClass("alert-success");
					}
					$("#retorno").html(o.m);
				}).fail(function() {
					$("#retorno").addClass("alert-danger").text("Erro ao enviar");
				}).always(function() {
					$("#enviar").attr("disabled", false);
				});
				return false;
			
			});
		});
		</script>
		';
		
		return $str;
	}
	
	public function tabelaTurmas(array $arrayTurma) {
		$strTurma = '';
		
		foreach ($arrayTurma as $t) {
			$strTurma .= '
			<tr id="tr'.$t->__get('id').'">
				<td>'.$t->__get('Curso')->__get('nome').'</td>
				<td>'.$t->__get('nome').'</td>
				<td>'.$t->getNomePeriodo().'</td>
				<td>'.$t->__get('dataInicio').'</td>
				<td align="center"><a href="javascript:void(0)" class="excluir" id="t'.$t->__get('id').'" style="text-decoration:none;" class="excluir"><img src="'.DIR_WWW.'imgs/layout/del24.png" /></a></td>
			</tr>
			';
		}
		
		$str = '
		<h1 class="page-header">
			Turmas Cadastradas
		</h1>
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th>Curso</th>
						<th>Turma</th>
						<th>Período</th>
						<th>Data de Início</th>
						<th style="text-align:center;">Ação</th>
					</tr>
				</thead>
				<tbody>
					'.$strTurma.'
				</tbody>
			</table>
		</div>
		<div id="retorno" class="alert"></div>
		<script type="text/javascript">
		$(document).ready(function() {
			$(".excluir").click(function() {
				var id = $(this).attr("id").substr(1);
				
				if (confirm("Confirma exclusão do professor na turma?")) {
					$.ajax({
						type: "POST",
						url: "'.DIR_ROOT_COORDENADOR.'ajax_professor_turma_excluir/",
						data: { id_turma: id, id_professor: '.$this->Professor->__get('id').' },
						beforeSend: function() {
							$("#retorno").removeClass("alert-danger alert-success")
							$("#retorno").html(\'<td colspan="5" align="center"><img src="'.DIR_WWW.'imgs/layout/ajax-loader.gif"></td>\');
						},
						contentType: "application/x-www-form-urlencoded; charset='.CODING.'"
					}).done(function(o) {
						$("#retorno").html(o.m);
						if (o.r == "t") {
							$("#retorno").addClass("alert-success");
							$("#tr"+id).slideDown("slow", function() {
								$(this).remove();
							});							
						} else
							$("#retorno").addClass("alert-danger");


					}).fail(function() {
						$("#retorno").addClass("alert-danger").text("Erro ao carregar");
					});
				} else {
					return false;
				}					
			});
		});
		</script>
		';
		return $str;
	}
	
		public function tabelaDisciplina(array $arrayDisciplina) {
		$strDisciplina = '';
		
		foreach ($arrayDisciplina as $d) {
			$strDisciplina .= '
			<tr id="tr'.$d->__get('id').'">
				<td>'.$d->__get('Curso')->__get('nome').'</td>
				<td>'.$d->__get('nome').'</td>
				<td align="center"><a href="javascript:void(0)" class="excluir" id="t'.$d->__get('id').'" style="text-decoration:none;" class="excluir"><img src="'.DIR_WWW.'imgs/layout/del24.png" /></a></td>
			</tr>
			';
		}
		
		$str = '
		<h1 class="page-header">
			Disciplinas Cadastradas
		</h1>
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th>Curso</th>
						<th>Disciplina</th>
						<th style="text-align:center;">Ação</th>
					</tr>
				</thead>
				<tbody>
					'.$strDisciplina.'
				</tbody>
			</table>
		</div>
		<div id="retorno" class="alert"></div>
		<script type="text/javascript">
		$(document).ready(function() {
			$(".excluir").click(function() {
				var id = $(this).attr("id").substr(1);
				
				if (confirm("Confirma exclusão do professor na disciplina?")) {
					$.ajax({
						type: "POST",
						url: "'.DIR_ROOT_COORDENADOR.'ajax_professor_disciplina_excluir/",
						data: { id_disciplina: id, id_professor: '.$this->Professor->__get('id').' },
						beforeSend: function() {
							$("#retorno").removeClass("alert-danger alert-success")
							$("#retorno").html(\'<td colspan="5" align="center"><img src="'.DIR_WWW.'imgs/layout/ajax-loader.gif"></td>\');
						},
						contentType: "application/x-www-form-urlencoded; charset='.CODING.'"
					}).done(function(o) {
						$("#retorno").html(o.m);
						if (o.r == "t") {
							$("#retorno").addClass("alert-success");
							$("#tr"+id).slideDown("slow", function() {
								$(this).remove();
							});							
						} else
							$("#retorno").addClass("alert-danger");


					}).fail(function() {
						$("#retorno").addClass("alert-danger").text("Erro ao carregar");
					});
				} else {
					return false;
				}					
			});
		});
		</script>
		';
		return $str;
	}
	
}


?>