<?php

class Usuario {

    public $id;
    public $nome;
    public $senha;
    public $email;
    public $cidadeID;

    function __construct($id, $nome, $senha, $email, $cidadeID) {
        $this->id = $id;
        $this->nome = $nome;
        $this->senha = $senha;
        $this->email = $email;
        $this->cidadeID = $cidadeID;
    }

    public static function validate($usuario) {
        if($usuario == null){
            throw new Exception('Um usuário não-nulo precisa ser fornecido.');
        }
        
        if ($usuario->nome == null || strlen($usuario->nome) > 45) {
            return new Exception('Overflow de caracteres!');
        }
        if ($usuario->senha == null || strlen($usuario->senha) > 45) {
            return new Exception('Overflow de caracteres!');
        }
        if ($usuario->email == null || strlen($usuario->email) > 100 ) {
            return new Exception('Overflow de caracteres!');
        }
        if ($usuario->cidade == null || strlen($usuario->cidade) > 45) {
            return new Exception('Overflow de caracteres!');
        }
        
        return null;
    }

}

