<?php

ini_set('include_path', ini_get('include_path') . ';' . $_SERVER['DOCUMENT_ROOT'] . '/khalifaAPI/');
require_once 'libraries/khalifaAPI.php';

use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;



/////// ----------------------INITIALIZATION----------------------
// Clear log file
Reset_file_according_to_size(EXCELANALYZER_LOG_FILE, 30);
$GLOBALS["general-log"] = new MyLogPHP(EXCELANALYZER_LOG_FILE);
$GLOBALS["tmp_progress_file"] = "khalifatmpfiles/progress.txt";
$GLOBALS["all_data"] = array();
Write_progress(5);
$final_reply = array(
	"status" => "success",
	"data" => ""
);
$LOCAL_DB = new MeekroDB(EXCELANALYZER_DB_HOST, DB_USER, DB_PASSWORD, EXCELANALYZER_DB_NAME, NULL, 'utf8');
$LOCAL_DB->error_handler = false; // since we're catching errors, don't need error handler
$LOCAL_DB->throw_exception_on_error = true; //enable exceptions for the DB
$GLOBALS["general-log"]->info("");
// retrieve the csv file name
//$file_name = "uploads/" . $_POST["file_name"];


$file_name = 'uploads/ea_csv_190322-full.csv'; //encoding issue with fgetcsv
$file_name = 'uploads/20181025_bolsar.csv'; //works well with fgetcsv
$file_name = 'uploads/Euronext_Bonds_EU_2019-03-25.csv'; //works well with fgetcsv
$file_name = 'uploads/20190408-MAE drive sheet.csv'; //works well with fgetcsv
$file_name = 'uploads/20190408-Perspektiva drive sheet.csv'; //works well with fgetcsv
$file_name = 'uploads/brazil2019.txt'; //encoding issue with fgetcsv


//conclusion: USE Spout get csv or even excel and set encoding to UTF-16LE for ECB

$GLOBALS["general-log"]->info("File : " . $file_name);
//$source = strtolower($_POST["source"]);
$step1 = microtime(true);

// $file_name = "uploads/2019.txt";
// $source = "Brazil";

// //$GLOBALS["general-log"]->info("Update source - <strong>" . $_POST["source"] . "</strong> - started on " . @date("Y-m-d h:i:s"));
// echo "<pre>";
// $array1 = array([1, 1, 1, 1, 1], [2, 2, 2, 2, 2]);
// $array2 = array([1, 1, 1, 1, 1], [2, 2, 2, 2, 2], [3, 3, 3, 3, 3]);
// print_r($array1);
// print_r($array2);


// // Compare all values by a json_encode
// $diff = array_diff(array_map('json_encode', $array1), array_map('json_encode', $array2));

// // Json decode the result
// $diff = array_map('json_decode', $diff);


//$result = array_diff_assoc($array1, $array2);
// print_r($result);
// exit;
/////// ----------------------STEP 1 Reading the file----------------------
//$GLOBALS["general-log"]->info("Importing using PHPExcel");
// get data from csv file
// $GLOBALS["general-log"]->info("Import data using CSV START");
// $extracted_data_from_csv = Getfromcsvfast($file_name);
//var_dump($extracted_data_from_csv);
// $GLOBALS["general-log"]->info("Import data using CSV STOP");
// $GLOBALS["general-log"]->info("Import data using PHPExcel START");
//$extracted_data_from_csv = exportExcelCsvToArrayFaster($file_name);
// var_dump($extracted_data_from_csv);
// $GLOBALS["general-log"]->info("Import data using PHPExcel STOP");
// exit;
// //var_dump($extracted_data_from_csv);

// $GLOBALS["general-log"]->info("Fixing columns names");
// Write_progress(10);
//$GLOBALS["general-log"]->info(timeDiff($step1, microtime(true)));


$GLOBALS["general-log"]->info("Importing using Spout");
$step11 = microtime(true);
$extracted_data_from_csv = getExcelCSVFasterUsingSpout($file_name, 'csv');
$GLOBALS["general-log"]->info(timeDiff($step11, microtime(true)));

var_dump($extracted_data_from_csv);

// $GLOBALS["general-log"]->info("Importing using Getfromcsvfast");
// $step12 = microtime(true);
// $extracted_data_from_csv = Getfromcsvfast($file_name);
// $GLOBALS["general-log"]->info(timeDiff($step12, microtime(true)));

// var_dump($extracted_data_from_csv);


exit;

$step2 = microtime(true);
$GLOBALS["general-log"]->info("Fixing column names");
$all_data = Addarraycolumns($extracted_data_from_csv, $source);
//var_dump($all_data);
// Write_progress(15);
$GLOBALS["general-log"]->info(timeDiff($step2, microtime(true)));


function Getfromcsvfast($csv_filename)
{
	$all_data = array();
	$number_of_securities = count(file($csv_filename));
	$GLOBALS["general-log"]->info("-----Number of securities in the file :  " . $number_of_securities);
	Clear_tmp_progress_file();
	$link_to_uploaded_csv_file = fopen($csv_filename, "r");
	$i = 1;
	$csv_delimiter = getCSVDelimiter($csv_filename);
	while ($row_to_array = fgetcsv($link_to_uploaded_csv_file, 0, $csv_delimiter)) {
		for ($i = 0; $i < count($row_to_array); $i++) {
			$row_to_array[$i] = mb_convert_encoding($row_to_array[$i], "UTF-8", "UTF-16LE");
		}
		array_push($all_data, $row_to_array);
	}
	// while ($row_to_array = fgetcsv($link_to_uploaded_csv_file, 0, $csv_delimiter)) {
	// 	array_push($all_data, $row_to_array);
	// }


	fclose($link_to_uploaded_csv_file);
	return $all_data;
}

function convert($str)
{
	return iconv("UTF-16LE", "UTF-8", $str);
}

function Addarraycolumns($int_indexed_2Darray, $source)
{
	$new_2Darray_correct_columns = array();
	$source_details = Getsourcedetails($source);
	foreach ($int_indexed_2Darray as $one_security) {
		for ($i = 1; $i <= $source_details[0]['columns']; $i++) {
			$one_security_tmp['column' . $i] = $one_security[$i - 1];
		}
		array_push($new_2Darray_correct_columns, $one_security_tmp);
	}
	return $new_2Darray_correct_columns;
	// for ($x = 0; $x < count($int_indexed_array); $x++) {
	// 	$one_security_with_correct_columns['column' . $i] = $one_security_array[$i - 1];
	// }
	// foreach ($int_indexed_array as $one_security_array) {
	// 	$one_security_with_correct_columns = array();
	// 	for ($i = 1; $i <= $source_details[0]['columns']; $i++) {
	// 		$one_security_with_correct_columns['column' . $i] = $one_security_array[$i - 1];
	// 	}
	// 	array_push($GLOBALS["all_data"], $one_security_with_correct_columns);
	// }
}

function getExcelCSVFasterUsingSpout($file_name, $file_type, $encoding = 'UTF-8')
{
	$reader = NULL;
	//$reader = ReaderFactory::create(Type::ODS); // for ODS files
	if ($file_type === 'csv') {
		$reader = ReaderFactory::create(Type::CSV);
		$reader->setFieldDelimiter(getCSVDelimiter($file_name));
		$reader->setEncoding($encoding);
		//$reader->setEncoding('');
	} else {
		$reader = ReaderFactory::create(Type::XLSX);
	}
	$reader->open($file_name);
	$all_data = array();
	foreach ($reader->getSheetIterator() as $sheet) {
		foreach ($sheet->getRowIterator() as $row) {
			array_push($all_data, $row);
		}
	}
	$reader->close();
	return $all_data;
}


function exportExcelCsvToArrayFaster($file)
{
	$filetype = PHPExcel_IOFactory::identify($file);
	$GLOBALS["general-log"]->info("----->file type = " . $filetype);
	$objReader = PHPExcel_IOFactory::createReader($filetype);
	$objReader->setReadDataOnly(true);
	if ($filetype === 'CSV') {
		$encoding = mb_detect_encoding(file_get_contents($file), mb_detect_order(), true);
		$objReader->setInputEncoding($encoding);
		$objReader->setDelimiter(getCSVDelimiter($file));
	}
	$objPHPExcel = $objReader->load($file);
	$results = $objPHPExcel->getActiveSheet()->toArray('', true, false, false);
	$GLOBALS['general-log']->info("----->Total rows in the file : " . count($results));
	//fix columns names


	return $results;
}

/////// ----------------------STEP 2 Inserting in Today table----------------------
// inserting in Today table
$GLOBALS["general-log"]->info("Inserting in today table");
$step3 = microtime(true);
try {
	$GLOBALS["LOCAL_DB"]->query('truncate table ' . $source . '_today');
} catch (MeekroDBException $ex) {
	$GLOBALS["final_reply"]['status'] = 'error';
	$GLOBALS['general-log']->error("ERROR: LOCAL DB Error: " . $ex->getMessage());
	exit;
}
try {
	$GLOBALS["LOCAL_DB"]->insert($source . '_today', $all_data);
} catch (MeekroDBException $ex) {
	$GLOBALS["final_reply"]['status'] = 'error';
	$GLOBALS['general-log']->error("ERROR: LOCAL DB Error: " . $ex->getMessage());
	exit;
}
Write_progress(20); //was 20
$GLOBALS["general-log"]->info(timeDiff($step3, microtime(true)));

exit;


/////// ----------------------STEP 3 Checking the changes----------------------
// check for new data
$GLOBALS["general-log"]->info("Check for new data");
try {
	$query = buildQueryToCompareDataInTwoTables($source, 'today', 'live');
	$GLOBALS["general-log"]->info($query);
	$new_data = $GLOBALS["LOCAL_DB"]->query($query);
} catch (MeekroDBException $ex) {
	$GLOBALS["final_reply"]['status'] = 'error';
	$GLOBALS['general-log']->error("ERROR: LOCAL DB Error: " . $ex->getMessage());
	exit;
}
Write_progress(25);
// check for deleted data
$GLOBALS["general-log"]->info("Check for deleted data");
// prepare the variable columns field required in the query
// Ex: ecb_today.column1 as column1, ecb_today.......
try {
	$query = buildQueryToCompareDataInTwoTables($source, 'live', 'today');
	$GLOBALS["general-log"]->info($query);
	$deleted_data = $GLOBALS["LOCAL_DB"]->query($query);
} catch (MeekroDBException $ex) {
	$GLOBALS["final_reply"]['status'] = 'error';
	$GLOBALS['general-log']->error("ERROR: LOCAL DB Error: " . $ex->getMessage());
	exit;
}
Write_progress(30);




/////// ----------------------STEP 4 Adding the changes----------------------
// add new data in live table and update history table
// Get the highest column number to be used later for inserting the status in HISTORY table
$res = Call_script_inside_project_with_post('get_the_correct_columns_parameter_for_datatables.php', array(
	"source" => $source,
	"table_type" => 'live'
));
$highest_column_number = count(current(json_decode($res)));
if (!empty($new_data)) {
	// echo 'There is new data | ';
	// add to live table
	$GLOBALS["general-log"]->info('Total New data : ' . count($new_data));
	$GLOBALS["general-log"]->info("Inserting new data in live table");
	try {
		$GLOBALS["LOCAL_DB"]->insert($source . '_live', $new_data);
	} catch (MeekroDBException $ex) {
		$GLOBALS["final_reply"]['status'] = 'error';
		$GLOBALS['general-log']->error("ERROR: LOCAL DB Error: " . $ex->getMessage());
		exit;
	}
	Write_progress(40);
	//        $Euronext2018_db->insert("live", $new_data);
	// add to history table
	// add status column
	$GLOBALS["general-log"]->info("Inserting new data in history table");
	for ($i = 0; $i < count($new_data); $i++) {
		$new_data[$i]['column' . strval($highest_column_number + 1)] = "INSERTED";
	}
	try {
		$GLOBALS["LOCAL_DB"]->insert($source . '_history', $new_data);
	} catch (MeekroDBException $ex) {
		$GLOBALS["final_reply"]['status'] = 'error';
		$GLOBALS['general-log']->error("ERROR: LOCAL DB Error: " . $ex->getMessage());
		exit;
	}
	Write_progress(50);
	//        $Euronext2018_db->insert("history", $new_data);
} else {
	$GLOBALS["general-log"]->info('No new data ');
}
Write_progress(60);
// delete the deleted data from live and update history table
if (!empty($deleted_data)) {
	$GLOBALS["general-log"]->info('Total deleted data :  ' . count($deleted_data));
	$GLOBALS["general-log"]->info("Deleting from live table");
	foreach ($deleted_data as $one_deleted_data) {
		try {
			$query = 'DELETE FROM ' . $source . '_live ';
			// ON ecb_today.column1 <=> ecb_live.column1 AND  .......
			//building the WHERE part
			$columns = $GLOBALS["LOCAL_DB"]->columnList($source . '_live');
			for ($i = 0; $i < count($columns); $i++) {
				$columns[$i] = $source . '_live' . "." . $columns[$i] . " <=> '" . $one_deleted_data['column' . strval($i + 1)] . "'";
			}
			$where_part = 'WHERE ' . implode(' AND ', $columns);

			$query .= $where_part;
			$GLOBALS["general-log"]->info($query);
			$GLOBALS["LOCAL_DB"]->query($query);
			//$GLOBALS["LOCAL_DB"]->delete($source . '_live', "column1=%s", $one_deleted_data['column1']);

		} catch (MeekroDBException $ex) {
			$GLOBALS["final_reply"]['status'] = 'error';
			$GLOBALS['general-log']->error("ERROR: LOCAL DB Error: " . $ex->getMessage());
			exit;
		}
		//            $Euronext2018_db->delete("live", ["AND" => ["isin" => $one_deleted_data["isin"], "symbol" => $one_deleted_data["symbol"]]]);
	}
	Write_progress(70);
	// update history table for deleted data
	// add status column
	for ($i = 0; $i < count($deleted_data); $i++) {
		$deleted_data[$i]['column' . strval($highest_column_number + 1)] = "DELETED";
	}
	$GLOBALS["general-log"]->info("Deleting in the history table ");
	try {
		$GLOBALS["LOCAL_DB"]->insert($source . '_history', $deleted_data);
	} catch (MeekroDBException $ex) {
		$GLOBALS["final_reply"]['status'] = 'error';
		$GLOBALS['general-log']->error("ERROR: LOCAL DB Error: " . $ex->getMessage());
		exit;
	}
	Write_progress(85);
} else {
	$GLOBALS["general-log"]->info('No deleted data ');
}
Write_progress(90);
/////// ----------------------END----------------------
$GLOBALS["general-log"]->success("SUCCESS : Update source - " . $_POST["source"] . " -  finished on :  " . date("Y-m-d h:i:s"));
$GLOBALS["general-log"]->info();
Write_progress(100);
echo json_encode($final_reply);


$query = '
        SELECT ' . getAllColumnsForSelectQuery($source, 'today') . ' 
        FROM ' . $source . '_today
        LEFT JOIN ' . $source . '_live 
        ON ' . $source . '_today.column1 <=> ' . $source . '_live.column1 AND ' . $source . '_today.column2 <=> ' . $source . '_live.column2
        WHERE ' . $source . '_live.column1 IS NULL AND ' . $source . '_live.column2 IS NULL
    ';

/////// ----------------------FUNCTIONS----------------------

function buildQueryToCompareDataInTwoTables($source, $new_data_table, $old_data_table)
{
	$final_query = 'SELECT ';
	// SELECT perspektiva_live.column1 as column1, perspektiva_live.column2 as column2,.......
	$columns = $GLOBALS["LOCAL_DB"]->columnList($source . '_' . $new_data_table);
	for ($i = 0; $i < count($columns); $i++) {
		$columns[$i] = $source . '_' . $new_data_table . '.' . $columns[$i] . " as " . $columns[$i];
	}
	$select_part = implode(", ", $columns);
	$final_query .= $select_part . ' ';
	//FROM part
	$from_part = 'FROM ' . $source . '_' . $new_data_table;
	$final_query .= ' UNION ALL ';

	$columns = $GLOBALS["LOCAL_DB"]->columnList($source . '_' . $new_data_table);
	for ($i = 0; $i < count($columns); $i++) {
		$columns[$i] = $source . '_' . $old_data_table . '.' . $columns[$i] . " as " . $columns[$i];
	}
	$select_part = implode(", ", $columns);
	$final_query .= $select_part . ' ';




	$final_query .= $from_part . ' ';
	// ON ecb_today.column1 <=> ecb_live.column1 AND  .......
	$columns = $GLOBALS["LOCAL_DB"]->columnList($source . '_' . $new_data_table);
	for ($i = 0; $i < count($columns); $i++) {
		$columns[$i] = $source . '_' . $new_data_table . "." . $columns[$i] . " <=> " . $source . '_' . $old_data_table . "." . $columns[$i];
	}
	$on_part = 'ON ' . implode(' AND ', $columns);
	$final_query .= $on_part . ' ';
	//WHERE perspektiva_today.column1 IS NULL AND perspektiva_today.column2 IS NULL  
	$where_part = 'WHERE ' . $source . '_' . $old_data_table . ".column1 IS NULL";
	$final_query .= $where_part . ' ';
	return $final_query;
}


function buildQueryToCompareDataInTwoTablesUsingUNION($source, $new_data_table, $old_data_table)
{
	$final_query = 'SELECT ';
	$columns_new_table = $GLOBALS["LOCAL_DB"]->columnList($source . '_' . $new_data_table);
	$select_part = implode(", ", $columns_new_table);
	$final_query .= $select_part . ' ,status';
	$final_query .= ' FROM';
	$final_query .= ' ( ';
	$final_query .= ' SELECT ';
	for ($i = 0; $i < count($columns_new_table); $i++) {
		$columns_new_table[$i] = $source . '_' . $new_data_table . '.' . $columns_new_table[$i];
	}
	$new_table_columns = implode(", ", $columns_new_table);
	$final_query .= $new_table_columns . ',  "' . 'DELETED' . '" as "status"';
	$final_query .= ' FROM ' . $source . '_' . $new_data_table;

	$final_query .= ' UNION ALL ';

	$final_query .= ' SELECT ';
	$columns_old_table = $GLOBALS["LOCAL_DB"]->columnList($source . '_' . $old_data_table);
	for ($i = 0; $i < count($columns_old_table); $i++) {
		$columns_old_table[$i] = $source . '_' . $old_data_table . '.' . $columns_old_table[$i];
	}
	$old_table_columns = implode(", ", $columns_old_table);
	$final_query .= $old_table_columns . ',  "' . 'INSERTED' . '" as "status"';
	$final_query .= ' FROM ' . $source . '_' . $old_data_table;

	$final_query .= ' ) tmp_table ';
	$final_query .= ' GROUP BY ';
	$final_query .= $select_part;
	$final_query .= ' HAVING COUNT(*) = 1 ';

	return $final_query;
}



function getAllColumnsForSelectQuery($source, $table)
{
	// function used to produce this "ecb_today.column1 as column1"
	$columns = $GLOBALS["LOCAL_DB"]->columnList($source . '_' . $table);
	for ($i = 0; $i < count($columns); $i++) {
		$columns[$i] = $source . "_" . $table . "." . $columns[$i] . " as " . $columns[$i];
	}
	$selected_columns_string = implode(", ", $columns);
	return $selected_columns_string;
}

function Getsourcedetails($source)
{
	// get the number of columns
	try {
		$source_details = $GLOBALS["LOCAL_DB"]->query('SELECT * FROM existing_sources WHERE text = %s', $source);
	} catch (MeekroDBException $ex) {
		$GLOBALS["final_reply"]['status'] = 'error';
		$GLOBALS['general-log']->error("ERROR: LOCAL DB Error: " . $ex->getMessage());
		exit;
	}
	return $source_details;
}
function exportExcelCsvToArray($file)
{
	$filetype = PHPExcel_IOFactory::identify($file);
	$GLOBALS["general-log"]->info("file type = " . $filetype);
	$objReader = PHPExcel_IOFactory::createReader($filetype);
	$objReader->setReadDataOnly(true);
	if ($filetype === 'CSV') {
		$encoding = mb_detect_encoding(file_get_contents($file), mb_detect_order(), true);
		$objReader->setInputEncoding($encoding);
		$objReader->setDelimiter(getCSVDelimiter($file));
	}
	$objPHPExcel = $objReader->load($file);
	$results = $objPHPExcel->getActiveSheet()->toArray('', true, false, false);
	$GLOBALS['general-log']->info("Total rows in the file : " . count($results));
	//fix columns names


	return $results;
}
// Detect CSV delimiter function
function getCSVDelimiter($csvFile)
{
	$GLOBALS['general-log']->info("----->Detecting CSV delimiter");
	$delimiters = array(
		';' => 0,
		',' => 0,
		"\t" => 0,
		"|" => 0
	);
	$handle = fopen($csvFile, "r");
	$firstLine = fgets($handle);
	fclose($handle);
	foreach ($delimiters as $delimiter => &$count) {
		$count = count(str_getcsv($firstLine, $delimiter));
		//$GLOBALS['general-log']->info($count . " columns with delimiter = " . $delimiter);
	}
	$chosen_delimiter = array_search(max($delimiters), $delimiters);
	$GLOBALS['general-log']->info("----->correct delimiter : " . $chosen_delimiter);
	return $chosen_delimiter;
}
function Clear_tmp_progress_file()
{
	$tmp_progress_file = $GLOBALS["tmp_progress_file"];
	$myfile = fopen($tmp_progress_file, "w");
	if ($myfile == false) {
		$GLOBALS["general-log"]->info("Could not clear tmp progress file");
	} else {
		// $GLOBALS["general-log"]->info("Progress file cleared");
	}
}
function Write_progress($progress)
{
	sleep(2);
	$tmp_progress_file = $GLOBALS["tmp_progress_file"];
	$myfile = fopen($tmp_progress_file, "w");
	if ($myfile == false) {
		$GLOBALS["general-log"]->info("ERROR in opening progress file");
	} else {
		fwrite($myfile, $progress);
		fclose($myfile);
	}
}
// old function not used now
