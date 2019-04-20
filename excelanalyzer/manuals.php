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
        <!-- BEGIN PAGE HEADER-->
        <!-- BEGIN PAGE TITLE-->
        <!-- END PAGE TITLE-->

        <!-- END PAGE HEADER-->
        <div class="row">
          <div class="col-md-12">
            <div>

              <div class="portlet light bg-inverse dark">
                <div class="portlet-title">
                  <div class="caption">
                    <i class="fa fa-book"></i>Manuals </div>

                </div>
                <div class="portlet-body">
                  <div class="row">
                    <div class="col-md-3 col-sm-3 col-xs-3">
                      <ul class="nav nav-tabs tabs-left">
                        <li class="active">
                          <a href="#tab_6_1" data-toggle="tab" aria-expanded="true"> Bolsar </a>
                        </li>
                        <li class="">
                          <a href="#tab_6_2" data-toggle="tab" aria-expanded="false"> MAE </a>
                        </li>
                        <li class="">
                          <a href="#tab_6_3" data-toggle="tab" aria-expanded="false"> European central bank </a>
                        </li>
                        <li class="">
                          <a href="#tab_6_4" data-toggle="tab" aria-expanded="false"> Euronext Bonds </a>
                        </li>
                        <li class="">
                          <a href="#tab_6_5" data-toggle="tab" aria-expanded="false"> Perspektiva </a>
                        </li>
                      </ul>
                    </div>
                    <div class="col-md-9 col-sm-9 col-xs-9">
                      <div class="tab-content">
                        <div class="tab-pane active in" id="tab_6_1">
                          <ol>
                            <li>You need to install a browser VPN to access this website,
                              choose any VPN you want. Here is one for Firefox browser <a target="_blank" href="https://addons.mozilla.org/fr/firefox/addon/hoxx-vpn-proxy/">Hoxx VPN</a></li>
                            <li>Create an account if necessary in the VPN extension and enable that extension in your browser</li>
                            <li>Go to <a target="_blank" href="https://www.bolsar.com/Vistas/Investigaciones/Especies.aspx">Bolsar securities list</a></li>
                            <li>Compile all the securities of all the following categories in one Excel file. Make sure that you select all the pages for each category<br>
                              <br><img src="khalifaassets/bolsar categories.png" alt="bolsar categories"> <br><br>
                            </li>
                            <li>The end result should be an Excel file like this one
                              <br><br>
                              <img src="khalifaassets/bolsar_Excel.png" alt="Excel bolsar"><br><br>
                            </li>
                            <li>Now go to the <a href="index.html">Scanner</a> page </li>
                            <li>Select "Bolsar" source, upload the Excel file that you just compiled and hit the "Run" button</li>
                          </ol>
                        </div>
                        <div class="tab-pane fade" id="tab_6_2">
                          <ol>
                            <li>For this source and also other we recommend installing this chrome extension <a target="_blank" href="https://chrome.google.com/webstore/detail/table-capture/iebpjdmgckacbodjpijphcplhebcmeop">Capture Table</a></li>

                            <li>Go to <a target="_blank" href="http://www.mae.com.ar/legales/emisiones/emisiones_on.aspx">MAE securities list</a></li>
                            <li>Click on the "Table capture" extension, select the correct table and click on the Google sheets icon
                              <br><br>
                              <img src="khalifaassets/MAE_how_to.png" alt="MAE"> <br><br>
                            </li>
                            <li>You will then be redirected to a new empty "Google Drive Sheet". Select the first cell A1 and paste.
                              <br><br>
                              <img src="khalifaassets/MAE_drive.png" alt="MAE"><br><br>
                            </li>
                            <li>Now remove the first column and the first row highlighted in red as they contain unnecessary data
                              <br><br>
                              <img src="khalifaassets/MAE_how_to_2.png" alt="MAE"><br><br>


                            </li>
                            <li>Now click "File" in the menu bar, go to "Download as" and select "Excel xlsx", and save the file somewhere in you computer
                              <br><br>

                              <img src="khalifaassets/MAE_how_to_3.png" alt="MAE"><br><br>


                            </li>
                            <li>Now go to the <a href="index.html">Scanner</a> page </li>
                            <li>Select "MAE" source, upload the Excel file that you just compiled and hit the "Run" button</li>
                          </ol>

                        </div>
                        <div class="tab-pane fade" id="tab_6_3">
                          <ol>
                            <li>Go to <a target="_blank" href="https://www.ecb.europa.eu/paym/coll/assets/html/list-MID.en.html">ECB : Eligible assets</a></li>
                            <li>Click on the "Full database" "uncompressed" csv file to download it
                              <br><br>
                              <img src="khalifaassets/ECB.png" alt="ECB"> <br><br>
                            </li>
                            <li>Open the "CSV" file using Excel and remove the first row
                              <br><br>
                              <img src="khalifaassets/ECB2.png" alt="Excel bolsar"><br><br>
                            </li>
                            <li>In "Excel" go to "File", "Save as (Enregistrer-sous)" and select the file type "Excel xlsx"
                              <br><br>
                              <img src="khalifaassets/ECB3.png" alt="Excel bolsar"><br><br>


                            </li>

                            <li>Now go to the <a href="index.html">Scanner</a> page </li>
                            <li>Select "ECB" source, upload the Excel file that you just compiled and hit the "Run" button</li>
                          </ol>
                        </div>
                        <div class="tab-pane fade" id="tab_6_4">

                          <ol>
                            <li>Go to <a target="_blank" href="https://www.euronext.com/bonds/directory">Euronext : Fixed Income Directory</a></li>
                            <li>Click on "Download", a window will appear in which you should click "Go" to download an excel file
                              <br><br>
                              <img src="khalifaassets/euronext1.png" alt="euronext1"> <br><br>
                            </li>
                            <li>Delete the header rows and save the file
                              <br><br>
                              <img src="khalifaassets/euronext2.png" alt="euronext2"> <br><br>
                            </li>

                            <li>Now go to the <a href="index.html">Scanner</a> page </li>
                            <li>Select "EuronextBonds" source, upload the Excel file that you just compiled and hit the "Run" button</li>
                          </ol>

                        </div>
                        <div class="tab-pane fade" id="tab_6_5">

                          <ol>
                            <li>Go to <a target="_blank" href="http://fbp.com.ua/Trade/StockListPer.aspx">Perspektiva bonds list</a></li>
                            <li>Click on "Bci" to show all the securities
                              <br><br>
                              <img src="khalifaassets/perspektiva1.png" alt="ECB"> <br><br>
                            </li>
                            <li>Click on the "table capture" chrome extension that we have already installed in the "MAE" source manual and select the second table that contains the securities.<br>
                              Now click on the "Google sheet" icon and paste
                              <br><br>
                              <img src="khalifaassets/euronext2.png" alt="ECB"> <br><br>
                            </li>

                            <li>Now go to the <a href="index.html">Scanner</a> page </li>
                            <li>Select "EuronextBonds" source, upload the Excel file that you just compiled and hit the "Run" button</li>
                          </ol>

                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>








            </div>
            <!-- END BLOCKQUOTES PORTLET-->
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