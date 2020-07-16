<tr class="tbl_bank">

    <td class="text-right"> Khách đã kích hoạt khóa học ?</td>

    <td class="position-relative">  

        <?php if ($rows['account_active'] == 0) { ?>

            <p class="text-warning">Contact chưa kích hoạt</p>

        <?php } else { ?>

            <p class="text-success">Contact đã kích hoạt</p>

        <?php } ?>

    </td>

</tr>

