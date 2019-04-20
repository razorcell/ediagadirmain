<?php
//Whatever happens in this script happens just before the user is officially redirected to account.php because they did not have proper permissions. You can either choose to redirect them somewhere else or perform some other logic.

//if homepage is empty and no referer link set in HTTP request headers than redirect to the website home page full path, somehow index.php doesn't work
if (!empty($_SERVER['HTTP_REFERER'])) {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
} else {
    header('Location: ' . "http://" . $_SERVER['SERVER_NAME']);
}
exit;
//$GLOBALS['general-log']->error('baseurl : ' . getBaseUrl());


// Redirect::to('https://facebook.com');
