<?php

declare(strict_types=1);

$dirContent = [];
$fileContent = [];
$totalIncome = 0;
$totalExpense = 0;

function getFilesPaths(string $path): array {
  $filesList = array_diff(scandir($path), ['.', '..']);
  $filesPaths = [];

  foreach ($filesList as $fileName) {
    $filesPaths[] = $path . $fileName;
  }

  return $filesPaths;
}

function getFileContent(string $filePath): array {
  $file = fopen($filePath, 'r');
  $fileContent = [];

  if ($file) {
    while (($line = fgetcsv($file)) !== false) {
      array_push($fileContent, $line);
    }
    fclose($file);
  }

  return $fileContent;
}

function getPartials(array $filesContent): array {
  $partials = [];

  foreach ($filesContent as $fileContent) {
    $amount = floatval(str_replace(['$', ','], '', end($fileContent)));
    $amount > 0 ?
      $partials['income'] += $amount :
      $partials['expense'] += $amount;
  }

  return $partials;
}

$files = getFilesPaths(FILES_PATH);


foreach ($files as $key => $file) {
  $fileContent = getFileContent($file);

  $partials = getPartials($fileContent);
  $totalExpense += $partials['expense'];
  $totalIncome += $partials['income'];

  if ($key > 2 ) unset($fileContent[0]);
  $dirContent = array_merge($dirContent, $fileContent);
}

$netTotal = $totalIncome + $totalExpense;

$totalIncome = substr_replace(number_format($totalIncome, 2, '.', ','), '$', 0, 0);
$totalExpense = substr_replace(number_format($totalExpense, 2, '.', ','), '$', 1, 0);
$netTotal = substr_replace(number_format($netTotal, 2, '.', ','), '$', ($netTotal > 0 ? 0 : 1), 0);
