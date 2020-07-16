<tr>

    <td class="text-right">

        <?php //echo h_find_name_display($key, $this->list_view); ?>
        Khóa học phụ

    </td>

    <td>

        <select class="form-control select_course_code selectpicker" name="edit_<?php echo $key;?>[]">

            <!-- <option value="0"> Chọn <?php echo h_find_name_display($key, $this->list_view); ?> </option> -->
            <option value="0"> Chọn khóa học phụ</option>

            <?php 
                $course_support = explode(',', $row['course_supporting']);

                foreach ($arr as $key => $value) { ?>

                <option value="<?php echo $value['course_code'] ?>" 
                    <?php if(in_array($value['course_code'], $course_support)){echo 'selected';} ?>> 

                        <?php echo $value['course_code'] ?>
                        
                </option>

            <?php } ?>

        </select>

    </td>

</tr>

<!-- <tr>
    <td class="text-right">
        Phần trăm doanh thu khóa phụ
    </td>

    <td>

        <input type="text" name="edit_per_revenue_support" class="form-control" value="<?php if($row['per_revenue_support'] != 0) echo $row['per_revenue_support'] ?>" />

    </td>
</tr>
 -->
