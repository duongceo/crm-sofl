<tr>

	<td class="text-right"> Lương/Buổi </td>

	<td>

		<div class="form-group">

			<input type="text" class="form-control money" value="<?php echo $row['salary_per_day']?>" name="edit_salary_per_day"/>

		</div>

	</td>

</tr>

<script  type="text/javascript">
	$('.money').simpleMoneyFormat();
</script>
