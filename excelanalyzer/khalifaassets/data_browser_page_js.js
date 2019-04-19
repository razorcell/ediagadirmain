jQuery(document).ready(function () {
	$.fn.select2.defaults.set("theme", "bootstrap");
	$("#table_type_select_tag").select2({
		placeholder: 'Select table type',
		width: '100%',
		dropdownAutoWidth: true,
		minimumResultsForSearch: -1

	});
	var username = $('#username').text();
	var user_name_form_data = new FormData();
	user_name_form_data.append('username', username);
	$("#source_select_tag").select2({
		placeholder: 'Select the source',
		width: '100%',
		dropdownAutoWidth: true,
		minimumResultsForSearch: -1,
		ajax: {
			url: "send_sources_list.php",
			type: 'POST',
			dataType: 'json',
			data: user_name_form_data,
			processData: false, // Don't process the files
			contentType: false, // Set content type to false as jQuery will tell the server its a query string request                      
			delay: 250,
			processResults: function (data, page) {
				// parse the results into the format expected by Select2.
				// since we are using custom formatting functions we do not need to
				// alter the remote JSON data
				return {
					results: data.items
				};
			},
			cache: true
		},
		escapeMarkup: function (markup) {
			return markup;
		}, // let our custom formatter work
		minimumInputLength: 0
	});

	$('#reload_table').click(reloadTable);

	function reloadTable() {
		var source = $('#source_select_tag option:selected').text();
		var table_type = $('#table_type_select_tag option:selected').text();
		if (source === '' || table_type === '') {
			//console.log('problem');
			return;
		}
		App.blockUI();
		if (browser_data_datatables_object) { // Check if table object exists and needs to be flushed
			//console.log(browser_data_datatables_object);
			browser_data_datatables_object.fnDestroy(); // For new version use table.destroy();
			$('#browser_data_datatables_dom').empty(); // empty in case the columns change
		}

		var form_data = new FormData();
		form_data.append('source', source);
		form_data.append('table_type', table_type);

		//get the columns parameter first
		$.ajax({
			url: 'get_the_correct_columns_parameter_for_datatables.php',
			type: 'POST',
			data: form_data,
			cache: false,
			dataType: 'json',
			processData: false, // Don't process the files
			contentType: false, // Set content type to false as jQuery will tell the server its a query string request
			beforeSend: function () { },
			success: function (response, textStatus, jqXHR) {
				//we have now the correct columns parameter, now we need to get the data relative to the desired source
				var correct_columns_parameter = response.correct_columns_parameter;
				$.ajax({
					url: 'send_datables_data_as_json.php',
					type: 'POST',
					data: form_data,
					cache: false,
					dataType: 'json',
					processData: false, // Don't process the files
					contentType: false, // Set content type to false as jQuery will tell the server its a query string request
					beforeSend: function () { },
					success: function (response, textStatus, jqXHR) {
						browser_data_datatables_object = $('#browser_data_datatables_dom').dataTable({
							//"ajax": response.live_data,
							"columns": correct_columns_parameter,
							// Internationalisation. For more info refer to http://datatables.net/manual/i18n
							"language": {
								"aria": {
									"sortAscending": ": activate to sort column ascending",
									"sortDescending": ": activate to sort column descending"
								},
								"emptyTable": "No data available in table",
								"info": "Showing _START_ to _END_ of _TOTAL_ entries",
								"infoEmpty": "No entries found",
								"infoFiltered": "(filtered1 from _MAX_ total entries)",
								"lengthMenu": "_MENU_ entries",
								"search": "Search:",
								"zeroRecords": "No matching records found"
							},
							// Or you can use remote translation file
							//"language": {
							//   url: '//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Portuguese.json'
							//},
							// setup rowreorder extension: http://datatables.net/extensions/fixedheader/

							buttons: [{
								extend: 'print',
								className: 'btn dark btn-outline'
							}, {
								extend: 'copy',
								className: 'btn red btn-outline'
							}, {
								extend: 'pdf',
								className: 'btn green btn-outline'
							}, {
								extend: 'excel',
								className: 'btn yellow btn-outline '
							}, {
								extend: 'csv',
								className: 'btn purple btn-outline '
							}],
							"order": [
								//[0, 'asc']
							],
							"lengthMenu": [
								[30, 100, 200, 300, 400, 500, -1],
								[30, 100, 200, 300, 400, 500, "All"] // change per page values here
							],
							// set the initial value
							"pageLength": 30,
							"autoWidth": false,
							// Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
							// setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js). 
							// So when dropdowns used the scrollable div should be removed. 
							//"dom": "<'row' <'col-md-12'T>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
							"fnDrawCallback": function () {
								//$("#browser_data_datatables_dom thead").hide();
							}
						});
						// handle datatable custom tools
						$('#datatables_data_table_tools_dom > li > a.tool-action').on('click',
							function () {
								var action = $(this).attr('data-action');
								browser_data_datatables_object.DataTable().button(action).trigger();
							});
						browser_data_datatables_object.api().rows.add(response.live_data);
						browser_data_datatables_object.api().draw();
						App.unblockUI();
					}
				});
			},
			error: function (jqXHR, textStatus, errorThrown) {
				// Handle errors here
				console.log('ERRORS: ' + textStatus);
				console.log('errorThrown: ' + errorThrown);
				console.log('jqXHR: ' + jqXHR);
				// STOP LOADING SPINNER
			}
		});

	}

	var browser_data_datatables_object = null;

	$('.select2').on('change', function (e) {
		var source = $('#source_select_tag option:selected').text();
		var table_type = $('#table_type_select_tag option:selected').text();
		if (source === '' || table_type === '') {
			//console.log('problem');
			return;
		}
		App.blockUI();
		if (browser_data_datatables_object) { // Check if table object exists and needs to be flushed
			//console.log(browser_data_datatables_object);
			browser_data_datatables_object.fnDestroy(); // For new version use table.destroy();
			$('#browser_data_datatables_dom').empty(); // empty in case the columns change
		}

		var form_data = new FormData();
		form_data.append('source', source);
		form_data.append('table_type', table_type);

		//get the columns parameter first
		$.ajax({
			url: 'get_the_correct_columns_parameter_for_datatables.php',
			type: 'POST',
			data: form_data,
			cache: false,
			dataType: 'json',
			processData: false, // Don't process the files
			contentType: false, // Set content type to false as jQuery will tell the server its a query string request
			beforeSend: function () { },
			success: function (response, textStatus, jqXHR) {
				//we have now the correct columns parameter, now we need to get the data relative to the desired source
				var correct_columns_parameter = response.correct_columns_parameter;
				$.ajax({
					url: 'send_datables_data_as_json.php',
					type: 'POST',
					data: form_data,
					cache: false,
					dataType: 'json',
					processData: false, // Don't process the files
					contentType: false, // Set content type to false as jQuery will tell the server its a query string request
					beforeSend: function () { },
					success: function (response, textStatus, jqXHR) {
						browser_data_datatables_object = $('#browser_data_datatables_dom').dataTable({
							//"ajax": response.live_data,
							"columns": correct_columns_parameter,
							// Internationalisation. For more info refer to http://datatables.net/manual/i18n
							"language": {
								"aria": {
									"sortAscending": ": activate to sort column ascending",
									"sortDescending": ": activate to sort column descending"
								},
								"emptyTable": "No data available in table",
								"info": "Showing _START_ to _END_ of _TOTAL_ entries",
								"infoEmpty": "No entries found",
								"infoFiltered": "(filtered1 from _MAX_ total entries)",
								"lengthMenu": "_MENU_ entries",
								"search": "Search:",
								"zeroRecords": "No matching records found"
							},
							// Or you can use remote translation file
							//"language": {
							//   url: '//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Portuguese.json'
							//},
							// setup rowreorder extension: http://datatables.net/extensions/fixedheader/

							buttons: [{
								extend: 'print',
								className: 'btn dark btn-outline'
							}, {
								extend: 'copy',
								className: 'btn red btn-outline'
							}, {
								extend: 'pdf',
								className: 'btn green btn-outline'
							}, {
								extend: 'excel',
								className: 'btn yellow btn-outline '
							}, {
								extend: 'csv',
								className: 'btn purple btn-outline '
							}],
							"order": [
								//[0, 'asc']
							],
							"lengthMenu": [
								[30, 100, 200, 300, 400, 500, -1],
								[30, 100, 200, 300, 400, 500, "All"] // change per page values here
							],
							// set the initial value
							"pageLength": 30,
							"autoWidth": false,
							// Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
							// setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js). 
							// So when dropdowns used the scrollable div should be removed. 
							//"dom": "<'row' <'col-md-12'T>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
							"fnDrawCallback": function () {
								//$("#browser_data_datatables_dom thead").hide();
							}
						});
						// handle datatable custom tools
						$('#datatables_data_table_tools_dom > li > a.tool-action').on('click',
							function () {
								var action = $(this).attr('data-action');
								browser_data_datatables_object.DataTable().button(action).trigger();
							});
						browser_data_datatables_object.api().rows.add(response.live_data);
						browser_data_datatables_object.api().draw();
						App.unblockUI();
					}
				});
			},
			error: function (jqXHR, textStatus, errorThrown) {
				// Handle errors here
				console.log('ERRORS: ' + textStatus);
				console.log('errorThrown: ' + errorThrown);
				console.log('jqXHR: ' + jqXHR);
				// STOP LOADING SPINNER
			}
		});
	});
});