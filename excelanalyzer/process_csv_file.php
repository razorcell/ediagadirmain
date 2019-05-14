<?php

ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . $_SERVER['DOCUMENT_ROOT'] . '/khalifaAPI/');
require_once 'libraries/khalifaAPI.php';

use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;

$GLOBALS["tmp_progress_file"] = "khalifatmpfiles/progress.txt";
Write_progress(0);

$GLOBALS["general-log"] = new MyLogPHP(EXCELANALYZER_LOG_FILE);

$GLOBALS["final_reply"] = array(
	"status" => "success",
	"data" => ""
);

/////// ----------------------Main checks----------------------

if (!isset($_POST["file_name"]) or !isset($_POST["source"])) {
	$GLOBALS['general-log']->error('---->ERROR: source or filename not set | script= ' . __FILE__);
	$GLOBALS["final_reply"]['status'] = 'error';
	echo json_encode($GLOBALS["final_reply"]);
	exit;
}

/////// ----------------------INITIALIZATION----------------------
// Clear log file
gc_enable();
gc_collect_cycles();
Reset_file_according_to_size(EXCELANALYZER_LOG_FILE, 30);


$LOCAL_DB = new MeekroDB(EXCELANALYZER_DB_HOST, DB_USER, DB_PASSWORD, EXCELANALYZER_DB_NAME, NULL, 'utf8');
$LOCAL_DB->error_handler = false; // since we're catching errors, don't need error handler
$LOCAL_DB->throw_exception_on_error = true; //enable exceptions for the DB


// retrieve the csv file name
$file_name = "uploads/" . $_POST["file_name"];
$source = $_POST["source"];

$GLOBALS["source_specific_log"] = new MyLogPHP(getLogFilePathFromSource($source));

$GLOBALS["all_data"] = array();

$GLOBALS["source_specific_log"]->info("");
$GLOBALS["source_specific_log"]->info("Updating the source - <strong>" . $source . "</strong> - started on " . @date("Y-m-d h:i:s"));

/////// ----------------------STEP 1 Reading the file----------------------

//Get encoding from DB
try {
	$encoding = $GLOBALS["LOCAL_DB"]->query('SELECT encoding FROM existing_sources WHERE text = %s', $source)[0];
} catch (MeekroDBException $ex) {
	$GLOBALS["final_reply"]['status'] = 'error';
	$GLOBALS["source_specific_log"]->error("Source: " . $_POST['source'] . " ------>ERROR: LOCAL DB Error: " . $ex->getMessage());
	echo json_encode($GLOBALS["final_reply"]);
	exit;
}
$GLOBALS["source_specific_log"]->warning("Encoding switched to : " . $encoding['encoding']);

try {
	$GLOBALS["LOCAL_DB"]->query('truncate table ' . $source . '_today');
} catch (MeekroDBException $ex) {
	$GLOBALS["final_reply"]['status'] = 'error';
	$GLOBALS["source_specific_log"]->error("Source: " . $_POST['source'] . " ---->ERROR: LOCAL DB Error: " . $ex->getMessage());
	echo json_encode($GLOBALS["final_reply"]);
	exit;
}


$step1 = microtime(true);
$GLOBALS["source_specific_log"]->info('-->Reading CSV file');

$extracted_data_from_csv = getExcelCSVFasterUsingSpout($file_name, 'csv', $encoding['encoding']);

// if ($source === 'ecb') {
// 	$GLOBALS["source_specific_log"]->warning('---->Encoding switched to UTF-16LE');
// 	$extracted_data_from_csv = getExcelCSVFasterUsingSpout($file_name, 'csv', 'UTF-16LE');
// } elseif ($source === 'brazilbonds') {
// 	$GLOBALS["source_specific_log"]->warning('---->Encoding switched to ISO-8859-2');
// 	$extracted_data_from_csv = getExcelCSVFasterUsingSpout($file_name, 'csv', 'ISO-8859-2');
// } else {
// 	$extracted_data_from_csv = getExcelCSVFasterUsingSpout($file_name, 'csv');
// }
$GLOBALS["source_specific_log"]->info('-->' . timeDiff($step1, microtime(true)));
/////// ----------------------STEP 1 Cleanup the data(Remove unnecessary columns and correct indexes)----------------------
$step12 = microtime(true);
$GLOBALS["source_specific_log"]->info('-->Data CleanUp');
$all_data_with_correct_columns = arrayCleanUp($extracted_data_from_csv, $source);
Write_progress(25); //was 20
$GLOBALS["source_specific_log"]->info('-->' . timeDiff($step12, microtime(true)));

/////// ----------------------STEP 2 Inserting in Today table----------------------

$step2 = microtime(true);
$GLOBALS["source_specific_log"]->info('-->Inserting Today\'s data');
//clear table first
try {
	$GLOBALS["LOCAL_DB"]->query('truncate table ' . $source . '_today');
} catch (MeekroDBException $ex) {
	$GLOBALS["final_reply"]['status'] = 'error';
	$GLOBALS["source_specific_log"]->error("Source: " . $_POST['source'] . " ---->ERROR: LOCAL DB Error: " . $ex->getMessage());
	echo json_encode($GLOBALS["final_reply"]);
	exit;
}
//add today data

//this is sloer but may decrease RAM consumption compared to giving all array directly
try {
	$GLOBALS["LOCAL_DB"]->insert($source . '_today', $all_data_with_correct_columns);
} catch (MeekroDBException $ex) {
	$GLOBALS["final_reply"]['status'] = 'error';
	$GLOBALS["source_specific_log"]->error("Source: " . $_POST['source'] . " ---->ERROR: LOCAL DB Error: " . $ex->getMessage());
	echo json_encode($GLOBALS["final_reply"]);
	exit;
}


// foreach ($all_data_with_correct_columns as $one_row) { //this is slower but may decrease RAM consumption compared to giving all array directly
// 	try {
// 		$GLOBALS["LOCAL_DB"]->insert($source . '_today', $one_row);
// 	} catch (MeekroDBException $ex) {
// 		$GLOBALS["final_reply"]['status'] = 'error';
// 		$GLOBALS["source_specific_log"]->error("Source: " . $_POST['source'] . " ---->ERROR: LOCAL DB Error: " . $ex->getMessage());
// 		echo json_encode($GLOBALS["final_reply"]);
// 		exit;
// 	}
// }

Write_progress(50); //was 20
$GLOBALS["source_specific_log"]->info('-->' . timeDiff($step2, microtime(true)));

/////// ----------------------STEP 3 Check for updates----------------------

$step3 = microtime(true);
// check for updates
$GLOBALS["source_specific_log"]->info('-->Check for updates');
try {
	$query = buildQueryToCompareDataInTwoTablesUsingUNION($source, 'live', 'today', $_POST["file_name"]);
	//$GLOBALS["source_specific_log"]->info($query);
	$updates = $GLOBALS["LOCAL_DB"]->query($query);
} catch (MeekroDBException $ex) {
	$GLOBALS["final_reply"]['status'] = 'error';
	$GLOBALS["source_specific_log"]->error("Source: " . $_POST['source'] . " ---->ERROR: LOCAL DB Error: " . $ex->getMessage());
	echo json_encode($GLOBALS["final_reply"]);
	exit;
}
$GLOBALS["source_specific_log"]->info('---->Updates found = ' . count($updates));
$GLOBALS["source_specific_log"]->info('-->' . timeDiff($step3, microtime(true)));
Write_progress(75); //was 20
/////// ----------------------STEP 4 Update the Database----------------------

if (count($updates) > 0) {
	$step4 = microtime(true);
	$GLOBALS["source_specific_log"]->info('-->Update the Database');
	$highest_column_number = count($GLOBALS["LOCAL_DB"]->columnList($source . '_live'));

	//Inserting the updates in the history table
	try {
		$GLOBALS["LOCAL_DB"]->insert($source . '_history', $updates);
	} catch (MeekroDBException $ex) {
		$GLOBALS["final_reply"]['status'] = 'error';
		$GLOBALS["source_specific_log"]->error("Source: " . $_POST['source'] . " ---->ERROR: LOCAL DB Error: " . $ex->getMessage());
		echo json_encode($GLOBALS["final_reply"]);
		exit;
	}

	//splitting results
	$new_data = array();
	$deleted_data = array();
	foreach ($updates as $row) {
		end($row);
		if (prev($row) === 'INSERTED') {
			array_pop($row);
			array_pop($row);
			array_push($new_data, $row);
		} else {
			array_pop($row);
			array_pop($row);
			array_push($deleted_data, $row);
		}
	}
	// Add to live
	if (!empty($new_data)) {
		$GLOBALS["source_specific_log"]->info('----><strong>Total New data : ' . count($new_data) . '</strong>');
		$GLOBALS["source_specific_log"]->info("---->Inserting new data in live table");
		try {
			$GLOBALS["LOCAL_DB"]->insert($source . '_live', $new_data);
		} catch (MeekroDBException $ex) {
			$GLOBALS["final_reply"]['status'] = 'error';
			$GLOBALS["source_specific_log"]->error("Source: " . $_POST['source'] . " ------>ERROR: LOCAL DB Error: " . $ex->getMessage());
			echo json_encode($GLOBALS["final_reply"]);
			exit;
		}
	} else {
		$GLOBALS["source_specific_log"]->info('---->New data = ' . count($new_data));
	}
	// Delete from live
	if (!empty($deleted_data)) {
		$GLOBALS["source_specific_log"]->info('----><strong>Total deleted data :  ' . count($deleted_data) . '</strong>');
		$GLOBALS["source_specific_log"]->info('---->Deleting from live table');
		foreach ($deleted_data as $one_deleted_data) {
			try {
				$query = 'DELETE FROM ' . $source . '_live ';
				// ON ecb_today.column1 <=> ecb_live.column1 AND  .......
				//building the WHERE part
				$columns = $GLOBALS["LOCAL_DB"]->columnList($source . '_live');
				for ($i = 0; $i < count($columns); $i++) {
					$columns[$i] = $source . '_live' . "." . $columns[$i] . " <=> '" . addslashes($one_deleted_data['column' . strval($i + 1)]) . "'";
				}
				$where_part = 'WHERE ' . implode(' AND ', $columns);
				$query .= $where_part;
				$GLOBALS["LOCAL_DB"]->query($query);
				//$GLOBALS["LOCAL_DB"]->delete($source . '_live', "column1=%s", $one_deleted_data['column1']);

			} catch (MeekroDBException $ex) {
				$GLOBALS["final_reply"]['status'] = 'error';
				$GLOBALS["source_specific_log"]->error('------>ERROR: LOCAL DB Error: ' . $ex->getMessage());
				echo json_encode($GLOBALS["final_reply"]);
				exit;
			}
			//            $Euronext2018_db->delete("live", ["AND" => ["isin" => $one_deleted_data["isin"], "symbol" => $one_deleted_data["symbol"]]]);
		}
	} else {
		$GLOBALS["source_specific_log"]->info('---->Deleted data = ' . count($deleted_data));
	}
	$GLOBALS["source_specific_log"]->info('-->' . timeDiff($step4, microtime(true)));
} else {
	$GLOBALS["source_specific_log"]->warning('<strong>No updates</strong>');
}


Write_progress(100); //was 20
/////// ----------------------END----------------------
gc_collect_cycles();
$GLOBALS["source_specific_log"]->success("SUCCESS : Update source - " . $_POST["source"] . " -  finished on :  " . date("Y-m-d h:i:s"));
$GLOBALS["source_specific_log"]->info();
echo json_encode($GLOBALS["final_reply"]);


/////// ----------------------FUNCTIONS----------------------


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

function Getfromcsvfast($csv_filename)
{
	$all_data = array();
	$number_of_securities = count(file($csv_filename));
	$GLOBALS["source_specific_log"]->info("-----Number of securities in the file :  " . $number_of_securities);
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

function arrayCleanUp($int_indexed_2Darray, $source)
{
	$new_2Darray_correct_columns = array();
	$source_details = Getsourcedetails($source);
	$required_columns_indexes = explode(',', $source_details[0]['columns']);
	if ($source_details[0]['ignorerows'] !== 'none') {
		$ignored_rows_indexes = explode(',', $source_details[0]['ignorerows']);
	}

	$line = 0;
	foreach ($int_indexed_2Darray as $one_security) {
		if (count($one_security) < count($required_columns_indexes)) {
			//validation for empty rows or incomplete rows
			$GLOBALS["source_specific_log"]->warning('---->Empty row found in the file at line = ' . $line);
			$line++;
			continue;
		}
		//Euronext skip first 4 rows
		// if (($source === 'euronextbonds') and $line < 4) {
		// 	$GLOBALS["source_specific_log"]->warning('---->Ignored row N: ' . $line . ' => ' . $one_security[0] . ' | ' . $one_security[1]);
		// 	$line++;
		// 	continue;
		// }
		if (isset($ignored_rows_indexes) and in_array(strval($line + 1), $ignored_rows_indexes)) {
			$GLOBALS["source_specific_log"]->warning('---->Ignored row N: ' . $line . ' (content) => ' . $one_security[0]);
			$line++;
			continue;
		}

		$i = 1;
		foreach ($required_columns_indexes as $required_index) {
			$filters = array('/(^")/', '/("$)/');
			$one_security_tmp["column$i"] = preg_replace($filters, '', $one_security[intval($required_index) - 1]);
			$i++;
		}
		array_push($new_2Darray_correct_columns, $one_security_tmp);
		$line++;
	}
	return $new_2Darray_correct_columns;
}

function getExcelCSVFasterUsingSpout($file_name, $file_type, $encoding = 'UTF-8')
{
	$reader = NULL;
	//$reader = ReaderFactory::create(Type::ODS); // for ODS files
	if ($file_type === 'csv') {
		$reader = ReaderFactory::create(Type::CSV);
		$reader->setFieldDelimiter(getCSVDelimiter($file_name));
		$reader->setEncoding($encoding);
	} else {
		$reader = ReaderFactory::create(Type::XLSX);
	}
	try {
		$reader->open($file_name);
		$all_data = array();
		foreach ($reader->getSheetIterator() as $sheet) {
			foreach ($sheet->getRowIterator() as $row) {
				array_push($all_data, $row);
			}
		}
		$reader->close();
		return $all_data;
	} catch (Exception $ex) {
		$GLOBALS["source_specific_log"]->error('------>Error Reading file : ' . $ex->getMessage());
	}
}


function exportExcelCsvToArrayFaster($file)
{
	$filetype = PHPExcel_IOFactory::identify($file);
	$GLOBALS["source_specific_log"]->info("----->file type = " . $filetype);
	$objReader = PHPExcel_IOFactory::createReader($filetype);
	$objReader->setReadDataOnly(true);
	if ($filetype === 'CSV') {
		$encoding = mb_detect_encoding(file_get_contents($file), mb_detect_order(), true);
		$objReader->setInputEncoding($encoding);
		$objReader->setDelimiter(getCSVDelimiter($file));
	}
	$objPHPExcel = $objReader->load($file);
	$results = $objPHPExcel->getActiveSheet()->toArray('', true, false, false);
	$GLOBALS['source_specific_log']->info("----->Total rows in the file : " . count($results));
	//fix columns names


	return $results;
}


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


function buildQueryToCompareDataInTwoTablesUsingUNION($source, $new_data_table, $old_data_table, $file_name)
{
	//Get columns list
	$columns = $GLOBALS["LOCAL_DB"]->columnList($source . '_' . $new_data_table);
	$status_column = 'column' . (count($columns) + 1);
	$file_name_column = 'column' . (count($columns) + 2);
	$final_query = 'SELECT ';
	$columns_new_table = $GLOBALS["LOCAL_DB"]->columnList($source . '_' . $new_data_table);
	$select_part = implode(", ", $columns_new_table);
	$final_query .= $select_part . ' ,' . $status_column . ',' . $file_name_column;
	$final_query .= ' FROM';
	$final_query .= ' ( ';
	$final_query .= ' SELECT ';
	for ($i = 0; $i < count($columns_new_table); $i++) {
		$columns_new_table[$i] = $source . '_' . $new_data_table . '.' . $columns_new_table[$i];
	}
	$new_table_columns = implode(", ", $columns_new_table);
	// $final_query .= $new_table_columns . ',  "' . 'DELETED' . '" as "status"';
	$final_query .= $new_table_columns . ',  \'' . 'DELETED' . '\' as "' . $status_column . '"' . ',  \'' . $file_name . '\' as "' . $file_name_column . '"';
	$final_query .= ' FROM ' . $source . '_' . $new_data_table;

	$final_query .= ' UNION ALL ';

	$final_query .= ' SELECT ';
	$columns_old_table = $GLOBALS["LOCAL_DB"]->columnList($source . '_' . $old_data_table);
	for ($i = 0; $i < count($columns_old_table); $i++) {
		$columns_old_table[$i] = $source . '_' . $old_data_table . '.' . $columns_old_table[$i];
	}
	$old_table_columns = implode(", ", $columns_old_table);
	//$final_query .= $old_table_columns . ',  "' . 'INSERTED' . '" as "status"';
	$final_query .= $old_table_columns . ',  \'' . 'INSERTED' . '\' as "' . $status_column . '"' . ',  \'' . $file_name . '\' as "' . $file_name_column . '"';
	// $final_query .= $old_table_columns . ',  \'' . 'INSERTED' . '\' as "' . $status_column . '"';
	$final_query .= ' FROM ' . $source . '_' . $old_data_table;

	$final_query .= ' ) tmp_table ';
	$final_query .= ' GROUP BY ';
	$final_query .= $select_part;
	$final_query .= ' HAVING COUNT(*) = 1 ';
	//$GLOBALS['source_specific_log']->info($final_query);
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
		$GLOBALS["source_specific_log"]->error("Source: " . $_POST['source'] . " ------>ERROR: LOCAL DB Error: " . $ex->getMessage());
		echo json_encode($GLOBALS["final_reply"]);
		exit;
	}
	return $source_details;
}
function exportExcelCsvToArray($file)
{
	$filetype = PHPExcel_IOFactory::identify($file);
	$GLOBALS["source_specific_log"]->info("file type = " . $filetype);
	$objReader = PHPExcel_IOFactory::createReader($filetype);
	$objReader->setReadDataOnly(true);
	if ($filetype === 'CSV') {
		$encoding = mb_detect_encoding(file_get_contents($file), mb_detect_order(), true);
		$objReader->setInputEncoding($encoding);
		$objReader->setDelimiter(getCSVDelimiter($file));
	}
	$objPHPExcel = $objReader->load($file);
	$results = $objPHPExcel->getActiveSheet()->toArray('', true, false, false);
	$GLOBALS['source_specific_log']->info("Total rows in the file : " . count($results));
	//fix columns names


	return $results;
}
// Detect CSV delimiter function
function getCSVDelimiter($csvFile)
{
	$GLOBALS['source_specific_log']->info("-->Detecting CSV delimiter");
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
	}
	$chosen_delimiter = array_search(max($delimiters), $delimiters);
	if ($chosen_delimiter === '"\t"') {
		$GLOBALS['source_specific_log']->warning("---->Correct delimiter = Tab space");
	}
	$GLOBALS['source_specific_log']->warning("---->Correct delimiter = " . $chosen_delimiter);
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
