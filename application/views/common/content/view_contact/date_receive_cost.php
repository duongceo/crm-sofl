<?php if ($rows['date_receive_lakita'] > 0) { ?>

    <tr>

        <td class="text-right">  Ngày thanh toán </td>

        <td>  <?php

            if ($rows['date_receive_cost'] > 0)

                echo date(_DATE_FORMAT_, $rows['date_receive_cost']);

            ?> 

        </td>

    </tr>

<?php } ?>
