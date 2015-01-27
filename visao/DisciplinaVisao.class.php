<?php
class DisciplinaVisao extends GeralVisao {
	private $Disciplina;
	
	public function setDisciplina(Disciplina $d) {
		$this->Disciplina = $d;
	}
	
	public function cadastro(array $arrayValida, $acao, $arrayCurso = array(), $idCurso = 0) {
		$alerta = $jsFocus = null;
		$idDisciplina = $this->Disciplina->__get('id');
		
		$strCurso = '<option value="0">Selecione o curso</option>';
		
		foreach ($arrayCurso as $c) {
			$check = ($idCurso == $c->__get('id')) ? 'selected="selected"' : '';
			$strCurso .= '<option value="'.$c->__get('id').'" '.$check.'>'.$c->__get('nome').'</option>';
		}
		
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
							'.$this->titulo.'
						</h1>
						
						<ol class="breadcrumb">
							<li>
								<a href="'.DIR_ROOT_COORDENADOR.'">Início</a>
							</li>
							<li>
								<a href="'.DIR_ROOT_COORDENADOR.'disciplina_listar">Listar disciplinas</a>
							</li>
							<li class="active">
								'.$this->titulo.'
							</li>
						</ol>
						<p align="right">
							<button class="btn btn-default" id="link_listar" type="button">Listar Disciplinas</button>
						</p>
						
					
						<form role="form" method="post" action="'.$acao.'" id="cadastro" style="margin-bottom:15px;" enctype="multipart/form-data">
							<input type="hidden" name="id" value="'.$this->Disciplina->__get('id').'">
							<div class="row" style="margin-bottom:20px;">
								<div class="col-lg-6">
									<div class="form-group">
										<label>Curso</label>
										<select class="form-control" name="curso" id="curso">
											'.$strCurso.'
										</select>
									</div>
								</div>
							
								<div class="col-lg-6">
									<div class="form-group">
										<label>Nome</label>
										<input class="form-control" type="text" id="nome" name="nome" value="'.$this->Disciplina->__get('nome').'">
									</div>
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
				href : "'.DIR_ROOT_COORDENADOR.'popup_disciplina_turma_ver/'.$this->Disciplina->__get('id').'"
			});

			$("#cadastro").submit(function() {
				$("#btn_enviar").attr("disabled", true).text("Enviando");
			});
			
			$("#link_listar").click(function() {
				location.href = "'.DIR_ROOT_COORDENADOR.'disciplina_listar";
			});
			
			'.$jsFocus.'
		});
		</script>
		';
		
		return $str;
	}
	

	public function listar(array $arrayCurso, array $arrayDisciplina, $idCurso = 0) {
		$strDisciplina = $jsTurma = '';
		$strCurso = '<option value="0">Todos os Cursos</option>';
		
		foreach ($arrayCurso as $c) {
			$strCheck = ($c->__get('id') == $idCurso) ? 'selected="selected"' : '';
			
			$strCurso .= '<option value="'.$c->__get('id').'" '.$strCheck.'>'.$c->__get('nome').'</option>';
		}
		
		$tabelaDisciplina = self::tabelaDisciplinas($arrayDisciplina, $idCurso);
			
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
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<p align="right"><button class="btn btn-default" id="link_inserir" type="button">Inserir Disciplina</button></p>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="form-group">
							<label>Selecione o Curso</label>
							<select id="curso" class="form-control">
								'.$strCurso.'
							</select>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<form id="lista" method="post" action="'.DIR_ROOT_COORDENADOR.'disciplina_listar">
						<div class="table-responsive" id="show_disciplina">
							'.$tabelaDisciplina.'
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
					url: "'.DIR_ROOT_COORDENADOR.'ajax_disciplina_listar_tabela/",
					data: { id_curso: $(this).val() },
					beforeSend: function() {
						$("#show_disciplina").html(\'<div align="center"><img src="'.DIR_WWW.'imgs/layout/ajax-loader.gif"></div>\');
					},
					contentType: "application/x-www-form-urlencoded; charset='.CODING.'"
				}).done(function(data) {
					$("#show_disciplina").html(data);
				}).fail(function() {
					$("#show_disciplina").text("Erro ao carregar");
				});
			});
						
			$("#link_inserir").click(function() {
				location.href = "'.DIR_ROOT_COORDENADOR.'disciplina_inserir";
			});
		});
		</script>
		';
		
		return $str;
	}
	
	public function tabelaDisciplinas(array $arrayDisciplina, $idCurso = 0) {
		$strDisciplina = '';
		$countDisciplina = count($arrayDisciplina);
		
		if ($countDisciplina > 0) {
			foreach ($arrayDisciplina as $idDisciplina => $d) {
				$strDisciplina .= '<tr>';
				$strDisciplina .= '<td align="center" class="check" style="cursor:pointer;"><input type="checkbox" name="apagar[]" value="'.$d->__get('id').'"></td>';
				$strDisciplina .= '<td>'.$d->__get('nome').'</td>';
				$strDisciplina .= '<td>'.$d->__get('Curso')->__get('nome').'</td>';
				$strDisciplina .= '<td align="center"><a href="'.DIR_ROOT_COORDENADOR.'disciplina_editar/'.$d->__get('id').'" style="text-decoration:none;"><img src="'.DIR_WWW.'imgs/layout/edit24.png" /></a> <a href="'.DIR_ROOT_COORDENADOR.'disciplina_excluir/'.$d->__get('id').'" style="text-decoration:none;" class="excluir"><img src="'.DIR_WWW.'imgs/layout/del24.png" /></a></td>';
				$strDisciplina .= '</tr>';
				
				$strDisciplina .= '<tr>';
				$strDisciplina .= '<td colspan="6" style="padding:0;"><div style="display:none;padding-top:20px;" id="show_info_'.$d->__get('id').'"></div></td>';
				$strDisciplina .= '</tr>';
			}
		} else {
			$strDisciplina .= '<tr><td colspan="10" align="center" style="color: #8a6d3b; background-color: #fcf8e3;"><a href="'.DIR_ROOT_COORDENADOR.'disciplina_inserir/'.$idCurso.'" style="color: #8a6d3b; font-weight: bold;">Nenhuma disciplina encontrado. Clique aqui para inserir a Disciplina.</td></td>';
		}
					
		$str = '
		<table id="lista_disciplina" class="table table-bordered table-hover table-striped">
			<thead>
				<tr>
					<th style="text-align:center;width:50px;"><input type="checkbox" id="select_all" value="1"></th>
					<th>Nome</th>
					<th>Curso</th>
					<th style="text-align:center;width:10%;">Acao</th>
				</tr>
			</thead>
			<tfoot>
				<td align="center"><button class="btn btn-sm btn-danger" type="submit">Excluir</button></td>
				<td colspan="6"></td>
			</tfoot>
			<tbody>
				'.$strDisciplina.'
			</tbody>
		</table>';
		
		return $str;
	}

	public function excluir(array $arrayValida) {
		$alerta = $jsFocus = null;
		
		if ($arrayValida['r'] === true) {
			$alerta = '<div class="alert alert-success">'.$arrayValida['m'].'</div>';
		} elseif ($arrayValida['r'] === false) {
			$alerta = '<div class="alert alert-danger">'.$arrayValida['m'].'</div>';
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
							<li><a href="'.DIR_ROOT_COORDENADOR.'disciplina_listar">Listar Disciplinas</a></li>
							<li class="active">'.$this->titulo.'</li>
						</ol>
						<p align="right"><button class="btn btn-default" id="link_listar" type="button">Listar Disciplinas</button></p>
						'.$alerta.'
					</div>	
				</div>
			</div>
		</div>
		<script type="text/javascript">
		$(document).ready(function() {
			$("#link_listar").click(function() {
				location.href = "'.DIR_ROOT_COORDENADOR.'disciplina_listar";
			});
		});
		</script>
		';
		
		return $str;
	}
}
?>