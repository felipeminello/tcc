<?php
class AlunoVisao extends GeralVisao {
	private $Aluno;
	
	public function setAluno(Aluno $a) {
		$this->Aluno = $a;
	}
	
	public function corpoLogin() {
		$str = '
		<div class="login">
		<form id="login">
		<fieldset>
		<label for="ra">RA:</label>
		<input type="text" id="fra" />
		<label for="ra">Senha:</label>
		<input type="password" id="fsenha" />
		<input type="submit" id="fenvia" value="Entrar" />
		</fieldset>
		</form>
		<div class="esqueci"><a href="popup/rec_ra.php" class="fancy_senha">Esqueci meu RA</a> | <a href="popup/rec_senha.php" class="fancy_senha">Esqueci minha senha</a></div>
		<div id="ret_login" align="center"></div>
		</div>
		';
		return $str;
	}
	
	public function scriptLogin() {
		$str = '
		<script type="text/javascript">
		$(document).ready(function() {
			$("form#login").submit(function() {
				var ra = $("#fra").attr("value");
				var senha = $("#fsenha").attr("value");
				
				$.ajax({
					type: "POST",
					url: "'.DIR_ROOT_ALUNO.'ajax_login_aluno",
					data: "fra="+ra+"&fsenha="+senha,
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
		$arrayAtivo = array('inicio' => null, 'curso' => null, 'material' => null, 'mensagens' => null, 'notas-e-faltas' => null, 'trabalhos-e-provas' => null);
		
		$arrayAtivo[$ativo] = 'class="active"';
		
		$str = '
			<div class="collapse navbar-collapse navbar-ex1-collapse">
				<ul class="nav navbar-nav side-nav">
					<li '.$arrayAtivo['inicio'].'>
						<a href="'.DIR_ROOT_ALUNO.'"><i class="fa fa-fw fa-dashboard"></i> Início</a>
					</li>
					<li '.$arrayAtivo['notas-e-faltas'].'>
						<a href="'.DIR_ROOT_ALUNO.'notas-e-faltas"><i class="fa fa-fw fa-bar-chart-o"></i> Notas e Faltas</a>
					</li>
					<li '.$arrayAtivo['trabalhos-e-provas'].'>
						<a href="'.DIR_ROOT_ALUNO.'trabalhos-e-provas"><i class="fa fa-fw fa-table"></i> Trabalhos e Provas</a>
					</li>
					<li '.$arrayAtivo['mensagens'].'>
						<a href="'.DIR_ROOT_ALUNO.'mensagens"><i class="fa fa-fw fa-edit"></i> Mensagens</a>
					</li>
					<li '.$arrayAtivo['material'].'>
						<a href="'.DIR_ROOT_ALUNO.'material-didatico"><i class="fa fa-fw fa-desktop"></i> Material Didático</a>
					</li>
					<li '.$arrayAtivo['curso'].'>
						<a href="'.DIR_ROOT_ALUNO.'curso"><i class="fa fa-fw fa-wrench"></i> Meu Curso</a>
					</li>
					<li>
						<a href="javascript:;" data-toggle="collapse" data-target="#demo"><i class="fa fa-fw fa-arrows-v"></i> Dropdown <i class="fa fa-fw fa-caret-down"></i></a>
						<ul id="demo" class="collapse">
							<li>
								<a href="#">Dropdown Item</a>
							</li>
							<li>
								<a href="#">Dropdown Item</a>
							</li>
						</ul>
					</li>
					<li>
						<a href="blank-page.html"><i class="fa fa-fw fa-file"></i> Blank Page</a>
					</li>
				</ul>
			</div>
		';
		
		return $str;
	}
	
	public function dashboard() {
		$str = '
		<div id="page-wrapper">
			<div class="container-fluid">

				<!-- Page Heading -->
				<div class="row">
					<div class="col-lg-12">
						<h1 class="page-header">
							Bem vindo <small>Statistics Overview</small>
						</h1>
						<ol class="breadcrumb">
							<li class="active">
								<i class="fa fa-dashboard"></i> Home
							</li>
						</ol>
					</div>
				</div>
				<!-- /.row -->
				
				<div class="row">
					<div class="col-sm-4">
						<div class="panel panel-primary">
							<div class="panel-heading">
								<h3 class="panel-title">Panel title</h3>
							</div>
							<div class="panel-body">
								Panel content
							</div>
						</div>
						<div class="panel panel-green">
							<div class="panel-heading">
								<h3 class="panel-title">Panel title</h3>
							</div>
							<div class="panel-body">
								Panel content
							</div>
						</div>
					</div>
					<!-- /.col-sm-4 -->
					<div class="col-sm-4">
						<div class="panel panel-red">
							<div class="panel-heading">
								<h3 class="panel-title">Panel title</h3>
							</div>
							<div class="panel-body">
								Panel content
							</div>
						</div>
						<div class="panel panel-yellow">
							<div class="panel-heading">
								<h3 class="panel-title">Panel title</h3>
							</div>
							<div class="panel-body">
								Panel content
							</div>
						</div>
					</div>
					<!-- /.col-sm-4 -->
				</div>

				
				
				
				

				<!-- /.row -->

				<div class="row">
					<div class="col-lg-3 col-md-6">
						<div class="panel panel-primary">
							<div class="panel-heading">
								<div class="row">
									<div class="col-xs-3">
										<i class="fa fa-comments fa-5x"></i>
									</div>
									<div class="col-xs-9 text-right">
										<div class="huge">2</div>
										<div>Provas não vistas</div>
									</div>
								</div>
							</div>
							<a href="#">
								<div class="panel-footer">
									<span class="pull-left">View Details</span>
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
									<div class="col-xs-3">
										<i class="fa fa-tasks fa-5x"></i>
									</div>
									<div class="col-xs-9 text-right">
										<div class="huge">12</div>
										<div>New Tasks!</div>
									</div>
								</div>
							</div>
							<a href="#">
								<div class="panel-footer">
									<span class="pull-left">View Details</span>
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
									<div class="col-xs-3">
										<i class="fa fa-shopping-cart fa-5x"></i>
									</div>
									<div class="col-xs-9 text-right">
										<div class="huge">124</div>
										<div>New Orders!</div>
									</div>
								</div>
							</div>
							<a href="#">
								<div class="panel-footer">
									<span class="pull-left">View Details</span>
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
									<div class="col-xs-3">
										<i class="fa fa-support fa-5x"></i>
									</div>
									<div class="col-xs-9 text-right">
										<div class="huge">13</div>
										<div>Support Tickets!</div>
									</div>
								</div>
							</div>
							<a href="#">
								<div class="panel-footer">
									<span class="pull-left">View Details</span>
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
								<h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> Area Chart</h3>
							</div>
							<div class="panel-body">
								<div id="morris-area-chart"></div>
							</div>
						</div>
					</div>
				</div>
				<!-- /.row -->

				<div class="row">
					<div class="col-lg-4">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h3 class="panel-title"><i class="fa fa-long-arrow-right fa-fw"></i> Donut Chart</h3>
							</div>
							<div class="panel-body">
								<div id="morris-donut-chart"></div>
								<div class="text-right">
									<a href="#">View Details <i class="fa fa-arrow-circle-right"></i></a>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h3 class="panel-title"><i class="fa fa-clock-o fa-fw"></i> Tasks Panel</h3>
							</div>
							<div class="panel-body">
								<div class="list-group">
									<a href="#" class="list-group-item">
										<span class="badge">just now</span>
										<i class="fa fa-fw fa-calendar"></i> Calendar updated
									</a>
									<a href="#" class="list-group-item">
										<span class="badge">4 minutes ago</span>
										<i class="fa fa-fw fa-comment"></i> Commented on a post
									</a>
									<a href="#" class="list-group-item">
										<span class="badge">23 minutes ago</span>
										<i class="fa fa-fw fa-truck"></i> Order 392 shipped
									</a>
									<a href="#" class="list-group-item">
										<span class="badge">46 minutes ago</span>
										<i class="fa fa-fw fa-money"></i> Invoice 653 has been paid
									</a>
									<a href="#" class="list-group-item">
										<span class="badge">1 hour ago</span>
										<i class="fa fa-fw fa-user"></i> A new user has been added
									</a>
									<a href="#" class="list-group-item">
										<span class="badge">2 hours ago</span>
										<i class="fa fa-fw fa-check"></i> Completed task: "pick up dry cleaning"
									</a>
									<a href="#" class="list-group-item">
										<span class="badge">yesterday</span>
										<i class="fa fa-fw fa-globe"></i> Saved the world
									</a>
									<a href="#" class="list-group-item">
										<span class="badge">two days ago</span>
										<i class="fa fa-fw fa-check"></i> Completed task: "fix error on sales page"
									</a>
								</div>
								<div class="text-right">
									<a href="#">View All Activity <i class="fa fa-arrow-circle-right"></i></a>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h3 class="panel-title"><i class="fa fa-money fa-fw"></i> Transactions Panel</h3>
							</div>
							<div class="panel-body">
								<div class="table-responsive">
									<table class="table table-bordered table-hover table-striped">
										<thead>
											<tr>
												<th>Order #</th>
												<th>Order Date</th>
												<th>Order Time</th>
												<th>Amount (USD)</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>3326</td>
												<td>10/21/2013</td>
												<td>3:29 PM</td>
												<td>$321.33</td>
											</tr>
											<tr>
												<td>3325</td>
												<td>10/21/2013</td>
												<td>3:20 PM</td>
												<td>$234.34</td>
											</tr>
											<tr>
												<td>3324</td>
												<td>10/21/2013</td>
												<td>3:03 PM</td>
												<td>$724.17</td>
											</tr>
											<tr>
												<td>3323</td>
												<td>10/21/2013</td>
												<td>3:00 PM</td>
												<td>$23.71</td>
											</tr>
											<tr>
												<td>3322</td>
												<td>10/21/2013</td>
												<td>2:49 PM</td>
												<td>$8345.23</td>
											</tr>
											<tr>
												<td>3321</td>
												<td>10/21/2013</td>
												<td>2:23 PM</td>
												<td>$245.12</td>
											</tr>
											<tr>
												<td>3320</td>
												<td>10/21/2013</td>
												<td>2:15 PM</td>
												<td>$5663.54</td>
											</tr>
											<tr>
												<td>3319</td>
												<td>10/21/2013</td>
												<td>2:13 PM</td>
												<td>$943.45</td>
											</tr>
										</tbody>
									</table>
								</div>
								<div class="text-right">
									<a href="#">View All Transactions <i class="fa fa-arrow-circle-right"></i></a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- /.row -->

			</div>
			<!-- /.container-fluid -->

		</div>		
		';
		
		return $str;
	}
	
	public function perfil() {
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
								<i class="fa fa-dashboard"></i>  <a href="'.DIR_ROOT_ALUNO.'">Início</a>
							</li>
							<li class="active">
								<i class="fa fa-bar-chart-o"></i> Meus Dados
							</li>
						</ol>
						
						<form role="form">

							<div class="form-group">
								<label>Nome</label>
								<input class="form-control" id="fnome" value="'.$this->Aluno->__get('nome').'">
								<p class="help-block">Example block-level help text here.</p>
							</div>

							<div class="form-group">
								<label>Text Input with Placeholder</label>
								<input placeholder="Enter text" class="form-control">
							</div>

							<div class="form-group">
								<label>Static Control</label>
								<p class="form-control-static">email@example.com</p>
							</div>

							<div class="form-group">
								<label>File input</label>
								<input type="file">
							</div>

							<div class="form-group">
								<label>Text area</label>
								<textarea rows="3" class="form-control"></textarea>
							</div>

							<div class="form-group">
								<label>Checkboxes</label>
								<div class="checkbox">
									<label>
										<input type="checkbox" value="">Checkbox 1
									</label>
								</div>
								<div class="checkbox">
									<label>
										<input type="checkbox" value="">Checkbox 2
									</label>
								</div>
								<div class="checkbox">
									<label>
										<input type="checkbox" value="">Checkbox 3
									</label>
								</div>
							</div>

							<div class="form-group">
								<label>Inline Checkboxes</label>
								<label class="checkbox-inline">
									<input type="checkbox">1
								</label>
								<label class="checkbox-inline">
									<input type="checkbox">2
								</label>
								<label class="checkbox-inline">
									<input type="checkbox">3
								</label>
							</div>

							<div class="form-group">
								<label>Radio Buttons</label>
								<div class="radio">
									<label>
										<input type="radio" checked="" value="option1" id="optionsRadios1" name="optionsRadios">Radio 1
									</label>
								</div>
								<div class="radio">
									<label>
										<input type="radio" value="option2" id="optionsRadios2" name="optionsRadios">Radio 2
									</label>
								</div>
								<div class="radio">
									<label>
										<input type="radio" value="option3" id="optionsRadios3" name="optionsRadios">Radio 3
									</label>
								</div>
							</div>

							<div class="form-group">
								<label>Inline Radio Buttons</label>
								<label class="radio-inline">
									<input type="radio" checked="" value="option1" id="optionsRadiosInline1" name="optionsRadiosInline">1
								</label>
								<label class="radio-inline">
									<input type="radio" value="option2" id="optionsRadiosInline2" name="optionsRadiosInline">2
								</label>
								<label class="radio-inline">
									<input type="radio" value="option3" id="optionsRadiosInline3" name="optionsRadiosInline">3
								</label>
							</div>

							<div class="form-group">
								<label>Selects</label>
								<select class="form-control">
									<option>1</option>
									<option>2</option>
									<option>3</option>
									<option>4</option>
									<option>5</option>
								</select>
							</div>

							<div class="form-group">
								<label>Multiple Selects</label>
								<select class="form-control" multiple="">
									<option>1</option>
									<option>2</option>
									<option>3</option>
									<option>4</option>
									<option>5</option>
								</select>
							</div>

							<button class="btn btn-default" type="submit">Submit Button</button>
							<button class="btn btn-default" type="reset">Reset Button</button>

						</form>
						
						<div style="min-height:500px;">
							<div id="example" style="width:470px; height:300px;">j</div>
							<did id="gallery"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript">
		$(document).ready(function() {
			
			$("#example").photobooth().on("image",function( event, dataUrl ){
				$( "#gallery" ).append( \'<img src="\' + dataUrl + \'" >\');
			});
		});
		</script>
		';
		
		return $str;
	}
	
	public function listar(array $arrayCurso, array $arrayAluno, $idCurso = 0, $idTurma = 0) {
		$strAluno = $jsTurma = '';
		$strCurso = '<option value="0">Todos os Cursos</option>';
		
		foreach ($arrayCurso as $c) {
			$strCheck = ($c->__get('id') == $idCurso) ? 'selected="selected"' : '';
			
			$strCurso .= '<option value="'.$c->__get('id').'" '.$strCheck.'>'.$c->__get('nome').'</option>';
		}
		
		if (!empty($idCurso))
			$jsTurma = '$("#turma").load("'.DIR_ROOT_COORDENADOR.'ajax_turma_listar/'.$idCurso.'/'.$idTurma.'");';
		
		$tabelaAluno = self::tabelaAlunos($arrayAluno);
			
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
						
						<p align="right"><button class="btn btn-default" id="link_inserir" type="button">Inserir Aluno</button></p>
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
						
						<form id="lista" method="post" action="'.DIR_ROOT_COORDENADOR.'aluno_listar">
						<div class="table-responsive" id="show_aluno">
							'.$tabelaAluno.'
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
					url: "'.DIR_ROOT_COORDENADOR.'ajax_aluno_listar/",
					data: { id_curso: $(this).val() },
					beforeSend: function() {
						$("#show_aluno").html(\'<div align="center"><img src="'.DIR_WWW.'imgs/layout/ajax-loader.gif"></div>\');
					},
					contentType: "application/x-www-form-urlencoded; charset='.CODING.'"
				}).done(function(data) {
					$("#show_aluno").html(data);
				}).fail(function() {
					$("#show_aluno").text("Erro ao carregar");
				});
				
				$("#turma").load("'.DIR_ROOT_COORDENADOR.'ajax_turma_listar/"+$(this).val());
			});
			
			$("#turma").change(function() {
				$.ajax({
					type: "POST",
					url: "'.DIR_ROOT_COORDENADOR.'ajax_aluno_listar/",
					data: { id_curso: $("#curso").val(), id_turma: $(this).val() },
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
						
			$("#link_inserir").click(function() {
				location.href = "'.DIR_ROOT_COORDENADOR.'aluno_inserir";
			});
		});
		</script>
		';
		
		return $str;
	}
	
	public function tabelaAlunos(array $arrayAluno, $idCurso = 0, $idTurma = 0) {
		$strAluno = '';
		$countAluno = count($arrayAluno);
		
		if ($countAluno > 0) {
			foreach ($arrayAluno as $idAluno => $a) {
				$strAluno .= '<tr>';
				$strAluno .= '<td align="center" class="check" style="cursor:pointer;"><input type="checkbox" name="apagar[]" value="'.$a->__get('id').'"></td>';
				$strAluno .= '<td class="abrir_info" id="c'.$a->__get('id').'" style="cursor:pointer;">'.$a->__get('nome').'</td>';
				$strAluno .= '<td align="center">'.$a->__get('email').'</td>';
				$strAluno .= '<td align="center">'.$a->__get('telefone').'</td>';
				$strAluno .= '<td align="center"><a href="'.DIR_ROOT_COORDENADOR.'aluno_editar/'.$a->__get('id').'" style="text-decoration:none;"><img src="'.DIR_WWW.'imgs/layout/edit24.png" /></a> <a href="'.DIR_ROOT_COORDENADOR.'aluno_excluir/'.$a->__get('id').'" style="text-decoration:none;" class="excluir"><img src="'.DIR_WWW.'imgs/layout/del24.png" /></a></td>';
				$strAluno .= '</tr>';
				
				$strAluno .= '<tr>';
				$strAluno .= '<td colspan="6" style="padding:0;"><div style="display:none;padding-top:20px;" id="show_info_'.$a->__get('id').'"></div></td>';
				$strAluno .= '</tr>';
			}
		} else {
			$strAluno .= '<tr><td colspan="10" align="center" style="color: #8a6d3b; background-color: #fcf8e3;"><a href="'.DIR_ROOT_COORDENADOR.'aluno_inserir/'.$idCurso.'/'.$idTurma.'" style="color: #8a6d3b; font-weight: bold;">Nenhum aluno encontrado. Clique aqui para inserir o Aluno.</td></td>';
		}
					
		$str = '
		<table id="lista_aluno" class="table table-bordered table-hover table-striped">
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
				'.$strAluno.'
			</tbody>
		</table>';
		
		return $str;
	}
	
	public function cadastro(array $arrayValida, $acao, $arrayCurso = array(), $idCurso = 0, $idTurma = 0) {
		$alerta = $jsFocus = $jsTurma = $strCombo = $strBotoes = null;
		$strCheckSexo = array();
		$idAluno = $this->Aluno->__get('id');
		
		$strCurso = '<option value="0">Selecione o curso</option>';
		
		foreach ($arrayCurso as $c) {
			$check = ($idCurso == $c->__get('id')) ? 'selected="selected"' : '';
			$strCurso .= '<option value="'.$c->__get('id').'" '.$check.'>'.$c->__get('nome').'</option>';
		}
		
		if (!empty($idTurma))
			$jsTurma = '$("#turma").load("'.DIR_ROOT_COORDENADOR.'ajax_turma_listar/'.$idCurso.'/'.$idTurma.'");';
		
		
		$strCheckSexo['m'] = ($this->Aluno->__get('sexo') == 'm') ? 'selected="selected"' : '';
		$strCheckSexo['f'] = ($this->Aluno->__get('sexo') == 'f') ? 'selected="selected"' : '';
		
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
		
		if (empty($idAluno)) {
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
		} else {
			$strBotoes = '
			<button class="btn btn-primary" id="link_turma_ver" type="button">Ver Turmas</button>
			<button class="btn btn-success" id="link_turma_ins" type="button">Inserir na Turma</button>
			<button class="btn btn-info" id="link_falta_ver" type="button">Ver faltas</button>
			<button class="btn btn-warning" id="link_nota_ver" type="button">Ver notas</button>
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
								<a href="'.DIR_ROOT_COORDENADOR.'aluno_listar">Alunos</a>
							</li>
							<li class="active">
								'.$this->titulo.'
							</li>
						</ol>
						<p align="right">
							<button class="btn btn-default" id="link_listar" type="button">Listar Alunos</button>
							'.$strBotoes.'
						</p>
						
					
						<form role="form" method="post" action="'.$acao.'" id="cadastro" style="margin-bottom:15px;" enctype="multipart/form-data">
							<input type="hidden" name="id" value="'.$this->Aluno->__get('id').'">
							'.$strCombo.'
							
							<div class="row" style="margin-bottom:20px;">
								<div class="col-lg-3">
									<label>Nome</label>
									<input class="form-control" type="text" id="nome" name="nome" value="'.$this->Aluno->__get('nome').'">
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
									<input class="form-control" type="text" id="email" name="email" value="'.$this->Aluno->__get('email').'">
								</div>
								<div class="col-lg-3">
									<label>Telefone</label>
									<input class="form-control telefone" type="text" id="telefone" name="telefone" value="'.$this->Aluno->__get('telefone').'">
								</div>
							</div>
							<div class="row" style="margin-bottom:20px;">
								<div class="col-lg-6">
									<label>RA</label>
									<input class="form-control" type="text" id="ra" name="ra" value="'.$this->Aluno->__get('ra').'">
								</div>
							
								<div class="col-lg-3">
									<label>Senha</label>
									<input class="form-control" type="password" id="senha" name="senha">
								</div>
								<div class="col-lg-3">
									<label>Confirma a senha</label>
									<input class="form-control" type="password" id="conf_senha" name="conf_senha">
								</div>
							</div>
							
							<div class="row" style="margin-bottom:20px;">
								<div class="col-lg-6">
									<div><img src="'.$this->Aluno->exibeImagem().'"></div>
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
				href : "'.DIR_ROOT_COORDENADOR.'popup_aluno_turma_ver/'.$this->Aluno->__get('id').'"
			});

			$("#link_turma_ins").fancybox({
				minWidth : 700,
				minHeight : 360,
				type : "ajax",
				scrolling: "no",
				href : "'.DIR_ROOT_COORDENADOR.'popup_aluno_turma_inserir/'.$this->Aluno->__get('id').'"
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
				location.href = "'.DIR_ROOT_COORDENADOR.'aluno_listar";
			});
			
			'.$jsFocus.'
			
			'.$jsTurma.'
		});
		</script>
		';
		
		return $str;
	}
	
	public function tabelaTurmas(array $arrayAlunoTurma) {
		$strTurma = '';
		
		foreach ($arrayAlunoTurma as $at) {
			$strTurma .= '
			<tr id="tr'.$at->__get('id').'">
				<td>'.$at->__get('Turma')->__get('Curso')->__get('nome').'</td>
				<td>'.$at->__get('Turma')->__get('nome').'</td>
				<td>'.$at->__get('Turma')->getNomePeriodo().'</td>
				<td>'.$at->__get('data').'</td>
				<td align="center"><a href="javascript:void(0)" class="excluir" id="at'.$at->__get('id').'" style="text-decoration:none;" class="excluir"><img src="'.DIR_WWW.'imgs/layout/del24.png" /></a></td>
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
						<th>Data</th>
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
				var id = $(this).attr("id").substr(2);
				
				if (confirm("Confirma exclusão do aluno na turma?")) {
					$.ajax({
						type: "POST",
						url: "'.DIR_ROOT_COORDENADOR.'ajax_aluno_turma_excluir/",
						data: { id_at: id },
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
				$("#turma").load("'.DIR_ROOT_COORDENADOR.'ajax_turma_listar/"+$(this).val());
			});
			
			$("form#inserir_turma").submit(function() {
				var curso = $("#curso").attr("value");
				var turma = $("#turma").attr("value");
				
				$("#enviar").attr("disabled", true);
				
				$.ajax({
					type: "POST",
					url: "'.DIR_ROOT_COORDENADOR.'ajax_submit_aluno_turma_inserir",
					data: "id_aluno='.$this->Aluno->__get('id').'&id_curso="+curso+"&id_turma="+turma,
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
	
	
	public function mensagemLogout() {
		$str = 'Você saiu do sistema';
		return $str;
	}
	
}


?>