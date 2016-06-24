<?php

set_exception_handler('logException');

function logException($exception) {
    if (!$myfile = fopen('./logs/repub-errors.txt', "a")) {
        echo 'Erro ao abrir log de exceção!';
    }
    $now = new DateTime('now');
    $text = $now->format('d/m/Y às H:i:s') . "---> ERRO: Em " . $exception->getFile() . ", linha " . $exception->getLine() . ": \n" .
            $exception->getMessage() . ". \n";

    if (fwrite($myfile, $text) !== false) {
        fclose($myfile);
    }
}
