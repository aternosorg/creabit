<?php

require_once "vendor/autoload.php";

use Aternos\Creabit\Creabit;
use Aternos\Creabit\Enums\DimensionType;
use Aternos\Creabit\Enums\SettingsType;
use Aternos\Creabit\Enums\GeneratorType;

if (!isset($argc)) {
    echo "argc and argv disabled. check php.ini\n";
    return;
}

$no = ["N", "n"];

function setup(string $filename): Creabit {
    if (!file_exists($filename)) {
        echo "input file does not exist\n";
        exit;
    }
    $filePtr = fopen($filename, "r");
    $fileContent = fread($filePtr, filesize($filename));
    fclose($filePtr);
    return new Creabit($fileContent);
}

switch ($argc) {
    case 1:
        echo "too few params given. choose:\n1 argument:\n\t1: path of input file -> output is current dir\n2 arguments:\n\t1: path of input file\n\t2: path of output file\n";
        return;

    case 2:
        $levelRepairer = setup($argv[1]);
        $writtenBytes = file_put_contents("new_level.dat", $levelRepairer->repair());
        break;
    case 3:
        $levelRepairer = setup($argv[1]);
        $fileName = $argv[2];
        if (!file_exists(dirname($argv[2]))) mkdir(dirname($argv[2]), recursive: true);
        if (file_exists($argv[2]) === true) {
            $answer = readline("output file does already exist.\ndo you want to overwrite it?(Y/n)\n");
            if (in_array($answer, $no)) {
                while (file_exists($fileName)) {
                    $numeric = substr($fileName, strlen($argv[2]));
                    if (!empty($numeric)) $fileName = $argv[2] . strval(intval($numeric) + 1);
                    else $fileName = $fileName . "1";
                }
            }
        }
        $writtenBytes = file_put_contents($fileName, $levelRepairer->repair());
        break;
    default:
        echo "too many params given. choose:\n1 argument:\n\t1: path of input file -> output is current dir\n2 arguments:\n\t1: path of input file\n\t2: path of output file\n";
        return;
}