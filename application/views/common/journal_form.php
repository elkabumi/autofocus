<script type="text/javascript">	
$(function(){
	createLookUp({
		table_id	: "#lookup_table_coa_journal",
		table_width	: 400,
		listSource 	: "journalcrud/coa_table_control",
		dataSource	: "journalcrud/coa_lookup_hierarchy",
		column_id 	: 0,
		component_id	: "#lookup_component_coa_journal",
		filter_by		: [{id : "p1", label : "Kode"}, {id : "p2", label : "Nama"}]
	});
	
	createLookUp({
		table_id	: "#lookup_table_market_journal",
		table_width	: 400,
		listSource 	: "lookup/market_table_control",
		dataSource	: "lookup/market_lookup_id",
		column_id 	: 0,
		component_id	: "#lookup_market_journal",
		filter_by		: [{id : "p2", label : "Nama"}]
	});
	//updateAll(); // tambahkan ini disetiap form
});
</script>
<?php
$is_add = (strlen($index)==0)?1:0;
?>
<form class="subform_area">
<table class="form_layout">
	<tr>
		<td width="120" req="req">Account No.</td>
		<td>
        	<span class="lookup" id="lookup_component_coa_journal">
				<input type="hidden" name="i_account" class="com_id" value="<?=$coa_id?>" />
				<input type="text" class="com_input" id="i_account" size="15" />
				<div class="iconic_base iconic_search com_popup"></div>
				<span class="com_desc"></span>				
			</span>
            <!-- simpan data lain dari table -->
            <input type="hidden" name="i_transaction_id" value="<?=$transaction_id?>" />
            
            <!-- variable untuk transient form -->
            <input type="hidden" name="i_index" value="<?=$index?>" />
			<?php
			if(!$is_add)
			{
			?>
			<input type="hidden" name="i_market" value="<?=$market_id?>" />
			<input type="hidden" name="i_jumlah" value="<?=$amount?>" />
			<input type="hidden" name="i_tipe" value="<?=$tipe?>" />
			<?php
			}
			?>
        </td>
	</tr>
	<tr>
		<td>Pasar</td>
		<td>
			<span class="lookup" id="lookup_market_journal">
			<input type="hidden" name="i_market" class="com_id" value="<?=$market_id?>" />
			<input type="text" class="com_input" size="6" />
			<div class="iconic_base iconic_search com_popup"></div>
			<span class="com_desc"></span>
			</span>
		</td>
	</tr>
	<tr>
		<td >Keterangan</td>
		<td>
			<textarea name="i_keterangan" cols="40" rows="3"><?=$desc?></textarea> 
		</td>
	</tr>
	<tr>
		<td  req="req">Jumlah</td>
		<td>
			<input type="text" name="i_jumlah" size="15" value="<?=$amount?>"/> ,<!--  <?=$is_add?'':'disabled="disabled"'?>  -->
			<select name="i_tipe" init="<?=$tipe?>" ><option value="0" <?=($tipe==0?'selected':'')?> >Debit</option><option value="1" <?=($tipe==1?'selected':'')?> >Kredit</option></select>
		</td>
	</tr>
</table>
<div class="command_bar">
	<input type="button" id="submit" value="Simpan ke Table" />
	<input type="reset" id="reset"  value="Reset" />
	<input type="button" id="cancel" value="Batal" />
</div>
</form>

<div>
	<table  id="lookup_table_coa_journal" cellpadding="0" cellspacing="0" border="0" class="display" > 
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
	<table id="lookup_table_market_journal" cellpadding="0" cellspacing="0" border="0" class="display" > 
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
