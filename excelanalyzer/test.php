<?php

ini_set('include_path', ini_get('include_path') . ';' . $_SERVER['DOCUMENT_ROOT'] . '/khalifaAPI/');
include_once 'libraries/khalifaAPI.php';


$GLOBALS["general-log"] = new MyLogPHP('./log/FIExcelAnalyzer.csv');



$res = Call_script_inside_project_with_post('get_the_correct_columns_parameter_for_datatables.php', array("source"=>'MAE', "table_type"=>'history'));

var_dump(json_decode($res));


