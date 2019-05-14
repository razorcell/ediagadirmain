<?php

ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . $_SERVER['DOCUMENT_ROOT'] . '/khalifaAPI/');
include_once 'libraries/khalifaAPI.php';
//Global Vars
$GLOBALS["general-log"] = new MyLogPHP(EXCELANALYZER_LOG_FILE);
$GLOBALS["final_reply"] = array("status" => "success");


$LOCAL_DB = new MeekroDB(EXCELANALYZER_DB_HOST, EXCELANALYZER_DB_USER, EXCELANALYZER_DB_PASSWORD, EXCELANALYZER_DB_NAME, NULL, 'utf8');
$GLOBALS["LOCAL_DB"]->error_handler = false; // since we're catching errors, don't need error handler
$GLOBALS["LOCAL_DB"]->throw_exception_on_error = true; //enable exceptions for the DB

$source = $_POST["source"];
$table_type = strtolower($_POST["table_type"]);


if ($table_type === 'History') {
    $columns = $GLOBALS["LOCAL_DB"]->columnList($source . '_history');
    $query = 'SELECT * FROM ' . $source . '_' . $table_type . ' ORDER BY ' . end($columns) . ' DESC';
} else {
    $query = 'SELECT * FROM ' . $source . '_' . $table_type;
}

//add table name to the list of tables
try {
    $live_data = $GLOBALS["LOCAL_DB"]->query($query);
} catch (MeekroDBException $ex) {
    $GLOBALS["final_reply"]['status'] = 'error';
    $GLOBALS['general-log']->error("ERROR: LOCAL DB Error: " . $ex->getMessage());
    echo json_encode($GLOBALS["final_reply"]);
    exit;
}

sleep(1);

$GLOBALS["final_reply"]["live_data"] =  $live_data;

echo json_encode($GLOBALS["final_reply"]);
