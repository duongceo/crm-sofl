<tr>

    <td class="text-right">

        <?php //echo h_find_name_display($key, $this->list_view); ?>
        Thương hiệu

    </td>

    <td>

        <!-- <select class="form-control select_course_code selectpicker" name="add_<?php echo $key;?>"> -->
        <select class="form-control select_course_code selectpicker" name="add_brand_id">

            <!-- <option value="0"> Chọn <?php echo h_find_name_display($key, $this->list_view); ?> </option> -->
            <option value="0"> Chọn thương hiệu </option>

            <?php foreach ($arr as $key => $value) {

                ?>

                <option value="<?php echo $value['id'] ?>"> <?php echo $value['name'] ?></option>

                <?php

            }

            ?>

        </select>

    </td>

</tr>

