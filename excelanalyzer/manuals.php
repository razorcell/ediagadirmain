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
  <?php
//---------------INCLUDE PAGE FOOTER--------------
include('template-blocks/footer.php');
?>