<?php

// $memoryStart = memory_get_usage();

require_once('./vendor/autoload.php');

use Geekbrains\Application1\Application\Application;

try{
    $app = new Application();
    echo $app->run();
}
catch(Exception $e){
    echo $e->getMessage();
}

// $memoryEnd = memory_get_usage();

// echo "<h4>Потреблено " . ($memoryEnd - $memoryStart) / 1024 / 1024  . " Мбайт памяти</h4>";