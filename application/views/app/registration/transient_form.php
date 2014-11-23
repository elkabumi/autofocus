<script type="text/javascript">	
$(function(){
	createLookUp({
		table_id		: "#lookup_table_active_product",
		listSource 		: "lookup/active_product_table_control/1/" + $('input[name="i_stand_id"]').val(),
		dataSource		: "lookup/active_product_lookup_id",
		component_id	: "#lookup_active_product",
		filter_by		: [{id : "p1", label : "Kategori Produk"}, {id : "p2", label : "Nama Produk"}, {id : "p3", label : "Tipe Produk"}],
		onSelect		: load_product_stock
	});
	
	function load_product_stock(id){
	
		if(id == ""){
			return;
		}
		
		var data ='product_stock_id='+id; 
		
		$.ajax({
			type: 'POST',
			url: '<?=site_url('registration/load_product_stock')?>',
			data: data,
			dataType: 'json',
			success: function(data){					
				$('input[name="i_product_id"]').val(data.content['product_id']);
				$('input[name="i_product_code"]').val(data.content['product_code']);
				$('input[name="i_transaction_detail_price"]').val(data.content['price']);
				$('input[name="i_transaction_detail_qty"]').val('');
				$('input[name="i_transaction_detail_total_price"]').val('');
			}
			
		});
		
	}
	
	$('input[name="i_transaction_detail_qty"]').change(function(){
		var price 	= $('input[name="i_transaction_detail_price"]').val();
		var qty = $(this).val();
		var total = price * qty;
		
		$('input[name="i_transaction_detail_total_price"]').val(total);
		
	});
	
});
</script>
<form class="subform_area">
<div class="form_area_frame">
<table class="form_layout">
	<tr>
		<td width="150" req="req">Produk
	 <span class="lookup" id="lookup_active_product">
        <input type="hidden" name="i_product_stock_id" class="com_id" value="<?=$product_stock_id?>" />
         <div class="iconic_base iconic_search com_popup" style="margin-top:5px !important"></div>
        <input type="text" class="com_input" size="6" name="module" />
        <input type="hidden" name="i_index" value="<?=$index?>" />
        <input type="hidden" name="i_product_id" value="" />
        <input type="hidden" name="i_product_code" value="" />
        
       </span></td>
	</tr>
    <tr>
     <td width="70" >Harga<input name="i_transaction_detail_price" type="text" id="i_transaction_detail_price" value="<?=$transaction_detail_price ?>" readonly="readonly" />
     </td>
   </tr>
    <tr>
     <td width="70" >Jumlah<input name="i_transaction_detail_qty" type="text" id="i_transaction_detail_qty" value="<?=$transaction_detail_qty ?>" />
     </td>
   </tr>
    <tr>
     <td width="70" >Total<input name="i_transaction_detail_total_price" type="text" id="i_transaction_detail_total_price" value="<?=$transaction_detail_total_price ?>" readonly="readonly" />
     </td>
   </tr>
	
</table>
</div>
<div class="command_bar">
	<input type="button" id="submit" value="Simpan" />
<input type="reset" id="reset"  value="Reset" />
	<input type="button" id="cancel" value="Batal" />
</div>
</form>
<div>
	<table  id="lookup_table_active_product" cellpadding="0" cellspacing="0" border="0" class="display" > 
		<thead>
			<tr>
				<th width="10%">ID</th>
				<th>Nama Cabang</th>
                <th>Kategori</th>
                <th>Kode Produk</th>
                <th>Nama Produk</th>
                <th>Tipe Produk</th>
                <th>Stok</th>
				<th>Harga</th>
           
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
