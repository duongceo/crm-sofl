<td class="text-center">
	<?php if (isset($value['level_study_detail']) && $value['level_study_detail'] != '') {
		echo $value['level_study_detail'];
	} else if (isset($value['level_study_id'])) {
		echo $value['level_study_id'];
	}
	?>
</td>
