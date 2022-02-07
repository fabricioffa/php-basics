<?php

$files = array_diff(scandir(FILES_PATH), ['.', '..'] ) ;
var_dump($files);
$file = fopen(FILES_PATH . 'transactions_1.csv', 'r');
$dirContent = [];
$fileContent = [];
$totalIncome = 0;
$totalExpense = 0;




if ($file) {
    while (($line = fgetcsv($file)) !== false) {
        $amount = floatval(str_replace(['$', ','], '', end($line)));
        $amount > 0 ? $totalIncome += $amount : $totalExpense += $amount;
        array_push($fileContent, $line);
    }
    fclose($file);
}
$netTotal = $totalIncome + $totalExpense;

$totalIncome = substr_replace(number_format($totalIncome, 2, '.', ','), '$', 0, 0);
$totalExpense = substr_replace(number_format($totalExpense, 2, '.', ','), '$', 1, 0);
$netTotal = substr_replace(number_format($netTotal, 2, '.', ','), '$', ($netTotal > 0 ? 0 : 1), 0);
