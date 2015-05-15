<script type="text/javascript">	
$(function(){

	createForm({
		id 				: "#id_form_nya", 
		actionTarget	: "create_po_material/form_action",
		backPage		: "create_po_material",
		nextPage		: "create_po_material/form"
	});
	createLookUp({
		table_id		: "#lookup_table_stand",
		table_width		: 400,
		listSource 		: "lookup/stand_table_control",
		dataSource		: "lookup/stand_lookup_id",
		column_id 		: 0,
		component_id	: "#lookup_stand",
		filter_by		: [{id : "p1", label : "Nama Cabang"}]
	});
	var otb = createTableFormTransient({
		id 				: "#transient_detail",
		listSource 		: "create_po_material/detail_table_loader/"+$('input[name="i_stand_id"]').val()+"/<?=$row_id?>",
		formSource 		: "create_po_material/detail_form/<?=$row_id?>",
		printTarget		: "create_po_material/print_doc",
		controlTarget	: "create_po_material/detail_form_action"
	});
	
	createDatePicker();
	//updateAll(); 
});
</script>

<form class="form_class" id="id_form_nya">	
<div class="form_area">
<div class="form_area_frame">
	<table width="100%" cellpadding="4" class="form_layout">
	<tr>
    <tr>
      <td>PO Bahan code
        </td>
      <td>:</td>
      <td> 
        <input readonly="readonly" type="text" name="i_code"  id="i_code"  value="<?=$tpm_code?>" />
         <input type="hidden" name="row_id" value="<?=$row_id?>" />
      </td>
    </tr>
    <tr>
      <td>Cabang
        		</td>
      <td>:</td>
      <td>  <span class="lookup" id="lookup_stand">
				<input type="hidden" name="i_stand_id" id="i_stand_id" class="com_id" value="<?=$stand_id?>" />
               
				<input type="text" class="com_input" />
				 <div class="iconic_base iconic_search com_popup"></div>
				</span></td>
    </tr>
    <tr>
      <td>Tanggal Create Po Bahan  </td>
      <td>:</td>
      <td><input type="text" name="i_create_date" class="date_input" size="15" value="<?=$tpm_create_date?>" /></td>
    </tr>
       <tr>
    <td width="158" valign="top">Keterangan</td>
    <td width="10" valign="top">:</td>
    <td width="745" valign="top"><textarea name="i_description" id="i_description" cols="45" rows="5"><?=$tpm_desc?></textarea></td>
    </tr>

   
   
     </table>
    <table width="100%" cellpadding="2">
    <tr>
    <td>
  