<?php // You need to add server side validation and better error handling here
ini_set('upload-max-filesize', '400M');
ini_set('post_max_size', '400M');
ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . $_SERVER['DOCUMENT_ROOT'] . '/khalifaAPI/');
include_once 'libraries/khalifaAPI.php';



$LOCAL_DB = new MeekroDB(EXCELANALYZER_DB_HOST, EXCELANALYZER_DB_USER, EXCELANALYZER_DB_PASSWORD, EXCELANALYZER_DB_NAME, NULL, 'utf8');
$LOCAL_DB->error_handler = false; // since we're catching errors, don't need error handler
$LOCAL_DB->throw_exception_on_error = true; //enable exceptions for the DB


$GLOBALS['general-log'] = new MyLogPHP(EXCELANALYZER_LOG_FILE);
$GLOBALS["final_reply"] = array(
	"status" => "success",
	"data" => ""
);

sleep(1.5);

/////// ----------------------Main checks----------------------

if (count($_FILES) < 1 or !isset($_POST["source"])) {
	$GLOBALS['general-log']->error('---->ERROR: source or files not set | script= ' . __FILE__);
	$GLOBALS["final_reply"]['status'] = 'error';
	echo json_encode($GLOBALS["final_reply"]);
	exit;
}

/////// ----------------------INITIALIZATION----------------------

$GLOBALS['source_specific_log'] = new MyLogPHP(getLogFilePathFromSource($_POST["source"]));



// $files = array();
$uploaddir = './uploads/';
foreach ($_FILES as $file) {
	if (move_uploaded_file($file['tmp_name'], $uploaddir . basename($file['name']))) {
		// $files[] = $uploaddir . $file['name'];
		$GLOBALS['source_specific_log']->success('SUCCESS: File Uploaded : ' . $file['name']);
		// $log->success('SUCCESS: File Uploaded : ' . $file['name']);
	} else {
		$GLOBALS['source_specific_log']->error("Source: " . $_POST['source'] . "---->ERROR: Uploading with code: " . $file["error"] . " | script= " . __FILE__);
		$GLOBALS["final_reply"]['status'] = 'error';
		echo json_encode($GLOBALS["final_reply"]);
		exit;
	}
}

echo json_encode($GLOBALS["final_reply"]);

function getLogFilePathFromSource($source)
{
	//get log file name from DB for this source
	try {
		$source_details = $GLOBALS["LOCAL_DB"]->query(
			'SELECT logfile FROM existing_sources WHERE text=%s_source',
			array('source' => $source)
		);
	} catch (MeekroDBException $ex) {
		$GLOBALS["final_reply"]['status'] = 'error';
		$GLOBALS['general-log']->error("Source: " . $_POST['source'] . " ---->ERROR: LOCAL DB Error: " . $ex->getMessage() . ' | script= ' . __FILE__);
		echo json_encode($GLOBALS["final_reply"]);
		exit;
	}

	$source_specific_logfile_path = $source_details[0]['logfile'];
	if (empty($source_specific_logfile_path)) {
		$GLOBALS['general-log']->error('Source specific log file not found');
		$GLOBALS["final_reply"]['status'] = 'error';
		echo json_encode($GLOBALS["final_reply"]);
		exit;
	}

	return $source_specific_logfile_path;
}
