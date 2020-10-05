<tr>
	<td class="text-right"> Hoàn thành học phí ? </td>
	<td>
		<div>
			<label class="radio-inline">
				<input type="radio" name="complete_fee" value="0" <?php if($rows['complete_fee'] == 0){echo 'checked="checked"';} ?>> Chưa
			</label>
			<label class="radio-inline">
				<input type="radio" name="complete_fee" value="1" <?php if($rows['complete_fee'] == 1){echo 'checked="checked"';} ?>> HT
			</label>
		</div>
	</td>
</tr>
