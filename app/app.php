<?php

declare(strict_types=1);



function getFilesPaths(string $path): array {
  $filesList = array_diff(scandir($path), ['.', '..']);
  $filesPaths = [];

  foreach ($filesList as $fileName) {
    $filesPaths[] = $path . $fileName;
  }

  return $filesPaths;
}

function getTransactions(string $filePath): array {
  if (!file_exists($filePath)) {
    trigger_error('File ' . $filePath . 'does not exist.', E_USER_ERROR);
  }

  $transactions = [];

  $file = fopen($filePath, 'r');

  while (($line = fgetcsv($file)) !== false) {
    $transactions[] = $line;
  }

  fclose($file);

  return $transactions;
}

function getTotals(array $transactions): array {
  $totals = [];

  foreach ($transactions as $transaction) {
    $amount = floatval(str_replace(['$', ','], '', end($transaction)));
    $amount > 0 ?
      $totals['income'] += $amount :
      $totals['expense'] += $amount;
  }

  return $totals;
}

$allTransactions = [];
$transactions = [];
$totalIncome = 0;
$totalExpense = 0;

$files = getFilesPaths(FILES_PATH);


foreach ($files as $key => $file) {
  $transactions = getTransactions($file);

  if ($key > 2) unset($transactions[0]);
  $allTransactions = array_merge($allTransactions, $transactions);
}

$totals = getTotals($allTransactions);
$totalExpense += $totals['expense'];
$totalIncome += $totals['income'];

$netTotal = $totalIncome + $totalExpense;

$totalIncome = substr_replace(number_format($totalIncome, 2, '.', ','), '$', 0, 0);
$totalExpense = substr_replace(number_format($totalExpense, 2, '.', ','), '$', 1, 0);
$netTotal = substr_replace(number_format($netTotal, 2, '.', ','), '$', ($netTotal > 0 ? 0 : 1), 0);
