<?php
class GeralVisao {
	protected $titulo;
	protected $header;
	protected $corpo;
	protected $footer;
	protected $script;
	
	private $arrayScript;
	private $arrayCSS;
	
	public function __construct($titulo = null, $carregaClasses = true) {
		$this->titulo = $titulo;
		$this->corpo = null;
		
		$this->arrayScript = array();
		$this->arrayCSS = array();
		
		if ($carregaClasses) {
			self::addScript(DIR_WWW.'js/jquery.min.js');
			self::addScript(DIR_WWW.'js/jquery-migrate.min.js');
			self::addScript(DIR_WWW.'js/jquery.meiomask.min.js');
			self::addScript(DIR_WWW.'js/jquery.tablesorter.min.js');
			
			self::addCSS(DIR_WWW.'css/bootstrap/bootstrap.min.css');
			self::addCSS(DIR_WWW.'css/bootstrap/sb-admin.css');
		}
	
//		self::addCSS(DIR_WWW.'css/geral.css');
	}
	
	public function setTitulo($valor) {
		$this->titulo = $valor;
	} public function getTitulo() {
		return $this->titulo;
	}
	
	public function setCorpo($valor) {
		$this->corpo = $valor;
	} public function getCorpo() {
		return $this->corpo;
	}
	
	public function setScript($valor) {
		$this->script = $valor;
	} public function getScript() {
		return $this->script;
	}
	
	public function geraHeaderHtml() {
		$strScript = $strCSS = '';
		
		foreach ($this->arrayScript as $script) {
			$strScript .= '<script type="text/javascript" src="'.$script.'"></script>'."\n";
		}
		
		foreach ($this->arrayCSS as $css) {
			$strCSS .= '<link rel="stylesheet" type="text/css" href="'.$css.'" />'."\n";
		}
		
		$jsDir = '<script type="text/javascript">var DIR_ROOT = \''.DIR_ROOT.'\';</script>'."\n";
		$jsDir .= '<script type="text/javascript">var DIR_WWW = \''.DIR_WWW.'\';</script>'."\n";
		
		$this->header = '<!DOCTYPE html><html><head><meta http-equiv="Content-Type" content="text/html; charset='.CODING.'" /><title>'.NOME.' - '.$this->titulo.'</title>'."\n".$strCSS.$strScript.$jsDir.$this->script.'</head><body>';
	}
	
	public function geraFooterHtml() {
		$this->footer = '</body></html>';
	}
	
	public function getDirRoot(Aluno $a = null, Professor $p = null, Coordenador $c = null) {
		if ($a) {
			$dirRoot = DIR_ROOT_ALUNO;
		} elseif ($p) {
			$dirRoot = DIR_ROOT_PROFESSOR;
		} elseif ($c) {
			$dirRoot = DIR_ROOT_COORDENADOR;
		} else {
			$dirRoot = DIR_ROOT;
		}
		
		return $dirRoot;
	}
	
	public function geraCabecalho(Aluno $a = null, Professor $p = null, Coordenador $c = null, $menu = null) {
		if ($a) {
			$strNome = $a->__get('nome');
			$strTitulo = 'Área do aluno';
			$strFoto = '';
			$dirRoot = DIR_ROOT_ALUNO;
		} elseif ($p) {
			$strNome = $p->__get('nome');
			$strTitulo = 'Área do professor';
			$strFoto = '';
			$dirRoot = DIR_ROOT_PROFESSOR;
		} elseif ($c) {
			$strNome = $c->__get('nome');
			$strTitulo = 'Área do coordenador';
			$strFoto = $c->exibeImagem(128);
			$dirRoot = DIR_ROOT_COORDENADOR;
		} else {
			$strNome = null;
			$strFoto = '';
		}
		
		self::addScript(DIR_WWW.'js/fancybox/jquery.fancybox.pack.js?v=2.1.5');
		self::addCSS(DIR_WWW.'js/fancybox/jquery.fancybox.css?v=2.1.5');
		
		$this->script = '
		<script type="text/javascript">
		$(document).ready(function() {
			$(".dropdown-toggle").click(function() {
				$(".dropdown-menu").slideToggle();
			});
			$("#altera_foto").mouseover(function() {
				$("#show_txt_foto").fadeIn(100);
			}).mouseleave(function() {
				$("#show_txt_foto").fadeOut(100);
			}).click(function() {
				$.fancybox({
					type : "iframe",
					minWidth : 700,
					minHeight : 460,
					href : "'.$dirRoot.'popup_minha_foto"
				});
				$(".dropdown-menu").slideUp();
			});
		});
		</script>
		';
		
		$str = '
		<div id="wrapper">
	        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
	            <!-- Brand and toggle get grouped for better mobile display -->
	            <div class="navbar-header">
	                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
	                    <span class="sr-only">Toggle navigation</span>
	                    <span class="icon-bar"></span>
	                    <span class="icon-bar"></span>
	                    <span class="icon-bar"></span>
	                </button>
	                <a class="navbar-brand" href="'.$dirRoot.'">'.$strTitulo.'</a>
	            </div>
	            <!-- Top Menu Items -->
	            <ul class="nav navbar-right top-nav">
	                <li class="dropdown">
	                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> '.$strNome.' <b class="caret"></b></a>
	                    <ul class="dropdown-menu">
	                        <li style="text-align:center;margin-bottom:5px;">
	                        	<div style="position:relative;cursor:pointer;" id="altera_foto">
	                            <img src="'.$strFoto.'" width="128" />
	                            <div id="show_txt_foto" style="position:absolute; top:104px; left:0; background-color:#46b8da;text-align:center;width:100%;padding:5px;filter: alpha(opacity=80);opacity: 0.8;display:none;font-weight:bold;">Alterar Foto</div>
	                            </div>
	                        </li>
	                        <li>
	                            <a href="'.$dirRoot.'perfil"><i class="fa fa-fw fa-user"></i> Perfil</a>
	                        </li>
	                        <li>
	                            <a href="'.$dirRoot.'mensagens"><i class="fa fa-fw fa-envelope"></i> Mensagens</a>
	                        </li>
	                        <li class="divider"></li>
	                        <li>
	                            <a href="'.$dirRoot.'sair"><i class="fa fa-fw fa-power-off"></i> Sair</a>
	                        </li>
	                    </ul>
	                </li>
	            </ul>
	            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
	            
	            
	            '.$menu.'
	            
	            
	            <!-- /.navbar-collapse -->
	        </nav>
	        <script type="text/javascript">
			$(document).ready(function() {
			});
			</script>
	        ';
		
		return $str;
	}
	
	public function pagina404() {
		$str = '
		<div id="page-wrapper">
			<div class="container-fluid">

				<!-- Page Heading -->
				<div class="row">
					<div class="col-lg-12">
						<h1 class="page-header">
							Página não encontrada
						</h1>
						
						<ol class="breadcrumb">
							<li>
								<i class="fa fa-dashboard"></i>  <a href="'.DIR_ROOT_ALUNO.'">Início</a>
							</li>
							<li class="active">
								<i class="fa fa-bar-chart-o"></i> Página não encontrada
							</li>
						</ol>
						<div style="text-align:left;font-size:256px; font-weight:bold;">OPS...</div>
					</div>
				</div>
			</div>
		</div>
		';
		
		return $str;
	}
	
	public function breadCrumb(array $array = array()) {
		$strLink = null;
		
		foreach ($array as $link => $descricao) {
			if (!empty($link))
				$strLink .= '<li><a href="'.$link.'">'.$descricao.'</a></li>';
			else
				$strLink .= '<li class="active">'.$descricao.'</li>';
		}
		
		$str = '
		<ol class="breadcrumb">
			'.$strLink.'
		</ol>
		';
		
		return $str;
	}
	
	public function alerta($texto) {
		$str = '<div class="alert alert-warning"><strong>Atenção!</strong> '.$texto.'</div>';
		
		return $str;
	}
	
	
	public function geraRodape() {
		$str = '</div>';
		
		return $str;
	}
	
	public function addScript($script) {
		array_push($this->arrayScript, $script);
	}
	
	public function addCSS($css) {
		array_push($this->arrayCSS, $css);
	}
	
	public function saida() {
		return $this->header.$this->corpo.$this->footer;
	}
	
}
?>