<div class="form_category">Parameter</div>
  <table width="100%" class="form_layout">
	<tr>
		<td width="116">Customer</td>
		<td width="257"><?php echo  form_dropdown('i_customers', $customers, $customers_id)  ?></td>
	</tr>
    <tr>
		<td>Status</td>
		<td><?php echo  form_dropdown('i_status', $status)  ?></td>
	</tr>


</table>