<tr>

    <td class="text-right">

        Chọn landing page

    </td>


	<td>

		<select style="width: 100%;" class="form-control select_landingpage" name="add_<?php echo $key; ?>" multiple="multiple">
			<option value="">Chọn landingpage</option>
			<?php foreach ($arr as $value) { ?>
				<option value="<?php echo $value['id'] ?>" data-url="<?php echo $value['url'] ?>"> <?php echo $value['landingpage_code'] . ' - ' . $value['url'] ?></option>
			<?php } ?>
		</select>

<!--            <div class="input-group-btn" id="basic-addon2"> <button class="btn btn-success btn-preview"> Xem trước landingpage </button> </div>-->

    </td>

</tr>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>

<script>
	$(document).ready(function() {
		$('.select_landingpage').select2({
			placeholder: 'Tìm Landingpage',
		});
	});
</script>

