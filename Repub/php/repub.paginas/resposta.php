<?php

class Resposta {
    public $mensagem;
    public $sucesso;
    
    /**
     * Cria uma nova instância de uma Resposta.
     * @param string $mensagem
     * @param boolean $sucesso
     */
    public function __construct($mensagem, $sucesso) {
        $this->mensagem = $mensagem;
        $this->sucesso = $sucesso;
    }
}
