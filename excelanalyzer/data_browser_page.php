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
  <title>Euronext Securities</title>
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
  <link href="assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
  <link href="assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
  <link href="assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
  <link href="assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
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
        <ul class="page-sidebar-menu page-header-fixed page-sidebar-menu-closed" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
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
            <!-- BEGIN SAMPLE FORM PORTLET-->
            <div class="portlet light portlet-fit portlet-datatable bordered">
              <div class="portlet-title">
                <div class="caption">
                  <i class="fa fa-globe"></i>Data Browser
                </div>


                <div class="actions">




                  <div class="btn-group">
                    <select id="source_select_tag" class="form-control select2 input-sm"></select>
                  </div>


                  <div class="btn-group">
                    <select id="table_type_select_tag" class="form-control select2 input-sm">
                      <option value="live">Live</option>
                      <option value="history">History</option>
                    </select>
                  </div>




                  <div class="btn-group">
                    <a class="btn red" href="javascript:;" data-toggle="dropdown">
                      <i class="fa fa-share"></i>
                      <span class="hidden-xs"> Tools </span>
                      <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu pull-right" id="datatables_data_table_tools_dom">
                      <li>
                        <a href="javascript:;" data-action="0" class="tool-action">
                          <i class="icon-printer"></i> Print</a>
                      </li>
                      <li>
                        <a href="javascript:;" data-action="1" class="tool-action">
                          <i class="icon-check"></i> Copy</a>
                      </li>
                      <li>
                        <a href="javascript:;" data-action="2" class="tool-action">
                          <i class="icon-doc"></i> PDF</a>
                      </li>
                      <li>
                        <a href="javascript:;" data-action="3" class="tool-action">
                          <i class="icon-paper-clip"></i> Excel</a>
                      </li>
                      <li>
                        <a href="javascript:;" data-action="4" class="tool-action">
                          <i class="icon-cloud-upload"></i> CSV</a>
                      </li>
                    </ul>
                  </div>

                  <a id="reload_table" href="javascript:;" class="btn btn-lg blue"> Reload the Table
                    <i class="fa fa-refresh"></i>
                  </a>


                </div>


              </div>
              <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover table-header-fixed" id="browser_data_datatables_dom">
                  <tbody>
                  </tbody>
                </table>
              </div>
            </div>
            <!-- END SAMPLE FORM PORTLET-->
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
  <script src="khalifaassets/data_browser_page_js.js"></script>
  <script src="assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
  <script src="assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
  <script src="assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
  <script src="assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
  <script src="assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
  <script src="assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
  <script src="assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
  <!-- END CORE PLUGINS -->
  <!-- BEGIN PAGE LEVEL PLUGINS -->
  <script src="assets/global/scripts/datatable.js" type="text/javascript"></script>
  <script src="assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
  <script src="assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
  <script src="assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
  <!-- END PAGE LEVEL PLUGINS -->
  <!-- BEGIN THEME GLOBAL SCRIPTS -->
  <script src="assets/global/scripts/app.min.js" type="text/javascript"></script>
  <!-- END THEME GLOBAL SCRIPTS -->
  <!-- BEGIN PAGE LEVEL SCRIPTS -->
  <!--<script src="assets/pages/scripts/table-datatables-fixedheader.js" type="text/javascript"></script>-->
  <!--<script src="assets/pages/scripts/components-code-editors.js" type="text/javascript"></script> -->
  <!-- END PAGE LEVEL SCRIPTS -->
  <!-- BEGIN THEME LAYOUT SCRIPTS -->
  <script src="assets/layouts/layout/scripts/layout.min.js" type="text/javascript"></script>
  <script src="assets/layouts/layout/scripts/demo.min.js" type="text/javascript"></script>
  <script src="assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
  <!-- END THEME LAYOUT SCRIPTS -->
</body>

</html>