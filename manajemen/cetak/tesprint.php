<?php
require __DIR__ . '\..\vendor\autoload.php';
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector ;
use Mike42\Escpos\Printer;

$connector = new WindowsPrintConnector("php://stdout");
$printer = new Printer($connector);
$printer->text("Hello World!\n");
$printer->cut();
$printer->close();
