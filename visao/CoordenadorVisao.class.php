<?php
class CoordenadorVisao extends GeralVisao {
	private $Coordenador;
	
	public function setCoordenador(Coordenador $c) {
		$this->Coordenador = $c;
	}
	
	public function corpoLogin() {
		$str = '
		<div class="login">
		<form id="login">
		<fieldset>
		<label for="ra">Email:</label>
		<input type="text" id="femail" />
		<label for="ra">Senha:</label>
		<input type="password" id="fsenha" />
		<input type="submit" id="fenvia" value="Entrar" />
		</fieldset>
		</form>
		<div class="esqueci"><a href="'.DIR_ROOT_COORDENADOR.'popup_recuperar_senha" class="senha fancybox.ajax">Esqueci minha senha</a></div>
		<div id="ret_login" align="center"></div>
		</div>
		<script type="text/javascript">
		$(document).ready(function() {
			$(".senha").fancybox({
				minWidth : 700,
				minHeight : 460,
				afterClose : function() {
					
				}
			});
			
		
			$("form#login").submit(function() {
				var email = $("#femail").attr("value");
				var senha = $("#fsenha").attr("value");
				
				$.ajax({
					type: "POST",
					url: "'.DIR_ROOT_COORDENADOR.'ajax_login_coordenador",
					data: "femail="+email+"&fsenha="+senha,
					dataType: "json",
					beforeSend: function () {
						$("#ret_login").removeClass("erro sucesso");
						$("div#ret_login").html("<img src=\"'.DIR_WWW.'imgs/layout/ajax-loader.gif\" \/>");
					}
				}).done(function(o) {
					if (o.r == "f") {
						$("#ret_login").addClass("erro");
		
						$("#"+o.c).focus();
					} else {
						$("#ret_login").addClass("sucesso");
						setTimeout(function() {
							location.reload();
						}, 1000);
					}
					$("#ret_login").html(o.m);
				}).fail(function() {
					$("#ret_login").text("Erro ao enviar");
				}).always(function() {
					/* NADA */
				});
				return false;
			});
		});
		</script>
		
		';
		return $str;
	}
	
	public function menuAdmin($ativo = '') {
		$arrayAtivo = array('inicio' => null, 'professor' => null, 'aluno' => null, 'curso' => null, 'turma' => null, 'disciplina' => null, 'chamada' => null, 'nota' => null);
		
		$arrayAtivo[$ativo] = 'class="active"';
		
		$str = '
			<div class="collapse navbar-collapse navbar-ex1-collapse">
				<ul class="nav navbar-nav side-nav">
					<li '.$arrayAtivo['inicio'].'>
						<a href="'.DIR_ROOT_COORDENADOR.'"><i class="fa fa-fw fa-dashboard"></i> Início</a>
					</li>
					<li '.$arrayAtivo['professor'].'>
						<a href="'.DIR_ROOT_COORDENADOR.'professor_listar"><i class="fa fa-fw fa-bar-chart-o"></i> Professores</a>
					</li>
					<li '.$arrayAtivo['aluno'].'>
						<a href="'.DIR_ROOT_COORDENADOR.'aluno_listar"><i class="fa fa-fw fa-table"></i> Alunos</a>
					</li>
					<li '.$arrayAtivo['curso'].'>
						<a href="'.DIR_ROOT_COORDENADOR.'curso_listar"><i class="fa fa-fw fa-edit"></i> Cursos</a>
					</li>
					<li '.$arrayAtivo['turma'].'>
						<a href="'.DIR_ROOT_COORDENADOR.'turma_listar"><i class="fa fa-fw fa-desktop"></i> Turmas</a>
					</li>
					<li '.$arrayAtivo['disciplina'].'>
						<a href="'.DIR_ROOT_COORDENADOR.'disciplina_listar"><i class="fa fa-fw fa-wrench"></i> Disciplinas</a>
					</li>
					<li '.$arrayAtivo['chamada'].'>
						<a href="'.DIR_ROOT_COORDENADOR.'chamada_listar"><i class="fa fa-fw fa-wrench"></i> Chamada</a>
					</li>
					<li '.$arrayAtivo['nota'].'>
						<a href="'.DIR_ROOT_COORDENADOR.'nota_listar"><i class="fa fa-fw fa-wrench"></i> Notas</a>
					</li>
					</ul>
			</div>
		';
		
		return $str;
	}
	
	public function dashboard(array $arrayCurso, $totalMensagem = 0, $totalTurma = 0, $totalProfessor = 0, $totalAluno = 0) {
		
		$strCurso = Elementos::popularSelect($arrayCurso);
		
		if ($totalMensagem == 1)
			$strMensagem = 'Mensagem recebida hoje';
		elseif ($totalMensagem > 1)
			$strMensagem = 'Mensagens recebidas hoje';
		else
			$strMensagem = 'Nenhuma mensagem hoje';
		
		if ($totalTurma == 1)
			$strTurma = 'Turma cadastrada';
		elseif ($totalTurma > 1)
			$strTurma = 'Turmas cadastradas';
		else
			$strTurma = 'Nenhuma turma cadastrada';
		
		if ($totalProfessor == 1)
			$strProfessor = 'Professor cadastrado';
		elseif ($totalProfessor > 1)
			$strProfessor = 'Professores cadastrados';
		else
			$strProfessor = 'Nenhuma professor cadastrado';
		
		if ($totalAluno == 1)
			$strAluno = 'Aluno cadastrado';
		elseif ($totalAluno > 1)
			$strAluno = 'Alunos cadastrados';
		else
			$strAluno = 'Nenhuma aluno cadastrado';
		
		$str = '
		<div id="page-wrapper">
			<div class="container-fluid">

				<!-- Page Heading -->
				<div class="row">
					<div class="col-lg-12">
						<h1 class="page-header">
							Bem vindo <small>área do coordenador</small>
						</h1>
						<ol class="breadcrumb">
							<li class="active">Home</li>
						</ol>
					</div>
				</div>

				<div class="row">
					<div class="col-lg-3 col-md-6">
						<div class="panel panel-primary">
							<div class="panel-heading">
								<div class="row">
									<div class="col-xs-12 text-right">
										<div class="huge">'.$totalMensagem.'</div>
										<div>'.$strMensagem.'</div>
									</div>
								</div>
							</div>
							<a href="'.DIR_ROOT_COORDENADOR.'mensagens">
								<div class="panel-footer">
									<span class="pull-left">Mensagens</span>
									<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
									<div class="clearfix"></div>
								</div>
							</a>
						</div>
					</div>
					<div class="col-lg-3 col-md-6">
						<div class="panel panel-green">
							<div class="panel-heading">
								<div class="row">
									<div class="col-xs-12 text-right">
										<div class="huge">'.$totalTurma.'</div>
										<div>'.$strTurma.'</div>
									</div>
								</div>
							</div>
							<a href="'.DIR_ROOT_COORDENADOR.'turma_listar">
								<div class="panel-footer">
									<span class="pull-left">Ver Turmas</span>
									<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
									<div class="clearfix"></div>
								</div>
							</a>
						</div>
					</div>
					<div class="col-lg-3 col-md-6">
						<div class="panel panel-yellow">
							<div class="panel-heading">
								<div class="row">
									<div class="col-xs-12 text-right">
										<div class="huge">'.$totalProfessor.'</div>
										<div>'.$strProfessor.'</div>
									</div>
								</div>
							</div>
							<a href="'.DIR_ROOT_COORDENADOR.'professor_listar">
								<div class="panel-footer">
									<span class="pull-left">Professores</span>
									<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
									<div class="clearfix"></div>
								</div>
							</a>
						</div>
					</div>
					<div class="col-lg-3 col-md-6">
						<div class="panel panel-red">
							<div class="panel-heading">
								<div class="row">
									<div class="col-xs-12 text-right">
										<div class="huge">'.$totalAluno.'</div>
										<div>'.$strAluno.'</div>
									</div>
								</div>
							</div>
							<a href="'.DIR_ROOT_COORDENADOR.'aluno_listar">
								<div class="panel-footer">
									<span class="pull-left">Ver Alunos</span>
									<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
									<div class="clearfix"></div>
								</div>
							</a>
						</div>
					</div>
				</div>
				<!-- /.row -->

				<div class="row">
					<div class="col-lg-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h3 class="panel-title">Notas</h3>
							</div>
							<div class="panel-body">
								<div id="morris-area-chart">
									<div class="form-group col-lg-4">
										<label>Curso</label>
										<select id="c_nota" class="form-control curso">
											<option value="0">Selecione o curso</option>
											'.$strCurso.'
										</select>
									</div>								
									<div class="form-group col-lg-4">
										<label>Turma</label>
										<select id="t_nota" class="form-control turma">
											<option value="0">Selecione primeiro o curso</option>
										</select>
									</div>
									<div class="form-group col-lg-4">
										<label>Disciplina</label>
										<select id="d_nota" class="form-control disciplina">
											<option value="0">Selecione primeiro o curso</option>
										</select>
									</div>
									<div class="col-lg-12" id="show_nota">
										<div class="alert alert-warning"><strong>Atenção</strong> Selecione o Curso</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h3 class="panel-title">Faltas</h3>
							</div>
							<div class="panel-body">
								<div id="morris-area-chart">
									<div class="form-group col-lg-4">
										<label>Curso</label>
										<select id="c_falta" class="form-control curso">
											<option value="0">Selecione o curso</option>
											'.$strCurso.'
										</select>
									</div>								
									<div class="form-group col-lg-4">
										<label>Turma</label>
										<select id="t_falta" class="form-control turma">
											<option value="0">Selecione primeiro o curso</option>
										</select>
									</div>
									<div class="form-group col-lg-4">
										<label>Disciplina</label>
										<select id="d_falta" class="form-control disciplina">
											<option value="0">Selecione primeiro o curso</option>
										</select>
									</div>
									
									<div class="col-lg-12" id="show_falta">
										<div class="alert alert-warning"><strong>Atenção</strong> Selecione o Curso</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript">
		$(document).ready(function() {
		
			$(".curso").change(function() {
				var area = $(this).attr("id").substr(2);
				$("#t_"+area).attr("disabled", true);
				$("#d_"+area).attr("disabled", true);
				
				$("#t_"+area).load("'.DIR_ROOT_COORDENADOR.'ajax_turma_listar/"+$(this).val(), function() {
					$(this).attr("disabled", false);
					
					$("#d_"+area).load("'.DIR_ROOT_COORDENADOR.'ajax_disciplina_listar/"+$("#c_"+area).val(), function() {
						$(this).attr("disabled", false);
					});
				});
			});
			
			$(".disciplina, .turma").change(function() {
				var area = $(this).attr("id").substr(2);
					
				$("#show_"+area).load("'.DIR_ROOT_COORDENADOR.'ajax_"+area+"_turma_grafico/"+$("#t_"+area).val()+"/"+$("#d_"+area).val());
			});
		});
		</script>
		
		';
		
		return $str;
	}
	
	public function perfil(array $arrayValida) {
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
							<li>
								<i class="fa fa-dashboard"></i>  <a href="'.DIR_ROOT_COORDENADOR.'">Início</a>
							</li>
							<li class="active">
								<i class="fa fa-bar-chart-o"></i> Meus dados
							</li>
						</ol>
						<p align="right"><button class="btn btn-info fancybox.iframe" type="button" id="minha_foto">Minha foto</button></p>
					</div>
				</div>
				<div class="row">
					<form method="post" action="'.DIR_ROOT_COORDENADOR.'perfil" id="cadastro">
					<input type="hidden" name="id" value="'.$this->Coordenador->__get('id').'">
					<div class="col-lg-6">
						<div class="form-group">
							<label>Nome</label>
							<input class="form-control" type="text" id="nome" name="nome" value="'.$this->Coordenador->__get('nome').'">
						</div>
						<div class="form-group">
							<label>Senha</label>
							<input class="form-control" type="password" id="senha" name="senha">
						</div>
						<button class="btn btn-default" type="submit">Enviar</button>
					</div>
					<div class="col-lg-6">	
						<div class="form-group">
							<label>Email</label>
							<input class="form-control" type="text" id="email" name="email" value="'.$this->Coordenador->__get('email').'">
						</div>
						<div class="form-group">
							<label>Confirme a senha</label>
							<input class="form-control" type="password" id="conf_senha" name="conf_senha">
						</div>
						
					</div>
					</form>
					
				</div>
				<div id="alerta" style="margin-top:15px;">'.$alerta.'</div>
			</div>
		</div>
		<script type="text/javascript">
		$(document).ready(function() {
			$("#cadastro").submit(function() {
				$("#btn_enviar").attr("disabled", true).text("Enviando");
			});
			
			$("#minha_foto").fancybox({
				minWidth : 700,
				minHeight : 460,
				href : "'.DIR_ROOT_COORDENADOR.'popup_minha_foto",
				afterClose : function() {
					
				}
			});
			
			
			'.$jsFocus.'
		});
		</script>
		
		';
		
		return $str;
	}
	
	public function cadastroFoto(array $arrayValida, $acao) {
		$alerta = $jsFocus = $strCurso = $strPeriodo = null;
		
		if ($arrayValida['r'] == 't') {
			$alerta = '<div class="alert alert-success">'.$arrayValida['m'].'</div>';
		} elseif ($arrayValida['r'] == 'f') {
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
							Minha Foto
						</h1>
					</div>
				</div>
				<div style="float:left;">
					<img src="'.$this->Coordenador->exibeImagem().'" />
				</div>
				<div id="gallery" style="width:300px; height:200px; float:left; margin: 0 20px 0 20px;"></div>
				<div id="webcam" style="width:300px; height:200px; float:left;"></div>
				
				<div style="float:left;">
					<form role="form" action="'.DIR_ROOT_COORDENADOR.$acao.'" method="post" id="cadastro_foto" style="margin-bottom:15px;" enctype="multipart/form-data">
					<label>Enviar arquivo</label><br />
					<input type="file" name="foto" accept="image/*">
					<button class="btn btn-default" type="submit" id="btn_enviar">Salvar</button>
					</form>
				</div>
				<div style="clear:both;"></div>
				
					'.$alerta.'
				
				</div>
			</div>
		</div>
		<script language="javascript"> 
		$(document).ready(function() {
			$( "#webcam" ).photobooth().on( "image", function( event, dataUrl ){
				$( "#gallery" ).show().html( \'<img src="\' + dataUrl + \'" >\');
				$.ajax({
					type: "POST",
					url: "'.DIR_ROOT_COORDENADOR.'ajax_photobooth_salvar",
					data: "dataUrl="+dataUrl
				});
			});
		});
		</script>
		';
		
		return $str;
	}
	
	
	public function mensagemLogout() {
		$str = '
		Você saiu do sistema
		<script language="javascript"> 
		$(document).ready(function() {
			
			setTimeout(function() {
				location.href = "'.DIR_ROOT_COORDENADOR.'"
			}, 1000);
		});
		</script>
		';
		return $str;
	}
	
}


?>