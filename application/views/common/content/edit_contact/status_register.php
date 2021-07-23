<tr>
	<td class="text-right"> Trạng thái đăng ký </td>
	<td>
		<div class="radio" style="margin-top: 0;">
			<label class="radio-inline" style="width: 45%">
				<input type="radio" name="status_register" value="0" <?php if($rows['status_register'] == 0){echo 'checked="checked"';} ?>> Đăng ký mới
			</label>
			<label class="radio-inline" style="width: 45%">
				<input type="radio" name="status_register" value="1" <?php if($rows['status_register'] == 1){echo 'checked="checked"';} ?>> Đăng ký tiếp
			</label>
		</div>
	</td>
</tr>
