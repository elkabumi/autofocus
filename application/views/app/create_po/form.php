<script type="text/javascript">	
$(function(){

	createForm({
		id 				: "#id_form_nya", 
		actionTarget	: "create_po/form_action",
		backPage		: "create_po",
		nextPage		: "create_po/form"
	});
	
	createLookUp({
		table_id		: "#lookup_table_registration",
		table_width		: 400,
		listSource 		: "lookup/registration_table_control/0",
		dataSource		: "lookup/registration_lookup_id",
		column_id 		: 0,
		component_id	: "#lookup_registration",
		filter_by		: [{id : "p1", label : "Kode Transaksi"}, {id : "p2", label : "Nopol"}, {id : "p3", label : "Nama Asuransi"},{id : "p3", label : "Nama Pelanggan"}],
		onSelect		: load_registration
	});
	
	
	var otb = createTableFormTransient({
		id 				: "#transient_detail",
		listSource 		: "create_po/detail_table_loader/"+$('input[name="i_registration_id"]').val()+"/<?=$row_id?>",
		formSource 		: "create_po/detail_form/<?=$row_id?>",
		printTarget		: "create_po/print_doc",
		controlTarget	: "create_po/detail_form_action"
	});
	
	
	function load_registration()
	{
		var id 	= $('input[name="i_registration_id"]').val();
		
		if(id == ""){
			return;
		}
		var data ='id='+id; 
		
		$.ajax({
			type: 'POST',
			url: '<?=site_url('create_po/load_registration')?>',
			data: data,
			dataType: 'json',
			success: function(data){	
				$('input[name="i_period"]').val(data.content['period_name']);				
				$('input[name="i_stand"]').val(data.content['stand_name']);
				//$('input[name="i_transaction_code"]').val(data.content['transaction_code']);
		
				$('input[name="i_customer"]').val(data.content['customer_name']);
				$('input[name="i_car"]').val(data.content['car_nopol']);
				$('input[name="i_code"]').val(data.content['po_code']);
			}
			
		});
		
		
		if(id.toString().length>0)
		{
			//alert(id);
			otb.fnSettings().sAjaxSource = site_url + "create_po/detail_table_loader/"+$('input[name="i_registration_id"]').val()+"/<?=$row_id?>";
			otb.fnReloadAjax();	
		}
	}
	

	function select_item(id)
	{
		if(id.toString().length>0)
		{
			//alert(id);
			otb.fnSettings().sAjaxSource = site_url + "create_po/detail_table_loader/"+$('input[name="i_registration_id"]').val()+"/<?=$row_id?>";
			otb.fnReloadAjax();	
		}
	}
	
	createDatePicker();
	//updateAll(); 
});
</script>

<form class="form_class" id="id_form_nya">	
<div class="form_area">
<div class="form_area_frame">
	<table width="100%" cellpadding="4" class="form_layout">
	<tr>
			<td width="17%">Kode Transaksi
               
            </td>
			<td width="1%" >:</td>
			<td  width="82%" > <span class="lookup" id="lookup_registration">
         <input type="hidden" id="i_registration_id" name="i_registration_id" class="com_id" value="<?=$period_id?>" />
         <input type="text" class="com_input" size="6" /> 
         <div class="iconic_base iconic_search com_popup"></div>
       </span></td> 
		</tr>
   
   <tr>
    <tr>
			<td width="17%">Periode
               
            </td>
			<td width="1%" >:</td>
			<td  width="82%" >
       
       <input name="i_period" type="text" id="i_period" value="<?=$period_id ?>" readonly="readonly" />
       
      
         <input type="hidden" name="row_id" value="<?=$row_id?>" /> </td> 
		</tr>
   
   <tr>
      <td>Cabang
        		</td>
      <td>:</td>
      <td> <input  readonly="readonly" type="text" name="i_stand"  id="i_stand" value="<?=$stand_id?>" />
              </td>
    </tr>

    <tr>
      <td>Data Pelanggan
        </td>
      <td>:</td>
      <td> 
        <input readonly="readonly" type="text" name="i_customer"  id="i_customer"  value="<?=$customer_id?>" />
      </td>

    <tr>
      <td>Data Mobil</td>
      <td>:</td>
      <td><input  readonly="readonly" type="text" name="i_car"  id="i_car"   value="<?=$car_id?>" />
              
			</td>
    </tr>
        </tr>
         <tr>
      <td>PO code
        </td>
      <td>:</td>
      <td> 
        <input readonly="readonly" type="text" name="i_code"  id="i_code"  value="<?=$po_code?>" />
      </td>
    </tr>
    <tr>
      <td>Tanggal Create Po  </td>
      <td>:</td>
      <td><input type="text" name="i_create_date" class="date_input" size="15" value="<?=$tp_create_date?>" /></td>
    </tr>
       <tr>
    <td width="158" valign="top">Keterangan</td>
    <td width="10" valign="top">:</td>
    <td width="745" valign="top"><textarea name="i_po_description" id="i_po_description" cols="45" rows="5"><?=$tp_desc?></textarea></td>
    </tr>

   
   
     </table>
    <table width="100%" cellpadding="2">
    <tr>
    <td>
  