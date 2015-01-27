<?php
class MensagemVisao extends GeralVisao {
	private $Mensagem;
	
	public function setMensagem(Mensagem $m) {
		$this->Mensagem = $m;
	}
	
	public function mensagemCoordenacao(array $arrayValida, array $arrayCurso, array $arrayTurma, array $arrayAluno, array $arrayProfessor, array $arrayCoordenador) {
		$alerta = $jsFocus = $strCurso = $strTurma = $strProfessor = $strAluno = $strCoordenador = null;
		
		$arCurso = array(0 => 'Selecione o Curso');
		foreach ($arrayCurso as $c) {
			$arCurso[$c->__get('id')] = $c->__get('nome');
		}
		$strCurso = Elementos::popularSelect($arCurso);
		
		$arTurma = array(0 => 'Selecione a Turma');
		foreach ($arrayTurma as $t) {
			$arTurma[$t->__get('id')] = $t->__get('nome');
		}
		$strTurma = Elementos::popularSelect($arTurma);
		
		$arProfessor = array(0 => 'Selecione o Professor');
		foreach ($arrayProfessor as $p) {
			$arProfessor[$p->__get('id')] = $p->__get('nome');
		}
		$strProfessor = Elementos::popularSelect($arProfessor);
		
		$arAluno = array(0 => 'Selecione o Aluno');
		foreach ($arrayAluno as $a) {
			$arAluno[$a->__get('id')] = $a->__get('nome');
		}
		$strAluno = Elementos::popularSelect($arAluno);
		
		$arCoordenador = array(0 => 'Selecione o Coordenador');
		foreach ($arrayCoordenador as $a) {
			$arCoordenador[$a->__get('id')] = $a->__get('nome');
		}
		$strCoordenador = Elementos::popularSelect($arCoordenador);
		
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
								<a href="'.DIR_ROOT_COORDENADOR.'">Início</a>
							</li>
							<li class="active">'.$this->titulo.'</li>
						</ol>
						<form role="form" id="cadastro">
						<div id="filtros" style="background-color:#fff;">
							<div class="col-lg-2" style="padding-left:0;">
								<div class="form-group">
									<label>Curso</label>
									<select id="curso" class="form-control">
										'.$strCurso.'
									</select>
								</div>
							</div>
							<div class="col-lg-2">				  
								<div class="form-group">
									<label>Turma</label>
									<select id="turma" class="form-control">
										'.$strTurma.'
									</select>
								</div>						
							</div>
							<div class="col-lg-2">				  
								<div class="form-group">
									<label>Aluno</label>
									<select id="aluno" class="form-control">
										'.$strAluno.'
									</select>
								</div>						
							</div>
							<div class="col-lg-2">
								<div class="form-group">
									<label>Professor</label>
									<select id="professor" class="form-control">'.$strProfessor.'</select>
								</div>
							</div>
							<div class="col-lg-2">				  
								<div class="form-group">
									<label>Coordenador</label>
									<select id="coordenador" class="form-control">'.$strCoordenador.'</select>
								</div>						
							</div>
							<div class="col-lg-2" style="margin-top:25px;padding-right:0;">				  
								<div class="form-group">
									<button class="btn btn-default" type="submit" style="width:100%;">Filtrar</button>
								</div>
							</div>
						</div>
						<div style="clear:both;"></div>
						<div class="table-responsive" id="show_mensagens"></div>
						<div class="form-group">
							<label>Inserir mensagem</label>
							<textarea rows="3" class="form-control" id="texto"></textarea>
						</div>
						<div class="form-group">
							<button class="btn btn-default" id="btn_enviar" type="submit">Enviar</button>
							<label class="radio-inline" style="margin-left:15px;"><input type="radio" id="dest_unico" name="destino" value="1">Enviar para destinatário do filtro</label>
							<label class="radio-inline" style="margin-left:15px;"><input type="radio" id="dest_todos" name="destino" value="2" checked="checked">Enviar para todas as Turmas</label>
						</div>
						</form>
						<div id="retorno" class="alert"></div>
					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript">
		$(document).ready(function() {
			$("#cadastro").submit(function() {
				$("#btn_enviar").attr("disabled", true).text("Enviando");
				
				var id_curso = $("#curso").attr("value");
				var id_turma = $("#turma").attr("value");
				var id_aluno = $("#aluno").attr("value");
				var id_professor = $("#professor").attr("value");
				var id_coordenador = $("#coordenador").attr("value");
				var texto = $("#texto").attr("value");
				var destino = $(\'input[name="destino"]:checked\').val();
				
				$.ajax({
					type: "POST",
					url: "'.DIR_ROOT_COORDENADOR.'ajax_submit_mensagem_inserir/",
					data: { id_curso: id_curso, id_turma: id_turma, id_aluno: id_aluno, id_professor: id_professor, id_coordenador: id_coordenador, texto: texto, destino: destino },
					beforeSend: function() {
						$("#retorno").removeClass("alert-danger alert-success")
						$("#retorno").html(\'<img src="'.DIR_WWW.'imgs/layout/ajax-loader.gif">\');
					},
					contentType: "application/x-www-form-urlencoded; charset='.CODING.'"
				}).done(function(o) {
					$("#retorno").html(o.m);
					if (o.r == "t") {
						$("#retorno").addClass("alert-success");
						$("#texto").attr("value", "");
						$("#show_mensagens").load("'.DIR_ROOT_COORDENADOR.'ajax_mensagem_visualizar", function() {
							$("html, body").animate({ scrollTop: $(document).height() }, 100);
						});
					} else {
						$("#"+o.c).focus();
						$("#retorno").addClass("alert-danger");
					}

				}).fail(function() {
					$("#retorno").addClass("alert-danger").text("Erro ao carregar");
				}).always(function() {
					$("#btn_enviar").attr("disabled", false).text("Enviar");
				});
				return false;
			});
			
			$("#curso").change(function() {
				var id_curso = ($(this).val() > 0) ? $(this).val() : 0;
				
				$("#dest_todos").attr("checked", false);
				$("#dest_unico").attr("checked", true);
				
				$("#turma").attr("disabled", true).load("'.DIR_ROOT_COORDENADOR.'ajax_turma_listar/"+id_curso, function() {
					$(this).attr("disabled", false);
				});
				$("#aluno").attr("disabled", true).load("'.DIR_ROOT_COORDENADOR.'ajax_aluno_listar_select/"+id_curso, function() {
					$(this).attr("disabled", false);
				});
				$("#professor").attr("disabled", true).load("'.DIR_ROOT_COORDENADOR.'ajax_professor_listar_select/"+id_curso, function() {
					$(this).attr("disabled", false);
				});
			});
			
			$("#turma").change(function() {
				var id_curso = ($("#curso").val() > 0) ? $("#curso").val() : 0;
				var id_turma = ($(this).val() > 0) ? $(this).val() : 0;
				
				$("#dest_todos").attr("checked", false);
				$("#dest_unico").attr("checked", true);
				
				$("#aluno").attr("disabled", true).load("'.DIR_ROOT_COORDENADOR.'ajax_aluno_listar_select/"+id_curso+"/"+id_turma, function() {
					$(this).attr("disabled", false);
				});
				$("#professor").attr("disabled", true).load("'.DIR_ROOT_COORDENADOR.'ajax_professor_listar_select/"+id_curso+"/"+id_turma, function() {
					$(this).attr("disabled", false);
				});
			});
			
			$("#aluno, #professor, #coordenador").change(function() {
				$("#dest_todos").attr("checked", false);
				$("#dest_unico").attr("checked", true);
			});
			
			$(".tt").tooltip();
			
			$("#show_mensagens").load("'.DIR_ROOT_COORDENADOR.'ajax_mensagem_visualizar");
			
			$("#filtros").scrollToFixed({
				marginTop: $(".navbar").outerHeight(),
				preFixed: function() {
					$(this).css({
						"padding-top" : 5,
						"border-bottom" : "1px solid #000"
					});
				},
				postFixed: function() {
					$(this).css({
						"padding-top" : 0,
						"border-bottom" : 0
					});
				}
			});
		});
		
		</script>
		';
		
		return $str;
	}
	
	public function boxMensagem(Mensagem $m, $permissaoExcluir = true) {
		$a = $m->__get('Aluno');
		$p = $m->__get('Professor');
		$c = $m->__get('Coordenador');
		$strMD = $strExcluir = '';
		
		$tituloMD = array('turma' => null, 'aluno' => null, 'professor' => null, 'coordenador' => null);
		
		$arrayMD = $m->__get('arrayMensagemDestino');

		$idAluno = $a->__get('id');
		$idProfessor = $p->__get('id');
		$idCoordenador = $c->__get('id');
		
		if (!empty($idAluno)) {
			$bg = '#fcf7e2';
			$borda = '#f2dd86';
			$fonte = '#b69614';
			$titulo = 'Aluno';
			$nome = $a->__get('nome');
		} elseif (!empty($idProfessor)) {
			$bg = '#fde1ec';
			$borda = '#f389ae';
			$fonte = '#a61145';
			$titulo = 'Professor';
			$nome = $p->__get('nome');
		} elseif (!empty($idCoordenador)) {
			$bg = '#e2fcf8';
			$borda = '#a0f5e9';
			$fonte = '#13b099';
			$titulo = 'Coordenador';
			$nome = $c->__get('nome');
		}
		
		if ($permissaoExcluir)
			$strExcluir = '<a href="javascript:void(0);" class="excluir" id="m'.$m->__get('id').'" style="color:'.$fonte.'; margin-left:50px;">Excluir mensagem</a>';
		
		
		
		$destino = '';
		
		$countMD = count($arrayMD);
		
		if ($countMD > 1) {
			$totalAluno = $totalTurma = $totalCoordenador = $totalProfessor = 0;			
			
			foreach ($arrayMD as $md) {
				$idAluno = $md->__get('Aluno')->__get('id');
				$idProfessor = $md->__get('Professor')->__get('id');
				$idCoordenador = $md->__get('Coordenador')->__get('id');
				$idTurma = $md->__get('Turma')->__get('id');
				
//				echo $md->__get('id').': '.$idTurma.'<br>';
				
				if (!empty($idAluno)) {
					$tituloMD['aluno'] .= $md->__get('Aluno')->__get('nome').', ';
					$totalAluno++;
				}
				if (!empty($idProfessor)) {
					$tituloMD['professor'] .= $md->__get('Professor')->__get('nome').', ';
					$totalProfessor++;
				}
				if (!empty($idCoordenador)) {
					$tituloMD['coordenador'] .= $md->__get('Coordenador')->__get('nome').', ';
					$totalCoordenador++;
				}
				if (!empty($idTurma)) {
					$tituloMD['turma'] .= $md->__get('Turma')->__get('nome').' - '.$md->__get('Turma')->__get('Curso')->__get('nome').', ';
					$totalTurma++;
				}
				
			}
			if ($totalAluno > 0) {
				$t = rtrim($tituloMD['aluno'], ', ');
				$destino .= '<span class="tt" title="'.$t.'" style="cursor:pointer;">'.$totalAluno.' Alunos</span>, ';
			}
			if ($totalProfessor > 0) {
				
				$t = rtrim($tituloMD['professor'], ', ');
				$destino .= '<span class="tt" title="'.$t.'" style="cursor:pointer;">'.$totalProfessor.' Professores</span>, ';
			}
			if ($totalCoordenador > 0) {
				$t = rtrim($tituloMD['coordenador'], ', ');
				$destino .= '<span class="tt" title="'.$t.'" style="cursor:pointer;">'.$totalCoordenador.' Coordenadores</span>, ';
			}
			if ($totalTurma > 0) {
				$t = rtrim($tituloMD['turma'], ', ');
				$destino .= '<span class="tt" title="'.$t.'" style="cursor:pointer;">'.$totalTurma.' Turmas</span>, ';
			}
			$strMD .= rtrim($destino, ', ');
		} elseif ($countMD == 1) {
			$md = $arrayMD[0];
			
			$a = $md->__get('Aluno');
			$p = $md->__get('Professor');
			$c = $md->__get('Coordenador');
			$t = $md->__get('Turma');
			
			$idAluno = $a->__get('id');
			$idProfessor = $p->__get('id');
			$idCoordenador = $c->__get('id');
			$idTurma = $t->__get('id');
			
			
				
			if (!empty($idAluno)) {
				$destino .= '(Aluno) '.$a->__get('nome').', ';
			}
			if (!empty($idProfessor)) {
				$destino .= '(Professor) '.$p->__get('nome').', ';
			}
			if (!empty($idCoordenador)) {
				$destino .= '(Coordenador) '.$c->__get('nome').', ';
			}
			if (!empty($idTurma) and empty($idAluno) and empty($idProfessor)) {
				$destino .= '(Turma) '.$t->__get('nome').' - '.$t->__get('Curso')->__get('nome').', ';
			}
			
			$strMD .= rtrim($destino, ', ');
		}
		
		
		
		$str = '
		<div class="alert alert-success" style="background-color:'.$bg.';border-color:'.$borda.';color:'.$fonte.'" id="box'.$m->__get('id').'">
			<strong>('.$titulo.') '.$nome.'</strong> para <strong>'.$strMD.': </strong>
			<div>'.nl2br(strip_tags(htmlspecialchars($m->__get('texto'), ENT_QUOTES))).'</div>
			<div style="font-size:12px;margin-top:8px;"><em>('.$m->__get('data').' às '.$m->__get('hora').')</em>'.$strExcluir.'</div>
		</div>
		
		';
		
		return $str;
	}
	
	public function scriptTooltip() {
		$str = '
		<script text="text/javascript">
		$(document).ready(function() {
			$(".tt").tooltip({
				content: function() {
					return $(this).prop("title");
				}
			});
		});
		</script>
		';
		
		return $str;
	}
	public function scriptExcluir() {
		$str = '
		<script text="text/javascript">
		$(document).ready(function() {
			$(".excluir").click(function() {
				var id_mensagem = $(this).attr("id").substr(1);
				
				if (confirm("Deseja realmente excluir?")) {
					$.ajax({
						type: "POST",
						url: "'.DIR_ROOT_COORDENADOR.'ajax_submit_mensagem_excluir/",
						data: { id_mensagem: id_mensagem },
						dataType: "json",
						beforeSend: function() {
							$("#m"+id_mensagem).text("Excluindo...");
						},
						contentType: "application/x-www-form-urlencoded; charset='.CODING.'"
					}).done(function(o) {
						if (o.r == "t") {
							$("#box"+id_mensagem).fadeOut("slow");
						} else {
							$("#m"+id_mensagem).text(o.m);
						}
	
					}).fail(function() {
						$("#m"+id_mensagem).text("Erro ao excluir mensagem, clique para tentar novamente");
					}).always(function() {
						
					});
				}
			});
		});
		</script>
		';
		
		return $str;
	}
}


?>