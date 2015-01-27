<?php
class Imagem {
	private $base64;
	
	public function setBase64($valor) {
		$this->base64 = $valor;
	}
	
	public function salvarBase64($diretorio, $nomeArquivo) {
		$img = str_replace('data:image/png;base64,', '', $this->base64);
		$img = str_replace(' ', '+', $img);
		$data = base64_decode($img);
		
		return (file_put_contents($diretorio.$nomeArquivo, $data) > 0) ? true : false;
	}
	
	public function geraNomeArquivo() {
		return md5(uniqid(rand(), true));
	}
}