<?php

require_once("config.php");

// $usuario = new Usuario();
// $usuario->loadById(3);
// echo $usuario;

// $listaUsu =  Usuario::getList();
// echo json_encode($listaUsu);

// $search = Usuario::search("e");
// echo json_encode($search);

// $usu = new Usuario();
// $usu -> login("user","4321");
// echo $usu;

$aluno = new Usuario("aluno2","senha");

$aluno->insert();

echo $aluno;

?>