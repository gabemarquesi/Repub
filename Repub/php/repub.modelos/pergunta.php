<?php

class Pergunta {

    public $id;
    public $data;
    public $pergunta;
    public $resposta;
    public $usuarioID;

    public function __construct($id, $data, $pergunta, $resposta, $usuarioID) {
        $this->id = $id;
        $this->data = $data;
        $this->pergunta = $pergunta;
        $this->resposta = $resposta;
        $this->usuarioID = $usuarioID;
    }
    
    public static function validate($pergunta) {
        if ($pergunta == null) {
            throw new Exception('Uma pergunta não-nula precisa ser fornecida.');
        }

        if ($pergunta->pergunta == null || strlen($pergunta->pergunta) > 255) {
            return new Exception('Overflow de caracteres!');
        }
        if ($pergunta->resposta == null || strlen($pergunta->resposta) > 255) {
            return new Exception('Overflow de caracteres!');
        }

        return null;
    }

}

