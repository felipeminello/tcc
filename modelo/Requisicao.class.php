<?php
class Requisicao {
	public static function post($var) {
		if (isset($_POST[$var]))
			return $_POST[$var];
		else
			return false;
	}
	
	public static function get($var) {
		if (isset($_GET[$var]))
			return $_GET[$var];
		else
			return false;
	}
	
	public static function checkEmail($str) {
		return filter_var($str, FILTER_VALIDATE_EMAIL);
	}
	
	public static function checkString($str) {
		if(is_array($str))
			foreach($str as $k => $v)
				$str[$k] = self::checkString($v);
		elseif(is_string($str))
			$str = filter_var($str, FILTER_SANITIZE_STRING);

		return $str;
	}
	
	public static function decode($str) {
		if(is_array($str))
			foreach($str as $k => $v)
				$str[$k] = self::decode($v);
		elseif(is_string($str))
			$str = utf8_decode($str);

		return $str;
	}
	
	public static function checkInt($str) {
		if(is_array($str))
			foreach($str as $k => $v)
				$str[$k] = self::checkInt($v);
		elseif(is_string($str))
			$str = filter_var($str, FILTER_VALIDATE_INT);

		return $str;
	}
	
    /**
     * Checa e converte datas
     *
     * @access	public
     * @param	string				$str		A data a ser verificada ou convertida, aceita: dd/mm/yyyy ou yyyy-mm-dd
     * @param	integer	Optional	$converter	1: Retorna a data no formato dd/mm/yyyy. 2: Retorna a data no formato yyyy-mm-dd 
     * @return	string	String					A data convertida ou falso
     */
	public static function checkData($str, $converter = 0) {
		$str = self::checkString($str);
		$data = substr($str, 0, 10);
		
		if (strpos($data, '/')) {
			$arrayData = explode('/', $data);

			$dia = $arrayData[0];
			$mes = $arrayData[1];
			$ano = $arrayData[2];
		} elseif (strpos($data, '-')) {
			$arrayData = explode('-', $data);
			
			$dia = $arrayData[2];
			$mes = $arrayData[1];
			$ano = $arrayData[0];
		} else {
			return false;
		}
		
		if (checkdate($mes, $dia, $ano)) {
			if ($converter == 1) {
				return $dia.'/'.$mes.'/'.$ano;
			} elseif ($converter == 2) {
				return $ano.'-'.$mes.'-'.$dia;
			} else {
				return $data;
			}
		} else
			return false;
	}
	
	public static function checkDiferencaData($dataInicial, $dataFinal) {
		$dataInicial = Requisicao::checkData($dataInicial, 2);
		$dataFinal = Requisicao::checkData($dataFinal, 2);
		
		if (!empty($dataInicial) and !empty($dataFinal)) {
			$arrayInicial = explode('-', $dataInicial);
			$timeInicial = mktime(0, 0, 0, $arrayInicial[1], $arrayInicial[2], $arrayInicial[0]);
			
			$arrayFinal = explode('-', $dataFinal);
			$timeFinal = mktime(0, 0, 0, $arrayFinal[1], $arrayFinal[2], $arrayFinal[0]);
			
			$diferenca = $timeFinal - $timeInicial;
			
			return $diferenca;
		} else {
			return false;
		}
	}
}
?>