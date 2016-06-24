<?php

class Telefone {

    public $id;
    public $numero;

    function __construct($id, $numero) {
        $this->id = $id;
        $this->numero = $numero;
    }

    public static function validate($telefone) {
        if ($telefone == null){
            throw new Exception('Um telefone não-nulo precisa ser fornecido.');
        }
        
        if ($telefone->numero == null || strlen($telefone->numero) > 15) {
            return new Exception('Overflow de caracteres!');
        }
        
        return null;
    }

}

?>