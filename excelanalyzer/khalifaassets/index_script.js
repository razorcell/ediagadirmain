$(function () {
	//----------GENERAL INIT-------

	$.fn.select2.defaults.set("theme", "bootstrap");
	// $('#logs_portlet').scroll();//maybe not needed
	// setInterval(function () { sendLogsFunction('ECB'); }, 1000);
	//----------UPDATE SOURCE INIT-------

	var files;
	$("#updatedb").prop('disabled', true);
	$('input[type=file]').val('');
	var username = $('#username').text();
	var user_name_form_data = new FormData();
	user_name_form_data.append('username', username);

	$("#source_select_tag").select2({
		placeholder: 'Select an existing source',
		width: "off",
		ajax: {
			url: "send_sources_list.php",
			type: 'POST',
			dataType: 'json',
			data: user_name_form_data,
			processData: false, // Don't process the files
			contentType: false, // Set content type to false as jQuery will tell the server its a query string request                      
			delay: 250,
			// beforeSend: function () {
			// 	console.log('HAHA' + user_name_form_data);
			// },
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
	$('#source_select_tag').on('select2:select', function (e) {
		sendLogsFunction($('#source_select_tag option:selected').text());
		$("#uploadfile").prop('disabled', true);
		App.unblockUI('#select_file_block');
	});

	$('#source_select_tag').val('');
	$('#updatedb').click(updateDb);
	$('#uploadfile').on('click', uploadFiles);
	$('#file_input_tag').on('change', prepareUpload);

	//----------ADD SOURCE INIT-------

	$("#encoding_select_tag").select2({
		placeholder: 'Select encoding',
		width: "off",
		escapeMarkup: function (markup) {
			return markup;
		}, // let our custom formatter work
		minimumInputLength: 0
	});
	$('#add_new_source_button').click(add_new_source);
	$('#source_name_input').val('');
	$('#required_columns').val('');
	$('#ignored_rows').val('');

	//----------DELETE SOURCE INIT-------

	$("#source_select_delete_tag").select2({
		placeholder: 'Select an existing source',
		width: "off",
		ajax: {
			url: "send_sources_list.php",
			dataType: 'json',
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
	$('#delete_source_button').click(deleteSource);
	$('#source_select_delete_tag').on('select2:select', function (e) {
		sendLogsFunction($('#source_select_delete_tag option:selected').text());
		$("#delete_source_button").prop('disabled', false);
		// App.unblockUI('#select_file_block');
	});
	//----------UPDATE SOURCE BLOCK UI -------

	// $("#delete_source_button").prop('disabled', true);
	// $("#file_input_tag").prop('disabled', true);
	// $("#uploadfile").prop('disabled', true);
	// $("#updatedb").prop('disabled', true);
	App.blockUI({
		target: '#select_file_block',
		animate: true
	});
	App.blockUI({
		target: '#upload_and_run_block',
		animate: true
	});


	//----------DELETE SOURCE BLOCK UI -------

	$("#delete_source_button").prop('disabled', true);

	// setInterval(function () { console.log("Hello"); }, 1000);
	sendLogsFunction('');

	//--------------------FUNCTIONS -------------


	function updateDb(event) {
		var source = $('#source_select_tag option:selected').text();
		//console.log(source);
		event.stopPropagation(); // Stop stuff happening
		event.preventDefault(); // Totally stop stuff happening
		if (files.length === 0) {
			show_message("Please select a CSV file");
		} else if (source.length === 0) {
			show_message("Please select a Source");
		} else {
			var progress_timer = setInterval(sendProgressFunction, 2000);
			var logs_timer = setInterval(function () { sendLogsFunction(source); }, 2000);
			var file_name = files[0].name;
			var data = new FormData();
			data.append('file_name', file_name);
			data.append('source', source);
			$.ajax({
				url: 'process_csv_file.php',
				type: 'POST',
				data: data,
				cache: false,
				dataType: 'json',
				processData: false, // Don't process the files
				contentType: false, // Set content type to false as jQuery will tell the server its a query string request
				beforeSend: function () {
					$("#updatedb").prop('disabled', true);
					$("#uploadfile").prop('disabled', true);
					$("#progress_bar_updating").show();
					App.blockUI({
						target: '#dashboard_portlet_header'
					});
					App.blockUI({
						target: '#dashboard_portlet_body',
						animate: true
					});
				},
				success: function (data, textStatus, jqXHR) {
					sendProgressFunction();
					sendLogsFunction(source);
					$("#uploadfile").prop('disabled', false);
					$("#progress_bar_updating").hide();
					App.unblockUI('#dashboard_portlet_header');
					App.unblockUI('#dashboard_portlet_body');
					App.blockUI({
						target: '#select_file_block',
						animate: true
					});
					App.blockUI({
						target: '#upload_and_run_block',
						animate: true
					});
					setTimeout(function () {
						clearInterval(progress_timer);
					}, 5000);
					setTimeout(function () {
						clearInterval(logs_timer);
					}, 5000);
					if (data.status === 'success') {
						show_message("Source data updated successfully !", 10000,
							'success');
					} else { }
				},
				error: function (jqXHR, textStatus, errorThrown) {
					$("#uploadfile").prop('disabled', false);
					// Handle errors here
					console.log('ERRORS: ' + textStatus);
					console.log('errorThrown: ' + errorThrown);
					console.log('jqXHR: ' + jqXHR);
					show_message("There was an error call Khalifa !");
					App.unblockUI('#dashboard_portlet_header');
					setTimeout(function () {
						clearInterval(progress_timer);
					}, 5000);
					setTimeout(function () {
						clearInterval(logs_timer);
					}, 5000);
					// STOP LOADING SPINNER
				}
			});
		}
	}
	function show_message(msg, timeout = 5000, type = 'danger') {
		$.bootstrapGrowl(msg, {
			ele: '#dashboard_portlet', // which element to append to
			type: type, // (null, 'info', 'danger', 'success', 'warning')
			offset: {
				from: 'top',
				amount: 10
			}, // 'top', or 'bottom'
			align: 'right', // ('left', 'right', or 'center')
			width: 'auto', // (integer, or 'auto')
			delay: timeout, // Time while the message will be displayed. It's not equivalent to the *demo* timeOut!
			allow_dismiss: true, // If true then will display a cross to close the popup.
			stackup_spacing: 10 // spacing between consecutively stacked growls.
		});
	}
	function prepareUpload(event) {
		App.unblockUI('#select_file_block');
		$("#uploadfile").prop('disabled', false);
		files = event.target.files;
	}
	function uploadFiles(event) {
		event.stopPropagation(); // Stop stuff happening
		event.preventDefault(); // Totally stop stuff happening
		if (files.length === 0) {
			show_message("Please select an Excel file !");
		} else {
			var source = $('#source_select_tag option:selected').text();
			var data = new FormData();
			$.each(files, function (key, value) {
				data.append(key, value);
			});
			data.append('source', source);
			var logs_timer = setInterval(function () { sendLogsFunction(source); }, 1000);
			$.ajax({
				url: 'upload_script.php',
				type: 'POST',
				data: data,
				cache: false,
				dataType: 'json',
				processData: false, // Don't process the files
				contentType: false, // Set content type to false as jQuery will tell the server its a query string request
				beforeSend: function () {
					App.blockUI({
						target: '#dashboard_portlet_header'
					});
				},
				success: function (data, textStatus, jqXHR) {
					App.unblockUI('#dashboard_portlet_header');
					$("#updatedb").prop('disabled', false);
					if (typeof data.error === 'undefined') {
						// Success so call function to process the form
						$("#updatedb").prop('disabled', false);
						App.unblockUI('#upload_and_run_block');
						show_message("File uploaded successfully !", 5000,
							'success');
					} else {
						// Handle errors here
						console.log('ERRORS: ' + data.error);
					}
					setTimeout(function () {
						clearInterval(logs_timer);
					}, 1000);
				},
				error: function (jqXHR, textStatus, errorThrown) {
					// Handle errors here
					console.log('ERRORS: ' + textStatus);
					console.log('errorThrown: ' + errorThrown);
					console.log('jqXHR: ' + jqXHR);
					App.unblockUI('#dashboard_portlet_header');
					setTimeout(function () {
						clearInterval(logs_timer);
					}, 5000);
				}
			});
		}
	}
	function deleteSource() {
		event.stopPropagation(); // Stop stuff happening
		event.preventDefault(); // Totally stop stuff happening
		var source_name_delete = $('#source_select_delete_tag option:selected').text();
		var admin_password_delete_source = $('#admin_password_delete_source').val();
		if (!admin_password_delete_source) {
			show_message("Admin Password required !",
				6000, 'danger');
			return;
		}
		if (!source_name_delete) {
			show_message("Source name required !",
				6000, 'danger');
			return;
		}
		var logs_timer = setInterval(function () { sendLogsFunction(source_name_delete); }, 1000);
		var data = new FormData();
		data.append('source', source_name_delete);
		data.append('admin_password', admin_password_delete_source);
		$.ajax({
			url: 'delete_source.php',
			type: 'POST',
			data: data,
			cache: false,
			dataType: 'json',
			processData: false, // Don't process the files
			contentType: false, // Set content type to false as jQuery will tell the server its a query string request            
			beforeSend: function () {
				App.blockUI({
					target: '#dashboard_portlet_header'
				});
				// $("#delete_source").prop('disabled', true);
			},
			success: function (data, textStatus, jqXHR) {
				App.unblockUI('#dashboard_portlet_header');
				if (data.status === 'success') {
					show_message("Source deleted successfully !", 6000,
						'success');
				} else {
					show_message("Error in Source delete, Check logs or Call Khalifa !",
						6000, 'danger');
				}
				setTimeout(function () {
					clearInterval(logs_timer);
				}, 5000);
				$('#source_select_delete_tag').val();
				// $("#delete_source").prop('disabled', false);
			},
			error: function (jqXHR, textStatus, errorThrown) {
				// Handle errors here
				console.log('ERRORS: ' + textStatus);
				console.log('errorThrown: ' + errorThrown);
				console.log('jqXHR: ' + jqXHR);
				App.unblockUI('#dashboard_portlet_header');
				show_message("Error in Source delet, Call Khalifa !",
					6000, 'danger');
				setTimeout(function () {
					clearInterval(logs_timer);
				}, 5000);
				// STOP LOADING SPINNER
			}
		});
	}
	function add_new_source() {
		var source_name = $('#source_name_input').val();
		var columns = $('#required_columns').val();
		var ignored_rows = $('#ignored_rows').val();
		var database_password = $('#database_password').val();
		var admin_password = $('#admin_password').val();
		// var file_encoding = $('#source_select_tag').val();
		var file_encoding = $('#encoding_select_tag option:selected').text();
		if (!admin_password) {
			show_message("Admin Password required !",
				6000, 'danger');
			return;
		}
		if (!database_password) {
			show_message("Database Password required !",
				6000, 'danger');
			return;
		}
		if (!source_name) {
			show_message("Source name required !",
				6000, 'danger');
			return;
		}
		if (!columns) {
			show_message("Captured Columns required !",
				6000, 'danger');
			return;
		}
		if (!file_encoding) {
			show_message("Select encoding type !",
				6000, 'danger');
			return;
		}
		var logs_timer = setInterval(function () { sendLogsFunction(source_name); }, 1000);
		var data = new FormData();
		data.append('source_name', source_name);
		data.append('columns', columns);
		data.append('admin_password', admin_password);
		data.append('database_password', database_password);
		data.append('file_encoding', file_encoding);
		if (ignored_rows) {
			data.append('ignored_rows', ignored_rows);
		}
		$.ajax({
			url: 'addnewsource.php',
			type: 'POST',
			data: data,
			cache: false,
			dataType: 'json',
			processData: false, // Don't process the files
			contentType: false, // Set content type to false as jQuery will tell the server its a query string request            
			beforeSend: function () {
				App.blockUI({
					target: '#dashboard_portlet_header'
				});
			},
			success: function (data, textStatus, jqXHR) {
				App.unblockUI('#dashboard_portlet_header');
				if (data.status === 'success') {
					show_message("Table created successfully !", 6000,
						'success');
				} else {
					show_message("Error in table creation, Check logs or Call Khalifa !",
						6000, 'danger');
				}
				setTimeout(function () {
					clearInterval(logs_timer);
				}, 5000);
			},
			error: function (jqXHR, textStatus, errorThrown) {
				// Handle errors here
				console.log('ERRORS: ' + textStatus);
				console.log('errorThrown: ' + errorThrown);
				console.log('jqXHR: ' + jqXHR);
				App.unblockUI('#dashboard_portlet_header');
				show_message("Error in table creation, Call Khalifa !",
					6000, 'danger');
				setTimeout(function () {
					clearInterval(logs_timer);
				}, 5000);
				// STOP LOADING SPINNER
			}
		});
	}

	function sendProgressFunction() {
		$.ajax({
			url: 'send_progress_json.php',
			type: 'GET',
			cache: false,
			dataType: 'json',
			processData: false, // Don't process the files
			contentType: false, // Set content type to false as jQuery will tell the server its a query string request                                   
			success: function (data, textStatus, jqXHR) {
				//console.log(data.progress_style);
				$('#progress_bar1').attr('style', data.progress_style);
				$("#updatedb").html(data.progress_value);
			},
			error: function (jqXHR, textStatus, errorThrown) {
				// Handle errors here
				console.log('ERRORS: ' + textStatus);
				console.log('errorThrown: ' + errorThrown);
				console.log('jqXHR: ' + jqXHR);
				// STOP LOADING SPINNER
			}
		});
	};
	function sendLogsFunction(source) {
		// var source = $('#source_select_tag option:selected').text();
		var data = new FormData();
		data.append('source', source);
		$.ajax({
			url: 'send_logs.php',
			type: 'POST',
			data: data,
			cache: false,
			dataType: 'json',
			processData: false, // Don't process the files
			contentType: false, // Set content type to false as jQuery will tell the server its a query string request                                   
			success: function (data, textStatus, jqXHR) {
				//$('#code_editor_demo_1').prop('value',data.log1_text);
				//$('#code_editor_demo_2').prop('value',data.log2_text);
				$('#source_specific_logs_div').html(data.source_specific_logs);
				$('#general_logs_div').html(data.general_logs);
			},
			error: function (jqXHR, textStatus, errorThrown) {
				// Handle errors here
				console.log('ERRORS: ' + textStatus);
				console.log('errorThrown: ' + errorThrown);
				console.log('jqXHR: ' + jqXHR);
				// STOP LOADING SPINNER
			}
		});
	};
});