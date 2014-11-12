<script type="text/javascript">	
$(function(){

	createForm({
		id 				: "#id_form_nya", 
		actionTarget	: "price_category/form_action",
		backPage		: "price_category",
		nextPage		: "price_category/form"
	});
	
	createLookUp({
		table_id		: "#lookup_table_insurance",
		table_width		: 400,
		listSource 		: "lookup/insurance_table_control",
		dataSource		: "lookup/insurance_lookup_id",
		column_id 		: 0,
		component_id	: "#lookup_insurance",
		filter_by		: [{id : "p1", label : "Nama"}]
	});
	
	$('#enable').click(function(){
			if(alert("Silahkan kilik tombol save untuk konfirmasi penyimpanan")){
	}
	});
	createDatePicker();
	//updateAll(); 
});
</script>
<form class="form_class" id="id_form_nya">	
<div class="form_area">
<div class="form_area_frame">
<table  width="100%" cellpadding="4" class="form_layout">
	<tr>
     <td width="196" >Type item price</td>
       <td width="651"><input name="i_name" type="text" id="i_name" value="<?=$product_item_name ?>" readonly="readonly" />
     
	 <input type="hidden" name="row_id" value="<?=$row_id?>" /></td>
   </tr>
   
    <tr>
     <td>Insurance adres</td>
       <td><input name="i_addres" type="text" id="i_addres" value="<?=$insurance_name ?>" size="70" readonly="readonly" /></td>
     </tr>
   
  <tr>
    <td width="189" valign="top">Notes</td>
      <td><textarea name="i_description" id="i_description" cols="45" rows="5" readonly="readonly"><?= $product_item_desc ?></textarea></td>
    </tr>
 </table>
 
 
    <table width="100%" cellpadding="2">
    <tr>
    <td>


   


   
	
	
