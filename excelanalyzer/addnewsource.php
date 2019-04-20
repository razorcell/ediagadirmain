<?php
ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . $_SERVER['DOCUMENT_ROOT'] . '/khalifaAPI/');
include_once 'libraries/khalifaAPI.php';

/////// ----------------------INITIALIZATION 1 ----------------------

$GLOBALS["general-log"] = new MyLogPHP(EXCELANALYZER_LOG_FILE);
$GLOBALS["final_reply"] = array("status" => "success");

/////// ----------------------Main checks----------------------

if (!isset($_POST["admin_password"]) or $_POST["admin_password"] !== 'Edmk1123581321') {
    exitAppOnError("'Admin Password' incorrect");
}
if (!isset($_POST["source_name"]) or !preg_match('/^[a-zA-Z][a-zA-Z1-9]{1,25}$/', $_POST["source_name"])) {
    exitAppOnError("'Name' field not valid. Should be between (1-26 characters / digits)");
} else {
    $source_name = $_POST["source_name"];
}
//at least 1,2
if (!isset($_POST["columns"]) or !preg_match('/^[1-9]{1,2},([1-9]{1,2},)*[1-9]{1,2}$/', $_POST["columns"])) {
    exitAppOnError("'Columns' field should be comma seperated digits Ex: (1,2,3,6,7)");
} else {
    $columns_string = $_POST["columns"];
}
if (isset($_POST["ignored_rows"])) {
    //1 or 1,2,3
    if (!preg_match('/^[1-9]{1,2}(,([1-9]{1,2},)*[1-9]{1,2})?$/', $_POST["ignored_rows"])) {
        exitAppOnError("'Ignored rows' field not valid. Should be comma seperated digits Ex: (1,2,3,6,7)");
    } else {
        $ignored_rows = $_POST["ignored_rows"];
    }
} else {
    $ignored_rows = 'none';
}
if (!isset($_POST["database_password"]) or !preg_match('/^.{1,100}$/', $_POST["database_password"])) {
    exitAppOnError("'Database password' not valid. (any char) 1 - 100");
} else {
    $database_password = $_POST["database_password"];
}
if (!isset($_POST["file_encoding"]) or !isEncodingStringValid($_POST["file_encoding"])) {
    exitAppOnError("Please select a valid encoding");
} else {
    $file_encoding = $_POST["file_encoding"];
}


/////// ----------------------INITIALIZATION 2 ----------------------

//Local smart_calendar DB connection
$GLOBALS["LOCAL_DB"] = new MeekroDB(EXCELANALYZER_DB_HOST, DB_USER, DB_PASSWORD, EXCELANALYZER_DB_NAME, NULL, 'utf8');
$GLOBALS["LOCAL_DB"]->error_handler = false; // since we're catching errors, don't need error handler
$GLOBALS["LOCAL_DB"]->throw_exception_on_error = true; //enable exceptions for the DB

$GLOBALS["general-log"]->info("Add new source  - <strong> $source_name </strong> - script started");
$GLOBALS["general-log"]->info("Monitor columns = " . $columns_string);
$GLOBALS["general-log"]->info("Ignore rows = " . $ignored_rows);
$GLOBALS["general-log"]->info("File encoding = " . $file_encoding);

/////// ----------------------Add to existing_sources table ----------------------

try {
    $GLOBALS["LOCAL_DB"]->insert('existing_sources', array(
        'text' => $source_name,
        'columns' => $columns_string,
        'ignorerows' => $ignored_rows,
        'logfile' => 'log/' . $source_name . '-logs.csv',
        'encoding' => $file_encoding,
    ));
} catch (MeekroDBException $ex) {
    exitAppOnError("ERROR: LOCAL DB Error: " . $ex->getMessage());
    exit;
}
$GLOBALS["general-log"]->warning('Entry added in existing_tables');

/////// ----------------------Add today, live and history tables ----------------------

Create_table('today', $source_name, $columns_string);
Create_table('live', $source_name, $columns_string);
Create_table('history', $source_name, $columns_string);

/////// ----------------------END ----------------------

$GLOBALS["general-log"]->success("SUCCESS : Add new source  - <strong> $source_name </strong> - script Finished");
echo json_encode($GLOBALS["final_reply"]);

/////// ----------------------Functions ----------------------

function Create_table($type, $name, $columns_string)
{
    sleep(1);
    $GLOBALS["general-log"]->info('Create table: type = ' . $type . ' | name = ' . $name);
    $number_columns = count(array_filter(explode(',', $columns_string)));
    //Creating Today's table
    $query_header = 'CREATE TABLE ' . $name . '_' . $type . ' (';
    $query_body = '';
    //$x = 1;
    for ($i = 1; $i <= $number_columns; $i++) {
        $query_body .= 'column' . $i . ' TEXT NULL COLLATE utf8mb4_unicode_ci,';
        //$x = $i;
    }
    if ($type === 'history') {
        $query_body .= 'column' . ($number_columns + 1) . ' ENUM(\'INSERTED\',\'UPDATED\',\'DELETED\') NOT NULL DEFAULT \'INSERTED\' COLLATE utf8mb4_general_ci,';
        $query_body .= 'column' . ($number_columns + 2) . ' TEXT NULL COLLATE utf8mb4_unicode_ci,';
        $query_body .= ' column' . ($number_columns + 3) . ' DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,';
    }
    // $query_body .= 'PRIMARY KEY(';
    // for($i=1; $i <= $columns; $i++){
    //     $query_body .= 'column'.$i.',';  
    // } 
    // $query_body .= ')'; 
    $query_body .= ')';
    $query_footer = ' COLLATE=utf8mb4_unicode_ci;';
    $final_query = str_replace(",)", ")", $query_header . $query_body . $query_footer);
    // $GLOBALS["general-log"]->info('Built query to run :');
    // $GLOBALS["general-log"]->info($final_query);
    try {
        $GLOBALS["LOCAL_DB"]->query($final_query);
    } catch (MeekroDBException $ex) {
        $GLOBALS["final_reply"]['status'] = 'error';
        $GLOBALS['general-log']->error("ERROR: LOCAL DB Error: " . $ex->getMessage());
        return false;
    }
    $GLOBALS["general-log"]->warning('SUCCESS: Table created ');
    return true;
}
function exitAppOnError($general_log_message = "")
{
    $GLOBALS["final_reply"]['status'] = 'error';
    $GLOBALS['general-log']->error($general_log_message);
    echo json_encode($GLOBALS["final_reply"]);
    exit;
}
function isEncodingStringValid($encoding_string)
{
    $all_encodingd = array(
        "UCS-4",
        "UCS-4BE",
        "UCS-4LE",
        "UCS-2",
        "UCS-2BE",
        "UCS-2LE",
        "UTF-32",
        "UTF-32BE",
        "UTF-32LE",
        "UTF-16",
        "UTF-16BE",
        "UTF-16LE",
        "UTF-7",
        "UTF7-IMAP",
        "UTF-8",
        "ASCII",
        "EUC-JP",
        "SJIS",
        "eucJP-win",
        "SJIS-win",
        "ISO-2022-JP",
        "ISO-2022-JP-MS",
        "CP932",
        "CP51932",
        "SJIS-mac",
        "SJIS-Mobile#DOCOMO",
        "SJIS-Mobile#KDDI",
        "SJIS-Mobile#SOFTBANK",
        "UTF-8-Mobile#DOCOMO",
        "UTF-8-Mobile#KDDI-A",
        "UTF-8-Mobile#KDDI-B",
        "UTF-8-Mobile#SOFTBANK",
        "ISO-2022-JP-MOBILE#KDDI",
        "JIS",
        "JIS-ms",
        "CP50220",
        "CP50220raw",
        "CP50221",
        "CP50222",
        "ISO-8859-1",
        "ISO-8859-2",
        "ISO-8859-3",
        "ISO-8859-4",
        "ISO-8859-5",
        "ISO-8859-6",
        "ISO-8859-7",
        "ISO-8859-8",
        "ISO-8859-9",
        "ISO-8859-10",
        "ISO-8859-13",
        "ISO-8859-14",
        "ISO-8859-15",
        "ISO-8859-16",
        "byte2be",
        "byte2le",
        "byte4be",
        "byte4le",
        "BASE64",
        "HTML-ENTITIES",
        "7bit",
        "8bit",
        "EUC-CN",
        "CP936",
        "GB18030",
        "HZ",
        "EUC-TW",
        "CP950",
        "BIG-5",
        "EUC-KR",
        "UHC",
        "ISO-2022-KR",
        "Windows-1251",
        "Windows-1252",
        "CP866",
        "KOI8-R",
        "KOI8-U",
        "ArmSCII-8"
    );
    return in_array($encoding_string, $all_encodingd) ? true : false;
}
