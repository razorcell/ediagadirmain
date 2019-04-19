<?php
require_once '../users/init.php';
if (!securePage($_SERVER['PHP_SELF'])) {
  die();
}
?>
<!DOCTYPE html>
<!-- 
   Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.6
   Version: 4.5.4
   Author: KeenThemes
   Website: http://www.keenthemes.com/
   Contact: support@keenthemes.com
   Follow: www.twitter.com/keenthemes
   Like: www.facebook.com/keenthemes
   Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
   License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
   -->
<!--[if IE 8]> 
<html lang="en" class="ie8 no-js">
   <![endif]-->
<!--[if IE 9]> 
   <html lang="en" class="ie9 no-js">
      <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
  <meta charset="utf-8" />
  <title>Excel Files Analyzer</title>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta content="width=device-width, initial-scale=1" name="viewport" />
  <meta content="" name="description" />
  <meta content="" name="author" />
  <!-- BEGIN GLOBAL MANDATORY STYLES -->
  <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
  <link href="assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
  <link href="assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
  <link href="assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link href="assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css" />
  <link href="assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
  <!-- END GLOBAL MANDATORY STYLES -->
  <!-- BEGIN PAGE LEVEL PLUGINS -->
  <link href="assets/global/plugins/codemirror/lib/codemirror.css" rel="stylesheet" type="text/css" />
  <link href="assets/global/plugins/codemirror/theme/neat.css" rel="stylesheet" type="text/css" />
  <link href="assets/global/plugins/codemirror/theme/ambiance.css" rel="stylesheet" type="text/css" />
  <link href="assets/global/plugins/codemirror/theme/material.css" rel="stylesheet" type="text/css" />
  <link href="assets/global/plugins/codemirror/theme/neo.css" rel="stylesheet" type="text/css" />
  <link href="assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
  <link href="assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link href="assets/global/plugins/bootstrap-touchspin/bootstrap.touchspin.css" rel="stylesheet" type="text/css" />
  <link href="assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />
  <!-- END PAGE LEVEL PLUGINS -->
  <!-- BEGIN THEME GLOBAL STYLES -->
  <link href="assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
  <link href="assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
  <!-- END THEME GLOBAL STYLES -->
  <!-- BEGIN THEME LAYOUT STYLES -->
  <link href="assets/layouts/layout/css/layout.min.css" rel="stylesheet" type="text/css" />
  <link href="assets/layouts/layout/css/themes/default.min.css" rel="stylesheet" type="text/css" id="style_color" />
  <link href="assets/layouts/layout/css/custom.min.css" rel="stylesheet" type="text/css" />
  <!-- END THEME LAYOUT STYLES -->
  <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
  <link rel="icon" href="favicon.ico" type="image/x-icon">
</head>
<!-- END HEAD -->

<body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white page-sidebar-closed">
  <!-- BEGIN HEADER -->
  <!-- END HEADER -->
  <!-- BEGIN HEADER & CONTENT DIVIDER -->
  <div class="clearfix"> </div>
  <!-- END HEADER & CONTENT DIVIDER -->
  <!-- BEGIN CONTAINER -->
  <div class="page-container">
    <!-- BEGIN SIDEBAR -->
    <div class="page-sidebar-wrapper">
      <!-- BEGIN SIDEBAR -->
      <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
      <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
      <div class="page-sidebar navbar-collapse collapse">
        <!-- BEGIN SIDEBAR MENU -->
        <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
        <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
        <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
        <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
        <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
        <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
        <ul class="page-sidebar-menu  page-header-fixed page-sidebar-menu-closed" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
          <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
          <li class="sidebar-toggler-wrapper hide">
            <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
            <div class="sidebar-toggler"> </div>
            <!-- END SIDEBAR TOGGLER BUTTON -->
          </li>
          <li class="nav-item start ">
            <a href="javascript:;" class="nav-link nav-toggle">
              <i class="icon-home"></i>
              <span class="title">Dashboard</span>
              <span class="arrow"></span>
            </a>
            <ul class="sub-menu">
              <li class="nav-item start ">
                <a href="index.html" class="nav-link ">
                  <i class="icon-bar-chart"></i>
                  <span class="title">Scanner</span>
                </a>
              </li>
              <li class="nav-item start ">
                <a href="data_browser_page.html" class="nav-link ">
                  <i class="icon-bulb"></i>
                  <span class="title">Data browser</span>
                </a>
              </li>
              <li class="nav-item start ">
                <a href="manuals.html" class="nav-link ">
                  <i class="icon-docs"></i>
                  <span class="title">Manuals</span>
                </a>
              </li>
            </ul>
          </li>
        </ul>
        <!-- END SIDEBAR MENU -->
        <!-- END SIDEBAR MENU -->
      </div>
      <!-- END SIDEBAR -->
    </div>
    <!-- END SIDEBAR -->
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
      <!-- BEGIN CONTENT BODY -->
      <div class="page-content">
        <div class="page-bar">
          <ul class="page-breadcrumb">
            <li> Welcome
              <?php
              echo $user->data()->fname . ' ' . $user->data()->lname;
              ?> !
              <i class="fa fa-circle"></i>
              <span id="username" hidden><?php echo $user->data()->username; ?></span>
            </li>
            <li>
              <a href="../users/logout.php"><span>Logout</span></a>
            </li>
          </ul>

        </div>
        <!-- BEGIN PAGE HEADER-->
        <!-- BEGIN PAGE TITLE-->
        <!-- END PAGE TITLE-->
        <!-- END PAGE HEADER-->
        <div class="row">
          <div class="col-md-4">
            <!-- BEGIN SAMPLE FORM PORTLET-->
            <div id="dashboard_portlet" class="portlet light">
              <div id="dashboard_portlet_header" class="portlet-title">
                <div class="caption">
                  <i class="icon-settings font-dark"></i>
                  <span class="caption-subject font-dark sbold uppercase">Dashboard</span>
                </div>
              </div>
              <div id="dashboard_portlet_body" class="portlet-body form">
                <div class="tabbable-custom nav-justified">
                  <ul class="nav nav-tabs nav-justified">
                    <li>
                      <a href="#process_files" data-toggle="tab"> Update Source </a>
                    </li>
                    <li>
                      <a href="#add_new_source" data-toggle="tab"> Add Source </a>
                    </li>
                    <li class="active">
                      <a href="#delete_source" data-toggle="tab"> Delete Source </a>
                    </li>
                  </ul>
                  <div class="tab-content">
                    <div class="tab-pane" id="process_files">
                      <form action="#" enctype="multipart/form-data" method="post" class="form-horizontal" role="form">
                        <div class="form-body">

                          <div class="form-group">

                            <div class="col-md-12">
                              <div class="input-group">
                                <span class="input-group-btn">
                                  <button class="btn btn-default" type="button">Source</button>
                                </span>
                                <select id="source_select_tag" class="form-control select2 select2-hidden-accessible" tabindex="-1" aria-hidden="true">
                                </select>
                              </div>
                            </div>
                          </div>
                          <hr>


                          <div class="form-group" id="select_file_block">
                            <div class="col-md-8">
                              <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="input-group input-large">
                                  <div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">
                                    <i class="fa fa-file fileinput-exists"></i>&nbsp;
                                    <span class="fileinput-filename"> </span>
                                  </div>
                                  <span class="input-group-addon btn default btn-file">
                                    <span class="fileinput-new"> Select a CSV file </span>
                                    <span class="fileinput-exists"> Change </span>
                                    <input id="file_input_tag" type="file" name="..."> </span>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-4">
                              <button id="uploadfile" class="btn yellow-saffron btn-block">Upload</button>
                            </div>
                          </div>

                          <hr>



                          <div class="form-group" id="upload_and_run_block">
                            <div class="col-md-12">
                              <button id="updatedb" name="updatedb" class="btn red btn-block">Run a Check </button>
                            </div>
                          </div>



                          <hr>
                          <div class="form-group">
                            <div class="col-md-12">
                              <div class="progress progress-striped active">
                                <div id="progress_bar1" class=" progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                    <div class="tab-pane" id="add_new_source">
                      <form action="#" enctype="multipart/form-data" method="post" class="form-horizontal" role="form">
                        <div class="form-body">
                          <div class="alert alert-danger">
                            <strong>Warning !</strong> This step is used one time to add a new source
                          </div>
                          <div class="form-group">
                            <div class="col-md-12">
                              <div class="input-group">
                                <span class="input-group-btn">
                                  <button class="btn btn-default" type="button">Name</button>
                                </span>
                                <input id="source_name_input" type="text" class="form-control" placeholder="Enter a name">
                                <span class="input-group-btn">
                                  <button id="add_new_source_button" class="btn red" type="button"> Add <i class="fa fa-plus fa-fw"></i></button>
                                </span>
                              </div>
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="col-md-12">
                              <div class="input-group">
                                <span class="input-group-btn">
                                  <button class="btn btn-default" type="button"> Columns</button>
                                </span>
                                <input id="required_columns" type="text" class="form-control" placeholder="Select columns. Example: 1,2,9,11">
                              </div>
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="col-md-12">
                              <div class="input-group">
                                <span class="input-group-btn">
                                  <button class="btn btn-default" type="button"> Ignore rows</button>
                                </span>
                                <input type="text" id="ignored_rows" class="form-control" placeholder="Ignore rows. Example : 1,2,3,4. Leave empty to process all rows">
                              </div>
                            </div>
                          </div>
                          <!-- <div class="form-group">
                            <div class="col-md-12">
                              <div class="input-group">
                                <span class="input-group-btn">
                                  <button class="btn btn-default" type="button"> File encoding</button>
                                </span>
                                <input type="text" id="file_encoding" class="form-control"
                                  placeholder="Charset encoding:  UTF-8, UTF-16LE, ISO-8859-2">
                              </div>
                            </div>
                          </div> -->
                          <div class="form-group">
                            <div class="col-md-12">
                              <div class="input-group">
                                <span class="input-group-btn">
                                  <button class="btn btn-default" type="button" data-select2-open="multi-prepend"> File
                                    encoding
                                  </button>
                                </span>
                                <select id="encoding_select_tag" class="form-control select2 select2-hidden-accessible" tabindex="-1" aria-hidden="true">
                                  <option value="UCS-4">UCS-4</option>
                                  <option value="UCS-4BE">UCS-4BE</option>
                                  <option value="UCS-4LE">UCS-4LE</option>
                                  <option value="UCS-2">UCS-2</option>
                                  <option value="UCS-2BE">UCS-2BE</option>
                                  <option value="UCS-2LE">UCS-2LE</option>
                                  <option value="UTF-32">UTF-32</option>
                                  <option value="UTF-32BE">UTF-32BE</option>
                                  <option value="UTF-32LE">UTF-32LE</option>
                                  <option value="UTF-16">UTF-16</option>
                                  <option value="UTF-16BE">UTF-16BE</option>
                                  <option value="UTF-16LE">UTF-16LE</option>
                                  <option value="UTF-7">UTF-7</option>
                                  <option value="UTF7-IMAP">UTF7-IMAP</option>
                                  <option selected="selected" value="UTF-8">UTF-8</option>
                                  <option value="ASCII">ASCII</option>
                                  <option value="EUC-JP">EUC-JP</option>
                                  <option value="SJIS">SJIS</option>
                                  <option value="eucJP-win">eucJP-win</option>
                                  <option value="SJIS-win">SJIS-win</option>
                                  <option value="ISO-2022-JP">ISO-2022-JP</option>
                                  <option value="ISO-2022-JP-MS">ISO-2022-JP-MS</option>
                                  <option value="CP932">CP932</option>
                                  <option value="CP51932">CP51932</option>
                                  <option value="SJIS-mac">SJIS-mac</option>
                                  <option value="SJIS-Mobile#DOCOMO">SJIS-Mobile#DOCOMO</option>
                                  <option value="SJIS-Mobile#KDDI">SJIS-Mobile#KDDI</option>
                                  <option value="SJIS-Mobile#SOFTBANK">SJIS-Mobile#SOFTBANK</option>
                                  <option value="UTF-8-Mobile#DOCOMO">UTF-8-Mobile#DOCOMO</option>
                                  <option value="UTF-8-Mobile#KDDI-A">UTF-8-Mobile#KDDI-A</option>
                                  <option value="UTF-8-Mobile#KDDI-B">UTF-8-Mobile#KDDI-B</option>
                                  <option value="UTF-8-Mobile#SOFTBANK">UTF-8-Mobile#SOFTBANK</option>
                                  <option value="ISO-2022-JP-MOBILE#KDDI">ISO-2022-JP-MOBILE#KDDI</option>
                                  <option value="JIS">JIS</option>
                                  <option value="JIS-ms">JIS-ms</option>
                                  <option value="CP50220">CP50220</option>
                                  <option value="CP50220raw">CP50220raw</option>
                                  <option value="CP50221">CP50221</option>
                                  <option value="CP50222">CP50222</option>
                                  <option value="ISO-8859-1">ISO-8859-1</option>
                                  <option value="ISO-8859-2">ISO-8859-2</option>
                                  <option value="ISO-8859-3">ISO-8859-3</option>
                                  <option value="ISO-8859-4">ISO-8859-4</option>
                                  <option value="ISO-8859-5">ISO-8859-5</option>
                                  <option value="ISO-8859-6">ISO-8859-6</option>
                                  <option value="ISO-8859-7">ISO-8859-7</option>
                                  <option value="ISO-8859-8">ISO-8859-8</option>
                                  <option value="ISO-8859-9">ISO-8859-9</option>
                                  <option value="ISO-8859-10">ISO-8859-10</option>
                                  <option value="ISO-8859-13">ISO-8859-13</option>
                                  <option value="ISO-8859-14">ISO-8859-14</option>
                                  <option value="ISO-8859-15">ISO-8859-15</option>
                                  <option value="ISO-8859-16">ISO-8859-16</option>
                                  <option value="byte2be">byte2be</option>
                                  <option value="byte2le">byte2le</option>
                                  <option value="byte4be">byte4be</option>
                                  <option value="byte4le">byte4le</option>
                                  <option value="BASE64">BASE64</option>
                                  <option value="HTML-ENTITIES">HTML-ENTITIES</option>
                                  <option value="7bit">7bit</option>
                                  <option value="8bit">8bit</option>
                                  <option value="EUC-CN">EUC-CN</option>
                                  <option value="CP936">CP936</option>
                                  <option value="GB18030">GB18030</option>
                                  <option value="HZ">HZ</option>
                                  <option value="EUC-TW">EUC-TW</option>
                                  <option value="CP950">CP950</option>
                                  <option value="BIG-5">BIG-5</option>
                                  <option value="EUC-KR">EUC-KR</option>
                                  <option value="UHC">UHC</option>
                                  <option value="ISO-2022-KR">ISO-2022-KR</option>
                                  <option value="Windows-1251">Windows-1251</option>
                                  <option value="Windows-1252">Windows-1252</option>
                                  <option value="CP866">CP866</option>
                                  <option value="KOI8-R">KOI8-R</option>
                                  <option value="KOI8-U">KOI8-U</option>
                                  <option value="ArmSCII-8">ArmSCII-8</option>
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="col-md-12">
                              <div class="input-group">
                                <span class="input-group-btn">
                                  <button class="btn btn-default" type="button"> Database pass</button>
                                </span>
                                <input type="password" class="form-control" id="database_password" placeholder="Set a password for the new Database">
                                <span class="input-group-addon">
                                  <i class="fa fa-database font-blue"></i>
                                </span>
                              </div>
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="col-md-12">
                              <div class="input-group">
                                <span class="input-group-btn">
                                  <button class="btn btn-default" type="button"> Admin pass</button>
                                </span>
                                <input type="password" class="form-control" id="admin_password" placeholder="Enter Admin Password">
                                <span class="input-group-addon">
                                  <i class="fa fa-user font-red"></i>
                                </span>
                              </div>
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                    <div class="tab-pane active" id="delete_source">
                      <form action="#" enctype="multipart/form-data" method="post" class="form-horizontal" role="form">
                        <div class="form-body">
                          <div class="alert alert-danger">
                            <strong>ATTENTION ! this area will delete a Source</strong>
                          </div>
                          <div class="form-group">
                            <div class="col-md-12">
                              <div class="input-group">
                                <span class="input-group-btn">
                                  <button class="btn btn-default" type="button" data-select2-open="multi-prepend">
                                    Source
                                  </button>
                                </span>
                                <select id="source_select_delete_tag" class="form-control select2 select2-hidden-accessible" tabindex="-1" aria-hidden="true">
                                </select>
                              </div>
                            </div>
                          </div>
                          <hr>
                          <div class="form-group">
                            <div class="col-md-12">
                              <div class="input-group">
                                <span class="input-group-btn">
                                  <button class="btn btn-default" type="button" data-select2-open="multi-prepend">
                                    Admin password
                                  </button>
                                </span>
                                <input type="password" class="form-control" id="admin_password_delete_source" placeholder="Password">
                                <span class="input-group-addon">
                                  <i class="fa fa-user font-red"></i>
                                </span>
                              </div>
                            </div>
                          </div>
                          <hr>
                          <div class="form-group">
                            <div class="col-md-12">
                              <button id="delete_source_button" name="delete_source" class="btn red btn-block">DELETE
                                SOURCE
                                !
                              </button>
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- END SAMPLE FORM PORTLET-->
          </div>
          <div class="col-md-4">
            <div class="portlet light">
              <div class="portlet-title">
                <div class="caption">
                  <i class="fa fa-bookmark"></i>Source specific logs
                </div>
                <div class="tools">
                  <a href="javascript:;" class="collapse"> </a>
                  <a href="" class="fullscreen"> </a>
                </div>
              </div>
              <div class="portlet-body">
                <div id="logs_portlet" class="scroller" style="height:720px">
                  <pre id="source_specific_logs_div"> </pre>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="portlet light">
              <div class="portlet-title">
                <div class="caption">
                  <i class="fa fa-bookmark"></i>General Logs
                </div>
                <div class="tools">
                  <a href="javascript:;" class="collapse"> </a>
                  <a href="" class="fullscreen"> </a>
                </div>
              </div>
              <div class="portlet-body">
                <div id="logs_portlet" class="scroller" style="height:720px">
                  <pre id="general_logs_div"> </pre>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- END CONTENT BODY -->
    </div>
    <!-- END CONTENT -->
  </div>
  <!-- END CONTAINER -->
  <!-- BEGIN FOOTER -->
  <div class="page-footer">
    <div class="page-footer-inner">
    </div>
    <div class="scroll-to-top">
      <i class="icon-arrow-up"></i>
    </div>
  </div>
  <!-- END FOOTER -->
  <!--[if lt IE 9]>
            <script src="assets/global/plugins/respond.min.js"></script>
            <script src="assets/global/plugins/excanvas.min.js"></script> 
            <![endif]-->
  <!-- BEGIN CORE PLUGINS -->
  <script src="khalifaassets/jquery2.js"></script>
  <script src="khalifaassets/index_script.js"></script>
  <script src="assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
  <script src="assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
  <script src="assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
  <script src="assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
  <script src="assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
  <script src="assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
  <script src="assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
  <!-- END CORE PLUGINS -->
  <!-- BEGIN PAGE LEVEL PLUGINS -->
  <script src="assets/global/plugins/jquery.pulsate.min.js" type="text/javascript"></script>
  <script src="assets/global/plugins/jquery-bootpag/jquery.bootpag.min.js" type="text/javascript"></script>
  <script src="assets/global/plugins/holder.js" type="text/javascript"></script>
  <script src="assets/global/plugins/codemirror/lib/codemirror.js" type="text/javascript"></script>
  <script src="assets/global/plugins/codemirror/mode/javascript/javascript.js" type="text/javascript"></script>
  <script src="assets/global/plugins/codemirror/mode/htmlmixed/htmlmixed.js" type="text/javascript"></script>
  <script src="assets/global/plugins/codemirror/mode/css/css.js" type="text/javascript"></script>
  <script src="assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
  <script src="assets/global/plugins/fuelux/js/spinner.min.js" type="text/javascript"></script>
  <script src="assets/global/plugins/bootstrap-touchspin/bootstrap.touchspin.js" type="text/javascript"></script>
  <script src="assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
  <script src="assets/global/plugins/bootstrap-growl/jquery.bootstrap-growl.min.js" type="text/javascript"></script>
  <!-- END PAGE LEVEL PLUGINS -->
  <!-- BEGIN THEME GLOBAL SCRIPTS -->
  <script src="assets/global/scripts/app.min.js" type="text/javascript"></script>
  <!-- END THEME GLOBAL SCRIPTS -->
  <!-- BEGIN PAGE LEVEL SCRIPTS -->
  <script src="assets/pages/scripts/ui-general.min.js" type="text/javascript"></script>
  <!--<script src="assets/pages/scripts/components-code-editors.js" type="text/javascript"></script> -->
  <!-- END PAGE LEVEL SCRIPTS -->
  <!-- BEGIN THEME LAYOUT SCRIPTS -->
  <script src="assets/layouts/layout/scripts/layout.min.js" type="text/javascript"></script>
  <script src="assets/layouts/layout/scripts/demo.min.js" type="text/javascript"></script>
  <script src="assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
  <!-- END THEME LAYOUT SCRIPTS -->
</body>

</html>