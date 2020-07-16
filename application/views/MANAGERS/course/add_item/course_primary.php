<tr>

    <td class="text-right">

        <?php //echo h_find_name_display($key, $this->list_view); ?>
        Khóa học chính

    </td>

    <td>

        <!-- <select class="form-control select_course_code selectpicker" name="add_<?php echo $key;?>[]" multiple> -->
        <select class="form-control select_course_code selectpicker" name="add_course_primary[]" multiple>

            <!-- <option value="0"> Chọn <?php //echo h_find_name_display($key, $this->list_view); ?> </option> -->

            <?php foreach ($arr as $key => $value) {

                ?>

                <option value="<?php echo $value['course_code'] ?>"> <?php echo $value['course_code'] ?></option>

                <?php

            }

            ?>

        </select>

    </td>

</tr>


<!-- <tr>
    <td class="text-right">
        Phần trăm doanh thu khóa chính
    </td>

    <td>

        <input type="text" name="add_per_revenue_primary" class="form-control" value="" />

    </td>
</tr> -->
