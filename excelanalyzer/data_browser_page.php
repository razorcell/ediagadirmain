<?php
require_once '../users/init.php';
if (!securePage($_SERVER['PHP_SELF'])) {
  die();
}
?>
<?php
//---------------INCLUDE PAGE HEADER--------------
include('template-blocks/header.php');
?>
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
 
  <?php
//---------------INCLUDE PAGE FOOTER--------------
include('template-blocks/footer.php');
?>

<?php
//---------------INCLUDE PAGE SPECIFIC SCRIPTS--------------
echo '<script src="khalifaassets/data_browser_page_js.js" type="text/javascript"></script>';
?>
 