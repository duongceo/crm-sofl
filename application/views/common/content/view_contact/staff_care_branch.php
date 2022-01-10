<tr>
    <td class="text-right"> Chăm sóc viên cơ sở </td>
    <td>  <?php
        foreach ($staff_care_branch as $key => $value) {
            if ($value['id'] == $rows['staff_care_branch_id']) {
                echo $value['name'];
                break;
            }
        }
        ?>
    </td>
</tr>