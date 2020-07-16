<!--<tr>
    <td class="text-right">
        Chọn chiến dịch quảng cáo
    </td>
    <td>
        <select class="form-control selectpicker" name="edit_<?php //echo $key;?>">
            <option value="0"> Chọn chiến dịch quảng cáo </option>
            <?php //foreach ($arr as $key => $value) {
                ?>
                <option value="<?php //echo $value['id'] ?>" <?php //if($value['id'] == $row['campaign_id']) echo 'selected= "selected"';?>> <?php //echo $value['name'] ?></option>
                <?php
            //}
            ?>
        </select>
    </td>
</tr>--><link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" /><tr>	<td class="text-right">        Chọn chiền dịch quảng cáo    </td>    <td>				<!--<select style="width: 100%;" id="channel-val" class="form-control select_course" name="add_<?php echo $key;?>" multiple="multiple">-->		<select style="width: 100%;" class="form-control select_course" name="edit_<?php echo $key;?>" multiple="multiple">			<?php foreach ($arr as $value) { ?>				 <option value="<?php echo $value['id'] ?>" <?php if($value['id'] == $row['campaign_id']) echo 'selected= "selected"';?>> <?php echo $value['name'] ?></option>			<?php } ?>		</select>    </td></tr><script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script><script>	$(document).ready(function() {		$('.select_course').select2({			placeholder: 'Tìm khóa học',		});	});</script>
