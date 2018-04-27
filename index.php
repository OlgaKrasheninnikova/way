<?php
 error_reporting(E_ALL);
ini_set("display_errors", 1);
include 'DirectionFinderClass.php';

function getData(){
    return file_get_contents('data.txt');
}

$finder = new DirectionFinder();
echo $finder->execute(getData());
