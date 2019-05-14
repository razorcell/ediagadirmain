<?php

ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . $_SERVER['DOCUMENT_ROOT'] . '/khalifaAPI/');
require_once 'libraries/khalifaAPI.php';

/////// ----------------------INITIALIZATION 1 ----------------------

$GLOBALS["general-log"] = new MyLogPHP(EXCELANALYZER_LOG_FILE);
$GLOBALS["final_reply"] = array(
    "status" => "success",
    "data" => ""
);
/////// ----------------------Main checks----------------------

// if (!isset($_POST["admin_password"]) or !isset($_POST["source"])) {
if (!isset($_POST["source"])) {
    exitAppOnError('-->ERROR: Missing source or password | script= ' . __FILE__);
}
// if ($_POST["admin_password"] !== 'Edmk1123581321') {
//     exitAppOnError('-->ERROR: incorrect Password | script= ' . __FILE__);
// }

/////// ----------------------INITIALIZATION 2 ----------------------

$GLOBALS['general-log']->warning('');
$GLOBALS['general-log']->warning('Delete source = ' . $_POST["source"]);

$LOCAL_DB = new MeekroDB(EXCELANALYZER_DB_HOST, EXCELANALYZER_DB_USER, EXCELANALYZER_DB_PASSWORD, EXCELANALYZER_DB_NAME, NULL, 'utf8');
$LOCAL_DB->error_handler = false; // since we're catching errors, don't need error handler
$LOCAL_DB->throw_exception_on_error = true; //enable exceptions for the DB

/////// ----------------------DELETE FROM existing_sources table ----------------------

try {
    $GLOBALS["LOCAL_DB"]->delete('existing_sources', "text=%s", $_POST["source"]);
} catch (MeekroDBException $ex) {
    exitAppOnError("Source: " . $_POST['source'] . " -->ERROR: LOCAL DB Error: " . $ex->getMessage());
}
$GLOBALS["general-log"]->info("-->Deleted from existing_sources");

/////// ----------------------DELETE prefix tables ----------------------

deleteAllTablesForOneSource($_POST["source"]);

/////// ---------------------- END ----------------------
$GLOBALS["general-log"]->success("SUCCESS : Source deleted");
echo json_encode($GLOBALS["final_reply"]);
exit;


function deleteAllTablesForOneSource($source)
{
    $table_prefixes = array('_today', '_live', '_history');
    foreach ($table_prefixes as $prefix) {
        $GLOBALS["general-log"]->info("---->Deleting table = " . $source . $prefix);
        $query = 'DROP TABLE ' . $source . $prefix;
        try {
            $GLOBALS["LOCAL_DB"]->query($query);
        } catch (MeekroDBException $ex) {
            exitAppOnError("Source: " . $_POST['source'] . " ------>ERROR: LOCAL DB Error: " . $ex->getMessage());
        }
    }
}

function exitAppOnError($general_log_message = "")
{
    $GLOBALS["final_reply"]['status'] = 'error';
    $GLOBALS['general-log']->error($general_log_message);
    echo json_encode($GLOBALS["final_reply"]);
    exit;
}
