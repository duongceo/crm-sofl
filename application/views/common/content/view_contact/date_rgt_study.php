<?php if ($rows['date_rgt_study'] > 0) { ?>
    <tr>
        <td class="text-right">  Ngày đăng ký học </td>
        <td>  <?php
            if ($rows['date_rgt_study'] > 0)
                echo date(_DATE_FORMAT_, $rows['date_rgt_study']);
            ?> 
        </td>
    </tr>
<?php } ?>