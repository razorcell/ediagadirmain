<?php
//ini_set('include_path', ini_get('include_path').PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/khalifaAPI/');
//ini_set('include_path', ini_get('include_path').';'.$_SERVER['SERVER_NAME'].'/khalifaassets/');
include_once "libraries/MyLogPHP.class.php";
include_once "libraries/simple_html_dom.php";
include_once 'libraries/Snoopy.class.php';
include_once 'libraries/Curl.php';
include_once 'libraries/CaseInsensitiveArray.php';
include_once 'libraries/medoo.php';
include_once 'libraries/phpexcel/PHPExcel.php';
include_once 'libraries/meekrodb.2.3.class.php';
include_once 'configuration/config.php';
require_once 'libraries/SpoutFastExcelReader/Spout/Autoloader/autoload.php';
include_once "libraries/DatatablesSSPClass.php";
//date_default_timezone_set('Africa/Casablanca'); // CDT
set_time_limit(86400); // 1 day max
//clear log file
Reset_file_according_to_size($_SERVER['DOCUMENT_ROOT'] . '/khalifaAPI/logs/khalifaAPI-logs.csv', 30);
// Global logging variable
$GLOBALS["logger"] = new MyLogPHP($_SERVER['DOCUMENT_ROOT'] . '/khalifaAPI/logs/khalifaAPI-logs.csv');
$GLOBALS["logger_bmv_com_mx"] = new MyLogPHP($_SERVER['DOCUMENT_ROOT'] . '/khalifaAPI/logs/logger_bmv_com_mx.csv');
$GLOBALS["logger_KASE"] = new MyLogPHP($_SERVER['DOCUMENT_ROOT'] . '/khalifaAPI/logs/logger_KASE.csv');
$GLOBALS["logger_euronext_CA_Monitor"] = new MyLogPHP($_SERVER['DOCUMENT_ROOT'] . '/khalifaAPI/logs/logger_euronext_CA_Monitor.csv');
$GLOBALS["logger_Bolsar_Bonds_Monitor"] = new MyLogPHP($_SERVER['DOCUMENT_ROOT'] . '/khalifaAPI/logs/logger_Bolsar_Bonds_Monitor.csv');
$GLOBALS["logger_KACD"] = new MyLogPHP($_SERVER['DOCUMENT_ROOT'] . '/khalifaAPI/logs/logger_KACD.csv');
$GLOBALS["logger_marketwatch"] = new MyLogPHP($_SERVER['DOCUMENT_ROOT'] . '/khalifaAPI/logs/logger_marketwatch.csv');
$GLOBALS["logger_hamburg"] = new MyLogPHP($_SERVER['DOCUMENT_ROOT'] . '/khalifaAPI/logs/logger_hamburg.csv');
$GLOBALS["logger_bmv_com_mx_download_counter"] = 0;
$GLOBALS["logger_euronextcamonitor_download_counter"] = 0;
$GLOBALS["logger_Bolsar_Bonds_download_counter"] = 0;
$GLOBALS["logger_KASE_download_counter"] = 0;
$GLOBALS["logger_KACD_download_counter"] = 0;
$GLOBALS["logger_marketwatch_download_counter"] = 0;
$GLOBALS["logger_hamburg_download_counter"] = 0;
//Local smart_calendar DB connection
$GLOBALS["DB_DATABASE_TOOLS"] = new MeekroDB(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE_TOOLS, NULL, 'utf8');
$GLOBALS["DB_DATABASE_TOOLS"]->error_handler = false; // since we're catching errors, don't need error handler
$GLOBALS["DB_DATABASE_TOOLS"]->throw_exception_on_error = true; //enable exceptions for the DB
/**
 * Suppose, you are browsing in your localhost 
 * http://localhost/myproject/index.php?id=8
 */
function getBaseUrl()
{
        // output: /myproject/index.php
        $currentPath = $_SERVER['PHP_SELF'];
        // output: Array ( [dirname] => /myproject [basename] => index.php [extension] => php [filename] => index ) 
        $pathInfo = pathinfo($currentPath);
        // output: localhost
        $hostName = $_SERVER['HTTP_HOST'];
        // output: http://
        $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"], 0, 5)) == 'https' ? 'https' : 'http';
        // return: http://localhost/myproject/
        return $protocol . '://' . $hostName . $pathInfo['dirname'] . "/";
}
function timeDiff($firstTime, $lastTime)
{
        $diff = round($lastTime - $firstTime);
        $minutes = floor($diff / 60); //only minutes
        $seconds = $diff % 60; //remaining seconds, using modulo operator
        return "ENDED IN: $minutes min:$seconds s"; //value in seconds
}
function Get_time_in_milliseconds()
{
        $mt = explode(' ', microtime());
        return ((int)$mt[1]) * 1000 + ((int)round($mt[0] * 1000));
}
function Reset_file_according_to_size($filename, $sizelimit_in_Mbytes)
{
        if (file_exists($filename) && filesize($filename) > ($sizelimit_in_Mbytes * 1000 * 1000)) { // if size is greater than 30 MB
                $fh = fopen($filename, 'w'); //Clear content
                fclose($fh);
                $GLOBALS["logger"]->info("Reset_file_according_to_size : Log cleared");
        }
}
function Get_proxy_from_db()
{
        $GLOBALS["logger"]->info("START Get_proxy_from_db");
        $current_proxy = false;
        $database = new medoo(['database_type' => 'mysql', 'database_name' => DB_DATABASE_TOOLS, 'server' => DB_HOST, 'username' => DB_USER, 'password' => DB_PASSWORD, 'charset' => 'utf8',]);
        while (empty($current_proxy)) {
                $proxies_array = $database->query("select * from proxies_multi_sources")->fetchAll(PDO::FETCH_ASSOC);
                if (!empty($proxies_array) and count($proxies_array) > 2) {
                        $current_proxy = $proxies_array[rand(0, (count($proxies_array) - 1))];
                } else {
                        //if table is empty try to fill it
                        $GLOBALS["logger"]->info("Proxies db is empty or has only 2 IPs");
                        //$sources = array("sslproxies.org", "free-proxy-list.net", "socks-proxy.net"");
                        $sources = array("free-proxy-list.net", "spys.one");
                        Update_proxies_table_from_multi_sources($sources);
                }
        }
        $GLOBALS["logger"]->info($current_proxy["proxy"]);
        $GLOBALS["logger"]->info("END Get_proxy_from_db");
        return $current_proxy;
}
function Get_proxy_from_pubproxy()
{
        //Last test showed that it fails too much
        $GLOBALS["logger"]->info("     START Get_proxy_from_pubproxy");
        $proxy = Download_using_Curl('http://pubproxy.com/api/proxy?type=http?https=true?level=anonymous?limit=30?last_check=60?cookies=true');
        $GLOBALS["logger"]->info("     END Get_proxy_from_pubproxy");
        return $proxy->data[0]->ipPort;
}
function Download_Hamburg($url, $page_number)
{
        $GLOBALS["logger_hamburg"]->info('Download_Hamburg : ' . $url);
        $curl = curl_init();
        $timeout = 60;
        $maximum_download_attempts = 30;
        $attempt = 0;
        $header[0] = "Accept: application/json, text/javascript, */*";
        $header[0] .= "text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5";
        $header[] = "Connection: keep-alive";
        $header[] = "Accept-Language: en-us,en;q=0.5";
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.3; Win64; x64; rv:59.0) Gecko/20100101 Firefox/59.0");
        curl_setopt($curl, CURLOPT_ENCODING, "gzip,deflate,br");
        curl_setopt($curl, CURLOPT_AUTOREFERER, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_VERBOSE, true); // to show errors	
        $post_param = array(
                'p' => $page_number,
                'pager' => '',
                'xinline' => '1',
                'n' => '',
                'kb' => 'A',
                'br' => '',
                'land' => '',
                'idx' => '',
                'limit' => '100',
                'o' => 'n',
                'od' => 'a'
        );
        $post_param_as_string = http_build_query($post_param);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post_param_as_string);
        $download_success = FALSE;
        while (!$download_success and $attempt < $maximum_download_attempts) {
                $GLOBALS["logger_hamburg"]->info('----> Attempt : ' . $attempt);
                $current_proxy = Get_proxy_from_db();
                curl_setopt($curl, CURLOPT_PROXY, $current_proxy["proxy"]);
                $data = curl_exec($curl);
                if (
                        empty($data) or
                        curl_error($curl) or
                        empty($data) or
                        strlen($data) == 0 or
                        strpos($data, 'Service not available or busy') !== false or
                        strpos($data, 'Es ist ein interner Fehler aufgetreten') !== false or
                        strpos($data, 'Forbidden') !== false or
                        strpos($data, '404 Not Found') !== false or
                        strpos($data, 'Backend not available') !== false or
                        strpos($data, 'Bad Request') !== false or
                        strpos($data, '500 Internal Server Error') !== false or
                        strpos($data, '503 Service') !== false or
                        strpos($data, 'Proxy Error') !== false
                ) {
                        $GLOBALS["logger_hamburg"]->info('Download_Hamburg : ERROR : ' . curl_error($curl));
                        //delete this proxy from table
                        $database_tools = new medoo(['database_type' => 'mysql', 'database_name' => DB_DATABASE_TOOLS, 'server' => DB_HOST, 'username' => DB_USER, 'password' => DB_PASSWORD, 'charset' => 'utf8',]);
                        $database_tools->delete("proxies_multi_sources", ["id" => $current_proxy["id"]]);
                        $GLOBALS["logger_hamburg"]->info('Download_Hamburg... PROXY DELETED : ' . $current_proxy["proxy"]);
                } else {
                        $download_success = TRUE;
                        $GLOBALS["logger_hamburg"]->info('Download_Hamburg : SUCCESS');
                        file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/khalifaAPI/logs/hamburg-downloads/' . $GLOBALS["logger_hamburg_download_counter"] . '.html', $data);
                        $GLOBALS["logger_hamburg_download_counter"]++;
                        curl_close($curl);
                        return $data;
                }
                $attempt++;
        }
        curl_close($curl);
        $GLOBALS["logger_hamburg"]->info('Too many download attempts');
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/khalifaAPI/logs/hamburg-downloads/' . $GLOBALS["logger_hamburg_download_counter"] . '.html', $data);
        $GLOBALS["logger_hamburg_download_counter"]++;
}
function Download_marketwatch($url)
{
        $GLOBALS["logger_marketwatch"]->info('Download_marketwatch : ' . $url);
        $curl = curl_init();
        $timeout = 20;
        $maximum_download_attempts = 140;
        $attempt = 0;
        $header[0] = "Accept: application/json, text/javascript, */*";
        $header[0] .= "text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5";
        $header[] = "Connection: keep-alive";
        $header[] = "Accept-Language: en-us,en;q=0.5";
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.3; Win64; x64; rv:59.0) Gecko/20100101 Firefox/59.0");
        curl_setopt($curl, CURLOPT_ENCODING, "gzip,deflate,br");
        curl_setopt($curl, CURLOPT_AUTOREFERER, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_VERBOSE, true); // to show errors	
        $download_success = FALSE;
        while (!$download_success and $attempt < $maximum_download_attempts) {
                $GLOBALS["logger_marketwatch"]->info('----> Attempt : ' . $attempt);
                $current_proxy = Get_proxy_from_db();
                curl_setopt($curl, CURLOPT_PROXY, $current_proxy["proxy"]);
                $data = curl_exec($curl);
                if (
                        empty($data) or
                        curl_error($curl) or
                        empty($data) or
                        strlen($data) < 2000 or
                        strpos($data, 'Forbidden' or
                                strpos($data, 'Backend not available') !== false or
                                strpos($data, 'Bad Request') !== false or
                                strpos($data, '500 Internal Server Error') !== false or
                                strpos($data, '503 Service') !== false or
                                strpos($data, 'distil_referrer') !== false or
                                strpos($data, 'Proxy Error') !== false) !== false
                ) {
                        $GLOBALS["logger_marketwatch"]->error('ERROR : ' . curl_error($curl));
                        //delete this proxy from table
                        //                        $database_tools = new medoo(['database_type' => 'mysql', 'database_name' => DB_DATABASE_TOOLS, 'server' => DB_HOST, 'username' => DB_USER, 'password' => DB_PASSWORD, 'charset' => 'utf8', ]);
                        //                        $database_tools->delete("proxies_multi_sources", ["id" => $current_proxy["id"]]);
                        //                        $GLOBALS["logger_marketwatch"]->info('PROXY DELETED : '.$current_proxy["proxy"]);
                        try {
                                $GLOBALS["DB_DATABASE_TOOLS"]->delete('proxies_multi_sources', "id=%i", $current_proxy["id"]);
                                $GLOBALS["logger_marketwatch"]->info('PROXY DELETED : ' . $current_proxy["proxy"]);
                        } catch (MeekroDBException $ex) {
                                $GLOBALS['logger_marketwatch']->error("ERROR: LOCAL DB Error: " . $ex->getMessage());
                        }
                        //sleep(2);
                } else {
                        $download_success = TRUE;
                        $GLOBALS["logger_marketwatch"]->success('Download_marketwatch : SUCCESS');
                        file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/khalifaAPI/logs/marketwatch-downloads/' . $GLOBALS["logger_marketwatch_download_counter"] . '.html', $data);
                        $GLOBALS["logger_marketwatch_download_counter"]++;
                        curl_close($curl);
                        return $data;
                }
                $attempt++;
        }
        curl_close($curl);
        $GLOBALS["logger_marketwatch"]->error('Too many download attempts');
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/khalifaAPI/logs/marketwatch-downloads/' . $GLOBALS["logger_marketwatch_download_counter"] . '.html', $data);
        $GLOBALS["logger_marketwatch_download_counter"]++;
}
function Download_KACD($url)
{
        $GLOBALS["logger_KACD"]->info('Download_KACD : ' . $url);
        $curl = curl_init();
        $timeout = 60;
        $maximum_download_attempts = 30;
        $attempt = 0;
        $header[0] = "Accept: application/json, text/javascript, */*";
        $header[0] .= "text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5";
        $header[] = "Connection: keep-alive";
        $header[] = "Accept-Language: en-us,en;q=0.5";
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.3; Win64; x64; rv:59.0) Gecko/20100101 Firefox/59.0");
        curl_setopt($curl, CURLOPT_ENCODING, "gzip,deflate,br");
        curl_setopt($curl, CURLOPT_AUTOREFERER, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_VERBOSE, true); // to show errors	
        $download_success = FALSE;
        while (!$download_success and $attempt < $maximum_download_attempts) {
                $GLOBALS["logger_KACD"]->info('----> Attempt : ' . $attempt);
                $current_proxy = Get_proxy_from_db();
                curl_setopt($curl, CURLOPT_PROXY, $current_proxy["proxy"]);
                $data = curl_exec($curl);
                if (
                        empty($data) or
                        curl_error($curl) or
                        empty($data) or
                        strlen($data) == 0 or
                        strpos($data, 'Forbidden' or
                                strpos($data, 'Backend not available') !== false or
                                strpos($data, 'Bad Request') !== false or
                                strpos($data, '500 Internal Server Error') !== false or
                                strpos($data, '503 Service') !== false or
                                strpos($data, 'Proxy Error') !== false) !== false
                ) {
                        $GLOBALS["logger_KACD"]->info('Download_KACD : ERROR : ' . curl_error($curl));
                        //delete this proxy from table
                        $database_tools = new medoo(['database_type' => 'mysql', 'database_name' => DB_DATABASE_TOOLS, 'server' => DB_HOST, 'username' => DB_USER, 'password' => DB_PASSWORD, 'charset' => 'utf8',]);
                        $database_tools->delete("proxies_multi_sources", ["id" => $current_proxy["id"]]);
                        $GLOBALS["logger_KACD"]->info('Download_KACD... PROXY DELETED : ' . $current_proxy["proxy"]);
                } else {
                        $download_success = TRUE;
                        $GLOBALS["logger_KACD"]->info('Download_KACD : SUCCESS');
                        file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/khalifaAPI/logs/KACD-downloads/' . $GLOBALS["logger_KACD_download_counter"] . '.html', $data);
                        $GLOBALS["logger_KACD_download_counter"]++;
                        curl_close($curl);
                        return $data;
                }
                $attempt++;
        }
        curl_close($curl);
        $GLOBALS["logger_KACD"]->info('Too many download attempts');
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/khalifaAPI/logs/KACD-downloads/' . $GLOBALS["logger_KACD_download_counter"] . '.html', $data);
        $GLOBALS["logger_KACD_download_counter"]++;
}
function Download_Bolsar_Bonds_Monitor($url, $page_number)
{
        $GLOBALS["logger_Bolsar_Bonds_Monitor"]->info('--------------------------- URL DOWNLOADING ID : ' . $GLOBALS["logger_Bolsar_Bonds_download_counter"] . '------------------------------');
        $GLOBALS["logger_Bolsar_Bonds_Monitor"]->info('');
        $GLOBALS["logger_Bolsar_Bonds_Monitor"]->info('');
        $GLOBALS["logger_Bolsar_Bonds_Monitor"]->info('  START Download_Bolsar_Bonds_Monitor()');
        $GLOBALS["logger_Bolsar_Bonds_Monitor"]->info('url :' . $url);
        $GLOBALS["logger_Bolsar_Bonds_Monitor"]->info('Page number :' . $page_number);
        $curl = curl_init();
        $waiting_time_after_failure = 5;
        $timeout = 30;
        $attempt = 0;
        $maximum_download_attempts = 30;
        $header[0] = "Accept: */*";
        //$header[0].= "text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5";
        //$header[] = "Cache-Control: max-age=0";
        $header[] = "Connection: keep-alive";
        //    $header[] = "Keep-Alive: 300";
        //$header[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
        $header[] = "Accept-Language: en-us,en;q=0.5";
        $header[] = 'Cookie:ASP.NET_SessionId=cbse4vzmkpijtiiptt1dqi55; ckLng=ENG; __utma=133838749.1038861758.1534320406.1534320406.1534320406.1; __utmc=133838749; __utmz=133838749.1534320406.1.1.utmcsr=(direct)|utmccn=(direct)|utmcmd=(none)';
        //    
        //    $header[] = "Cookie:"
        //            . "__utma=133838749.1038861758.1534320406.1534320406.1534320406.1;"
        //            . "__utmc=133838749;"
        //            . "__utmz=133838749.1534320406.1.1.utmcsr=(direct)|utmccn=(direct)|utmcmd=(none);"
        //            . "ASP.NET_sessionId=cbse4vzmkpijtiiptt1dqi55;"
        //            . "ckLng=ENG";
        //$header[] = "Pragma: ";
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, TRUE);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:7.0.1) Gecko/20100101 Firefox/7.0.12011-10-16");
        curl_setopt($curl, CURLOPT_REFERER, "https://www.bolsar.com/Vistas/Investigaciones/Especies.aspx");
        curl_setopt($curl, CURLOPT_ENCODING, "gzip,deflate,br");
        curl_setopt($curl, CURLOPT_AUTOREFERER, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_VERBOSE, true); // to show errors
        $post_param = array(
                'ctl00$ctl00$txbFiltro_MasterEspecie' => '',
                'ctl00$ctl00$ContentPlaceHolder1$tablaContenidoFiltro$txbFiltro_Especiect' => '',
                'ctl00$ctl00$ContentPlaceHolder1$tablaContenidoFiltro$cboTipoEspeciect' => '1',
                'ctl00$ctl00$ContentPlaceHolder1$cpeFiltro_ClientState' => 'false',
                'ctl00$ctl00$ContentPlaceHolder1$GrillaListado$dataGridListado$ctl104$cboPages' => '100',
                'ctl00$ctl00$sm' =>
                //'ctl00$ctl00$ContentPlaceHolder1$UpdatePanel1|ctl00$ctl00$ContentPlaceHolder1$GrillaListado$dataGridListado$ctl104$ctl0'.strval($page_number), 
                strval('ctl00$ctl00$ContentPlaceHolder1$UpdatePanel1|ctl00$ctl00$ContentPlaceHolder1$GrillaListado$dataGridListado$ctl104$ctl0' . $page_number),
                //'ctl00$ctl00$ContentPlaceHolder1$UpdatePanel1|ctl00$ctl00$ContentPlaceHolder1$GrillaListado$dataGridListado$ctl104$ctl05', 
                '__EVENTTARGET' =>
                //'ctl00$ctl00$ContentPlaceHolder1$GrillaListado$dataGridListado$ctl104$ctl0'.strval($page_number),
                strval('ctl00$ctl00$ContentPlaceHolder1$GrillaListado$dataGridListado$ctl104$ctl0' . $page_number),
                //'ctl00$ctl00$ContentPlaceHolder1$GrillaListado$dataGridListado$ctl104$ctl05',
                '__EVENTARGUMENT' => '',
                '__LASTFOCUS' => '',
                '__VIEWSTATE' => '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',
                '__VIEWSTATEGENERATOR' => '9D12FF9B',
                '__PREVIOUSPAGE' => '0Ft6dlY_tOalskzUBjYgWRZMogYCG6M6sXrnRhpq6h4sbGvZt9aXigyi-26eEkROZ5cNHbCWQgQE9xnn1GNUXp8mslcNoclr20rrBIO4zPKBg89R0',
                '__EVENTVALIDATION' => 'roGjeLH9UhKsICOGU5CVKqeFFiR7dqfdSN0FG3loAQxQ3yPZ+HPPZpFNMkBVsMF4Wvzj31XbwlrZ8D6iM6iVvxW7yVg3IrveI7aa7F8Sr1wsVW/PwMM8N35c37UyNAoDJhJcYQyxlHWooiR37jyaVLwx3VAtBpGvr/i4OeRJmhrDClqvT0fJmuXrkBtn2EDb6eO+rmVKYKDNe1+7rxcaDcTLZKkyqBgsa6j6HsP8al5LUluL0sTXntk/JhhRggjO59yAQ9Wu64q+HcV5MI7GEY+3iFzFf5Q6UfU6DNKIpibedkpHL8MKgQrLNo3DB8Su7dcudthrZDurWIruFCJWX5/8rS/DejG2mwySElkP5KGWf5B5',
                '__VIEWSTATEENCRYPTED' => '',
                '__ASYNCPOST' => 'true',
        );
        $post_param_as_string = http_build_query($post_param);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post_param_as_string);
        $download_success = FALSE;
        while (!$download_success and $attempt < $maximum_download_attempts) {
                $GLOBALS["logger_Bolsar_Bonds_Monitor"]->info('----> Attempt : ' . $attempt);
                $current_proxy = Get_proxy_from_db();
                curl_setopt($curl, CURLOPT_PROXY, $current_proxy['proxy']);
                $data = curl_exec($curl);
                $GLOBALS["logger_Bolsar_Bonds_Monitor"]->info('Using PROXY: ' . $current_proxy['proxy']);
                if (
                        curl_error($curl) or
                        empty($data) or
                        strlen($data) == 0 or
                        strpos($data, 'Forbidden') !== false or
                        strpos($data, 'Backend not available') !== false or
                        strpos($data, 'Bad Request') !== false or
                        strpos($data, '500 Internal Server Error') !== false or
                        strpos($data, '503 Service') !== false or
                        strpos($data, 'Proxy Error') !== false
                ) {
                        $GLOBALS["logger_Bolsar_Bonds_Monitor"]->info('ERROR: ' . curl_error($curl));
                        $GLOBALS["logger_Bolsar_Bonds_Monitor"]->info('Resulting page size = ' . strlen($data));
                        //delete this proxy from the DB
                        $database_tools = new medoo(['database_type' => 'mysql', 'database_name' => DB_DATABASE_TOOLS, 'server' => DB_HOST, 'username' => DB_USER, 'password' => DB_PASSWORD, 'charset' => 'utf8',]);
                        $database_tools->delete("proxies_multi_sources", ["id" => $current_proxy["id"]]);
                        $GLOBALS["logger_Bolsar_Bonds_Monitor"]->info('PROXY DELETED : ' . $current_proxy["proxy"]);
                        $GLOBALS["logger_Bolsar_Bonds_Monitor"]->info('Waiting ' . $waiting_time_after_failure . ' seconds...');
                        sleep($waiting_time_after_failure);
                        //            }elseif(strpos($data, 'Negociables') !== false){               
                        //                $GLOBALS["logger_Bolsar_Bonds_Monitor"]->info('WARNING !!');
                        //                $GLOBALS["logger_Bolsar_Bonds_Monitor"]->info('No Bonds in this page');
                } else {
                        $download_success = TRUE;
                        $GLOBALS["logger_Bolsar_Bonds_Monitor"]->info('Resulting page size = ' . strlen($data));
                        $GLOBALS["logger_Bolsar_Bonds_Monitor"]->info('SUCCESS');
                }
                $attempt++;
        }
        curl_close($curl);
        $GLOBALS["logger_Bolsar_Bonds_Monitor"]->info('  END Download_Bolsar_Bonds_Monitor()');
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/khalifaAPI/logs/bolsar_bonds_monitor-downloads/' . $GLOBALS["logger_Bolsar_Bonds_download_counter"] . '.html', $data);
        $GLOBALS["logger_Bolsar_Bonds_download_counter"]++;
        return $data;
}
function Download_euronext_CA_Monitor($url)
{
        $GLOBALS["logger_euronext_CA_Monitor"]->info('--------------------------- URL DOWNLOADING ID : ' . $GLOBALS["logger_euronextcamonitor_download_counter"] . '------------------------------');
        $GLOBALS["logger_euronext_CA_Monitor"]->info('');
        $GLOBALS["logger_euronext_CA_Monitor"]->info('');
        $GLOBALS["logger_euronext_CA_Monitor"]->info('  START Download_euronext_CA_Monitor()');
        $GLOBALS["logger_euronext_CA_Monitor"]->info('url :' . $url);
        $curl = curl_init();
        $timeout = 30;
        $header[0] = "Accept: application/json, text/javascript, */*";
        //$header[0].= "text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5";
        //$header[] = "Cache-Control: max-age=0";
        $header[] = "Connection: keep-alive";
        //$header[] = "Keep-Alive: 300";
        //$header[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
        $header[] = "Accept-Language: en-us,en;q=0.5";
        $header[] = "Cookie: __utma=42729265.981042069.1462810763.1518734549.1518804546.1065; __utmz=42729265.1518013260.1062.42.utmcsr=google|utmccn=(organic)|utmcmd=organic|utmctr=https://www.euronext.com/fr/cpr/a2micile-europe-projet-doffre-publique-de-retrait-suivie-dun-retrait-obligatoire-sur-a2micile-eu; cookie-agreed-en=2; cookie-agreed-fr=2; TS01a5de3f=015c8de707b819dcee06791e0572330beeabb8113d07708d221a5e8ae1b4c7a22744873ca2; __utmc=42729263";
        //$header[] = "Pragma: ";
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, TRUE);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:7.0.1) Gecko/20100101 Firefox/7.0.12011-10-16");
        curl_setopt($curl, CURLOPT_REFERER, "https://www.euronext.com/en/equities/directory");
        curl_setopt($curl, CURLOPT_ENCODING, "gzip,deflate,br");
        curl_setopt($curl, CURLOPT_AUTOREFERER, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_VERBOSE, true); // to show errors
        $download_success = FALSE;
        while (!$download_success) {
                $current_proxy = Get_proxy_from_db();
                curl_setopt($curl, CURLOPT_PROXY, $current_proxy["proxy"]);
                $data = curl_exec($curl);
                $GLOBALS["logger_euronext_CA_Monitor"]->info('Using PROXY: ' . $current_proxy["proxy"]);
                if (
                        curl_error($curl) or
                        empty($data) or
                        strlen($data) == 0 or
                        strpos($data, 'Forbidden') !== false or
                        strpos($data, 'Backend not available') !== false or
                        strpos($data, 'Bad Request') !== false or
                        strpos($data, 'ERROR') !== false or
                        strpos($data, '500 Internal Server Error') !== false or
                        strpos($data, '503 Service') !== false or
                        strpos($data, 'Proxy Error') !== false
                ) {
                        $GLOBALS["logger_euronext_CA_Monitor"]->info('ERROR: ' . curl_error($curl));
                        $GLOBALS["logger_euronext_CA_Monitor"]->info('Resulting page size = ' . strlen($data));
                        //delete this proxy from table
                        $database_tools = new medoo(['database_type' => 'mysql', 'database_name' => DB_DATABASE_TOOLS, 'server' => DB_HOST, 'username' => DB_USER, 'password' => DB_PASSWORD, 'charset' => 'utf8',]);
                        $database_tools->delete("proxies_multi_sources", ["id" => $current_proxy["id"]]);
                        $GLOBALS["logger_euronext_CA_Monitor"]->info('PROXY DELETED : ' . $current_proxy["proxy"]);
                } else {
                        $download_success = TRUE;
                        $GLOBALS["logger_euronext_CA_Monitor"]->info('Resulting page size = ' . strlen($data));
                        $GLOBALS["logger_euronext_CA_Monitor"]->info('SUCCESS');
                }
        }
        curl_close($curl);
        $GLOBALS["logger_euronext_CA_Monitor"]->info('  END Download_euronext_CA_Monitor()');
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/khalifaAPI/logs/euronext_ca_monitor-downloads/' . $GLOBALS["logger_euronextcamonitor_download_counter"] . '.html', $data);
        $GLOBALS["logger_euronextcamonitor_download_counter"]++;
        return $data;
}
function Download_KASE($url)
{
        $GLOBALS["logger_KASE"]->info('--------------------------- URL DOWNLOADING ID : ' . $GLOBALS["logger_KASE_download_counter"] . '------------------------------');
        $GLOBALS["logger_KASE"]->info('');
        $GLOBALS["logger_KASE"]->info('');
        $GLOBALS["logger_KASE"]->info('  START Download_KASE_using_proxy_curl_delete_bad_proxy()');
        $GLOBALS["logger_KASE"]->info('url :' . $url);
        $curl = curl_init();
        $timeout = 30;
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_AUTOREFERER, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_VERBOSE, true); // to show errors
        $download_success = FALSE;
        while (!$download_success) {
                //20190408: i found these lines commented which led to undefined$current_proxy array
                $current_proxy = Get_proxy_from_db();
                //20190408: also foudn here curl_setopt as variable not function
                curl_setopt($curl, CURLOPT_PROXY, $current_proxy["proxy"]);
                $data = curl_exec($curl);
                $GLOBALS["logger_KASE"]->info('Using PROXY: ' . $current_proxy["proxy"]);
                if (
                        curl_error($curl) or
                        empty($data) or
                        strlen($data) == 0 or
                        strpos($data, 'Forbidden') !== false or
                        strpos($data, 'Backend not available') !== false or
                        strpos($data, 'Bad Request') !== false or
                        strpos($data, 'ERROR') !== false or
                        strpos($data, '500 Internal Server Error') !== false or
                        strpos($data, '503 Service') !== false or
                        strpos($data, 'Proxy Error') !== false
                ) {
                        $GLOBALS["logger_KASE"]->info('ERROR: ' . curl_error($curl));
                        $GLOBALS["logger_KASE"]->info('Resulting page size = ' . strlen($data));
                        //delete this proxy from table
                        $database_tools = new medoo(['database_type' => 'mysql', 'database_name' => DB_DATABASE_TOOLS, 'server' => DB_HOST, 'username' => DB_USER, 'password' => DB_PASSWORD, 'charset' => 'utf8',]);
                        $database_tools->delete("proxies_multi_sources", ["id" => $current_proxy["id"]]);
                        $GLOBALS["logger_KASE"]->info('PROXY DELETED : ' . $current_proxy["proxy"]);
                } else {
                        $download_success = TRUE;
                        $GLOBALS["logger_KASE"]->info('Resulting page size = ' . strlen($data));
                        $GLOBALS["logger_KASE"]->info('SUCCESS');
                }
        }
        curl_close($curl);
        $GLOBALS["logger_KASE"]->info('  END Download_KASE_using_proxy_curl_delete_bad_proxy()');
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/khalifaAPI/logs/KASE-downloads/' . $GLOBALS["logger_KASE_download_counter"] . '.html', $data);
        $GLOBALS["logger_KASE_download_counter"]++;
        return $data;
}
function Download_bmv_com_mx_using_proxy_curl_delete_bad_proxy($url)
{
        $GLOBALS["logger_bmv_com_mx"]->info('--------------------------- URL DOWNLOADING ID : ' . $GLOBALS["logger_bmv_com_mx_download_counter"] . '------------------------------');
        $GLOBALS["logger_bmv_com_mx"]->info('');
        $GLOBALS["logger_bmv_com_mx"]->info('');
        $GLOBALS["logger_bmv_com_mx"]->info('  START Download_bmv_com_mx_using_proxy_curl_delete_bad_proxy()');
        $GLOBALS["logger_bmv_com_mx"]->info('url :' . $url);
        $curl = curl_init();
        $timeout = 30;
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_AUTOREFERER, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_VERBOSE, true); // to show errors
        $download_success = FALSE;
        while (!$download_success) {
                $current_proxy = Get_proxy_from_db();
                //curl_setopt($curl, CURLOPT_PROXY, $current_proxy["proxy"]);
                $data = curl_exec($curl);
                //                $GLOBALS["logger_bmv_com_mx"]->info('Using PROXY: ' . $current_proxy["proxy"]);               
                sleep(10);
                if (
                        curl_error($curl) or
                        empty($data) or
                        strlen($data) == 0 or
                        strpos($data, 'Forbidden') !== false or
                        strpos($data, 'Backend not available') !== false or
                        strpos($data, 'Bad Request') !== false or
                        strpos($data, 'ERROR') !== false or
                        strpos($data, '500 Internal Server Error') !== false or
                        strpos($data, '503 Service') !== false or
                        strpos($data, '404 Not Found') !== false or (strpos($data, 'BmvJsonGeneric') !== false and strpos($data, 'for(;;);({') == false) or
                        strpos($data, 'Service unavailable') !== false or
                        strpos($data, 'Proxy Error') !== false
                ) {
                        $GLOBALS["logger_bmv_com_mx"]->info('ERROR: ' . curl_error($curl));
                        $GLOBALS["logger_bmv_com_mx"]->info('Resulting page size = ' . strlen($data));
                        //delete this proxy from table
                        //                        $database_tools = new medoo(['database_type' => 'mysql', 'database_name' => DB_DATABASE_TOOLS, 'server' => DB_HOST, 'username' => DB_USER, 'password' => DB_PASSWORD, 'charset' => 'utf8', ]);
                        //                        $database_tools->delete("proxies_multi_sources", ["id" => $current_proxy["id"]]);
                        //                        $GLOBALS["logger_bmv_com_mx"]->info('PROXY DELETED : '.$current_proxy["proxy"]);                    	
                } else {
                        $download_success = TRUE;
                        $GLOBALS["logger_bmv_com_mx"]->info('Resulting page size = ' . strlen($data));
                        $GLOBALS["logger_bmv_com_mx"]->info('SUCCESS');
                }
        }
        curl_close($curl);
        $GLOBALS["logger_bmv_com_mx"]->info('  END Download_bmv_com_mx_using_proxy_curl_delete_bad_proxy()');
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/khalifaAPI/logs/MexicoSOMonitor-downloads/' . $GLOBALS["logger_bmv_com_mx_download_counter"] . '.html', $data);
        $GLOBALS["logger_bmv_com_mx_download_counter"]++;
        return $data;
}
function Download_zonebourse_using_proxy_curl_delete_bad_proxy($url)
{
        $GLOBALS["logger"]->info('  START Download_zonebourse()');
        $GLOBALS["logger"]->info('url :' . $url);
        $curl = curl_init();
        $timeout = 30;
        curl_setopt($curl, CURLOPT_URL, $url);
        $headers_array = array(
                'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                'Accept-Encoding: gzip, deflate',
                'Accept-Language: en-US,en;q=0.5',
                'Connection: keep-alive',
                'Cookie: iStreamV3=on; pv_r0_date=2018-02-22; pv_r0=0; termtype=none; Wysistat=0.7891492174906691_1519292560812%A74%A71519292560812%A72%A71519257626%A70.3804511545687781_1519172893872; L1819=1.1519259293884; __gads=ID=bae91e66e617b11b:T=1519172892:S=ALNI_MYnzgd0k8-sEMCB4L6jVxZvPP4zTw; __utma=206525848.2032659648.1519172895.1519172895.1519292561.2; __utmz=206525848.1519172895.1.1.utmcsr=(direct)|utmccn=(direct)|utmcmd=(none); __utmv=206525848.|1=User%20Type=Visitor=1^4=Edition=fr_FR=1; __qca=P0-441625012-1519172895168; PHPSESSID=v1cdug98imrmptlqe4cm30nrc3; __utmc=206525848; StayOn=NO; __utmb=206525848.0.10.1519292561; __utmt=1',
                //'Upgrade-Insecure-Requests: 1', // this one caused some odd results 
                'User-Agent: Mozilla/5.0 (Windows NT 6.3; Win64; x64; rv:59.0) Gecko/20100101 Firefox/59.0'
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers_array);
        curl_setopt($curl, CURLOPT_ENCODING, "gzip");
        curl_setopt($curl, CURLOPT_AUTOREFERER, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_VERBOSE, true); // to show errors
        $download_success = FALSE;
        while (!$download_success) {
                $current_proxy = Get_proxy_from_db();
                curl_setopt($curl, CURLOPT_PROXY, $current_proxy["proxy"]);
                $data = curl_exec($curl);
                //$GLOBALS["logger"]->info('Headers: ' . curl_getinfo($curl, CURLINFO_HEADER_OUT));
                if (empty($data)) {
                        $GLOBALS["logger"]->info('');
                        $GLOBALS["logger"]->info('ERROR: ' . curl_error($curl));
                        $GLOBALS["logger"]->info('');
                        //delete this proxy from table
                        $database_tools = new medoo(['database_type' => 'mysql', 'database_name' => DB_DATABASE_TOOLS, 'server' => DB_HOST, 'username' => DB_USER, 'password' => DB_PASSWORD, 'charset' => 'utf8',]);
                        $database_tools->delete("proxies_multi_sources", ["id" => $current_proxy["id"]]);
                        $GLOBALS["logger"]->info('PROXY DELETED : ' . $current_proxy["proxy"]);
                        sleep(2); // if error, wait 2 seconds and try again
                } else {
                        $download_success = TRUE;
                        $GLOBALS["logger"]->info('SUCCESS');
                }
        }
        curl_close($curl);
        $GLOBALS["logger"]->info('  END Download_zonebourse()');
        return $data;
}
// this one also worked with zonebourse but it was not stable
function Download_using_proxy_curl_delete_bad_proxy($url)
{
        $GLOBALS["logger"]->info('Download_using_proxy_curl : ' . $url);
        $curl = curl_init();
        $timeout = 30;
        $header[0] = "Accept: application/json, text/javascript, */*";
        $header[0] .= "text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5";
        $header[] = "Connection: keep-alive";
        $header[] = "Accept-Language: en-us,en;q=0.5";
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.3; Win64; x64; rv:59.0) Gecko/20100101 Firefox/59.0");
        curl_setopt($curl, CURLOPT_ENCODING, "gzip,deflate,br");
        curl_setopt($curl, CURLOPT_AUTOREFERER, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_VERBOSE, true); // to show errors	
        $download_success = FALSE;
        while (!$download_success) {
                $current_proxy = Get_proxy_from_db();
                curl_setopt($curl, CURLOPT_PROXY, $current_proxy["proxy"]);
                $data = curl_exec($curl);
                if (empty($data)) {
                        $GLOBALS["logger"]->info('Download_using_proxy_curl_delete_bad_proxy : ERROR : ' . curl_error($curl));
                        //delete this proxy from table
                        $database_tools = new medoo(['database_type' => 'mysql', 'database_name' => DB_DATABASE_TOOLS, 'server' => DB_HOST, 'username' => DB_USER, 'password' => DB_PASSWORD, 'charset' => 'utf8',]);
                        $database_tools->delete("proxies_multi_sources", ["id" => $current_proxy["id"]]);
                        $GLOBALS["logger"]->info('Download_using_proxy_curl_delete_bad_proxy... PROXY DELETED : ' . $current_proxy["proxy"]);
                } else {
                        $download_success = TRUE;
                        $GLOBALS["logger"]->info('Download_using_proxy_curl_delete_bad_proxy : SUCCESS');
                        return $data;
                }
        }
        curl_close($curl);
}
function Download_euronext_page_using_curl($url, $iDisplayStart_post_parameter = NULL, $secho_post_parameter = NULL)
{
        $GLOBALS["logger"]->info('Download_euronext_page_using_curl : ' . $url);
        $curl = curl_init();
        $timeout = 30;
        $header[0] = "Accept: application/json, text/javascript, */*";
        //$header[0].= "text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5";
        //$header[] = "Cache-Control: max-age=0";
        $header[] = "Connection: keep-alive";
        //$header[] = "Keep-Alive: 300";
        //$header[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
        $header[] = "Accept-Language: en-us,en;q=0.5";
        $header[] = "Cookie: __utma=42729265.981042069.1462810763.1518734549.1518804546.1065; __utmz=42729265.1518013260.1062.42.utmcsr=google|utmccn=(organic)|utmcmd=organic|utmctr=https://www.euronext.com/fr/cpr/a2micile-europe-projet-doffre-publique-de-retrait-suivie-dun-retrait-obligatoire-sur-a2micile-eu; cookie-agreed-en=2; cookie-agreed-fr=2; TS01a5de3f=015c8de707b819dcee06791e0572330beeabb8113d07708d221a5e8ae1b4c7a22744873ca2; __utmc=42729263";
        //$header[] = "Pragma: ";
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, TRUE);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:7.0.1) Gecko/20100101 Firefox/7.0.12011-10-16");
        curl_setopt($curl, CURLOPT_REFERER, "https://www.euronext.com/en/equities/directory");
        curl_setopt($curl, CURLOPT_ENCODING, "gzip,deflate,br");
        curl_setopt($curl, CURLOPT_AUTOREFERER, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_VERBOSE, true); // to show errors
        $post_param = array(
                "bSortable_0" => "true",
                "bSortable_1" => "false",
                "bSortable_2" => "false",
                "bSortable_3" => "false",
                "bSortable_4" => "false",
                "bSortable_5" => "false",
                "bSortable_6" => "false",
                "iColumns" => "7",
                "iDisplayLength" => "1000",
                "iSortCol_0" => "0",
                "iSortingCols" => "1",
                "sColumns" => "",
                "sSortDir_0" => "asc"
        );
        if (!empty($iDisplayStart_post_parameter) or !empty($secho_post_parameter)) {
                // a page number was provided so add it to the POST parameters
                $post_param["iDisplayStart"] = $iDisplayStart_post_parameter;
                $post_param["sEcho"] = $secho_post_parameter;
                $post_param_as_string = http_build_query($post_param);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $post_param_as_string);
        } else {
                // page number was not provided
                // this means that this may be any page requsted from euronext website so no need to
                // post anything
        }
        $download_success = FALSE;
        while (!$download_success) {
                $current_proxy = Get_proxy_from_db();
                //curl_setopt($curl, CURLOPT_PROXY, Get_proxy_from_db());
                curl_setopt($curl, CURLOPT_PROXY, $current_proxy["proxy"]);
                $data = curl_exec($curl);
                if (empty($data)) {
                        $GLOBALS["logger"]->info('Download_euronext_page_using_curl : ERROR : ' . curl_error($curl));
                        //delete this proxy from table
                        $database_tools = new medoo(['database_type' => 'mysql', 'database_name' => DB_DATABASE_TOOLS, 'server' => DB_HOST, 'username' => DB_USER, 'password' => DB_PASSWORD, 'charset' => 'utf8',]);
                        $database_tools->delete("proxies_multi_sources", ["id" => $current_proxy["id"]]);
                        $GLOBALS["logger"]->info('Download_euronext... PROXY DELETED : ' . $current_proxy["proxy"]);
                } else {
                        $download_success = TRUE;
                        $GLOBALS["logger"]->info('Download_euronext_page_using_curl : SUCCESS');
                        return $data;
                }
        }
        curl_close($curl);
}
function Update_proxies_table_from_multi_sources($sources = array("free-proxy-list.net", "spys.one"))
{
        $GLOBALS["logger"]->info("     START Update_proxies_table_from_multi_sources");
        $all_proxies_from_all_sources = array();
        foreach ($sources as $source) {
                switch ($source) {
                        case "sslproxies.org":
                                $results = Get_proxies_from_sslproxies_org();
                                //                    var_dump($results);
                                if ($results["success"]) {
                                        //                        var_dump($results["proxies"]);
                                        $all_proxies_from_all_sources = array_merge($all_proxies_from_all_sources, $results["proxies"]);
                                }
                                break;
                        case "free-proxy-list.net":
                                $results = Get_proxies_from_freeproxylist_net();
                                //                    var_dump($results);
                                if ($results["success"]) {
                                        //                        var_dump($results["proxies"]);
                                        $all_proxies_from_all_sources = array_merge($all_proxies_from_all_sources, $results["proxies"]);
                                }
                                break;
                        case "socks-proxy.net":
                                $results = Get_proxies_from_socksproxy_net();
                                //                    var_dump($results);
                                if ($results["success"]) {
                                        //                        var_dump($results["proxies"]);
                                        $all_proxies_from_all_sources = array_merge($all_proxies_from_all_sources, $results["proxies"]);
                                }
                                break;
                        case "spys.one":
                                $results = Get_proxies_from_spys_one();
                                //                    var_dump($results);
                                if ($results["success"]) {
                                        //                        var_dump($results["proxies"]);
                                        $all_proxies_from_all_sources = array_merge($all_proxies_from_all_sources, $results["proxies"]);
                                }
                                break;
                }
        }
        $output = array("success" => false, "message" => "");
        $database = new medoo([' database_type ' => ' mysql ', ' database_name ' => DB_DATABASE_TOOLS, ' server ' => DB_HOST, ' username ' => DB_USER, ' password ' => DB_PASSWORD, ' charset ' => ' utf8 ',]);
        $database->query("truncate table proxies_multi_sources");
        //    var_dump($all_proxies_from_all_sources);
        $query_results = $database->insert("proxies_multi_sources", $all_proxies_from_all_sources);
        if (count($query_results) < 1) {
                $output["message"] = "Error: proxies table not updated";
                $GLOBALS["logger"]->info("Error: proxies table not updated");
        } else {
                $output["success"] = true;
                $output["message"] = "Success: proxies table updated";
                $GLOBALS["logger"]->info("Success: proxies table updated");
        }
        $GLOBALS["logger"]->info("     END Update_proxies_table_from_multi_sources");
        return $output;
}
function Update_proxies_table_from_freeproxy()
{
        $proxies_list = array();
        $proxies_page = false;
        while (empty($proxies_page)) {
                $proxies_page = Download_using_Curl("https://free-proxy-list.net/anonymous-proxy.html");
                if (!empty($proxies_page)) {
                        $sponge_bob = new simple_html_dom();
                        $sponge_bob->load($proxies_page);
                        $trs = $sponge_bob->find(' tr ');
                        $i = 0;
                        foreach ($trs as $tr) {
                                if ($i == 0 or $i > 99) { // to avoid trs in header and footer
                                        $i++;
                                        continue;
                                } else {
                                        if (!empty($tr)) {
                                                $tds = $tr->find(' td ');
                                                $ip = $tds[0]->innertext;
                                                $port = $tds[1]->innertext;
                                                array_push($proxies_list, array("proxy" => $ip . ":" . $port));
                                                $i++;
                                        } else {
                                                $GLOBALS["logger"]->info("Update_proxies_table_from_freeproxy: a tr is empty");
                                        }
                                }
                        }
                } else {
                        $GLOBALS["logger"]->info("Update_proxies_table_from_freeproxy: proxies page is empty");
                }
        }
        $output = array("success" => false, "message" => "");
        $database = new medoo([' database_type ' => ' mysql ', ' database_name ' => DB_DATABASE_TOOLS, ' server ' => DB_HOST, ' username ' => DB_USER, ' password ' => DB_PASSWORD, ' charset ' => ' utf8 ',]);
        $database->query("truncate table proxies");
        $query_results = $database->insert("proxies", $proxies_list);
        if (count($query_results) < 1) {
                $output["message"] = "Error: proxies table not updated";
                $GLOBALS["logger"]->info("Update_proxies_table_from_freeproxy: Error: proxies table not updated");
        } else {
                $output["success"] = true;
                $output["message"] = "Success: proxies table updated";
                $GLOBALS["logger"]->info("Update_proxies_table_from_freeproxy: Success: proxies table updated");
        }
        return $output;
}
function Get_proxies_from_spys_one()
{
        $GLOBALS["logger"]->info("     START Get_proxies_from_spys_one");
        $proxies_list = array();
        $proxies_page = false;
        $results = array("success" => false, "proxies" => NULL);
        $trials = 0;
        while (empty($proxies_page and $trials < 20)) {
                $post_param = array(
                        "xpp" => "2",
                        "xf1" => "1",
                        "xf2" => "0",
                        "xf4" => "3",
                        "xf5" => "0"
                );
                $url = "http://spys.one/en/anonymous-proxy-list/";
                $proxies_page = Download_using_snoopy($url, $post_param);
                echo $proxies_page;
                exit;
                if (!empty($proxies_page)) {
                        $sponge_bob = new simple_html_dom();
                        $sponge_bob->load($proxies_page);
                        $tags = $sponge_bob->find('font.spy14');
                        foreach ($tags as $tag) {
                                if (!empty($tag)) {
                                        preg_match_all('/\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}/', $tag->outertext, $ip_matches);
                                        if (!empty($ip_matches[0])) {
                                                $proxy_string = $ip_matches[0][0] . ': 80 ';
                                                array_push($proxies_list, array("proxy" => $proxy_string));
                                        }
                                } else {
                                        $GLOBALS["logger"]->info("ERROR : IP tag is empty");
                                }
                        }
                        if (count($proxies_list) > 0) {
                                $results["success"] = true;
                                $results["proxies"] = $proxies_list;
                        }
                } else {
                        $GLOBALS["logger"]->info("proxies page is empty");
                }
                $trials++;
        }
        $GLOBALS["logger"]->info("     END Get_proxies_from_spys_one");
        return $results;
}
function Get_proxies_from_freeproxylist_net()
{
        $GLOBALS["logger"]->info("     START Get_proxies_from_freeproxylist_net");
        $proxies_list = array();
        $proxies_page = false;
        $results = array("success" => false, "proxies" => NULL);
        $trials = 0;
        while (empty($proxies_page and $trials < 20)) {
                $proxies_page = Download_using_Curl("https://free-proxy-list.net/anonymous-proxy.html");
                if (!empty($proxies_page)) {
                        $sponge_bob = new simple_html_dom();
                        $sponge_bob->load($proxies_page);
                        $trs = $sponge_bob->find(' tr ');
                        $i = 0;
                        foreach ($trs as $tr) {
                                if ($i == 0 or $i > 99) { // to avoid trs in header and footer
                                        $i++;
                                        continue;
                                } else {
                                        if (!empty($tr)) {
                                                $tds = $tr->find(' td ');
                                                $ip = $tds[0]->innertext;
                                                $port = $tds[1]->innertext;
                                                array_push($proxies_list, array("proxy" => $ip . ":" . $port));
                                                $i++;
                                        } else {
                                                $GLOBALS["logger"]->info("ERROR : a tr is empty");
                                        }
                                }
                        }
                        if (count($proxies_list) > 0) {
                                $results["success"] = true;
                                $results["proxies"] = $proxies_list;
                        }
                } else {
                        $GLOBALS["logger"]->info("proxies page is empty");
                }
                $trials++;
        }
        $GLOBALS["logger"]->info("     END Get_proxies_from_freeproxylist_net");
        return $results;
}
function Get_proxies_from_sslproxies_org()
{
        $GLOBALS["logger"]->info("     START Get_proxies_from_sslproxies_org");
        $proxies_list = array();
        $proxies_page = false;
        $results = array("success" => false, "proxies" => NULL);
        $trials = 0;
        while (empty($proxies_page and $trials < 20)) {
                $proxies_page = Download_using_Curl("https://www.sslproxies.org/");
                if (!empty($proxies_page)) {
                        $sponge_bob = new simple_html_dom();
                        $sponge_bob->load($proxies_page);
                        $trs = $sponge_bob->find(' tr ');
                        $i = 0;
                        foreach ($trs as $tr) {
                                if ($i == 0 or $i > 99) { // to avoid trs in header and footer
                                        $i++;
                                        continue;
                                } else {
                                        if (!empty($tr)) {
                                                $tds = $tr->find(' td ');
                                                $ip = $tds[0]->innertext;
                                                $port = $tds[1]->innertext;
                                                array_push($proxies_list, array("proxy" => $ip . ":" . $port));
                                                $i++;
                                        } else {
                                                $GLOBALS["logger"]->info("ERROR : a tr is empty");
                                        }
                                }
                        }
                        if (count($proxies_list) > 0) {
                                $results["success"] = true;
                                $results["proxies"] = $proxies_list;
                        }
                } else {
                        $GLOBALS["logger"]->info("proxies page is empty");
                }
                $trials++;
        }
        $GLOBALS["logger"]->info("     END Get_proxies_from_sslproxies_org");
        return $results;
}
function Get_proxies_from_socksproxy_net()
{
        $GLOBALS["logger"]->info("     START Get_proxies_from_socksproxy_net");
        $proxies_list = array();
        $proxies_page = false;
        $results = array("success" => false, "proxies" => NULL);
        $trials = 0;
        while (empty($proxies_page and $trials < 20)) {
                $proxies_page = Download_using_Curl("https://www.socks-proxy.net/");
                if (!empty($proxies_page)) {
                        $sponge_bob = new simple_html_dom();
                        $sponge_bob->load($proxies_page);
                        $trs = $sponge_bob->find(' tr ');
                        $i = 0;
                        foreach ($trs as $tr) {
                                if ($i == 0 or $i > 99) { // to avoid trs in header and footer
                                        $i++;
                                        continue;
                                } else {
                                        if (!empty($tr)) {
                                                $tds = $tr->find(' td ');
                                                $ip = $tds[0]->innertext;
                                                $port = $tds[1]->innertext;
                                                array_push($proxies_list, array("proxy" => $ip . ":" . $port));
                                                $i++;
                                        } else {
                                                $GLOBALS["logger"]->info("ERROR : a tr is empty");
                                        }
                                }
                        }
                        if (count($proxies_list) > 0) {
                                $results["success"] = true;
                                $results["proxies"] = $proxies_list;
                        }
                } else {
                        $GLOBALS["logger"]->info("proxies page is empty");
                }
                $trials++;
        }
        $GLOBALS["logger"]->info("     END Get_proxies_from_socksproxy_net");
        return $results;
}
function Get_anonyproxy_from_freeproxy()
{
        $proxies_list = array();
        $proxies_page = Download_using_Curl("https://free-proxy-list.net/anonymous-proxy.html");
        if (!empty($proxies_page)) {
                $sponge_bob = new simple_html_dom();
                $sponge_bob->load($proxies_page);
                $trs = $sponge_bob->find(' tr ');
                $i = 0;
                foreach ($trs as $tr) {
                        if ($i == 0 or $i > 99) { // to avoid trs in header and footer
                                $i++;
                                continue;
                        } else {
                                if (!empty($tr)) {
                                        $tds = $tr->find(' td ');
                                        $ip = $tds[0]->innertext;
                                        $port = $tds[1]->innertext;
                                        array_push($proxies_list, $ip . ":" . $port);
                                        $i++;
                                } else {
                                        $GLOBALS["logger"]->info("Get_anonyproxy_from_freeproxy: a tr is empty");
                                }
                        }
                }
        } else {
                $GLOBALS["logger"]->info("Get_anonyproxy_from_freeproxy: proxies page is empty");
        }
        $current_proxy = $proxies_list[rand(0, 20)];
        $GLOBALS["logger"]->info("Get_anonyproxy_from_freeproxy: PROXY = " . $current_proxy);
        return $current_proxy;
}
function Download_using_Curl($url)
{
        $GLOBALS["logger"]->info("Download_using_Curl : " . $url);
        $curl = new Curl();
        $Curl_results = "";
        $is_page_downloaded = false;
        $download_trials_counter = 1;
        while ($is_page_downloaded == false) {
                $curl->get($url);
                if ($curl->error) { //Page download error
                        // echo ' Error: ' . $curl->errorCode . ': ' . $curl->errorMessage;
                        $download_trials_counter++;
                        $GLOBALS["logger"]->info("Download_using_Curl : ERROR Code : " . $curl->errorCode . " | ERROR Message : " . $curl->errorMessage);
                        $GLOBALS["logger"]->info("Download_using_Curl : Retrying... : (" . $download_trials_counter . ")");
                } else { //page succefully downloaded
                        // echo ' Response: ' . "\n";
                        $GLOBALS["logger"]->info("Download_using_Curl : Page downloaded");
                        $Curl_results = $curl->response;
                        $is_page_downloaded = true;
                }
        }
        $curl->close();
        return $Curl_results;
}
function Get_random_proxy_multiproxy()
{
        $list = file_get_contents("http://multiproxy.org/txt_all/proxy.txt");
        $proxies_array = preg_split(' / \s + / ', $list);
        $random_proxy_key = array_rand($proxies_array);
        return $proxies_array[$random_proxy_key];
}




function Download_using_snoopy($url, $post_param = NULL)
{
        $results = NULL;
        $trials = 0;
        $snoopy = new Snoopy;
        $all_good = false;
        while (!$all_good && $trials < 10) {
                $trials++;
                $GLOBALS["logger"]->info("Download_using_snoopy | Trial : " . $trials);
                if ($snoopy->submit($url, $post_param)) {
                        preg_match(' / 200 / ', $snoopy->response_code, $result);
                        if (empty($result)) {
                                $GLOBALS["logger"]->info(" Download_using_snoopy : Response code =  " . $snoopy->response_code);
                        } else {
                                $all_good = true;
                                $GLOBALS["logger"]->info("Download_using_snoopy : Response code: " . $snoopy->response_code);
                                return $snoopy->results;
                        }
                } else {
                        $GLOBALS["logger"]->info("Download_using_snoopy : error while fetching document: " . $snoopy->error);
                }
        }
}
function build_table($array)
{
        if (!empty($array)) {
                // start table
                $html = ' < table > ';
                // header row
                $html .= ' < tr > ';
                foreach ($array[0] as $key => $value) {
                        $html .= ' < th > ' . $key . ' < / th > ';
                }
                $html .= ' < / tr > ';
                // data rows
                foreach ($array as $key => $value) {
                        $html .= ' < tr > ';
                        foreach ($value as $key2 => $value2) {
                                $html .= ' < td > ' . $value2 . ' < / td > ';
                        }
                        $html .= ' < / tr > ';
                }
                // finish table and return it
                $html .= ' < / table > ';
                return $html;
        } else {
                echo "Empty array";
        }
}
function Call_script_inside_project_with_post($script_file, $data)
{
        $site_url = Get_script_base_url();
        $curl = curl_init($site_url . ' / ' . $script_file);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
}
function Get_script_base_url()
{
        $url = $_SERVER[' REQUEST_URI ']; //returns the current URL
        $parts = explode(' / ', $url);
        $dir = $_SERVER[' SERVER_NAME'];
        for ($i = 0; $i < count($parts) - 1; $i++) {
                $dir .= $parts[$i] . "/";
        }
        return $dir;
}
function Write_progress_to_file($progress_value, $progress_file)
{
        $myfile = fopen($progress_file, "w");
        if ($myfile == false) {
                $GLOBALS["general-log"]->info("ERROR in opening progress file");
        } else {
                //$GLOBALS["general-log"]->info("Progress = ".$progress);
                fwrite($myfile, $progress_value);
                fclose($myfile);
        }
}
