<?php

class Imagem {

    public $id;
    public $endereco;

    public function __construct($id, $endereco) {
        $this->id = $id;
        $this->endereco = $endereco;
    }

    public static function validate($imagem) {
        if ($imagem == null) {
            throw new Exception('Uma imagem não-nula precisa ser fornecida.');
        }

        if ($imagem->endereco == null || strlen($imagem->endereco) > 1024) {
            return new Exception('Overflow de caracteres!');
        }

        return null;
    }

}

?>