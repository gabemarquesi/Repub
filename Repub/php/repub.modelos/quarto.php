<?php

class Quarto {

    public $id;
    public $valor;
    public $descricao;
    public $alugado;
    public $imagens;

    function __construct($id, $valor, $descricao, $alugado, $imagens) {
        $this->id = $id;
        $this->valor = $valor;
        $this->descricao = $descricao;
        
        $this->alugado = $alugado;
        $this->imagens = $imagens;
    }

    public static function validate($quarto) {
        if ($quarto == null){
            throw new Exception('Um quarto não-nullo precisa ser fornecido.');
        }
        
        if (strlen($quarto->descricao) > 255) {
            return new Exception('Overflow de caracteres!');
        }
        if ($quarto->valor == NULL) {
            return new Exception('Valor não pode ser nulo');
        }
        if ($quarto->alugado === NULL) {
            return new Exception('Overflow de caracteres!');
        }
        
        return null;
    }

}

?>