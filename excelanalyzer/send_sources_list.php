<?php
ini_set('include_path', ini_get('include_path') . ';' . $_SERVER['DOCUMENT_ROOT'] . '/khalifaAPI/');
include_once 'libraries/khalifaAPI.php';

/////// ----------------------INITIALIZATION 1 ----------------------
$GLOBALS["general-log"] = new MyLogPHP(EXCELANALYZER_LOG_FILE);
$GLOBALS["final_reply"] = array("status" => "success");

/////// ----------------------Main checks----------------------
if (!isset($_POST["username"])) {
    exitAppOnError("Not logged in !");
}


//Local smart_calendar DB connection
$GLOBALS["LOCAL_DB"] = new MeekroDB(EXCELANALYZER_DB_HOST, DB_USER, DB_PASSWORD, EXCELANALYZER_DB_NAME, NULL, 'utf8');
$GLOBALS["LOCAL_DB"]->error_handler = false; // since we're catching errors, don't need error handler
$GLOBALS["LOCAL_DB"]->throw_exception_on_error = true; //enable exceptions for the DB


//Get list of sources user has access to
// $query = 'SELECT id, text FROM existing_sources';

$query = 'SELECT id, text FROM user_access JOIN existing_sources ON sourcename = text WHERE username = %s_username';

//add table name to the list of tables
try {
    $res = $GLOBALS["LOCAL_DB"]->query($query, array('username' => $_POST["username"]));
} catch (MeekroDBException $ex) {
    $GLOBALS["final_reply"]['status'] = 'error';
    $GLOBALS['general-log']->info("LOCAL DB Error: " . $ex->getMessage());
    exit;
}

echo json_encode(array('items' => $res));

function exitAppOnError($general_log_message = "")
{
    $GLOBALS["final_reply"]['status'] = 'error';
    $GLOBALS['general-log']->error($general_log_message);
    echo json_encode($GLOBALS["final_reply"]);
    exit;
}
