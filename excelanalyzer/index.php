<?php
//---------------ACCESS CONTROL CHECK--------------
require_once '../users/init.php';
if (!securePage($_SERVER['PHP_SELF'])) {
  die();
}
?>
<?php
//---------------INCLUDE PAGE HEADER--------------
include('template-blocks/header.php');
?>
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
  <!-- BEGIN CONTENT BODY -->
  <div class="page-content">
    <!-- BEGIN THEME PANEL -->
    <?php
    //include('template-blocks/themepanel.php'); 
    ?>
    <!-- END THEME PANEL -->
    <!-- BEGIN PAGE USER BAR -->
    <div id="upper_bar" class="page-bar">
      <ul class="page-breadcrumb">
      </ul>
    </div>
    <div class="page-bar">
      <ul class="page-breadcrumb">
        <li>
          <a href="index.php">Home</a>
          <i class="fa fa-circle"></i>
        </li>
        <li>
          <span>Update source</span>
        </li>
      </ul>
    </div>
    <!-- END PAGE BAR -->
    <!-- END PAGE USER BAR -->
    <div class="row">
      <div id="progress_bar_div" class="progress progress-striped active" style="display: none;">
        <div id="progress_bar_updating" class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
        </div>
      </div>
    </div>


    <div class="row">
      <!-- <div id="global_dashboard_portlet" class="col-md-2"> -->
      <!-- BEGIN SAMPLE FORM PORTLET-->
      <div id="dashboard_portlet" class="portlet light col-md-3">
        <div id="dashboard_portlet_header" class="portlet-title">
          <!-- <div class="caption">
              <i class="icon-settings font-dark"></i>
              <span class="caption-subject font-dark sbold uppercase">Dashboard</span>
            </div> -->
        </div>
        <div id="dashboard_portlet_body" class="portlet-body form">
          <!-- TAB START -->
          <!-- <form action="#" enctype="multipart/form-data" method="post" class="form-horizontal form-bordered" role="form"> -->
          <!-- <div class="form-body"> -->
          <div class="row">
            <!-- <div class="form-group"> -->
            <div class="input-group">
              <span class="input-group-btn">
                <button class="btn btn-default" type="button">Source</button>
              </span>
              <select id="source_select_tag" class="form-control select2 select2-hidden-accessible" tabindex="-1" aria-hidden="true">
              </select>
            </div>
            <!-- </div> -->
          </div>
          <hr>

          <div class="row">
            <!-- <div class="form-group"> -->

            <!-- <div class="col-md-9"> -->
            <div class="fileinput fileinput-new" data-provides="fileinput">
              <span class="btn green btn-file">
                <span class="fileinput-new"> Select file </span>
                <span class="fileinput-exists"> Change </span>
                <input id="file_input_tag" type="file" name="..."> </span>
              <span class="fileinput-filename"> </span> &nbsp;
              <a href="javascript:;" class="close fileinput-exists" data-dismiss="fileinput"> </a>
            </div>
            <!-- </div> -->
            <!-- </div> -->
          </div>

          <hr>

          <!-- <div class="row"> -->

          <!-- version 2 keep this commented -->
          <!-- <div class="form-group"> -->

          <!-- <div class="fileinput fileinput-new" data-provides="fileinput"> -->

          <!-- version 2 keep this commented -->
          <!-- <div class="input-group"> -->

          <!-- <div class="form-control uneditable-input" data-trigger="fileinput"> 
                <i class="fa fa-file fileinput-exists"></i>&nbsp;
                <span class="fileinput-filename"> </span>
              </div>
              <span class="input-group-addon btn default btn-file">
                <span class="fileinput-new"> Select file </span> -->
          <!-- <span  class="fileinput-exists"> Change </span>
                <input id="file_input_tag" type="file" name="...">
              </span>-->
          <!-- version 2 keep this commented -->
          <!-- <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> Remove </a> -->
          <!-- </div> -->

          <!-- </div> -->

          <!-- version 2 keep this commented -->
          <!-- </div> -->


          <!-- </div>  -->
          <!-- <hr> -->
          <div class="row">
            <button id="uploadfile" class="btn yellow-saffron btn-block">Upload</button>
          </div>
          <hr>
          <div class="row">
            <button id="updatedb" name="updatedb" class="btn red btn-block">Run a Check </button>
          </div>
          <hr>

        </div>
      </div>
      <!-- </div> -->
      <!-- TAB END -->

      <!-- END PORTLET DASKBOARD-->

      <!-- Source specific logs -->
      <!-- <div class="col-md-6"> -->
      <div class="portlet light col-md-5">
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
          <!-- <div id="logs_portlet" class="scroller" style="height:720px"> -->
          <div id="logs_portlet">
            <pre id="source_specific_logs_div"> </pre>
          </div>
        </div>
      </div>
      <!-- </div> -->


      <!-- General Logs -->
      <!-- <div class="col-md-4"> -->
      <div class="portlet light col-md-4">
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
          <!-- <div id="logs_portlet" class="scroller" style="height:720px"> -->
          <div id="logs_portlet">
            <pre id="general_logs_div"> </pre>
          </div>
        </div>
      </div>
      <!-- </div> -->

    </div>
    <?php
    //---------------INCLUDE PAGE FOOTER--------------
    include('template-blocks/footer.php');
    ?>
    <?php
    //---------------INCLUDE PAGE SPECIFIC SCRIPTS--------------
    echo '<script src="khalifaassets/index_js.js" type="text/javascript"></script>';
    ?>