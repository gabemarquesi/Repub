<?php

set_exception_handler('logException');

function logException($exception) { 
    if (!($myfile = fopen('../logs/repub-errors.txt', "a"))) {        
        print_r(error_get_last());
        die();
    }
    $now = new DateTime('now');
    $text = $now->format('d/m/Y às H:i:s') . "---> ERRO: Em " . $exception->getFile() . ", linha " . $exception->getLine() . ": \n" .
            $exception->getMessage() . ". \n";

    if (fwrite($myfile, $text) !== false) {
        fclose($myfile);
    }
    
    die();
}
