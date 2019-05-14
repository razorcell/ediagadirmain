<?php
define('DB_HOST', "192.168.1.154");
define('DB_LOCALHOST', "127.0.0.1");
define('DB_USER', "root");
define('DB_PASSWORD', "0verlordX");
define('DB_DATABASE_EURONEXT', "euronext2018");
define('DB_DATABASE_ZONEBOURSE', "zonebourse");
define('DB_DATABASE_GMCALENDAR', "gmcalendar");
define('DB_DATABASE_TOOLS', "tools");
define('DB_DATABASE_EURONEXTETFMONITOR', "euronextetfmonitor");
define('DB_DATABASE_MEXICOSOMONITOR', "mexicosomonitor");
define('DB_DATABASE_MEXICOSOMONITORTEST', "mexicosomonitortest");
define('DB_DATABASE_KASE', "kase");
define('DB_DATABASE_KACD', "kacd");
define('DB_DATABASE_EURONEXT_CA_MONITOR', "euronextcamonitor");
define('DB_DATABASE_FTPFILESCHECKER', "ftpfileschecker");
define('DB_DIV_CALENDAR_DBNAME', "smart_calendar");

//Excel analyzer
//LOCAL
define('EXCELANALYZER_DB_NAME', "excelanalyzer");
define('EXCELANALYZER_DB_HOST', "192.168.1.154");
define('EXCELANALYZER_DB_USER', "root");
define('EXCELANALYZER_DB_PASSWORD', "0verlordX");
define('EXCELANALYZER_LOG_FILE', $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'excelanalyzer' . DIRECTORY_SEPARATOR . 'log' . DIRECTORY_SEPARATOR . 'ExcelAnalyzer.csv');

//Euronext2018
//LOCAL
define('EURONEXTEQUITIESMASTERLIST_DB_NAME', "euronext2018");
define('EURONEXTEQUITIESMASTERLIST_DB_HOST', "localhost");
define('EURONEXTEQUITIESMASTERLIST_DB_USER', "euronext2018");
define('EURONEXTEQUITIESMASTERLIST_DB_PASS', "");
define('EURONEXTEQUITIESMASTERLIST_LOG_FILE', "log/EURONEXTEQUITIESMASTERLIST.csv");



//GREENGEEK HOSTING
define('GREENGEEK_EXCELANALYZER_DB_HOST', "184.154.174.162");
define('GREENGEEK_EXCELANALYZER_DB_NAME', "topbowti_excelanalyzer");
define('GREENGEEK_EXCELANALYZER_DB_USER', "topbowti_edi");
define('GREENGEEK_EXCELANALYZER_DB_PASSWORD', "8hsi-oo!_TC7");



//Marketwatch
define('DB_DIV_MARKETWATCH_DBNAME', "marketwatch");

//Remote EDI Databases
define('DB_WCA2_DBNAME', "wca2");
define('DB_XDES_DBNAME', "xdes");

define('DB_WCA2_HOST', "185.3.164.40");
define('DB_WCA2_USER', "kalifa");
define('DB_WCA2_PASS', "H257:mbrp");
