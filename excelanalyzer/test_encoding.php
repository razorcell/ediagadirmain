<?php
ini_set('include_path', ini_get('include_path') . ';' . $_SERVER['DOCUMENT_ROOT'] . '/khalifaAPI/');
include_once 'libraries/khalifaAPI.php';
use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;

$GLOBALS["general-log"] = new MyLogPHP("log/test_encoding.csv");
$LOCAL_DB = new MeekroDB(EXCELANALYZER_DB_HOST, DB_USER, DB_PASSWORD, EXCELANALYZER_DB_NAME, NULL, 'utf8');
$LOCAL_DB->error_handler = false; // since we're catching errors, don't need error handler
$LOCAL_DB->throw_exception_on_error = true; //enable exceptions for the DB
$GLOBALS["general-log"]->info("");
// $url = "https://www.euronext.com/fr/popup/data/download?ml=nyx_pd_bonds&cmd=default&formKey=nyx_pd_filter_values:85d85c2eb49c52a229b7a70e0a117a32";
// getCSVECB('190412');
//getCSVEuronextBonds();
// echo getPerspektiva();
// echo getCSVMAE();

$file_path = 'khalifatmpfiles' . DIRECTORY_SEPARATOR . 'encodings';
$file = new SplFileObject($file_path, 'a+');
$lines = new LimitIterator($file);
foreach (iterator_to_array($lines) as $line) {
    echo '<option value="' . trim($line) . '">' . trim($line) . '</option>';
    //     }
}


exit;



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


function getCSVMAE()
{
    $url = 'http://www.mae.com.ar/legales/emisiones/emisiones_on.aspx';
    $GLOBALS["general-log"]->info($url);
    $ch = curl_init();
    $headers_array = array(
        'User-Agent: Mozilla/5.0 (Windows NT 6.3; Win64; x64; rv:67.0) Gecko/20100101 Firefox/67.0',
        'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
        'Accept-Language: en-US,en;q=0.5',
        'Accept-Encoding: gzip, deflate',
        'Connection: keep-alive',
        'Upgrade-Insecure-Requests: 1',
    );
    $post_param = array(
        'Cookie' => '__utma=33218978.1278455279.1553872549.1553872549.1554824825.2;
        __utmb=33218978.1278455279.1553872549.1553872549.1554824825.2;
        __utmc=33218978;
        __utmz=33218978.1553872549.1.1.utmcsr=(direct)|utmccn=(direct)|utmcmd=(none);
        ASP.NET_SessionId=5se4x32xhc2vix55dvntslq5;
        CultureName= en-US'
    );
    $post_param_as_string = http_build_query($post_param);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_param_as_string);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers_array);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); //1 to check the existence of a common name in the SSL peer certificate. 2 to check the existence of a common name and also verify that it matches the hostname provided. 0 to not check the names. 
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); //FALSE to stop cURL from verifying the peer's certificate.
    curl_setopt($ch, CURLOPT_URL, $url);
    //curl_setopt($ch, CURLOPT_FILE, $fp);
    curl_setopt($ch, CURLOPT_HEADER, false); //TRUE to include the header in the output. 
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); //TRUE to follow any "Location: " header that the server sends as part of the HTTP header (note this is recursive, PHP will follow as many "Location: " headers that it is sent, unless CURLOPT_MAXREDIRS is set). 
    curl_setopt($ch, CURLOPT_VERBOSE, true); // to show errors
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}
function getPerspektiva()
{
    //$file_name = 'downloads/' . date("Ymd_his") . '-euronextbonds.csv';
    // $file_name .= '.' . pathinfo($url, PATHINFO_EXTENSION);
    //$fp = fopen($file_name, 'w+');
    $ch = curl_init();
    $headers_array = array(
        'User-Agent: Mozilla/5.0 (Windows NT 6.3; Win64; x64; rv:67.0) Gecko/20100101 Firefox/67.0',
        'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
        'Accept-Language: en-US,en;q=0.5',
        'Accept-Encoding: gzip, deflate, br',
        'Content-Type: application/x-www-form-urlencoded',
        'Connection: keep-alive',
        // 'Referer: wEPDwUKMTIwNTA0MTQwOA9kFgJmD2QWAgIDD2QWBAIGD2QWDAIKDw8WBB4EVGV4dAUCMTUeB0VuYWJsZWRnZGQCCw8PFgQfAAUCMzAfAWdkZAIMDw8WBB8ABQI1MB8BaGRkAg0PDxYCHwFnZGQCDg88KwANAQAPFggeC18hSXRlbUNvdW50AsMCHgtBbGxvd1BhZ2luZ2ceC18hRGF0YUJvdW5kZx4IUGFnZVNpemUCMmQWAmYPZBZmAgEPZBYeZg8PFgIfAAUBMWRkAgEPZBYCZg8PFgQfAAUMVUE0MDAwMTg1MTUxHgtOYXZpZ2F0ZVVybAUnfi9TZWN1cml0aWVzSW5mby5hc3B4P0lTSU49VUE0MDAwMTg1MTUxZGQCAg8PFgIfAAUGJm5ic3A7ZGQCAw8PFgIfAAUGMTg1MTUxZGQCBA8PFgIfAAUIMDAwMTM0ODBkZAIFDw8WAh8ABSnQnNGW0L3RltGB0YLQtdGA0YHRgtCy0L4g0KTRltC90LDQvdGB0ZbQsmRkAgYPDxYCHwAFvAHQntCx0LvRltCz0LDRhtGW0Y8g0LLQvdGD0YLRgNGW0YjQvdGW0YUg0LTQtdGA0LbQsNCy0L3QuNGFINC',
        // 'Cookie: __utma=42729265.499549795.1553260723.1554215292.1554745981.16; __utmz=42729265.1553607453.9.5.utmcsr=192.168.1.153|utmccn=(referral)|utmcmd=referral|utmcct=/euronextetfmonitor/; cookie-agreed-en=2; cookie-agreed-fr=2; __utmc=42729265; TS01a5de3f=015c8de7078ea05f84f452eb96c935d69ed2327581feaab689a0a82238259fc14810092aaa; __utmb=42729265.1.10.1554745981; __utmt=1',
        'Upgrade-Insecure-Requests: 1',
    );

    $post_param = array(
        'ctl00_MainContentPlaceHolder_ScriptManager1_HiddenField' => ';;AjaxControlToolkit,+Version=3.5.51116.0,+Culture=neutral,+PublicKeyToken=28f01b0e84b6d53e:uk-UA:ab81b866-60eb-4f97-a962-1308435f4a86:de1feab2:fcf0e993:f2c8e708:720a52bf:f9cec9bc:589eaa30:698129cf:fb9b4c57:ccb96cf9',
        '__EVENTTARGET' => 'ctl00$MainContentPlaceHolder$SetAll',
        '__EVENTARGUMENT ' => ' ',
        '__VIEWSTATE ' => 'wEPDwUKMTIwNTA0MTQwOA9kFgJmD2QWAgIDD2QWBAIGD2QWDAIKDw8WBB4EVGV4dAUCMTUeB0VuYWJsZWRnZGQCCw8PFgQfAAUCMzAfAWdkZAIMDw8WBB8ABQI1MB8BaGRkAg0PDxYCHwFnZGQCDg88KwANAQAPFggeC18hSXRlbUNvdW50AsMCHgtBbGxvd1BhZ2luZ2ceC18hRGF0YUJvdW5kZx4IUGFnZVNpemUCMmQWAmYPZBZmAgEPZBYeZg8PFgIfAAUBMWRkAgEPZBYCZg8PFgQfAAUMVUE0MDAwMTg1MTUxHgtOYXZpZ2F0ZVVybAUnfi9TZWN1cml0aWVzSW5mby5hc3B4P0lTSU49VUE0MDAwMTg1MTUxZGQCAg8PFgIfAAUGJm5ic3A7ZGQCAw8PFgIfAAUGMTg1MTUxZGQCBA8PFgIfAAUIMDAwMTM0ODBkZAIFDw8WAh8ABSnQnNGW0L3RltGB0YLQtdGA0YHRgtCy0L4g0KTRltC90LDQvdGB0ZbQsmRkAgYPDxYCHwAFvAHQntCx0LvRltCz0LDRhtGW0Y8g0LLQvdGD0YLRgNGW0YjQvdGW0YUg0LTQtdGA0LbQsNCy0L3QuNGFINC',
        'ctl00$MainContentPlaceHolder$txtFrom' => '2019-04-08',
    );
    $post_param_as_string = http_build_query($post_param);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_param_as_string);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers_array);
    // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_URL, 'http://fbp.com.ua/Trade/StockListPer.aspx');
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_VERBOSE, true); // to show errors
    $result = curl_exec($ch);
    curl_close($ch);
    // fclose($fp);
    return $result;
}
function Downloadfile($url, $source)
{
    //This is the file where we save the    information
    //$GLOBALS["general-log"]->info($file_name);
    $fp = fopen('tmp_name', 'w+');
    //Here is the file we are downloading, replace spaces with %20
    $ch = curl_init(str_replace(" ", "%20", $url));
    curl_setopt($ch, CURLOPT_TIMEOUT, 50);
    // write curl response to file
    curl_setopt($ch, CURLOPT_FILE, $fp);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    // get curl response
    curl_exec($ch);
    curl_close($ch);
    fclose($fp);
}
function getCSVECB($date)
{
    $url = 'https://www.ecb.europa.eu/paym/coll/assets/shared/data/EMA/2019/04/ea_csv_' . $date  . '.csv.gz';
    $GLOBALS["general-log"]->info($url);
    //first we need to get the correct link
    // $file_name = 'downloads/$date' . date("Ymd_his") . '-ecb.csv.gz';
    $file_name = "downloads/$date-ecb.csv.gz";

    // $file_name .= '.' . pathinfo($url, PATHINFO_EXTENSION);
    $fp = fopen($file_name, 'w+');
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FILE, $fp);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_VERBOSE, true); // to show errors
    $result = curl_exec($ch);
    curl_close($ch);
    fclose($fp);
    gzipUncompress($file_name);
    return $result ? $file_name : false;
}
function gzipUncompress($file_name)
{
    // Raising this value may increase performance
    $buffer_size = 4096; // read 4kb at a time
    $out_file_name = str_replace('.gz', '', $file_name);
    // Open our files (in binary mode)
    $file = gzopen($file_name, 'rb');
    $out_file = fopen($out_file_name, 'wb');
    // Keep repeating until the end of the input file
    while (!gzeof($file)) {
        // Read buffer-size bytes
        // Both fwrite and gzread and binary-safe
        fwrite($out_file, gzread($file, $buffer_size));
    }
    // Files are done, close files
    fclose($out_file);
    gzclose($file);
}
function getCSVEuronextBonds()
{
    $file_name = 'downloads/' . date("Ymd_his") . '-euronextbonds.csv';
    // $file_name .= '.' . pathinfo($url, PATHINFO_EXTENSION);
    $fp = fopen($file_name, 'w+');
    $ch = curl_init();
    // $headers_array = array(
    //     'User-Agent: Mozilla/5.0 (Windows NT 6.3; Win64; x64; rv:67.0) Gecko/20100101 Firefox/67.0',
    //     'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
    //     'Accept-Language: en-US,en;q=0.5',
    //     'Accept-Encoding: gzip, deflate, br',
    //     'Content-Type: application/x-www-form-urlencoded',
    //     'Connection: keep-alive',
    //     'Referer: https://www.euronext.com/fr/popup/data/download?ml=nyx_pd_bonds&cmd=default&formKey=nyx_pd_filter_values%3A85d85c2eb49c52a229b7a70e0a117a32',
    //     'Cookie: __utma=42729265.499549795.1553260723.1554215292.1554745981.16; __utmz=42729265.1553607453.9.5.utmcsr=192.168.1.153|utmccn=(referral)|utmcmd=referral|utmcct=/euronextetfmonitor/; cookie-agreed-en=2; cookie-agreed-fr=2; __utmc=42729265; TS01a5de3f=015c8de7078ea05f84f452eb96c935d69ed2327581feaab689a0a82238259fc14810092aaa; __utmb=42729265.1.10.1554745981; __utmt=1',
    //     'Upgrade-Insecure-Requests: 1',
    // );
    $post_param = array(
        "format" => "2",
        "layout" => "2",
        "decimal_separator" => "1",
        "date_format" => "1",
        "op" => "Go",
        "form_build_id" => "form-a95710e82fa886fbb6ea8d65ef9f2210",
        "form_id" => "nyx_download_form"
    );
    $post_param_as_string = http_build_query($post_param);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_param_as_string);
    //curl_setopt($ch, CURLOPT_HTTPHEADER, $headers_array);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_URL, 'https://www.euronext.com/fr/popup/data/download?ml=nyx_pd_bonds&cmd=default&formKey=nyx_pd_filter_values:85d85c2eb49c52a229b7a70e0a117a32');
    curl_setopt($ch, CURLOPT_FILE, $fp);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_VERBOSE, true); // to show errors
    $result = curl_exec($ch);
    curl_close($ch);
    fclose($fp);
    return $result ? $file_name : false;
}
$step1 = microtime(true);
var_dump(getExcelCSVFasterUsingSpout('uploads/2019.TXT', 'csv'));
$GLOBALS["general-log"]->info(timeDiff($step1, microtime(true)));
function getExcelCSVFasterUsingSpout($file_name, $file_type)
{
    $reader = ($file_type === 'csv') ? ReaderFactory::create(Type::CSV) : ReaderFactory::create(Type::XLSX);
    //$reader = ReaderFactory::create(Type::ODS); // for ODS files
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
// $source = 'test';
// $one_deleted_data = array('column1'=> 'Val1',
// 'column2'=> 'Val2',
// 'column3'=> 'Val3',
// 'column4'=> 'Val4',
// );
// $query = 'DELETE FROM '.$source . '_live ';
// 			// ON ecb_today.column1 <=> ecb_live.column1 AND  .......
// 			//building the WHERE part
// 			$columns = $GLOBALS["LOCAL_DB"]->columnList($source . '_live');
// 			for ($i = 0; $i < count($columns); $i++) {
//                 $columns[$i] = $source . '_live'. "." . $columns[$i] . " <=> '" . 
//                 $one_deleted_data['column'.strval($i+1)]."'";
// 			}
// 			$where_part = 'WHERE '.implode(' AND ', $columns);
// 			$query .= $where_part;
// 			echo $query;
//echo '<pre>';
//echo buildQueryToCompareDataInTwoTablesUsingUNION('ecb', 'live', 'today');
//  exit;
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
/*
$source = "ECB";
try {
	$GLOBALS["LOCAL_DB"]->query('truncate table test_table');
}
catch(MeekroDBException $ex) {
	$GLOBALS["final_reply"]['status'] = 'error';
	$GLOBALS['general-log']->error("ERROR: LOCAL DB Error: " . $ex->getMessage());
	exit;
}
$csv_filename = "uploads/ecb_half.xlsx";
//$csv_filename = "uploads/ea_excel_full.xlsx";
$all_data = array();
$all_securities_array_tmp = exportExcelCsvToArray($csv_filename);
try {
    $source_details = $GLOBALS["LOCAL_DB"]->query('SELECT * FROM existing_sources WHERE text = %s', $source);
}
catch(MeekroDBException $ex) {
    $GLOBALS["final_reply"]['status'] = 'error';
    $GLOBALS['general-log']->error("ERROR: LOCAL DB Error: " . $ex->getMessage());
    exit;
}
foreach($all_securities_array_tmp as $one_security_array){
    $one_security_with_correct_columns = array();
    for ($i = 1; $i <= $source_details[0]['columns']; $i++) {
        $one_security_with_correct_columns['column' . $i] = $one_security_array[$i - 1];
    }
    array_push($all_data, $one_security_with_correct_columns);
}
$GLOBALS["general-log"]->info("Inserting in today table");
var_dump($all_data);
//STEP 1
//inserting in Today table
try {
	$GLOBALS["LOCAL_DB"]->insert('test_table', $all_data);
}
catch(MeekroDBException $ex) {
	$GLOBALS["final_reply"]['status'] = 'error';
	$GLOBALS['general-log']->error("ERROR: LOC
AL DB Error: " . $ex->getMessage());
	exit;
}
*/
function exportExcelCsvToArray($file)
{
    $filetype = PHPExcel_IOFactory::identify($file);
    $GLOBALS["general-log"]->info("fi le type = " . $filetype);
    $objReader = PHPExcel_IOFactory::createReader($filetype);
    if ($filetype === 'CSV') {
        $encoding = mb_detect_encoding(file_get_contents($file), mb_detect_order(), true);
        $objReader->setInputEncoding($encoding);
        $objReader->setDelimiter(getCSVDelimiter($file));
    }
    $objPHPExcel = $objReader->load($file);
    $results = $objPHPExcel->getActiveSheet()->toArray(null, true, true, false);
    //var_dump($results);
    return $results;
}
function Get_data_from_csv_file_to_array($csv_filename)
{
    $all_data = array();
    // counting the number of lines in the file for the progress bar
    $number_of_securities = count(file($csv_filename));
    $GLOBALS["general-log"]->info("Number of securities in the file :  " . $number_of_securities);
    // clear the progress file
    $link_to_uploaded_csv_file = fopen($csv_filename, "r");
    // echo "<pre>";
    $i = 1;
    $csv_delimiter = getCSVDelimiter($csv_filename);
    while ($row_to_array = fgetcsv($link_to_uploaded_csv_file, 0, $csv_delimiter)) {
        if (count($row_to_array) < 22) {
            continue;
        }
        $data = array_map("utf8_encode", $row_to_array); //added
        //var_dump($data);
        //var_dump($row_to_array);
        //echo $row_to_array[0]."<br>";
        $current_security = array();
        for ($i  = 1; $i <= 22; $i++) {
            $GLOBALS["general-log"]->info("Offset : " . ($i -  1) . " = " . $row_to_array[$i - 1]);
            $GLOBALS["general-log"]->info("converttoutf8 : " . ($i - 1) . " = " . ConvertToUTF8($row_to_array[$i - 1]));
            $current_security['column' . $i] = $row_to_array[$i - 1];
            //echo "Gross val = ".$row_to_array[$i - 1]."<br>";
            //echo convToUtf8($row_to_array[$i - 1])."<br>";
            //echo "column = ".$i."<br>";
            //echo ConvertToUTF8($row_to_array[$i - 1])."<br>";
            $encoding = mb_detect_encoding($row_to_array[$i - 1], mb_detect_order(), true);
            //echo "detected encoding  = ".$encoding."<br>";
            //echo iconv("ASCII", "UTF-8//TRANSLIT", $ro w _to_array[$i - 1])."<br>";
            echo utf8_encode($row_to_array[$i - 1]) . "<br>";
            //echo iconv(mb_detect_encoding($row_to_array[$i - 1], mb_detect_order(), true), "UTF-8//IGNORE", $row_to_array[$i - 1])."<br>";
            //$encoding = mb_detect_encoding($row_to_array[$i - 1], mb_detect_order(), true);
            //$GLOBALS['general-log']->info($row_to_array[$i - 1] . " encoded on = " . $encoding);
            //$current_security['column' . $i] = preg_replace('/\s+/', '', iconv(mb_detect_encoding($row_to_array[$i - 1], mb_detect_order(), true), "ASCII", $row_to_array[$i - 1]));
            //$GLOBALS['general-log']->info("Gross value : ".$current_security['column' . $i]);
            //$GLOBALS['general-log']->info("encoding converted value : ".iconv(mb_detect_encoding($row_to_array[$i - 1], mb_detect_order(), true), "UTF-8", $row_to_array[$i - 1]));
        }
        array_push($all_data, $current_security);
    }
    fclose($link_to_uploaded_csv_file);
    return $all_data;
}
function ConvertToUTF8($text)
{
    $encoding = mb_detect_encoding($text, mb_detect_order(), false);
    if ($encoding == "UTF-8") {
        $text = mb_convert_encoding($text, 'UTF-8', 'UTF-8');
    }
    $out = iconv(mb_detect_encoding($text, mb_detect_order(), false), "UTF-8//IGNORE", $text);
    return $out;
}
function convToUtf8($str, $encoding_detection_types = "UTF-16,UTF-16LE,UTF-16BE,UTF-8,ASCII, ISO-8859-15")
{
    $detect = mb_detect_encoding($str, $encoding_detection_types);
    if ($detect && $detect != "UTF-8") {
        return  $str = mb_convert_encoding($str, "UTF-8", $detect);
    } else {
        return $str;
    }
}
// Detect CSV delimiter function
function getCSVDelimiter($csvFile)
{
    $GLOBALS['general-log']->info("Detecting CSV delimiter");
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
        $GLOBALS['general-log']->info($count . " columns with delimiter =   " . $delimiter);
    }
    return array_search(max($delimiters), $delimiters);
}
