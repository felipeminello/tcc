<?php
class MaterialVisao extends GeralVisao {
	private $Material;
	
	public function setMaterial(Material $m) {
		$this->Material = $m;
	}
	
	public function tabelaMateriais(array $arrayMaterial, $idCurso = 0, $idTurma = 0, $idDisciplina = 0, Professor $p = null, $dataInicial = null, $dataFinal = null) {
		$strMaterial = '';
		$countMaterial = count($arrayMaterial);

		if (!is_object($p))
			$p = new Professor();
		
		$arrayFalta = $this->Material->calcularFaltas($arrayAluno, $arrayMaterial);
		
		foreach ($arrayAluno as $a) {
			$idAluno = $a->__get('id');

			$strMaterial .= '<tr>';
			$strMaterial .= '<td>'.$a->__get('nome').'</td>';
			$strMaterial .= '<td>'.$arrayFalta[$idAluno].'</td>';
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
				'.$strMaterial.'
			</tbody>
		</table>';
		
		return $str;
	}
	
}


?>