<tr>
	<td class="text-right"> Hoàn thành học phí ? </td>
	<td>
		<div class="radio" style="margin-top: 0;">
			<label class="radio-inline" style="width: 45%">
				<input type="radio" name="complete_fee" value="0" <?php if($rows['complete_fee'] == 0){echo 'checked="checked"';} ?>> Chưa
			</label>
			<label class="radio-inline" style="width: 45%">
				<input type="radio" name="complete_fee" value="1" <?php if($rows['complete_fee'] == 1){echo 'checked="checked"';} ?>> HT
			</label>
		</div>
	</td>
</tr>
