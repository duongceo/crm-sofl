<tr>

    <td class="text-right">

        <?php //echo h_find_name_display($key, $this->list_view); ?>
        Khóa học chính

    </td>

    <td>

        <select class="form-control select_course_code selectpicker" name="edit_course_primary[]">

            <option value="0"> Chọn Khóa học chính </option>

            <?php 

                $course_primary = explode(',', $row['course_primary']);

                foreach ($arr as $key => $value) { ?>

                <option value="<?php echo $value['course_code'] ?>" 
                    <?php if(in_array($value['course_code'], $course_primary)){echo 'selected';} ?>> 

                        <?php echo $value['course_code'] ?>
                        
                </option>

            <?php } ?>

        </select>

    </td>

</tr>


<!-- <tr>
    <td class="text-right">
        Phần trăm doanh thu khóa chính
    </td>

    <td>

        <input type="text" name="edit_per_revenue_primary" class="form-control" value="<?php if($row['per_revenue_primary']) echo $row['per_revenue_primary']?>" />

    </td>
</tr> -->


