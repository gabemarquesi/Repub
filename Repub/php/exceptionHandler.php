<?php

set_exception_handler('logException');

function logException($exception) {
    $myfile = fopen('logs/repub-errors.txt', "a") or die("Unable to open file!");
    $now = new DateTime('now');
    $text = "$now ---> ERRO: Em ". $exception->getFile() . ", linha " . $exception->getLine() . ": \n" .
            $exception->getMessage() . ". \n";
    if (fwrite($myfile, $text) > 0) {
        fclose($myfile);
    }
}
