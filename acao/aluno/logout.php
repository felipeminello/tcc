<?php
$v = new AlunoVisao('Login');

$v->geraHeader();
$v->geraRodape();
$v->scriptFocus();
$v->scriptLogin();

$v->geraCorpo();
echo $v->saida();
?>