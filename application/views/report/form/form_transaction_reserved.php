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
		table_id		: "#lookup_table_po_received",
		table_width		: 400,
		listSource 		: "lookup/po_received_table_control",
		dataSource		: "lookup/po_received_lookup_id",
		column_id 		: 0,
		component_id	: "#lookup_po_received",
		filter_by		: [{id : "p1", label : "Phase"}, {id : "p2", label : "Project Name"}, {id : "p3", label : "PO Number"}],
		
	});
	
	
	createLookUp({
		table_id		: "#lookup_table_site",
		table_width		: 400,
		listSource 		: "lookup/site_table_control",
		dataSource		: "lookup/site_lookup_id",
		column_id 		: 0,
		component_id	: "#lookup_site",
		filter_by		: [{id : "p1", label : "Site Code"}, {id : "p2", label : "Site Name"}]
	});
	
	createLookUp({
		table_id		: "#lookup_table_site_mapping",
		table_width		: 400,
		listSource 		: "lookup/site_table_control",
		dataSource		: "lookup/site_lookup_id",
		column_id 		: 0,
		component_id	: "#lookup_site_mapping",
		filter_by		: [{id : "p1", label : "Site Code"}, {id : "p2", label : "Site Name"}]
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
         <span class="com_desc"></span></span>
        </span>	</td>
      </tr>
      
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
      <tr>
      <td>PO Number</td>
      <td> <span class="lookup" id="lookup_po_received">
          <input type="hidden" name="i_transaction_id" class="com_id" value="<?=$transaction_id?>" />
          <input type="text" class="com_input" />
          <div class="iconic_base iconic_search com_popup"></div>
          <span class="com_desc"></span></span>
        </span>	</td>
    </tr>>
    </tr>
   
    <tr>
      <td valign="top">Site</td>
      <td valign="top"> <span class="lookup" id="lookup_site">
          <input type="hidden" name="i_site_id" class="com_id" value="<?=$site_id?>" />
          <input type="text" class="com_input" />
          <div class="iconic_base iconic_search com_popup"></div>
          <span class="com_desc"></span></span>
        </span>	</td>
    </tr>
    
    <tr>
      <td valign="top">Site Mapping</td>
      <td valign="top"> <span class="lookup" id="lookup_site_mapping">
          <input type="hidden" name="i_site_mapping_id" class="com_id" value="<?=$site_mapping_id?>" />
          <input type="text" class="com_input" />
          <div class="iconic_base iconic_search com_popup"></div>
          <span class="com_desc"></span></span>
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
	<table id="lookup_table_po_received" cellpadding="0" cellspacing="0" border="0" class="display" > 
		<thead>
			<tr>
            <th>ID</th>
			<th>Project Phase</th>
         	<th>PO Number</th>
            <th>PO Type</th>
			<th>Project Name</th>
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
	<table id="lookup_table_site" cellpadding="0" cellspacing="0" border="0" class="display" > 
		<thead>
			<tr>
            <th>ID</th>
			<th>Site Code</th>
         	<th>Site Name</th>
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
	<table id="lookup_table_site_mapping" cellpadding="0" cellspacing="0" border="0" class="display" > 
		<thead>
			<tr>
            <th>ID</th>
			<th>Site Code</th>
         	<th>Site Name</th>
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






