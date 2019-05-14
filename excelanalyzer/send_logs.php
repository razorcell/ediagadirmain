<?php

ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . $_SERVER['DOCUMENT_ROOT'] . '/khalifaAPI/');
include_once 'libraries/khalifaAPI.php';

/////// ----------------------INIT----------------------
$LOCAL_DB = new MeekroDB(EXCELANALYZER_DB_HOST, EXCELANALYZER_DB_USER, EXCELANALYZER_DB_PASSWORD, EXCELANALYZER_DB_NAME, NULL, 'utf8');
$LOCAL_DB->error_handler = false; // since we're catching errors, don't need error handler
$LOCAL_DB->throw_exception_on_error = true; //enable exceptions for the DB

$GLOBALS["general-log"] = new MyLogPHP(EXCELANALYZER_LOG_FILE);
$response = array("general_logs" => "", "source_specific_logs" => "");

/////// ----------------------Get General logs ----------------------

if (empty(EXCELANALYZER_LOG_FILE)) {
    $GLOBALS['general-log']->error('General log file unknown' . ' | script= ' . __FILE__);
} else {
    $response["general_logs"] = ReadFromEndByLine(EXCELANALYZER_LOG_FILE, 32);
}

/////// ----------------------Get source specific logs ----------------------
//get the source
if (isset($_POST['source']) and !empty($_POST['source'])) {
    $source = $_POST['source'];
    //get log file name from DB for this source
    try {
        $source_details = $GLOBALS["LOCAL_DB"]->query(
            'SELECT logfile FROM existing_sources WHERE text=%s_source',
            array('source' => $source)
        );
    } catch (MeekroDBException $ex) {
        $GLOBALS["final_reply"]['status'] = 'error';
        $GLOBALS['general-log']->error("---->ERROR: LOCAL DB Error: " . $ex->getMessage() . ' | script= ' . __FILE__);
        echo json_encode($response);
        exit;
    }
    if (empty($source_details) and empty($source_details[0]['logfile'])) {
        // $GLOBALS['general-log']->error('Source specific log file unknown');
        $response["source_specific_logs"] = "";
    } else {
        $response["source_specific_logs"] = ReadFromEndByLine($source_details[0]['logfile'], 32);
    }
}

/////// ----------------------END ----------------------

echo json_encode($response);

function ReadFromEndByLine($filename, $lines)
{
    $file = new SplFileObject($filename, 'a+');
    $file->seek(PHP_INT_MAX);
    $last_line = $file->key();
    $file->rewind();
    $first_line = $file->key();


    if (filesize($filename) == 0) {
        return "Log file empty";
    } else {
        while (($last_line - $lines) < 0) {
            $lines--;
        }
        $lines = new LimitIterator($file, $last_line - $lines, $last_line);
        $full_string = "";
        foreach (iterator_to_array($lines) as $line) {
            $full_string = str_replace('"', '', $full_string . $line);
            //     }
        }
        return $full_string;
    }
}
