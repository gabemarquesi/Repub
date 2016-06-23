<?php

include_once '../repub.controlador/usuarioControlador.php';

class SignIn {

    public function criarConta($nome, $email, $senha) {
        $usuario = new Usuario(null, $nome, $senha, $email);
        $usuarioControlador = new UsuarioControlador();
        $usuarios = $usuarioControlador->create($usuario);
        if (count($usuarios) == 1) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }

}

$pagina = new SignIn();
$acao = $_REQUEST["action"];
switch ($acao) {
    case "inscrever":
        $nome = $_REQUEST["nome"];
        $email = $_REQUEST["email"];
        $senha = $_REQUEST["senha"];
        $pagina->criarConta($nome, $email, $senha);

    case "login":
        $controller = new UsuarioControlador();        
        $usuario = $controller->getByEmail($_REQUEST["email"]);
        
        if ($usuario == null){
            echo json_encode(false);
            die();
        }

        $hash = \hash('sha256', $_REQUEST["senha"] . 'no-rainbow');
        if ($hash == $usuario->senha) {
            session_start();
            $_SESSION['usuario'] = $usuario;

            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
}
