<tr>
    <td class="text-right"> Khách đã kích hoạt khóa học ? </td>
    <td> 
        <?php if ($rows['account_active'] == 0) { ?>

            <p class="text-danger">Contact chưa kích hoạt</p>

        <?php } else { ?>

            <p class="text-success">Contact đã kích hoạt</p>

        <?php } ?>
    </td>
</tr>
