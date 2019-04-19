<?php

ini_set('include_path', ini_get('include_path').';'.$_SERVER['DOCUMENT_ROOT'].'Euronext2018/khalifaclass/'.';'.$_SERVER['DOCUMENT_ROOT'].'Euronext2018/khalifaassets/');

//ini_set('include_path', ini_get('include_path').';'.$_SERVER['SERVER_NAME'].'/khalifaassets/');

include_once "MyLogPHP.class.php";

include_once "simple_html_dom.php";

include_once 'Snoopy.class.php';

include_once 'Curl.php';

include_once 'CaseInsensitiveArray.php';

include_once 'MultiCurl.php';

include_once 'medoo.php';

include_once 'config.php';

date_default_timezone_set('Africa/Casablanca'); // CDT

set_time_limit(86400);// 1 day max

//clear log file
Reset_file_according_to_size($_SERVER['DOCUMENT_ROOT'].'Euronext2018/log/khalifaAPI-logs.csv',30);

// Global logging variable
$GLOBALS["logger"] = new MyLogPHP($_SERVER['DOCUMENT_ROOT'].'Euronext2018/log/khalifaAPI-logs.csv');


function Reset_file_according_to_size($filename, $sizelimit_in_Mbytes){
    
    if (file_exists($filename) && filesize($filename) > ($sizelimit_in_Mbytes * 1000 * 1000)) {// if size is greater than 30 MB
        $fh = fopen($filename, 'w' );//Clear content
        fclose($fh);
        $GLOBALS["logger"]->info("Reset_file_according_to_size : Log cleared");
    }
}


function Download_using_proxy_curl_delete_bad_proxy($url)
{
        $GLOBALS["logger"]->info('Download_using_proxy_curl : ' . $url);
	$curl = curl_init();
	$timeout = 30;
        
	$header[0] = "Accept: application/json, text/javascript, */*";
	$header[0].= "text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5";
	//$header[] = "Cache-Control: max-age=0";
	$header[] = "Connection: keep-alive";
	//$header[] = "Keep-Alive: 300";
	//$header[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
	$header[] = "Accept-Language: en-us,en;q=0.5";
        //$header[] = "Cookie: __utma=42729265.981042069.1462810763.1518734549.1518804546.1065; __utmz=42729265.1518013260.1062.42.utmcsr=google|utmccn=(organic)|utmcmd=organic|utmctr=https://www.euronext.com/fr/cpr/a2micile-europe-projet-doffre-publique-de-retrait-suivie-dun-retrait-obligatoire-sur-a2micile-eu; cookie-agreed-en=2; cookie-agreed-fr=2; TS01a5de3f=015c8de707b819dcee06791e0572330beeabb8113d07708d221a5e8ae1b4c7a22744873ca2; __utmc=42729263";
	//$header[] = "Pragma: ";
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
	curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:7.0.1) Gecko/20100101 Firefox/7.0.12011-10-16");	
	curl_setopt($curl, CURLOPT_ENCODING, "gzip,deflate,br");
	curl_setopt($curl, CURLOPT_AUTOREFERER, true);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_VERBOSE, true);// to show errors
//	
        
	$download_success = FALSE;
	while (!$download_success) {
		$current_proxy = Get_proxy_from_db();
                curl_setopt($curl, CURLOPT_PROXY, $current_proxy["proxy"]);
		$data = curl_exec($curl);
                
                if (empty($data)) {
			$GLOBALS["logger"]->info('Download_euronext_page_using_curl : ERROR : ' . curl_error($curl));
                        //delete this proxy from table
                        $database_tools = new medoo(['database_type' => 'mysql', 'database_name' => DB_DATABASE_TOOLS, 'server' => DB_HOST, 'username' => DB_USER, 'password' => DB_PASSWORD, 'charset' => 'utf8', ]);
                        $database_tools->delete("proxies", ["id" => $current_proxy["id"]]);
                        $GLOBALS["logger"]->info('Download_euronext... PROXY DELETED : '.$current_proxy["proxy"]);
		}
		else {
			$download_success = TRUE;
			$GLOBALS["logger"]->info('Download_euronext_page_using_curl : SUCCESS');
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
        curl_setopt($curl, CURLOPT_VERBOSE, true);// to show errors
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
	}
	else {

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
                        $database_tools = new medoo(['database_type' => 'mysql', 'database_name' => DB_DATABASE_TOOLS, 'server' => DB_HOST, 'username' => DB_USER, 'password' => DB_PASSWORD, 'charset' => 'utf8', ]);
                        $database_tools->delete("proxies", ["id" => $current_proxy["id"]]);
                        $GLOBALS["logger"]->info('Download_euronext... PROXY DELETED : '.$current_proxy["proxy"]);
		}
		else {
			$download_success = TRUE;
			$GLOBALS["logger"]->info('Download_euronext_page_using_curl : SUCCESS');
			return $data;
		}
	}

	curl_close($curl);
}

function Update_proxies_table_from_freeproxy()
{
	$proxies_list = array();
        $proxies_page = false;
        while(empty($proxies_page)){
            $proxies_page = Download_using_Curl("https://free-proxy-list.net/anonymous-proxy.html");
            if (!empty($proxies_page)) {
                    $sponge_bob = new simple_html_dom();
                    $sponge_bob->load($proxies_page);
                    $trs = $sponge_bob->find('tr');
                    $i = 0;
                    foreach($trs as $tr) {
                            if ($i == 0 or $i > 99) { // to avoid trs in header and footer
                                    $i++;
                                    continue;
                            }
                            else {
                                    if (!empty($tr)) {
                                            $tds = $tr->find('td');
                                            $ip = $tds[0]->innertext;
                                            $port = $tds[1]->innertext;
                                            array_push($proxies_list, array("proxy"=>$ip.":".$port));
                                            $i++;
                                    }
                                    else {
                                            $GLOBALS["logger"]->info("Update_proxies_table_from_freeproxy: a tr is empty");
                                    }
                            }
                    }
            }
            else {
                    $GLOBALS["logger"]->info("Update_proxies_table_from_freeproxy: proxies page is empty");
            } 
        }
	
        
        $output = array("success"=>false,"message"=>"");
        $database = new medoo(['database_type' => 'mysql', 'database_name' => DB_DATABASE_TOOLS, 'server' => DB_HOST, 'username' => DB_USER, 'password' => DB_PASSWORD, 'charset' => 'utf8', ]);
        $database->query("truncate table proxies");
        $query_results = $database->insert("proxies",$proxies_list);
        if(count($query_results)<1){
            $output["message"] = "Error: proxies table not updated";
            $GLOBALS["logger"]->info("Update_proxies_table_from_freeproxy: Error: proxies table not updated");
        }else{
            $output["success"] = true;
            $output["message"] = "Success: proxies table updated";
            $GLOBALS["logger"]->info("Update_proxies_table_from_freeproxy: Success: proxies table updated");
        }
        return $output;
        
}


function Get_proxy_from_db(){
        $current_proxy = false;
        $database = new medoo(['database_type' => 'mysql', 'database_name' => DB_DATABASE_TOOLS, 'server' => DB_HOST, 'username' => DB_USER, 'password' => DB_PASSWORD, 'charset' => 'utf8', ]);
        while(empty($current_proxy)){
            $proxies_array = $database->query("select * from proxies")->fetchAll(PDO::FETCH_ASSOC);
            if(!empty($proxies_array) AND count($proxies_array) > 0){
                $current_proxy = $proxies_array[rand(0, (count($proxies_array) - 1))];
            }else{
                //if table is empty try to file it
                $GLOBALS["logger"]->info("Get_proxy_from_db: Proxies db is empty");
                Update_proxies_table_from_freeproxy();
            }
        }
        $GLOBALS["logger"]->info("Get_proxy_from_db: ".$current_proxy["proxy"]);
        return $current_proxy;

}



function Get_anonyproxy_from_freeproxy()
{
	$proxies_list = array();
	$proxies_page = Download_using_Curl("https://free-proxy-list.net/anonymous-proxy.html");
	if (!empty($proxies_page)) {
		$sponge_bob = new simple_html_dom();
		$sponge_bob->load($proxies_page);
		$trs = $sponge_bob->find('tr');
		$i = 0;
		foreach($trs as $tr) {
			if ($i == 0 or $i > 99) { // to avoid trs in header and footer
				$i++;
				continue;
			}
			else {
				if (!empty($tr)) {
					$tds = $tr->find('td');
					$ip = $tds[0]->innertext;
					$port = $tds[1]->innertext;
					array_push($proxies_list, $ip . ":" . $port);
					$i++;
				}
				else {
					$GLOBALS["logger"]->info("Get_anonyproxy_from_freeproxy: a tr is empty");
				}
			}
		}
	}
	else {
		$GLOBALS["logger"]->info("Get_anonyproxy_from_freeproxy: proxies page is empty");
	}
        $current_proxy = $proxies_list[rand(0, 20)];
        $GLOBALS["logger"]->info("Get_anonyproxy_from_freeproxy: PROXY = ".$current_proxy);
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

			// echo 'Error: ' . $curl->errorCode . ': ' . $curl->errorMessage;

			$download_trials_counter++;
			$GLOBALS["logger"]->info("Download_using_Curl : ERROR Code : " . $curl->errorCode . " | ERROR Message : " . $curl->errorMessage);
			$GLOBALS["logger"]->info("Download_using_Curl : Retrying... : (" . $download_trials_counter . ")");
		}
		else { //page succefully downloaded

			// echo 'Response:' . "\n";

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
	$proxies_array = preg_split('/\s+/', $list);
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
			preg_match('/200/', $snoopy->response_code, $result);
			if (empty($result)) {
				$GLOBALS["logger"]->info(" Download_using_snoopy : Response code =  " . $snoopy->response_code);
			}
			else {
				$all_good = true;
				$GLOBALS["logger"]->info("Download_using_snoopy : Response code: " . $snoopy->response_code);
				return $snoopy->results;
			}
		}
		else {
			$GLOBALS["logger"]->info("Download_using_snoopy : error while fetching document: " . $snoopy->error);
		}
	}
}

function build_table($array)
{
	if (!empty($array)) {

		// start table

		$html = '<table>';

		// header row

		$html.= '<tr>';
		foreach($array[0] as $key => $value) {
			$html.= '<th>' . $key . '</th>';
		}

		$html.= '</tr>';

		// data rows

		foreach($array as $key => $value) {
			$html.= '<tr>';
			foreach($value as $key2 => $value2) {
				$html.= '<td>' . $value2 . '</td>';
			}

			$html.= '</tr>';
		}

		// finish table and return it

		$html.= '</table>';
		return $html;
	}
	else {
		echo "Empty array";
	}
}
