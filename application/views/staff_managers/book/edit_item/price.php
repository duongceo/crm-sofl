<tr>

	<td class="text-right"> Giá sách </td>

	<td>

		<div class="form-group">

			<input type="text" class="form-control money" value="<?php echo $row['price']?>" name="edit_price"/>

		</div>

	</td>

</tr>

<script  type="text/javascript">
	$('.money').simpleMoneyFormat();
</script>
