<?php

$response = array("progress_style"=>"", "progress_value"=>"");
$tmp_progress_file = "khalifatmpfiles/progress.txt";
$myfile = fopen($tmp_progress_file, "r");
if($myfile == false){
        $GLOBALS["general-log"]->info("ERROR in opening progress file");
    }else{
        if(filesize($tmp_progress_file) == 0){
            $response["progress_style"] = "width: 0%";
            $response["progress_value"] = "0%";
            fclose($myfile);
        }else{
            $progress = fread($myfile,filesize($tmp_progress_file));
            if($progress == 100){
                $response["progress_style"] = "width: ".$progress."%";
                $response["progress_value"] = 'Run a Check';
            }else{
                $response["progress_style"] = "width: ".$progress."%";
                $response["progress_value"] = $progress."%";
            }
            
            fclose($myfile);
        }
    }
    echo json_encode($response);
