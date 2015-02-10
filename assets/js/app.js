// start!
function helperFormatMoney(amount, currency_symbol_before, currency_symbol_after, thousands_separator, decimal_point,	significant_after_decimal_pt, display_after_decimal_pt)
{
	// 30JUL2008 MSPW  Fixed minus display by moving this line to the top
	// We need to know how the significant digits will alter our displayed number
	var significant_multiplier = Math.pow(10, significant_after_decimal_pt);

	// Only display a minus if the final displayed value is going to be <= -0.01 (or equivalent)
	var str_minus = (amount * significant_multiplier <= -0.5 ? "-" : "");

	// Sanity check on the incoming amount value
	amount = parseFloat(amount);
	if( isNaN(amount) || Math.LOG10E * Math.log(Math.abs(amount)) +
			Math.max(display_after_decimal_pt, significant_after_decimal_pt) >= 21 )
	{
		if(isNaN(amount))return '';
		return str_minus + currency_symbol_before +
			(isNaN(amount)? "#" : "####################".substring(0, Math.LOG10E * Math.log(Math.abs(amount)))) +
			(display_after_decimal_pt >= 1?
				(decimal_point + "##################".substring(0, display_after_decimal_pt)) : "") +
			currency_symbol_after;
	}
	
	// Make +ve and ensure we round up/down properly later by adding half a penny now.
	amount = Math.abs(amount) + (0.5 / significant_multiplier);

	amount *= significant_multiplier;
	
	var str_display = parseInt(
		parseInt(amount) * Math.pow(10, display_after_decimal_pt - significant_after_decimal_pt) ).toString();
			
	// Prefix as many zeroes as is necessary and strip the leading 1
	if( str_display.length <= display_after_decimal_pt )
		str_display = (Math.pow(10, display_after_decimal_pt - str_display.length + 1).toString() +
			str_display).substring(1);
			
	var comma_sep_pounds = str_display.substring(0, str_display.length - display_after_decimal_pt);
	var str_pence = str_display.substring(str_display.length - display_after_decimal_pt);
	
	if( thousands_separator.length > 0 && comma_sep_pounds.length > 3 )
	{
		comma_sep_pounds += ",";

		// We need to do this twice because the first time only inserts half the commas.  The reason is
		// the part of the lookahead ([0-9]{3})+ also consumes characters; embedding one lookahead (?=...)
		// within another doesn't seem to work, so (?=[0-9](?=[0-9]{3})+,)(.)(...) fails to match anything.
		if( comma_sep_pounds.length > 7 )
			comma_sep_pounds = comma_sep_pounds.replace(/(?=[0-9]([0-9]{3})+,)(.)(...)/g, "$2,$3");

		comma_sep_pounds = comma_sep_pounds.replace(/(?=[0-9]([0-9]{3})+,)(.)(...)/g, "$2,$3");

		// Remove the fake separator at the end, then replace all commas with the actual separator
		comma_sep_pounds = comma_sep_pounds.substring(0, comma_sep_pounds.length - 1).replace(/,/g, thousands_separator);
	}

	return str_minus + currency_symbol_before +
		comma_sep_pounds + (display_after_decimal_pt >= 1? (decimal_point + str_pence) : "") +
		currency_symbol_after;
}

function formatMoney(value) {
	return helperFormatMoney(value, '', '', ',', '.', 2, 2);
}

var oLang = {
		"sLengthMenu": "_MENU_",
		"sSearch": "Kata Kunci",
		"sEmptyTable": "Tidak ada data yang dapat ditampilkan",
		"oPaginate": { "sFirst": "<<", "sLast": ">>", "sNext" : ">", "sPrevious" : "<" },
		"sInfo": "Jumlah : _TOTAL_",
		"sInfoEmpty": ""
	}
function tableSearchSupport(params, envi, otable)
{
	if(params.filter_by.length>0) {
	
		var i, kat;
		var filter = params.filter_by;
		
		kat = '<select name="kategori" class="kategori">';
		
		for(i = 0; i < filter.length; i++) {
			kat += '<option value="' + filter[i].id + '">' + filter[i].label + '</option>';
		}
		
		kat += '</select>';
		envi.find(".dataTables_filter").html(kat + '<div class="search_area"><input type="text" name="q" class="q" /><div class="search_go" ><!--<img src="assets/css/images/searchglass.png" />--></div></div>');
	}
	else envi.find(".dataTables_filter").html('');
	envi.find('.search_go').click( function() { otable.fnDraw(); });
	
	envi.find('.q').keypress(function(evt) {
  		if (evt.keyCode == '13') {
     		otable.fnDraw();
			return false;
   		}
	});	
}

function session_check(json)
{
	if(json.url)
	{
		//alert("Session sudah habis.\nKami akan membawa Anda ke halaman Login.");
		//logout_redirect(json.url);
	}
}

function logout_redirect(url)
{
	if(url)window.location.href = url;
}
function ajaxOn() {
      $('.ajaxProgressBox').show();
}

function ajaxOff() {
      $('.ajaxProgressBox').fadeOut(250);	
}
$(function() {	

	$('body').ajaxStart(function() {
	      ajaxOn();	
	});
	
	$('body').ajaxComplete(function() {
	      ajaxOff();
	});
	
	$('body').ajaxSuccess(function() {
	      ajaxOff();	
	});
	
	$('body').ajaxStop(function() {
	      ajaxOff();	
	});
	
	$('body').ajaxError(function() {
	      ajaxOff();
	      alert('Server unable to produce expected response!');
	});
	
	ajaxOff();
	
	$('input.format_money').each(function() { 
		  var d = $(this);
		  var value = d.val();
		  d.val(formatMoney(value))
	});
	
	document.onkeydown = null;
	if (document.layers) document.captureEvents(Event.KEYDOWN);
	
	
});

function createTable(args) {	
	var params = {
		id 		: "#actionTable",
		listSource 	: "nowhere",	
		formSource 	: "nowhere", //include form
		formTarget	: "nowhere", //next page form
		submitTarget	: "nowhere",
		sendIDTarget	: "nowhere",
		column_id 	: 0,
		dblclick	: null,
		filter_by 	: [],
		aoColumnDefs	: [],
		bFilter : true,
		aLengthMenu : [[50, 100, 250, 500, -1], [50, 100, 250, 500, "All"]]
	}
	
	$.extend(params, args);
	var tabl = $(params.id);
	var rows = tabl.find('tbody');
	var envi = tabl.parent();
	
	var cmd  = envi.find('div.command_table');
	var edtr = envi.find('#editor');
	var selectedId = '';
	
	if (crud_mode.indexOf('c') < 0) cmd.find('#add').hide();
	
	var postJSON_lookup = function(url, data, success) {
		var q = envi.find('.q').val();
		var kat = envi.find('.kategori').val();
		
		var qvalue = (q == undefined ? '' : q);
		var katvalue = (kat == undefined ? '' : kat);
		
		if (data == null) data = new Array();
		
		data.push( { "name" : "q", "value" : qvalue } );
		data.push( { "name" : "kat", "value":  katvalue } );		
	
		$.ajax({
		  url: url,
		  dataType: 'json',
		  type : 'POST', 
		  data: data,
		  success: function (json) {
		  	session_check(json);		  	
			success(json);			
		}
		});
		
	}
	var bServerSide = (params.formTarget!="nowhere")?true:false;
	var oTable = tabl.dataTable({
			"sAjaxSource" : site_url + params.listSource,
			"bJQueryUI": true,
			"oLanguage": oLang,
			//"bInfo" : false,oLang
			"sPaginationType": "full_numbers",
			"aoColumns" : params.column_conf,
			"bAutoWidth": false,
			"fnServerData" : postJSON_lookup,
			"sScrollY": "100%",
			"sScrollX": "100%",
			"bScrollCollapse": true,
			"bServerSide": bServerSide,
			//"bProcessing": true,
			//"bServerSide": true,
			"bSort"	: true,
			"iDisplayLength"	: 50,
			"aLengthMenu"		: params.aLengthMenu,
			"_fnFeatureHtmlFilter" : null,
			"bFilter": params.bFilter,
			"sDom": '<"H"lfr>t<"F"ip<"toolbar">>',
			"aoColumnDefs": params.aoColumnDefs
		});
	//var form = envi.find('form');
	//form.attr('action', site_url + params.submitTarget);
	//form.attr('method', 'POST');
	
	envi.find("div.toolbar").after($(cmd));
	if(bServerSide)tableSearchSupport(params, envi, oTable);
	rows.click(function(event) {
		$(oTable.fnSettings().aoData).each(function (){
			$(this.nTr).removeClass('row_selected');
		});
		$(event.target.parentNode).addClass('row_selected');
		var pos = oTable.fnGetPosition(event.target.parentNode);
		var data = oTable.fnGetData(pos);
		selectedId = data[params.column_id];
		
	});
	if(params.dblclick!=null)
	{
	rows.dblclick(function(event) {
		//alert(selectedId);
		var data = 's=1&id='+selectedId;
		$.ajax({
			url: site_url+params.dialogPage,
			async : false,
			//dataType: 'json',
			type : 'GET', 
			data: data,
			success: function(data){$( "#dialog" ).html(data);}
		});
		$( "#dialog" ).dialog( "open" );
	});
	}
	function closeForm() {
		oTable.fnReloadAjax();
		edtr.slideUp(function() { edtr.html(''); });					
	}
	cmd.find('input').click(function() {
		
		var ajaxData = "";
		switch ($(this).attr('id'))	{
			case 'edit':
				
				if (isNaN(parseInt(selectedId))) {
					alert('Pilih data yang akan dilihat');
					return;
				}
				if(params.formTarget!="nowhere")
				{
				window.location.href = site_url + params.formTarget + '/' + selectedId;
				return;
				}
				ajaxData  = { row_id : selectedId };
				break;
				
			case 'refresh':
				oTable.fnReloadAjax();
				return;
				
			case 'submit':
				form.submit();
				break;
				
			case 'add': 
				if(params.formTarget!="nowhere")
				{	
					window.location.href = site_url + params.formTarget;
					return;
				}
				break;
				
			case 'send':
				if (isNaN(parseInt(selectedId))) {
					alert('Pilih data yang akan diproses');
					return;
				}
				
				window.location.href = site_url + params.sendIDTarget + '/' + selectedId;
				return;
				
				
			case 'delete':
			
			if (isNaN(parseInt(selectedId))) {
				alert('Pilih Data yang akan dihapus..');
				return;
			}
			
			if (!confirm("Anda yakin menghapus data ini ?")) return;
		
				
			//rowInputs = $('input, select, textarea', selectedNode).serializeArray();
			ajaxData  = { row_id : selectedId };
			
			//$.extend(ajaxData, rowInputs);
			
			$.ajax({
				url : site_url + params.actionTarget + '/1',
				dataType : "json",
				data : ajaxData,
				type : "POST",
				success : function (data) {
						if (data.type == 'success') {
							alert('Hapus Sukses. Terima Kasih.');
							oTable.fnReloadAjax();							
						}
						else {
							alert('Maaf, Hapus Gagal.\n'+data.content);
						}
					}
			});
			
			return;
			
			
			case 'active':
			
			if (isNaN(parseInt(selectedId))) {
				alert('Pilih Data yang akan anda aktifkan');
				return;
			}
			
			if (!confirm("Anda yakin mengaktifkan data ini ?")) return;
		
				
			//rowInputs = $('input, select, textarea', selectedNode).serializeArray();
			ajaxData  = { row_id : selectedId };
			
			//$.extend(ajaxData, rowInputs);
			
			$.ajax({
				url : site_url + params.activeTarget ,
				dataType : "json",
				data : ajaxData,
				type : "POST",
				success : function (data) {
						if (data.type == 'success') {
							alert('Data Sukses Diaktifkan. Terima Kasih.');
							oTable.fnReloadAjax();							
						}
						else {
							alert('Maaf, Data Gagal Diaktifkan.\n'+data.content);
						}
					}
			});
			
			return;
		}
		$.ajax({
			url : site_url + params.formSource, 
			dataType : "html",
			data: ajaxData,
			type: "POST",
			success : function(data) {
				// ------------
				edtr.html('<div id="gap">' + data + '</div>');
				edtr.slideDown();					
			
				edtr.find('#submit').click(function() {
				
					var thisButton = $(this);
					thisButton.attr('disabled', 'disabled');
				
					var data = edtr.find('form').find('input, select, textarea');
					$.ajax({
						url 	: site_url + params.actionTarget,
						dataType: "json",
						data	: data.serialize(),
						type	: "POST",
						success	: function(data) { 
								
								if (data.type == 'success') {
									alert('Simpan Berhasil');
									closeForm();
									return;
								}
								
								edtr.find('.ajax_status').html(data.content);
								thisButton.removeAttr('disabled');
								show_error_input(data);
								
							},
						error	: function() {
						
							thisButton.removeAttr('disabled');
							edtr.find('.ajax_status').html(data.content);
							
						}
					})
				});
				
				edtr.find('#cancel').click(function() {
					edtr.find('#cancel').click(function() { $(this).unbind('click'); });
					closeForm();
				});
				
				// ------------
			}
		});
		
	});
	
	return oTable;
}

function createTableFixed(args, osettings_user)
{
	var params = {
		id 				: "#actionTable",
		submitTarget	: "nowhere",
		formTarget		: "nowhere",
		nextPage		: "nowhere",
		column_id 		: 0,
		useSearch		: false
	}
	
	$.extend(params, args);
	
	
	var tabl = $(params.id);
	var rows = tabl.find('tbody');
	var envi = tabl.parent();
	var panl = envi.find('#panel');
	var status = envi.find('.ajax_status');
	var selectedId = '';
	
	var osettings = {
			"bJQueryUI": true,
			"oLanguage": oLang,
			"bPaginate" : false,
			"aoColumns" : params.column_conf,
			"bAutoWidth": false,
			"_fnFeatureHtmlFilter" : null,
			"sDom": '<"H"lfr>t<"F"ip<"toolbar">>',
			"bFilter": false,
			"bSort"	: true
	};
	
	$.extend(osettings, osettings_user);

	var otable = tabl.dataTable(osettings);
	
	var form = envi.find('form');
	form.attr('action', site_url + params.submitTarget);
	form.attr('method', 'POST');
	$("div.toolbar").after($(panl));
	//tabl.after($(panl));
	if (!params.useSearch) envi.find('.fg-toolbar:first').hide();
	tabl.find('th').addClass('ui-state-default');
	
	var input_data = envi.find('input, textarea, select');
	
	rows.mousedown(function(event) {
		$(otable.fnSettings().aoData).each(function (){
			$(this.nTr).removeClass('row_selected');
		});
		
		var pos = otable.fnGetPosition(event.target.parentNode);
		
		if (!isNaN(pos)) {
			var data = otable.fnGetData(pos);		
			selectedId = data[params.column_id];
		}
		
		$(event.target.parentNode).addClass('row_selected');
	});
	
	panl.find('input').click(function() {
		
		switch ($(this).attr('id'))	{
			case 'choose':
				
				if (isNaN(parseInt(selectedId))) {
					alert('Mohon pilih data dahulu');
					break;
				}
				
				window.location.href = site_url + params.formTarget + '/' + selectedId;
				break;
				
			case 'submit':
				$.ajax({
					url 	: site_url + params.submitTarget,
					dataType: "json",
					data	: input_data.serialize(),
					type	: "POST",
					success	: 
					
							function(feedback) { 
							
									if (feedback.type == 'success') {
										alert('Simpan Berhasil');
										window.location.replace(site_url + params.nextPage);
									}
									else status.html(feedback.content);
									
							}
				});
				break;

		}
		
	});
	
	return otable;
}
function createTableForm(args) {
	
	var params = {
		id 				: "#example",
		listSource 		: "nowhere",
		formSource 		: "nowhere",
		actionTarget	: "nowhere",
		redirectUrl		: "nowhere",
		onComplete		: null,
		column_id		: 0,
		sScrollY		: "500px"
	}
	
	$.extend(params, args);
	
	var tabl = $(params.id);
	var rows = tabl.find('tbody');
	var envi = tabl.parent();
	var panl = envi.find('div.command_table');
	var edtr = envi.find('#editor');
	
	var btn_add = envi.find('#add');
	var btn_edit = envi.find('#edit');
	var btn_delete = envi.find('#delete');

	
	if (crud_mode.indexOf('c') < 0) btn_add.hide();
	if (crud_mode.indexOf('u') < 0) btn_edit.hide();
	if (crud_mode.indexOf('d') < 0) btn_delete.hide();
	
	var selectedId = '';
	var selectedNode = null;
	var fnServerData = function ( url, data, callback ) {
		data.push( { "name" : "_q", "value": '' } );
		$.ajax( {
			"url": url,
			"data": data,
			"success": function (json) {
		  		session_check(json);
				callback(json);			
				},
			"dataType": "json",
			"cache": false,
			"error": function (xhr, error, thrown) {
				if ( error == "parsererror" ) {
				alert( "DataTables warning: JSON data from server could not be parsed. "+
								"This is caused by a JSON formatting error." );
				}
			}
			} );
		};
	var otable = tabl.dataTable({
		"oLanguage": oLang,
		"sAjaxSource" : site_url + params.listSource,
		"fnServerData" : fnServerData,
		"bInfo" : false,
		"bJQueryUI": true,
		"sScrollY": params.sScrollY,
		"sScrollX": "100%",
		"bScrollCollapse": true,
		"sPaginationType": "full_numbers",
		"aoColumns" : params.column_conf,
		"bAutoWidth": false,
		"sDom": '<"H">t<"F"<"toolbar">i>',
		"fnInitComplete" : params.onComplete,
		"iDisplayLength" : 1000,
		"bSort" : false
	});
	
	edtr.hide();
	
	function closeForm() {
		otable.fnReloadAjax(otable.sAjaxSource, function() { if (params.onComplete != null) params.onComplete(); });
		edtr.slideUp(function() { edtr.html(''); });					
	}
	tabl.find(".toolbar").after($(panl));
	//$("div.toolbar").after($(panl));
	//tabl.after($(panl));
	
	// select a row
	rows.mousedown(function(event) {
	
		$(otable.fnSettings().aoData).each(function () {
			$(this.nTr).removeClass('row_selected');
		});
		
		var pos = otable.fnGetPosition(event.target.parentNode);
		var data = otable.fnGetData(pos);
		
		selectedId = data[params.column_id];
		selectedNode = event.target.parentNode;
		
		$(event.target.parentNode).addClass('row_selected');
	});

	panl.find('input').click(function() {
		
		var ajaxData = "";
		
		switch ($(this).attr('id'))	{
		case 'redirect':
			
			if (isNaN(parseInt(selectedId))) {
				alert('Pilih Data yang akan dibuka');
				return;
			}
			window.location.replace(site_url + params.redirectUrl + '/' + selectedId);
			
			break;
		case 'edit':
			
			if (isNaN(parseInt(selectedId))) {
				alert('Pilih Data yang akan Edit');
				return;
			}
			
			ajaxData = selectedId;

			
			break;
			
		case 'delete':
			
			if (isNaN(parseInt(selectedId))) {
				alert('Pilih Data yang akan dihapus');
				return;
			}
			
			if (!confirm("Anda yakin menghapus data ini ?")) return;
		
				
			rowInputs = $('input, select, textarea', selectedNode).serializeArray();
			ajaxData  = { row_id : selectedId };
			
			$.extend(ajaxData, rowInputs);
			
			$.ajax({
				url : site_url + params.actionTarget + '/1',
				dataType : "json",
				data : ajaxData,
				type : "POST",

				success : function (data) {
						if (data.type == 'success') {
							otable.fnReloadAjax(otable.sAjaxSource, function() { if (params.onComplete != null) params.onComplete(); });
							alert('Hapus Sukses. Terima Kasih.');
						}
						else alert('Maaf, Hapus Gagal');
					}
			});
			
			return;
			
		case 'refresh':
			otable.fnReloadAjax(otable.sAjaxSource, function() { if (params.onComplete != null) params.onComplete(); });
			return; 
		}
		
		$.ajax({
				url : site_url + params.formSource, 
				dataType : "html",
				data: {row_id : ajaxData},
				type: "POST",
				success : function(data) {
					// ------------
					edtr.html(data);
					var status = edtr.prepend('<div class="ajax_status"></div>');
					edtr.slideDown();					
					edtr.find('input').each(function() {
						if($(this).hasClass('required'))$(this).after(' <span style="color:red">*</span>');
					});
					edtr.find('#submit').click(function() {
					
						var thisButton = $(this);
						thisButton.attr('disabled', 'disabled');
						
						var data = edtr.find('form').find('input, select, textarea');
						$.ajax({
							url 	: site_url + params.actionTarget,
							dataType: "json",
							data	: data.serialize(),
							type	: "POST",
							success	: function(data) { 
									
									if (data.type == 'success') {
										alert('Simpan Berhasil');
										closeForm();
										return;
									}
									else
									{
										edtr.find('input').each(function() {
											$(this).attr('title','');
											$(this).removeClass('error');
										});
										edtr.find('textarea').each(function() {
											$(this).attr('title','');
											$(this).removeClass('error');
										});
										if(data.content)status.html(data.content);	
										show_error_input(data);
									}
									//edtr.find('.ajax_status').html(data.content);
									thisButton.removeAttr('disabled');
									
								},
							error	: function() {
							
								thisButton.removeAttr('disabled');
								edtr.find('.ajax_status').html(data.content);
								
							}
						})
					});
					
					edtr.find('#cancel').click(function() {
						edtr.find('#cancel').click(function() { $(this).unbind('click'); });
						closeForm();
					});
					
					// ------------
				}
		});

	});
	
	return otable;
}
function createForm(args) {
	
	var params = {
		id 		: "#id_form_nya",
		printTarget		: "nowhere", 
		actionTarget	: "nowhere",
		backPage		: "nowhere",
		nextPage		: "nowhere",
		onFormActive	: null
	}
	
	$.extend(params, args);
	
	var envi = $(params.id);
	var form_area = envi.find('.form_area');
	form_area.prepend('<div class="ajax_status" style="display:none;"></div>');
	var status = envi.find('.ajax_status');
	var row_id = envi.find('input[type="hidden"][name="row_id"]').val();
	var cmd = envi.find('.command_bar');
	var input_data = envi.find('input, textarea, select');
	var all_input = envi.find('input[type!="button"][type!="submit"][type!="reset"][name!="id"][id!="fixed_state"], textarea, select[id!="fixed_state"]');
	var all_component = envi.find('#com_popup');

	var btn_submit = cmd.find('#submit');
	var btn_enable = cmd.find('#enable');
	var btn_edit = cmd.find('#edit');
	var btn_delete = cmd.find('#delete');	
	var btn_cancel = cmd.find('#cancel');
	var btn_print = envi.find('#print');
	if (row_id.length != 0) {
		all_input.attr('disabled', 'disabled');
		all_component.hide();
		btn_submit.hide();
		//btn_add.hide();
		if (crud_mode.indexOf('u') < 0) btn_enable.hide();
		if (crud_mode.indexOf('d') < 0) btn_delete.hide();
	} else {
		//btn_discard.hide();
		btn_enable.hide();
		btn_delete.hide();
		if (crud_mode.indexOf('c') < 0) btn_submit.hide();
	}
	btn_print.click(function() {
		var is_ok = confirm('Anda ingin mencetak dokumen ini ?');
		if (is_ok == false) return;
		
		window.location.href=(site_url + params.printTarget);
	});
	btn_delete.click(function() {		
		var is_ok = confirm('Apa Anda yakin akan menghapus data ini ?');
		if (is_ok == false) return;
		
		$.ajax({
			url 	: site_url + params.actionTarget + '/1',
			dataType: "json",
			data	: input_data.serialize(),
			type	: "POST",
			success	: function(feedback) { 					
					if (feedback.type == 'success') {						
						alert(feedback.content);
						window.location.replace(site_url + params.nextPage + (feedback.param ? '/' + feedback.param : ''));
					}
					else {
						status.html(feedback.content);
					} 
				}
		});
	});
	btn_submit.click(function() {
		if (confirm('Anda ingin menyimpan data ini ?') == false) return;
		var thisButton = $(this);
		//thisButton.attr('disabled', 'disabled');
		
		status.html('');
		input_data ='';
		$('form').each(function(data){
			if($(this).attr('class')!='subform_area')
			{
			input_data += '&'+$(this).serialize();
			}
			//alert($(this));
		});
		$.ajax({
			url 	: site_url + params.actionTarget,
			dataType: "json",
			data	: input_data,
			type	: "POST",
			success	: function(feedback) {
					if (feedback.type == 'success') {
						alert(feedback.content);
						window.location.replace(site_url + params.nextPage + (feedback.param ? '/' + feedback.param : ''));
						//$( "#dialog" ).dialog( "close" );
					}
					else 
					{
						envi.find('input').each(function() {
							$(this).attr('title','');
							$(this).removeClass('error');
						});
						envi.find('textarea').each(function() {
							$(this).attr('title','');
							$(this).removeClass('error');
						});
						if(feedback.content)status.html(feedback.content);
						status.show( 'blind', {}, 500 );
						//	
						show_error_input(feedback);
					}
					
				}
		});
	});
	
	btn_cancel.click(function() {
		//$( "#dialog" ).dialog( "close" );
		window.location.replace(site_url + params.backPage);
	});
	btn_enable.click(function() {
		$(this).hide();
		btn_submit.show();
		all_input.removeAttr('disabled');
	});
	var input_code=envi.find('input#code');
	if(input_code.val()){
		input_code.attr('readonly', 'readonly');
		all_input.attr('disabled', 'disabled');
		//btn_edit.show();
		//btn_submit.hide();
	}
	else
	{
	//btn_edit.hide();
	//btn_submit.show();
	//btn_delete.hide();
	}
	envi.find('input').each(function() {
		if($(this).hasClass('required'))$(this).after(' <span style="color:red"></span>');
		//$(this).hasClass('required').after(' <span style="color:red">*</span>');
	});
	//var tabl = form_area.find('table');
	//cmd.before('<span style="color:red;"></span> <span class="small_note"></span>');
	
}
function show_error_input(feedback)
{
	var i=0;
	var iname, ival;
	if(!feedback.field)return;
	$('.ajax_status').html(feedback.errmsg);
	$('.ajax_status').show( 'blind', {}, 500 );
	for(i=0;i<feedback.field.length;i++)
	{
		iname = feedback.field[i]; ival = feedback.msg[i];
		if($('input[name="'+iname+'"]').attr('class') == 'com_id')
		{
			var inputarea = $('input[name="'+iname+'"]');
			var lookuparea = inputarea.parent();
			var inputdesc = lookuparea.find('.com_input');
			inputdesc.attr('title', ival);
			inputdesc.addClass('error');
			
		}
		else
		{
			$('input[name="'+feedback.field[i]+'"]').attr('title',feedback.msg[i]);
			$('input[name="'+feedback.field[i]+'"]').addClass('error');
			
			$('textarea[name="'+feedback.field[i]+'"]').attr('title',feedback.msg[i]);
			$('textarea[name="'+feedback.field[i]+'"]').addClass('error');
		}
	}
}

function getDayName(i){
	var dayNames = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
	return dayNames[i];
}

function getMonthName(i){
	var monthNames = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Ags", "Sep", "Okt", "Nov", "Des"];
	return monthNames[i];
}
function setTwoDigits(digit){
	if(digit<10){
		digit = "0" + digit;
    }
    return digit;
}
function postJSONAsync(url, data, success) {	
	$.ajax({
	  url: url,
	  async : false,
	  dataType: 'json',
	  type : 'POST', 
	  data: data,
	  success: function (json) {
		  	session_check(json);		  	
			success(json);			
		}
	});
}
function createLookUp(args) {
	var params = {
		table_id		: "#lookup_table",
		table_width		: 400,
		listSource 		: '',
		dataSource		: '',	
		column_id 		: 0,
		component_id		: "#lookup_component",
		i_market		: '',
		i_branch		: '',
		useDetail		: false,
		isDetailHidden		: true,
		onSelect		: null,
		onData			: null,
		filter_by 		: []		
	}	
	
	$.extend(params, args);
	var tabl = $(params.table_id);
	var rows = tabl.find('tbody');
	var envi = tabl.parent();
	var panl = envi.find('#panel');
	
	var fenvi = $(params.component_id);
	var finput = fenvi.find('.com_input');
	var fbutton = fenvi.find('.com_popup');
	var fdesc = fenvi.find('.com_desc');
	var fid = fenvi.find('.com_id');
	var i_market = $(params.i_market);
	var i_branch = $(params.i_branch);
	
	if (params.useDetail) {
		fenvi.append('<div class="com_detail"></div>');
		var fdetail = fenvi.find('.com_detail');
		params.dataSource += (params.useDetail ? '/1' : '');
		
		if (params.isDetailHidden) {
			fbutton.after('<div class="iconic_base iconic_window com_popup"></div>');
			fenvi.find('.iconic_window').click(function() {
				fdetail.toggle(100);
			});
			fdetail.hide();
		}
	}
	
	var old_send_data = '';
	var selectedId = '';
	var currentRow = null;
	var btnNextPage = null;
	var btnPrevPage = null;
	var btnPick = null;
	
	var kh = function(e) {	

		if (!currentRow) return;
		var pK = e ? e.which : window.event.keyCode;
		
		$(otableLookUp.fnSettings().aoData).each(function (){
			$(this.nTr).removeClass('row_selected');
		});
		
		//salert(pK);
		
		switch(pK) {
			case 38: 
				if ($(currentRow).prev().length > 0) currentRow = $(currentRow).prev(); 
				break;
			case 40: 
				if ($(currentRow).next().length > 0) currentRow = $(currentRow).next();
				break;
			case 39: // right
				if (btnNextPage) btnNextPage.click();
				break;
			case 37: // left
				if (btnPrevPage) btnPrevPage.click();
				break;
//			case 13:
//				if (btnPick) btnPick.click();
//				break;
			default:
				return true;
		}
		
		// alert(pK);
		
		var o = null;
		if (!currentRow.each) return false;
		
		currentRow.each(function() { o = this; });
		
		var pos = otableLookUp.fnGetPosition(o);
		var data = otableLookUp.fnGetData(pos);
		selectedId = data[params.column_id];
		
		e.preventDefault();
		e.stopPropagation();
		$(currentRow).addClass('row_selected');
		$('input.bb', currentRow).focus();
		
		return false;
	}
	
	var getData = function(data_mode, data_id) {
	
		var send_data = {mode : data_mode, data : data_id, more : (params.onData != null ? params.onData() : null)};
		if(data_mode==2 && data_id==''){fdesc.html('');fid.val('');return;}
		postJSONAsync(site_url + params.dataSource, send_data, function(json) {
			finput.val(json.value);
			fdesc.html(json.desc);
			fid.val(json.id);
			if (params.useDetail) fdetail.html(json.detail)
			if(params.onSelect != null) params.onSelect(json.id, json.value, json.desc);
		});
		
		return send_data;
	}
	
	if(envi.length==0){getData(1, fid.val());return;}	// jika table_id tidak didefinisikan
	var postJSON_lookup = function(url, data, success) {
		
		var q = envi.find('.q').val();
		var kat = envi.find('.kategori').val();
		
		var qvalue = (q == undefined ? '' : q);
		var katvalue = (kat == undefined ? '' : kat);
		
		if (data == null) data = new Array();
		
		data.push( { "name" : "q", "value" : qvalue } );
		data.push( { "name" : "kat", "value":  katvalue } );
		data.push( { "name" : "more", "value" : (params.onData != null ? params.onData() : null) } );	
	
		$.ajax({
		  url: url,
		  dataType: 'json',
		  type : 'POST', 
		  data: data,
		  success: function (json) {
		  	session_check(json);		  	
			success(json);
		}
		});
	}
	
	//var _input = '<div style="width:0px; height:0px; overflow: hidden;"><input class="bb" /></div>';
	var id_market;
	id_market = i_market.val();
	
	if(id_market == undefined){
		id_market = '';
	}
	
	var otableLookUp = tabl.dataTable({
			"sAjaxSource" 		: site_url + params.listSource + '/' + id_market,
			"bJQueryUI"		: true,
			"oLanguage": oLang,
			//"bProcessing"		: true,
			"bServerSide"		: true,
			"bFilter" 		: true,
			"sScrollY": "180px",
			//"sScrollX": "300px",
			"bScrollCollapse": true,
			"sDom": '<"H"lfr>t<"F"ip<"lookup_toolbar">>',
			//"sDom": '<"H"lfr>t<"F"<"lookup_toolbar">ip>',
			"bInfo" 			: false,
			"sPaginationType"	: "full_numbers",
			"aoColumns" 		: params.column_conf,
			"fnRowCallback"		: function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
				//$('td:eq(0)', nRow).append(_input);
				$('td', nRow).each(function() {
					var tdmg = $('span', this);
					if (tdmg.size() > 0) $(this).addClass(tdmg.attr('value'));
					//alert(tdmg.size());
				});
				if (iDisplayIndex == 0) {					
					var pos = otableLookUp.fnGetPosition(nRow);
					var data = otableLookUp.fnGetData(pos);
					currentRow = nRow;
					selectedId = data[params.column_id];
					$(nRow).addClass('row_selected');
				}
				return nRow;
			},
			//"bAutoWidth"		: false,
			"fnServerData" 		: postJSON_lookup,
			"_fnFeatureHtmlFilter" : null
		});
		
	otableLookUp.fnSetColumnVis(0, false, false); // hidden colomn 1
	//tabl.after($(panl));
	envi.find(".lookup_toolbar").after($(panl));
	
	envi.addClass('jqmWindow');
	envi.addClass('lookup_table');
	fenvi.addClass('lookup_control');
	envi.jqm();
	btnNextPage = envi.find('#table_next');
	btnPrevPage = envi.find('#table_previous');
	
	tableSearchSupport(params, envi, otableLookUp);
	
	finput.keydown(function(e) {
		var pK = e ? e.which : window.event.keyCode;
		if (pK == 34) { 
			fbutton.click();
			e.preventDefault();
			e.stopPropagation();
			return false;
		}
		return true;
	});	
	
	fbutton.click(function() {		
		var pos = finput.position();
		envi.css('width', params.table_width);
		envi.css('left', pos.left);
		envi.css('top', pos.top + finput.outerHeight());	
		//console.log('top:'+pos.top+',left:'+pos.left);
		if (!$(finput).attr('disabled') && !$(finput).attr('readonly')) {
			window.document.onkeydown = kh;
			envi.jqmShow();
		}
		
		
	});
	
	finput.blur(function() {
		if ($(this).attr('disabled') || $(this).attr('readonly')) return;
			
		$(fdetail).html("");
		getData(2, finput.val());
	});
	
	getData(1, fid.val());
	
	rows.mousedown(function(event) {
		$(otableLookUp.fnSettings().aoData).each(function (){
			$(this.nTr).removeClass('row_selected');
		});
		
		var pos = otableLookUp.fnGetPosition(event.target.parentNode);
		var data = otableLookUp.fnGetData(pos);
		currentRow = event.target.parentNode;
		selectedId = data[params.column_id];
		$(event.target.parentNode).addClass('row_selected');
	});
	
	rows.dblclick(function(event) {
		$(otableLookUp.fnSettings().aoData).each(function (){
			$(this.nTr).removeClass('row_selected');
		});
		
		//selectedId = $(event.target.parentNode).find('td').eq(params.column_id).text();
		var pos = otableLookUp.fnGetPosition(event.target.parentNode);
		var data = otableLookUp.fnGetData(pos);
		selectedId = data[params.column_id];
		
		fid.val(selectedId);
		getData(1, fid.val());
		
		// $(event.target.parentNode).addClass('row_selected');
		document.onkeydown = null;
		envi.jqmHide();
		// finput.focus();
	});
	
	
	btnPick = panl.find('input[type="button"]#choose');
	panl.find('input[type="button"]').click(function() {
		
		var ajaxData = "";
		
		switch ($(this).attr('id'))	{
		case 'choose':
			
			if (isNaN(parseInt(selectedId))) {
				alert('Mohon pilih satu data');
				return;
			}
			
			fid.val(selectedId);
			getData(1, fid.val());
			
			document.onkeydown = null;
			envi.jqmHide();
			// finput.focus();
			break;
			
		case 'refresh':
			otableLookUp.fnDraw();			
			break;
		
		case 'cancel':
			document.onkeydown = null;
			envi.jqmHide();
			// finput.focus();
			break;
		}
		
	});	
	return otableLookUp ; 	
}

function createTableFormTransient(args) {
	var params = {

		id 				: "#actionArray",
		listSource 		: "nowhere",
		formSource		: "nowhere",	
		formTarget		: "nowhere",
		submitTarget	: "nowhere",
		addController	: "nowhere",
		editController	: "nowhere",
		onAdd			: null,
		onComplete		: null,
		onReload		: null,
		onFormLoad		: null,
		onFormSubmit	: null,
		onOpenForm		: null,
		resetAfterSubmit: true,
		column_id 		: 0,
		display_length	: 10,
		bPaginate 		: true,
		printTarget		: "nowhere",
		filter_by 		: [],
		aLengthMenu : [[100, 500, -1], [100, 500, "All"]]
	}
	
	
	
	$.extend(params, args);
	
	var tabl = $(params.id);
	var rows = tabl.find('tbody');
	var envi = tabl.parent();
	
	
	var edtr = envi.find('#editor');
	var panl = envi.find('.command_table');
	var summ = envi.find('.summarybox');
	
	var btn_add = envi.find('#add');
	var btn_edit = envi.find('#edit');
	var btn_delete = envi.find('#delete');
	var btn_print = envi.find('#print');
	if (crud_mode.indexOf('c') < 0) btn_add.hide();
	if (crud_mode.indexOf('u') < 0) btn_edit.hide();
	if (crud_mode.indexOf('d') < 0) btn_delete.hide();
	
	var selectedRow = '';
	var selectedNode = null;
	
	var postJSONtransient = function(url, data, fnCallback) {	
		$.ajax({
		  async: false,
		  url: url,
		  dataType: 'json',
		  type : 'POST', 
		  data: data,
		  success:  function (json) {
		  	session_check(json);		  	
			fnCallback(json);		
		  }
		});
	}
	
	
	
	var otable = tabl.dataTable({
			"sAjaxSource" : site_url + params.listSource,
			"bInfo" : true,
			"oLanguage": oLang,
			"bJQueryUI": true,
			"sPaginationType": "full_numbers",
			"aoColumns" : params.column_conf,
			"fnServerData" : postJSONtransient,
			"aLengthMenu"		: params.aLengthMenu,
			"iDisplayLength" 	: 100,
			"bAutoWidth": false,
			"bSort"			: false,
			"fnRowCallback": function( nRow, aData, iDisplayIndex ) { 
				
				$('td', nRow).each(function() {
					var hint = $(this).find('#hidden_hint').val();
					if (hint) $(this).attr('title', hint);
				});
				
				return nRow;
			}
		});
		

	edtr.hide();
	envi.find("#table_filter").prepend('&nbsp;&nbsp;&nbsp; Cari ');
	if(params.title!=null)envi.find("#table_filter").prepend(params.title+' ');
	if(params.rtitle!=null)envi.find("#table_filter").prepend(params.rtitle+'&nbsp;&nbsp;&nbsp; ');
	function closeForm() {
		edtr.slideUp(function() { edtr.html(''); });					
	}
	envi.find("div.toolbar").after($(panl));
	envi.find("div.toolbar").after($(summ));
	//tabl.after($(panl));
	tabl.find('th').addClass('ui-state-default');

	rows.mousedown(function(event) {
	
		$(otable.fnSettings().aoData).each(function () {
			$(this.nTr).removeClass('row_selected');
		});
		
		var pos = otable.fnGetPosition(event.target.parentNode);
		
		selectedRow = pos;
		selectedNode = event.target.parentNode;
		
		$(event.target.parentNode).addClass('row_selected');
	});
	
	panl.find('input[type="button"]').click(function() {
		
		var ajaxData = null;
		//alert($(this).attr('id'));
		switch ($(this).attr('id'))	{
		case 'add':
			ajaxData = null;
			if (params.onOpenForm != null) {
				if (!params.onOpenForm('add')) return;
			}
			break;
		case 'print':
			if (isNaN(parseInt(selectedRow))) {
				alert('Pilih Data yang akan di print');
				return;
			}
			
			window.location.href=(site_url + params.printTarget + '/' + selectedRow);
			break;	
		case 'edit':
		
			if (params.onOpenForm != null) {
				if (!params.onOpenForm('edit')) return;
			}
		
			var candel = $(selectedNode).find('.nodel');
			if(candel.length>0)return;
			if (isNaN(parseInt(selectedRow))) {
				alert('Pilih Data yang akan Edit');
				return;
			}
			
			ajaxData = $('input, select, textarea', selectedNode).serialize() + '&transient_index=' + selectedRow;
			
			break;
			
		case 'delete':
			var candel = $(selectedNode).find('.nodel');
			if(candel.length>0)return;
			if (isNaN(parseInt(selectedRow))) {
				alert('Pilih Data yang akan dihapus');
				return;
			}
			
			if (!confirm("Anda yakin menghapus data ini ?")) return;
			
			closeForm();
			otable.fnSettings().oFeatures.bServerSide = false;
			otable.fnDeleteRow(selectedRow, null, true);
			otable.fnSettings().oFeatures.bServerSide = true;
			selectedNode = null;
			selectedRow = '';
			
			if(params.onAdd != null) params.onAdd();
			
			return;
			
		case 'reset':
		
			closeForm();
			otable.fnReloadAjax();	
			if(params.onAdd != null) params.onAdd();		
			return;
			
		case 'submit':
		
			var thisButton = $(this);
			
			thisButton.attr('disabled', 'disabled');
			
			$.ajax({
				url 		: site_url + params.actionTarget, 
				dataType 	: "json",
				data 		: envi.serialize(),
				type		: "POST",
				success		:function(json) { 
				
					if (json.type == 'success') {
						otable.fnReloadAjax();
						thisButton.removeAttr('disabled');
						if (params.onSuccess != null) params.onSuccess();						
					}
					else 
					{
						thisButton.removeAttr('disabled');
						envi.find('.ajax_status').html(json.content);
					}
									
				},
				error		: function() {
					thisButton.removeAttr('disabled');
					envi.find('.ajax_status').html(json.content);
				}
			});
			
			closeForm();			
			return;
			
		default:return;			
		}
		
		$.ajax({
				url : site_url + params.formSource, 
				dataType : "html",
				data: ajaxData,
				type: "POST",
				success : function(data) {
					// ------------
					edtr.html(data);
					//edtr.html('<input type="text" />');
					edtr.prepend('<div class="ajax_status"></div>');
					var status = edtr.find('.ajax_status');
	
					edtr.slideDown();					
					//return;
					edtr.find('.command_bar #submit').click(function() {
						
						var data = edtr.find('input, select, textarea');
						$.ajax({
							url 	: site_url + params.controlTarget,
							dataType: "json",
							data	: data.serialize(),
							type	: "POST",
							success	: function(json) { 									
									
									if (json.mode == 'add') {
										otable.fnSettings().oFeatures.bServerSide = false;
										if (params.onFormSubmit != null) params.onFormSubmit(edtr, json.mode);
										tabl.dataTable().fnAddData(json.data);
										if (params.resetAfterSubmit) edtr.find('form input[type="reset"]').click();
										if(params.onAdd != null) params.onAdd();
										otable.fnSettings().oFeatures.bServerSide = true;
									} 
									else if (json.mode == 'edit') {
										otable.fnSettings().oFeatures.bServerSide = false;
										if (params.onFormSubmit != null) params.onFormSubmit(edtr, json.mode);
										otable.fnUpdate(json.data, json.index);
										if(params.onAdd != null) params.onAdd();
										otable.fnSettings().oFeatures.bServerSide = true;
										closeForm();
									}
									else {
										edtr.find('input').each(function() {
											$(this).attr('title','');
											$(this).removeClass('error');
										});
										edtr.find('textarea').each(function() {
											$(this).attr('title','');
											$(this).removeClass('error');
										});
										if(json.content)status.html(json.content);	
										show_error_input(json);
									//edtr.find('.ajax_status').html(json.content);							
									}
								}
						})
					});
					
					edtr.find('.command_bar #cancel').click(function() {
						edtr.find('#cancel').click(function() { $(this).unbind('click'); });
						closeForm();
					});
					
					edtr.find('.command_bar #reset').click(function() {
						edtr.find('.com_desc').html('');
						edtr.find('.com_id').val('');
						edtr.find('.ajax_status').html('');
					});
					
					if (params.onFormLoad != null) params.onFormLoad(edtr);
					// ------------
				}
		});

	});
	
	return otable;
}



function createTableMovable(args) {
	var params = {
		id 		: "#actionArray",
		listSource 	: "nowhere",	
		targetSource 	: null,
		formSource	: null,
		controlTarget	: null,	
		listTarget	: "nowhere",
		submitTarget	: "nowhere",
		bPaginate 	: true,
		onAdd		: null,
		onTargetLoad	: null,
		column_id 	: 0,
		initTable	: null,
		onDeleteSource	: null,
		filter_by 	: []
	}
	
	$.extend(params, args);
	
	var envi = $(params.id);
	
	var edtr = envi.find('#editor');
	edtr.hide();
	
	function closeForm() {
		edtr.slideUp(function() { edtr.html(''); });					
	}
	
	var form1 = envi.find('#form1');
	var form2 = envi.find('#form2');
	var tabl = form1.find('#table_source');
	var rows = tabl.find('tbody');
	var panl = form1.find('.command_table');
	var panl2 = form2.find('.command_table');
	var edtr = envi.find('#editor');
	var tabl_target = form2.find('#table_target');
	var rowsTarget = tabl_target.find('tbody');
	var btn_add = envi.find('#add');
	
	if (crud_mode.indexOf('c') < 0) btn_add.hide();
	
	var selectedRow = '';
	var selectedNode = null;
	var selectedRowTarget = '';
	var selectedNodeTarget = null;
	var postJSONtransient = function(url, data, fnCallback) {	
		$.ajax({
		  async: false,
		  url: url,
		  dataType: 'json',
		  type : 'POST', 
		  data: data,
		  success:  function (json) {
		  	session_check(json);		  	
			fnCallback(json);		
		}
		});
	}
	var otable = tabl.dataTable({
			"sAjaxSource" : site_url + params.listSource,
			"bInfo" : false,
			"oLanguage": oLang,
			"bJQueryUI": true,
			"sPaginationType": "full_numbers",
			"aoColumns" : params.column_conf,
			"fnServerData" : postJSONtransient,
			"bAutoWidth": false 
		});
	var otabletarget = tabl_target.dataTable({
			"sAjaxSource" : (params.targetSource)?site_url + params.targetSource:null,
			"bInfo" : false,
			"bPaginate" : params.bPaginate,
			"bJQueryUI": true,
			"sPaginationType": "full_numbers",
			"aoColumns" : params.column_conf,
			"fnServerData" : postJSONtransient,
			"fnInitComplete" : params.onTargetLoad,
			"bAutoWidth": false 
		});
		
	tabl.after($(panl));
	
	rows.mousedown(function(event) {
	
		$(otable.fnSettings().aoData).each(function () {
			$(this.nTr).removeClass('row_selected');
		});
		
		var pos = otable.fnGetPosition(event.target.parentNode);
		
		selectedRow = pos;
		selectedNode = event.target.parentNode;
		
		$(event.target.parentNode).addClass('row_selected');
	});
	
	rowsTarget.mousedown(function(event) {
	
		$(otabletarget.fnSettings().aoData).each(function () {
			$(this.nTr).removeClass('row_selected');
		});
		
		var pos = otabletarget.fnGetPosition(event.target.parentNode);
		
		selectedRowTarget = pos;
		selectedNodeTarget = event.target.parentNode;
		
		$(event.target.parentNode).addClass('row_selected');
	});
	
	panl2.find('input[type="button"]').click(function() {		
		var ajaxData = null;		
		switch ($(this).attr('id'))	{		
		case 'remove':
			var candel = $(selectedNodeTarget).find('.nodel');
			if(candel.length>0)return;
			if (isNaN(parseInt(selectedRowTarget))) {
				alert('Pilih Data yang akan dihapus');
				return;
			}
			
			if (!confirm('Anda ingin MENGHAPUS data ini?')) return;
			
			closeForm();
			otabletarget.fnDeleteRow(selectedRowTarget, null, true);
						
			if(params.onAdd != null) params.onAdd();
			selectedNodeTarget = null;
			selectedRowTarget = '';
			return;
		
		case 'removeall':	
			$(otabletarget.fnSettings().aoData).each(function () {
				var candel = $(this.nTr).find('.nodel');
				if(candel.length==0){
				$(this.nTr).removeClass('row_selected');
				var pos = otabletarget.fnGetPosition(this.nTr);
				otabletarget.fnDeleteRow(pos, null, true);
				}
			});	return;
			otabletarget.fnClearTable(1);
			if(params.onAdd != null) params.onAdd();
			selectedNodeTarget = null;
			selectedRowTarget = '';
			closeForm();
			return;
			
		case 'reset':
			closeForm();
			if(otabletarget.fnSettings().sAjaxSource) otabletarget.fnReloadAjax(otabletarget.sAjaxSource, function() { if (params.onTargetLoad != null) params.onTargetLoad(); });
			
			else{
				otabletarget.fnClearTable(1);
				if(params.onAdd != null) params.onAdd();
				selectedNodeTarget = null;
				selectedRowTarget = '';
				otabletarget.fnReloadAjax(otabletarget.sAjaxSource, function() { if (params.onTargetLoad != null) params.onTargetLoad(); });
			
			}
			return;		
		case 'edit':
		// --------------------------------------------------------------------------------------------------
			
			if (isNaN(parseInt(selectedRowTarget))) {
				alert('Pilih Data yang akan Edit');
				return;
			}
			
			ajaxData = $('input, select, textarea', selectedNodeTarget).serialize() + '&transient_index=' + selectedRowTarget;
			
			$.ajax({
				url : site_url + params.formSource, 
				dataType : "html",
				data: ajaxData,
				type: "POST",
				success : function(data) {
					// ------------
					edtr.html('<div id="gap">' + data + '</div>');
					edtr.slideDown();					
					
					edtr.find('#submit').click(function() {
						
						var data = edtr.find('form').find('input, select, textarea');
						
						$.ajax({
							url 	: site_url + params.controlTarget,
							dataType: "json",
							data	: data.serialize(),
							type	: "POST",
							success	: function(json) { 
									if (json.mode == 'edit' || json.mode == 'add') {
										otabletarget.fnUpdate(json.data, json.index);
										if(params.onAdd != null) params.onAdd();
										closeForm();
									}
									else edtr.find('.ajax_status').html(json.content);									
								}
						})
					});
					
					edtr.find('#cancel').click(function() {
						edtr.find('#cancel').click(function() { $(this).unbind('click'); });
						closeForm();
					});
					edtr.find('#reset').click(function() {
						edtr.find('.com_desc').html('');
						edtr.find('.com_id').val('');
						edtr.find('.ajax_status').html('');
					});
					// ------------
				}
		});
		
		// --------------------------------------------------------------------------------------------------
		return;
		}
	});
	panl.find('input[type="button"]').click(function() {
		
		var ajaxData = null;
		
		switch ($(this).attr('id'))	{
		case 'remove':
			if (isNaN(parseInt(selectedRow))) {
				alert('Pilih Data yang akan dihapus');
				return;
			}
			
			if (!confirm('Anda ingin MENGHAPUS data ini?')) return;
			var aData = otable.fnGetData( selectedNode );
			var iId = aData[0];
			otable.fnDeleteRow(selectedRow, null, true);
						
			if(params.onDeleteSource != null) params.onDeleteSource(iId);
			selectedNode = null;
			selectedRow = '';
			return;	
		case 'add':
			
			if (isNaN(parseInt(selectedRow))) {
				alert('Pilih Data yang akan ditambahkan');
				return;
			}
			ajaxData = $('input, select, textarea', form1.find('.form_area')).serialize()+'&';
			ajaxData += $('input, select, textarea', selectedNode).serialize() + '&transient_index=' + selectedRow;
			break;
			
		case 'reset':
			otable.fnReloadAjax();	
			return;		
		}
		
		$.ajax({
			url : site_url + params.listTarget, 
			dataType : "json",
			data: ajaxData,
			type: "POST",
			success : function(json) {			
				if (json.type == 'error') { alert(json.content); return; }
				
				// check first
				var tData = otabletarget.fnGetData();
				var sData = json.data;
				
				var tData = otabletarget.fnGetData();
				
				if (tData.length > 0)
				for(var i = 0; i < tData.length; i++) {//console.log(tData[i][params.column_id]);console.log(sData[params.column_id]);
					if (sData[params.column_id] == tData[i][params.column_id]) 
					{
						alert('data sudah digunakan');
						return;
					}
				}
				
				otabletarget.fnAddData(json.data);			
				if(params.onAdd != null) params.onAdd();							
			}
		});

	});
	
	if (params.initTable != null) params.initTable(otable, otabletarget);
	return otable;
}

function displayProvince(params) {
	
	var envi = $(params.id);
	var prov_val = params.prov_val;
	var city_val = params.city_val;
	var sel_id = envi.find('select');
	var prov_id = sel_id.eq(0);
	var city_id = sel_id.eq(1);
	var selected_val = '';
	var cbo,i;
	$.ajax({
				url : site_url + 'common/get_province', 
				dataType : "json",
				type: "POST",
				success : function(data) {
					cbo='';
					for(i=0;i<data.length;i++){
						selected_val = (data[i][0]==prov_val)?'selected="selected"':'';	
						cbo+='<option value="'+data[i][0]+'" '+selected_val+'>'+data[i][1]+'</option>';
					}
					prov_id.html(cbo);	
					
					prov_id.change(function() {
			var province_id = this.value;
			var selected_val = '';
			var va = 'province_id='+province_id;
			$.ajax({
				type: 'POST',
				url: site_url + 'common/get_cities',
				data: va,
				dataType: 'json',
				success: function (data){
					var i, optHtml='';
					
					for(i=0;i<data.length;i++){
						selected_val = (data[i][0]==city_val)?'selected="selected"':'';	
						optHtml+='<option '+selected_val+' value="'+data[i][0]+'">'+data[i][1]+'</option>';
					}
					city_id.html(optHtml);
				}
			});			
		});
		prov_id.change();
				}
		});	
		
}

function displayCustomer(params) {
	
	var envi = $(params.id);
	var customer_val = params.customer_val;
	var project_val = params.project_val;
	var sel_id = envi.find('select');
	var customer_id = sel_id.eq(0);
	var project_id = sel_id.eq(1);
	var selected_val = '';
	var cbo,i;
	$.ajax({
				url : site_url + 'common/get_customer', 
				dataType : "json",
				type: "POST",
				success : function(data) {
					cbo='';
					for(i=0;i<data.length;i++){
						selected_val = (data[i][0]==customer_val)?'selected="selected"':'';	
						cbo+='<option value="'+data[i][0]+'" '+selected_val+'>'+data[i][1]+'</option>';
					}
					customer_id.html(cbo);	
					
					customer_id.change(function() {
			var customer_id = this.value;
			var selected_val = '';
			var va = 'customer_id='+customer_id;
			$.ajax({
				type: 'POST',
				url: site_url + 'common/get_project',
				data: va,
				dataType: 'json',
				success: function (data){
					var i, optHtml='';
					
					for(i=0;i<data.length;i++){
						selected_val = (data[i][0]==project_val)?'selected="selected"':'';	
						optHtml+='<option '+selected_val+' value="'+data[i][0]+'">'+data[i][1]+'</option>';
					}
					project_id.html(optHtml);
				}
			});			
		});
		customer_id.change();
				}
		});	
		
}

function displaySalary(params){
	var id_gs_gradetype = $(params.id_gs_gradetype);
	var id_grade_type = $(params.id_grade_type);
	var id_salary_type = $(params.id_salary_type);
	var grade_type_old = $(params.grade_type_old);
	var i_employee_work = $(params.i_employee_work);
	var i_emp_status_id = $(params.i_emp_status_id);
	var i_emp_tenure_now = $(params.i_emp_tenure_now);
	
	var grade_id = grade_type_old.val();
	var year_work = i_employee_work.val();
	var emp_status_id = i_emp_status_id.val();
	
	id_gs_gradetype.change(function(){
		if(id_gs_gradetype.val() == 'gaji'){
			var grade_type = grade_type_old.val();
			$.post(site_url + 'emp_grade_salary/gs_salary_type/',{grade_id : grade_id, year_work : year_work},function (data){
				var optionHtml = "";
				for(i=0; i < data.length; i++){
					optionHtml += '<option value="'+data[i][0]+'">'+data[i][1]+'</option>';
				}
				id_salary_type.html(optionHtml);
				id_grade_type.html('<option value="">---</option>').attr('disabled','disabled');
			},'json');
		} else {
			id_grade_type.removeAttr('disabled');
			id_salary_type.html('<option value="">---</option>');
			
			$.post(site_url + 'emp_grade_salary/gs_grade_type',{emp_status_id: emp_status_id, grade_id : grade_id, year_work : year_work},function (data){
				var optionHtml = "<option value=''>---</option>";
				for(i=0; i < data.length; i++){
					optionHtml += '<option value="'+data[i][0]+'">'+data[i][1]+' ('+data[i][2]+')</option>';
				}
				id_grade_type.html(optionHtml).change(function(){
					var grade_type = $(this).val();
					$.post(site_url + 'emp_grade_salary/gs_salary_type/'+grade_type,{grade_id : grade_id, year_work : year_work},function (data){
						var optionHtml = "";
						for(i = 0; i < data.length; i++){
							optionHtml += '<option value="'+data[i][0]+'">'+data[i][1]+'</option>';
						}
						id_salary_type.html(optionHtml);
						i_emp_tenure_now.val(data[(i-1)][2]);
					},'json');
				});
			}, 'json');
		}
		/**/
	});
}

function displayTypeStatus(params){
	var i_status = $(params.i_status);
	var i_jenis = $(params.i_jenis);
	var i_periode_start = $(params.i_periode_start);
	var i_periode_end = $(params.i_periode_end);
	
	i_jenis.change(function(){
		var monitor_type = i_jenis.val();
		$.post(site_url + 'emp_status_history/hs_monitor_type/'+monitor_type, function(data){
			var optionHtml = "";
			for(i=0; i < data.length; i++){
				optionHtml += '<option value="'+data[i][0]+'">'+data[i][1]+'</option>';
			}
			i_status.html(optionHtml);
		},'json');
		
		/*if(monitor_type == "status"){
			i_periode_start.attr("disabled","disabled");
			i_periode_end.attr("disabled","disabled");
		} else {
			i_periode_start.removeAttr("disabled");
			i_periode_end.removeAttr("disabled");
		}*/
	});
}

function reloadImage(el,url){
	//$(el).html('');
	var img = new Image();					
	$(img).load(function () {
		$(this).css('display','none'); // since .hide() failed in safari
		$(el).attr('src', url);
		$(this).fadeIn();
	}).error(function () {
		$(el).remove();
	}).attr('src', url);	
}
function displayProvince(params) {
	
	var envi = $(params.id);
	var prov_val = params.prov_val;
	var city_val = params.city_val;
	var sel_id = envi.find('select');
	var prov_id = sel_id.eq(0);
	var city_id = sel_id.eq(1);
	var selected_val = '';
	var cbo,i;
	$.ajax({
				url : site_url + 'common/get_province', 
				dataType : "json",
				type: "POST",
				success : function(data) {
					cbo='';
					for(i=0;i<data.length;i++){
						selected_val = (data[i][0]==prov_val)?'selected="selected"':'';	
						cbo+='<option value="'+data[i][0]+'" '+selected_val+'>'+data[i][1]+'</option>';
					}
					prov_id.html(cbo);
					
					prov_id.change(function() {
			var province_id = this.value?this.value:0;
			var selected_val = '';
			var va = 'province_id='+province_id;
			$.ajax({
				type: 'POST',
				url: site_url + 'common/get_cities',
				data: va,
				dataType: 'json',
				success: function (data){
					var i, optHtml='';
					
					for(i=0;i<data.length;i++){
						selected_val = (data[i][0]==city_val)?'selected="selected"':'';	
						optHtml+='<option '+selected_val+' value="'+data[i][0]+'">'+data[i][1]+'</option>';
					}
					city_id.html(optHtml);
				}
			});			
		});
		prov_id.change();
				}
		});			
}
function createDatePicker() {
	var input = $('.date_input');
	
	var df = 'dd/mm/yy';
	input.attr('readonly', 'readonly');
	input.datepicker({
		altFormat : 'D, d MM yy',
		dateFormat : df,
		constraintInput : true,
		changeYear: true,
		changeMonth: true,
		showOtherMonths : true
	});
}

function createTableReport(args)
{
	var params = {
		id 				: "#actionTable",
		submitTarget	: "nowhere",
		formTarget		: "nowhere",
		nextPage		: "nowhere",
		column_id 		: 0
	}
	
	$.extend(params, args);
	
	var envi = $(params.id);
	var tabl = envi.find('#table');
	var rows = tabl.find('tbody');
	var panl = envi.find('.command_bar');
	var status = envi.find('.ajax_status');
	var selectedId = '';	

	var otable = tabl.dataTable({
			"bJQueryUI": true,
			"bPaginate" : false,
			"aoColumns" : params.column_conf,
			"bAutoWidth": false,
			"_fnFeatureHtmlFilter" : null,
			"bFilter": false
	});
	
	var form = envi.find('form');
	form.attr('action', site_url + params.submitTarget);
	form.attr('method', 'POST');
	
	tabl.after($(panl));
	envi.find('.fg-toolbar:last').hide();
	
	var input_data = envi.find('input, textarea, select');
	
	rows.mousedown(function(event) {
		$(otable.fnSettings().aoData).each(function (){
			$(this.nTr).removeClass('row_selected');
		});
		
		var pos = otable.fnGetPosition(event.target.parentNode);
		
		if (!isNaN(pos)) {
			var data = otable.fnGetData(pos);		
			selectedId = data[params.column_id];
		}
		
		$(event.target.parentNode).addClass('row_selected');
	});
	
	panl.find('input').click(function() {
		
		switch ($(this).attr('id'))	{
			case 'choose':
				
				if (selectedId=='') {
					alert('Mohon pilih data dahulu');
					break;
				}
				
				window.location.href = site_url + selectedId;
				break;
		}
		
	});
	
	return otable;
}
function initMoney(){
	$('.format_money').each(function() {
		var d = $(this);
		var value = d.val();
		value = value.replace(/,/g,'');
		d.val(formatMoney(value));
	  	d.unbind();
		d.focus(function()
	  	{
	  		var value = d.val();
			value = value.replace(/,/g,'');
	  		d.val(helperFormatMoney(value, '', '', '', '.', 2, 2));
		} );
		/*d.mouseup(function ()
	  	{
	  		d.select();
		});*/
		d.blur(function()
	  	{
	  		value = d.val();			
			d.val(formatMoney(d.val()));
		} );		  	
	});
}
(function($){
$.fn.number = function(){
	var d = $(this);
	var value = d.val();
	value = value.replace(/,/g,'');
	return value;
}
})(jQuery);
