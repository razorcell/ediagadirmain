<?php

ini_set('include_path', ini_get('include_path') . ';' . $_SERVER['DOCUMENT_ROOT'] . '/khalifaAPI/');
include_once 'libraries/khalifaAPI.php';

$GLOBALS["general-log"] = new MyLogPHP(EXCELANALYZER_LOG_FILE);
$GLOBALS["final_reply"] = array("status" => "success", "columns_obj" => null);
//Local smart_calendar DB connection
$GLOBALS["LOCAL_DB"] = new MeekroDB(EXCELANALYZER_DB_HOST, DB_USER, DB_PASSWORD, EXCELANALYZER_DB_NAME, NULL, 'utf8');
$GLOBALS["LOCAL_DB"]->error_handler = false; // since we're catching errors, don't need error handler
$GLOBALS["LOCAL_DB"]->throw_exception_on_error = true; //enable exceptions for the DB
//Getting the data
$source = strtolower($_POST["source"]);
$table_type = $_POST["table_type"];
//get columns array for the table
$columns = $GLOBALS["LOCAL_DB"]->columnList($source . '_' . $table_type);
$columns_var = array();
for ($i = 1; $i <= count($columns); $i++) {

    array_push($columns_var, array("data" => "column" . $i));
}

echo json_encode(array("correct_columns_parameter" => $columns_var));
