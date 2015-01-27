<?php
class Elementos {
	public static function popularSelect(array $array, $id = 0) {
		$str = '';
		foreach ($array as $k => $v) {
			$select = ($id == $k) ? 'selected="selected"' : '';
			
			$str .= '<option value="'.$k.'" '.$select.'>'.$v.'</option>';
		}
		return $str;
	}
}
?>