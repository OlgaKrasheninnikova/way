<?php
include 'DirectionFinderClass.php';

function getData(){
    return file_get_contents('data.txt');
}

$finder = new DirectionFinder();
echo $finder->execute(getData());
