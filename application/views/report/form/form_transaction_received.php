<script type="text/javascript">	
$(function(){


	
	createLookUp({
		table_id		: "#lookup_table_phase",
		table_width		: 400,
		listSource 		: "lookup/phase_table_control",
		dataSource		: "lookup/phase_lookup_id",
		column_id 		: 0,
		component_id	: "#lookup_phase",
		filter_by		: [{id : "p2", label : "Nama"}]
	});
	
	createLookUp({
		table_id		: "#lookup_table_project",
		table_width		: 400,
		listSource 		: "lookup/project_table_control",
		dataSource		: "lookup/project_lookup_id",
		column_id 		: 0,
		component_id	: "#lookup_project",
		filter_by		: [{id: "p1", label : "Project Code" },{id: "p2", label : "Project Name" }, {id : "p3", label : "Client Name"}]
	});
	createLookUp({
		table_id		: "#lookup_table_product_category",
		table_width		: 400,
		listSource 		: "lookup/product_category_table_control",
		dataSource		: "lookup/product_category_lookup_id",
		column_id 		: 0,
		component_id	: "#lookup_product_category",
		filter_by		: [{id : "p1", label : "Nama"}]
	});
	
	createLookUp({
		table_id		: "#lookup_table_po_number",
		table_width		: 400,
		listSource 		: "lookup/po_number_table_control",
		dataSource		: "lookup/po_number_lookup_id",
		column_id 		: 0,
		component_id	: "#lookup_po_number",
		filter_by		: [{id : "p1", label : "PO Number"}],

	});
	
	//updateAll(); 
});
</script>

<form class="form_class" id="id_form_nya">	
<div class="form_area">
<div class="form_area_frame">
	<table width="100%" cellpadding="4" class="form_layout">
    <tr>
      <td>Project Phase
       	</td>
      <td> <span class="lookup" id="lookup_phase">
          <input type="hidden" name="i_phase_id" class="com_id" value="<?=$phase_id?>" />
            <input type="text" class="com_input" size="6" name="module" />
          <div class="iconic_base iconic_search com_popup"></div>
        </span>	
        
       
        </td>
    </tr>
    <tr>
      <td>Project Name
       	</td>
      <td> <span class="lookup" id="lookup_project">
          <input type="hidden" name="i_project_id" class="com_id" value="<?=$project_id?>" />
           <input type="text" class="com_input" />
          <div class="iconic_base iconic_search com_popup"></div>   
         
        </span>	</td>
        <tr>
     <td>Material Type</td>
        <td><span class="lookup" id="lookup_product_category">
				<input type="hidden" name="i_category_id" class="com_id" value="<?=$product_categories_id?>" />
                <input type="text" class="com_input" />
                <div class="iconic_base iconic_search com_popup"></div>
				</span>	
       </td>
     </tr>
      <tr>
      <td>PO Received</td>
      <td> <span class="lookup" id="lookup_po_number">
          <input type="hidden" name="i_transaction_id" class="com_id" value="<?=$transaction_id?>" />
          <input type="text" class="com_input" />
          <div class="iconic_base iconic_search com_popup"></div>
        </span>	</td>
    </tr>
   
   
     </table>
     
 
<!-- table contact -->


</form>


<div id="">
	<table id="lookup_table_phase" cellpadding="0" cellspacing="0" border="0" class="display" > 
		<thead>
			<tr>
			<th>ID</th>
         		<th>Code</th>
				<th>Name</th>
            
			</tr> 
		</thead> 
		<tbody> 	
		</tbody>
	</table>
	<div id="panel">
		<input type="button" id="choose" value="Pilih Data"/>
		<input type="button" id="refresh" value="Refresh"/>
		<input type="button" id="cancel" value="Cancel" />
	</div>	
</div>


<div id="">
	<table id="lookup_table_project" cellpadding="0" cellspacing="0" border="0" class="display" > 
		<thead>
			<tr>
			<th>ID</th>
            <th>Project Code</th>
         	<th>Project Name</th>
			<th>Client Name</th>
            
			</tr> 
		</thead> 
		<tbody> 	
		</tbody>
	</table>
	<div id="panel">
		<input type="button" id="choose" value="Pilih Data"/>
		<input type="button" id="refresh" value="Refresh"/>
		<input type="button" id="cancel" value="Cancel" />
	</div>	
</div>


<div id="">
	<table id="lookup_table_product_category" cellpadding="0" cellspacing="0" border="0" class="display" > 
		<thead>
			<tr>
			<th>ID</th>
				<th>Nama</th>
            
			</tr> 
		</thead> 
		<tbody> 	
		</tbody>
	</table>
	<div id="panel">
		<input type="button" id="choose" value="Pilih Data"/>
		<input type="button" id="refresh" value="Refresh"/>
		<input type="button" id="cancel" value="Cancel" />
	</div>	
</div>

<div id="">
	<table id="lookup_table_po_number" cellpadding="0" cellspacing="0" border="0" class="display" > 
		<thead>
			<tr>
            <th>ID</th>
            <th>nama</th>
			</tr> 
		</thead> 
		<tbody> 	
		</tbody>
	</table>
	<div id="panel">
		<input type="button" id="choose" value="Pilih Data"/>
		<input type="button" id="refresh" value="Refresh"/>
		<input type="button" id="cancel" value="Cancel" />
	</div>	
</div






