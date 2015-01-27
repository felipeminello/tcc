<?php
class CursoVisao extends GeralVisao {
	private $Curso;
	
	public function setCurso(Curso $c) {
		$this->Curso = $c;
	}
	
	public function cadastro(array $arrayValida, $acao) {
		$alerta = $jsFocus = null;
		
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
							<li><a href="'.DIR_ROOT_COORDENADOR.'curso_listar">Cursos</a></li>
							<li class="active">'.$this->titulo.'</li>
						</ol>
						<p align="right"><button class="btn btn-default" id="link_listar" type="button">Listar Cursos</button></p>
						<form role="form" method="post" action="'.$acao.'" id="cadastro" style="margin-bottom:15px;">
							<input type="hidden" name="id" value="'.$this->Curso->__get('id').'">
							<div class="form-group">
								<label for="nome">Nome</label>
								<input class="form-control" name="nome" id="nome" value="'.$this->Curso->__get('nome').'">
							</div>


							<button class="btn btn-default" type="submit" id="btn_enviar">Enviar</button>

						</form>
						<div id="alerta">'.$alerta.'</div>	
					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript">
		$(document).ready(function() {
			$("#cadastro").submit(function() {
				$("#btn_enviar").attr("disabled", true).text("Enviando");
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

	public function listar(array $arrayCurso, array $arrayTotalTurma = array(), array $arrayTotalAluno = array(), array $arrayTotalProfessor = array()) {
		$strCurso = '';
		
		$countCurso = count($arrayCurso);
		
		if ($countCurso > 0) {
			foreach ($arrayCurso as $idCurso => $c) {
				$totalTurma = (isset($arrayTotalTurma[$idCurso])) ? $arrayTotalTurma[$idCurso] : 0;
				$totalAluno = (isset($arrayTotalAluno[$idCurso])) ? count($arrayTotalAluno[$idCurso]) : 0;
				$totaProfessor = (isset($arrayTotalProfessor[$idCurso])) ? count($arrayTotalProfessor[$idCurso]) : 0;
				
				$strCurso .= '<tr>';
				$strCurso .= '<td align="center" class="check" style="cursor:pointer;"><input type="checkbox" name="apagar[]" value="'.$c->__get('id').'"></td>';
				$strCurso .= '<td>'.$c->__get('nome').'</td>';
				$strCurso .= '<td align="center">'.$totalTurma.'</td>';
				$strCurso .= '<td align="center">'.$totalAluno.'</td>';
				$strCurso .= '<td align="center">'.$totaProfessor.'</td>';
				$strCurso .= '<td align="center"><a href="javascript:void(0)" style="text-decoration:none;" class="abrir_info" id="c'.$c->__get('id').'"><img src="'.DIR_WWW.'imgs/layout/abrir24.png" /></a> <a href="'.DIR_ROOT_COORDENADOR.'curso_editar/'.$c->__get('id').'" style="text-decoration:none;"><img src="'.DIR_WWW.'imgs/layout/edit24.png" /></a> <a href="'.DIR_ROOT_COORDENADOR.'curso_excluir/'.$c->__get('id').'" style="text-decoration:none;" class="excluir"><img src="'.DIR_WWW.'imgs/layout/del24.png" /></a></td>';
				$strCurso .= '</tr>';
				
				$strCurso .= '<tr>';
				$strCurso .= '<td colspan="6" style="padding:0;"><div style="display:none;padding-top:20px;" id="show_info_'.$c->__get('id').'"></div></td>';
				$strCurso .= '</tr>';
			}
		}
		
		$str = '
		<div id="page-wrapper">
			<div class="container-fluid">

				<!-- Page Heading -->
				<div class="row">
					<div class="col-lg-12">
						<h1 class="page-header">
							Cursos
						</h1>
						<ol class="breadcrumb">
							<li>
								<i class="fa fa-dashboard"></i>  <a href="'.DIR_ROOT_COORDENADOR.'">Início</a>
							</li>
							<li class="active">
								<i class="fa fa-bar-chart-o"></i> Cursos
							</li>
						</ol>
						<p align="right"><button class="btn btn-default" id="link_inserir" type="button">Inserir Curso</button></p>
						<form id="lista" method="post" action="'.DIR_ROOT_COORDENADOR.'curso_listar">
							<table id="lista_curso" class="table table-bordered table-hover table-striped">
								<thead>
									<tr>
										<th style="text-align:center;width:50px;"><input type="checkbox" id="select_all" value="1"></th>
										<th>Curso</th>
										<th style="text-align:center;">Turmas</th>
										<th style="text-align:center;">Alunos</th>
										<th style="text-align:center;">Professores</th>
										<th style="text-align:center;">Ação</th>
									</tr>
								</thead>
								<tfoot>
									<td align="center"><button class="btn btn-sm btn-danger" type="submit">Excluir</button></td>
									<td colspan="6"></td>
								</tfoot>
								<tbody>
									'.$strCurso.'
								</tbody>
							</table>
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
					$("#show_info_"+id).load("'.DIR_ROOT_COORDENADOR.'ajax_curso_listar_info/"+id, function() {
						$(this).slideDown("fast");
					});
				} else {
					$("#show_info_"+id).slideUp("fast");
				}
			});
			
			$("#link_inserir").click(function() {
				location.href = "'.DIR_ROOT_COORDENADOR.'curso_inserir";
			});
			
			$("#add_turma").fancybox({
				minWidth	: 840,
				minHeight	: 475
			});
			
			
			
			
			$("#turma").change(function() {
				$.ajax({
					type: "POST",
					url: "'.DIR_ROOT_COORDENADOR.'ajax_notas-e-faltas_listar/",
					data: { id_turma: $(this).val() },
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
	
	public function infoListar(array $arrayTurma, array $arrayAluno, array $arrayProfessor) {
		$countTurma = count($arrayTurma);
		$countAluno = count($arrayAluno);
		$countProfessor = count($arrayProfessor);
		
		$strTurma = $strAluno = $strProfessor = '';
		
		if ($countTurma > 0) {
			foreach ($arrayTurma as $t) {
				$strTurma .= '<a class="list-group-item" href="javascript:void(0)">'.$t->__get('nome').'</a>';
			}
		} else {
			$strTurma .= '<a class="list-group-item" href="javascript:void(0)">Nenhuma turma cadastrada</a>';
		}
		
		if ($countAluno > 0) {
			foreach ($arrayAluno as $a) {
				$strAluno .= '<a class="list-group-item" href="javascript:void(0)">'.$a->__get('nome').'</a>';
			}
		} else {
			$strAluno .= '<a class="list-group-item" href="javascript:void(0)">Nenhum aluno cadastrado</a>';
		}
		
		if ($countProfessor > 0) {
			foreach ($arrayProfessor as $p) {
				$strProfessor .= '<a class="list-group-item" href="javascript:void(0)">'.$p->__get('nome').'</a>';
			}
		} else {
			$strProfessor .= '<a class="list-group-item" href="javascript:void(0)">Nenhum professor cadastrado</a>';
		}
		
		$str = '
		<div class="col-lg-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><i class="fa fa-clock-o fa-fw"></i> Turmas</h3>
				</div>
				<div class="panel-body">
					<div class="list-group" id="lista_turma">
						'.$strTurma.'
					</div>
					<div class="text-right">
						<a class="fancybox.ajax" href="'.DIR_ROOT_COORDENADOR.'popup_turma_inserir/'.$this->Curso->__get('id').'" id="add_turma">Adicionar nova turma</a>
					</div>
				</div>
			</div>
		</div>
		
		<div class="col-lg-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><i class="fa fa-clock-o fa-fw"></i> Alunos</h3>
				</div>
				<div class="panel-body">
					<div class="list-group">
						'.$strAluno.'
					</div>
					<div class="text-right">
						<a href="'.DIR_ROOT_COORDENADOR.'aluno_listar/'.$this->Curso->__get('id').'">Visualizar Alunos</a>
					</div>
				</div>
			</div>
		</div>
								
		<div class="col-lg-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><i class="fa fa-clock-o fa-fw"></i> Professores</h3>
				</div>
				<div class="panel-body">
					<div class="list-group">
						'.$strProfessor.'
					</div>
					<div class="text-right">
						<a href="'.DIR_ROOT_COORDENADOR.'professor_listar/'.$this->Curso->__get('id').'">Visualizar Professores</a>
					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript">
		$(document).ready(function() {
			
		});
		</script>
		
		';
		
		return $str;
	}
	public function excluir(array $arrayValida) {
		$alerta = null;
		
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
							<li><a href="'.DIR_ROOT_COORDENADOR.'curso_listar">Cursos</a></li>
							<li class="active">'.$this->titulo.'</li>
						</ol>
						<p align="right"><button class="btn btn-default" id="link_listar" type="button">Listar Cursos</button></p>
						'.$alerta.'
					</div>	
				</div>
			</div>
		</div>
		<script type="text/javascript">
		$(document).ready(function() {
			$("#link_listar").click(function() {
				location.href = "'.DIR_ROOT_COORDENADOR.'curso_listar";
			});
		});
		</script>
		';
		
		return $str;
	}
	
}


?>