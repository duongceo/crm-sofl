<tr class="filter_date_date_rgt_study">

    <td class="text-right"> Ngày đăng ký học: </td>

    <td>

 <input type="text" class="form-control daterangepicker" name="filter_date_date_rgt_study" style="position: static" autocomplete="off"

        <?php if (filter_has_var(INPUT_GET, 'filter_date_date_rgt_study')) { ?>

                   value="<?php echo filter_input(INPUT_GET, 'filter_date_date_rgt_study') ;?>"

               <?php }?>

               />

    </td>

</tr>