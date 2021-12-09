<td class="text-center tbl_sale">
    <?php
    foreach ($staffs as $key2 => $value2) {
        if ($value2['id'] == $value['sale_staff_id']) {
            echo $value2['name'];
        }
    }
    ?>
</td>