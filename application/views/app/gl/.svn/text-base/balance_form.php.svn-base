<script type="text/javascript">	
$(function(){
	createLookUp({
		table_id		: "#lookup_table_coa",
		listSource 		: "lookup/coa_table_control",
		dataSource		: "lookup/coa_lookup_hierarchy",
		component_id		: "#lookup_component_coa",
		filter_by		: [{id : "p1", label : "Kode"}, {id : "p2", label : "Nama"}]
	});
	
	createLookUp({
		table_id	: "#lookup_table_market",
		table_width	: 400,
		listSource 	: "lookup/market_table_control",
		dataSource	: "lookup/market_lookup_id",
		column_id 	: 0,
		component_id	: "#lookup_market",
		filter_by		: [{id : "p1", label : "Kode"}, {id : "p2", label : "Nama"}]
	});
	
	createDatePicker(); 
	
	updateAll(); // tambahkan ini disetiap form
});
</script>
<form class="form_class">
<table class="form_layout">
	<tr>
		<td width="150">ID</td>
		<td>
			<input type="text" size="5" value="<?=$row_id?>" disabled="disabled" />
			<input type="hidden" name="row_id" value="<?=$row_id?>" /></td>
	</tr>
	<tr>
	  <td req="req">Unit Pasar</td>
	  <td>
		<span class="lookup" id="lookup_market">
			<input type="hidden" name="i_market" class="com_id" value="<?=$market_id?>" />
			<input type="text" class="com_input" size="6" />
			<div class="iconic_base iconic_search com_popup"></div>
			<span class="com_desc"></span>
		</span>
		
	  </td>
	</tr>
	<tr>
	  <td req="req">Coa</td>
	  <td>
	  <span class="lookup" id="lookup_component_coa">
		<input type="hidden" name="i_coa" class="com_id" value="<?=$coa_id?>" />
		<input type="text" class="com_input" size="6" name="module" />
		<div class="iconic_base iconic_search com_popup"></div>
		<span class="com_desc"></span></span></td>
    </tr>
	<tr>
	  <td req="req">Periode</td>
	  <td><?=form_dropdown('i_period', $period, $period_id)?></td>
	</tr>
	<tr>
	  <td req="req">Tanggal Entry</td>
	  <td><input type="text" name="i_date" class="date_input" value="<?php echo $balance_date;?>" /></td>
	</tr>
    <tr>
	<td req="req">Nilai Debet (Rp)</td>
	<td><input type="text" name="i_debit" size="30" maxlength="30" value="<?php echo ($balance_debit) ? $balance_debit : 0;?>" /></td>
    </tr>
    <tr>
	<td req="req">Nilai Kredit (Rp)</td>
	<td><input type="text" name="i_kredit" size="30" maxlength="30" value="<?php echo ($balance_kredit) ? $balance_kredit : 0;?>" /></td>
    </tr>
</table>
<div class="command_transient">
	<input type="button" id="submit" value="Simpan" />
	<input type="reset" id="reset"  value="Reset" />
	<input type="button" id="cancel" value="Batal" />
</div>
</form>
<div>
	<table id="lookup_table_coa" cellpadding="0" cellspacing="0" border="0" class="display" > 
		<thead>
			<tr>
				<th width="10%"></th>
				<th width="30%">Hirarki</th>
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
	<table id="lookup_table_market" cellpadding="0" cellspacing="0" border="0" class="display" > 
		<thead>
			<tr>
			<th>ID</th>
				<th>Kode</th>
				<th>Nama Pasar</th>
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