<?php if ($row['role_id'] == 1) { ?>

    <tr class="ipphone">

        <td class="text-right"> Mật khẩu IPPhone </td>

        <td>

            <input type="text" name="ipphone_password" class="form-control" value="<?php echo $row['ipphone_password'] ?>" />

        </td>

    </tr>

<?php } ?>