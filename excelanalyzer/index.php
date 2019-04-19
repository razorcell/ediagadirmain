
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

<?php 
//---------------INCLUDE PAGE CONTENT--------------
?>
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
                    <li class="active">
                      <a href="#process_files" data-toggle="tab"> Update Source </a>
                    </li>
                    
                  </ul>
                  <div class="tab-content">
                    <div class="tab-pane active" id="process_files">
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

   
<?php
//---------------INCLUDE PAGE FOOTER--------------
include('template-blocks/footer.php');
?>

<?php
//---------------INCLUDE PAGE SPECIFIC SCRIPTS--------------
echo '<script src="khalifaassets/index_js.js" type="text/javascript"></script>';
?>
 