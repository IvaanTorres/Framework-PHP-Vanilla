<?php
    require __DIR__ . '/../vendor/autoload.php';
    $templates = new League\Plates\Engine(__DIR__ . '/../app/views');
    //librería para poder leer archivos.env
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->load();
    include  __DIR__ . ('/../routes/web.php');
?>