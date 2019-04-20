<?php

ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR .'khalifaAPI'.DIRECTORY_SEPARATOR);
include_once 'libraries'.DIRECTORY_SEPARATOR.'khalifaAPI.php';

// echo getBaseUrl();

echo '11111<br>';

echo $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'excelanalyzer' . DIRECTORY_SEPARATOR . 'log' . DIRECTORY_SEPARATOR . 'ExcelAnalyzer.csv<br>';

/////// ----------------------INITIALIZATION 1 ----------------------
// $GLOBALS["general-log"] = new MyLogPHP(EXCELANALYZER_LOG_FILE);
echo '222222';

$GLOBALS["general-log"] = new MyLogPHP($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'excelanalyzer' . DIRECTORY_SEPARATOR . 'log' . DIRECTORY_SEPARATOR . 'ExcelAnalyzer.csv');
$GLOBALS["general-log"]->info("HAHAHAHA");

echo '333333';


exit;