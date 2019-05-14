<?php
ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'khalifaAPI' . DIRECTORY_SEPARATOR);
include_once 'libraries' . DIRECTORY_SEPARATOR . 'khalifaAPI.php';
// require_once 'libraries'.DIRECTORY_SEPARATOR.'Goutte'.DIRECTORY_SEPARATOR.'Client.php';
// require_once 'libraries'.DIRECTORY_SEPARATOR.'Symfony'.DIRECTORY_SEPARATOR.'Component'.DIRECTORY_SEPARATOR.'BrowserKit'.DIRECTORY_SEPARATOR.'Client.php';
// require_once 'libraries/Guzzle/autoload.php';
// echo getBaseUrl();
require 'vendor/autoload.php';
use Goutte\Client as GoutteClient;
use GuzzleHttp\Client as  GuzzleClient;
use GuzzleHttp\Handler\CurlHandler as CurlHandler;
use GuzzleHttp\HandlerStack as HandlerStack;
use GuzzleTor\Middleware as Middleware;


Get_proxies_from_spys_one();
exit;

getBolsarUsingGoutte();

//var_dump(Get_proxy_from_db());
// echo getBolsarUsingGoutte();
// echo getPerspektiva();
// Go to the symfony.com website



// // $client = new GoutteClient();
// // $client->setClient(new GuzzleClient(['proxy' => 'tcp://localhost:9151']));
// $crawler = $client->request('POST', $url);
// var_dump($crawler);

// getBolsarUsingGoutte();

// $post_param = array(
//     'ctl00_MainContentPlaceHolder_ScriptManager1_HiddenField' => ';;AjaxControlToolkit,+Version=3.5.51116.0,+Culture=neutral,+PublicKeyToken=28f01b0e84b6d53e:uk-UA:ab81b866-60eb-4f97-a962-1308435f4a86:de1feab2:fcf0e993:f2c8e708:720a52bf:f9cec9bc:589eaa30:698129cf:fb9b4c57:ccb96cf9',
//     '__EVENTTARGET' => 'ctl00$MainContentPlaceHolder$SetAll',
//     '__EVENTARGUMENT ' => ' ',
//     '__VIEWSTATE ' => 'wEPDwUKMTIwNTA0MTQwOA9kFgJmD2QWAgIDD2QWBAIGD2QWDAIKDw8WBB4EVGV4dAUCMTUeB0VuYWJsZWRnZGQCCw8PFgQfAAUCMzAfAWdkZAIMDw8WBB8ABQI1MB8BaGRkAg0PDxYCHwFnZGQCDg88KwANAQAPFggeC18hSXRlbUNvdW50AsMCHgtBbGxvd1BhZ2luZ2ceC18hRGF0YUJvdW5kZx4IUGFnZVNpemUCMmQWAmYPZBZmAgEPZBYeZg8PFgIfAAUBMWRkAgEPZBYCZg8PFgQfAAUMVUE0MDAwMTg1MTUxHgtOYXZpZ2F0ZVVybAUnfi9TZWN1cml0aWVzSW5mby5hc3B4P0lTSU49VUE0MDAwMTg1MTUxZGQCAg8PFgIfAAUGJm5ic3A7ZGQCAw8PFgIfAAUGMTg1MTUxZGQCBA8PFgIfAAUIMDAwMTM0ODBkZAIFDw8WAh8ABSnQnNGW0L3RltGB0YLQtdGA0YHRgtCy0L4g0KTRltC90LDQvdGB0ZbQsmRkAgYPDxYCHwAFvAHQntCx0LvRltCz0LDRhtGW0Y8g0LLQvdGD0YLRgNGW0YjQvdGW0YUg0LTQtdGA0LbQsNCy0L3QuNGFINC',
//     'ctl00$MainContentPlaceHolder$txtFrom' => '2019-04-25',
// );
// $crawler = $client->request('POST', 'http://fbp.com.ua/Trade/StockListPer.aspx', $post_param);

// echo $crawler->html();
function getBolsarUsingGoutte()
{
    $page_number = 1;
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
        '__VIEWSTATEGENERATOR' => '9D12FF9B',
        '__PREVIOUSPAGE' => '0Ft6dlY_tOalskzUBjYgWRZMogYCG6M6sXrnRhpq6h4sbGvZt9aXigyi-26eEkROZ5cNHbCWQgQE9xnn1GNUXp8mslcNoclr20rrBIO4zPKBg89R0',
        '__EVENTVALIDATION' => 'roGjeLH9UhKsICOGU5CVKqeFFiR7dqfdSN0FG3loAQxQ3yPZ+HPPZpFNMkBVsMF4Wvzj31XbwlrZ8D6iM6iVvxW7yVg3IrveI7aa7F8Sr1wsVW/PwMM8N35c37UyNAoDJhJcYQyxlHWooiR37jyaVLwx3VAtBpGvr/i4OeRJmhrDClqvT0fJmuXrkBtn2EDb6eO+rmVKYKDNe1+7rxcaDcTLZKkyqBgsa6j6HsP8al5LUluL0sTXntk/JhhRggjO59yAQ9Wu64q+HcV5MI7GEY+3iFzFf5Q6UfU6DNKIpibedkpHL8MKgQrLNo3DB8Su7dcudthrZDurWIruFCJWX5/8rS/DejG2mwySElkP5KGWf5B5',
        '__VIEWSTATEENCRYPTED' => '',
        '__ASYNCPOST' => 'true',
    );



    // //preparing Guzzle client with Tor
    // $GoutteClient = new GoutteClient();
    // $stack = new HandlerStack();
    // $stack->setHandler(new CurlHandler());
    // $stack->push(Middleware::tor('127.0.0.1:9150', '127.0.0.1:9151'));
    // $GuzzleClient = new GuzzleClient(['handler' => $stack]);
    // //pushing Tor guzzle client to Goutte
    // $GoutteClient->setClient($GuzzleClient);
    // $url = 'https://www.bolsar.com/Vistas/Investigaciones/Especies.aspx';
    // $crawler = $GoutteClient->request('POST', $url, $post_param);
    // var_dump($crawler);

    Get_proxies_from_spys_one();


    Update_proxies_table_from_multi_sources();

    $proxy = Get_proxy_from_db();
    // var_dump($proxy);
    //exit;
    $url = 'https://exchange-data.com';
    $client = new GoutteClient();
    $client->setClient(new GuzzleClient(['proxy' => $proxy['proxy']]));

    // $client->setClient(new GuzzleClient(['proxy' => 'socks5://127.0.0.1:9150']));
    $crawler = $client->request('POST', $url);
    echo     $crawler->html();





    //$page = $crawler->html();
    // $post_param = array(
    //     'ctl00_MainContentPlaceHolder_ScriptManager1_HiddenField' => ';;AjaxControlToolkit,+Version=3.5.51116.0,+Culture=neutral,+PublicKeyToken=28f01b0e84b6d53e:uk-UA:ab81b866-60eb-4f97-a962-1308435f4a86:de1feab2:fcf0e993:f2c8e708:720a52bf:f9cec9bc:589eaa30:698129cf:fb9b4c57:ccb96cf9',
    //     '__EVENTTARGET' => 'ctl00$MainContentPlaceHolder$SetAll',
    //     '__EVENTARGUMENT ' => ' ',
    //     '__VIEWSTATE ' => 'wEPDwUKMTIwNTA0MTQwOA9kFgJmD2QWAgIDD2QWBAIGD2QWDAIKDw8WBB4EVGV4dAUCMTUeB0VuYWJsZWRnZGQCCw8PFgQfAAUCMzAfAWdkZAIMDw8WBB8ABQI1MB8BaGRkAg0PDxYCHwFnZGQCDg88KwANAQAPFggeC18hSXRlbUNvdW50AsMCHgtBbGxvd1BhZ2luZ2ceC18hRGF0YUJvdW5kZx4IUGFnZVNpemUCMmQWAmYPZBZmAgEPZBYeZg8PFgIfAAUBMWRkAgEPZBYCZg8PFgQfAAUMVUE0MDAwMTg1MTUxHgtOYXZpZ2F0ZVVybAUnfi9TZWN1cml0aWVzSW5mby5hc3B4P0lTSU49VUE0MDAwMTg1MTUxZGQCAg8PFgIfAAUGJm5ic3A7ZGQCAw8PFgIfAAUGMTg1MTUxZGQCBA8PFgIfAAUIMDAwMTM0ODBkZAIFDw8WAh8ABSnQnNGW0L3RltGB0YLQtdGA0YHRgtCy0L4g0KTRltC90LDQvdGB0ZbQsmRkAgYPDxYCHwAFvAHQntCx0LvRltCz0LDRhtGW0Y8g0LLQvdGD0YLRgNGW0YjQvdGW0YUg0LTQtdGA0LbQsNCy0L3QuNGFINC',
    //     'ctl00$MainContentPlaceHolder$txtFrom' => $data_string,
    // );
    //C. Bonds
    // return $page;
}
function getPerspektivaUsingGoutte($data_string)
{
    $client = new GoutteClient();
    $post_param = array(
        'ctl00_MainContentPlaceHolder_ScriptManager1_HiddenField' => ';;AjaxControlToolkit,+Version=3.5.51116.0,+Culture=neutral,+PublicKeyToken=28f01b0e84b6d53e:uk-UA:ab81b866-60eb-4f97-a962-1308435f4a86:de1feab2:fcf0e993:f2c8e708:720a52bf:f9cec9bc:589eaa30:698129cf:fb9b4c57:ccb96cf9',
        '__EVENTTARGET' => 'ctl00$MainContentPlaceHolder$SetAll',
        '__EVENTARGUMENT ' => ' ',
        '__VIEWSTATE ' => 'wEPDwUKMTIwNTA0MTQwOA9kFgJmD2QWAgIDD2QWBAIGD2QWDAIKDw8WBB4EVGV4dAUCMTUeB0VuYWJsZWRnZGQCCw8PFgQfAAUCMzAfAWdkZAIMDw8WBB8ABQI1MB8BaGRkAg0PDxYCHwFnZGQCDg88KwANAQAPFggeC18hSXRlbUNvdW50AsMCHgtBbGxvd1BhZ2luZ2ceC18hRGF0YUJvdW5kZx4IUGFnZVNpemUCMmQWAmYPZBZmAgEPZBYeZg8PFgIfAAUBMWRkAgEPZBYCZg8PFgQfAAUMVUE0MDAwMTg1MTUxHgtOYXZpZ2F0ZVVybAUnfi9TZWN1cml0aWVzSW5mby5hc3B4P0lTSU49VUE0MDAwMTg1MTUxZGQCAg8PFgIfAAUGJm5ic3A7ZGQCAw8PFgIfAAUGMTg1MTUxZGQCBA8PFgIfAAUIMDAwMTM0ODBkZAIFDw8WAh8ABSnQnNGW0L3RltGB0YLQtdGA0YHRgtCy0L4g0KTRltC90LDQvdGB0ZbQsmRkAgYPDxYCHwAFvAHQntCx0LvRltCz0LDRhtGW0Y8g0LLQvdGD0YLRgNGW0YjQvdGW0YUg0LTQtdGA0LbQsNCy0L3QuNGFINC',
        'ctl00$MainContentPlaceHolder$txtFrom' => $data_string,
    );
    $crawler = $client->request('POST', 'http://fbp.com.ua/Trade/StockListPer.aspx', $post_param);
    $page = $crawler->html();
    return $page;
}
//Curl version
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
