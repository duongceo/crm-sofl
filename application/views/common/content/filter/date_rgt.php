<tr class="filter_date_date_rgt">

    <td class="text-right"> Ngày contact về : </td>

    <td>

        <input type="text" class="form-control daterangepicker" name="filter_date_date_rgt" style="position: static" autocomplete="off"

        <?php if (filter_has_var(INPUT_GET, 'filter_date_date_rgt')) { ?>

                   value="<?php echo filter_input(INPUT_GET, 'filter_date_date_rgt') ;?>"

               <?php } ?> 

               />

    </td>

</tr>