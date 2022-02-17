<?php if ($row['role_id'] == 1 || $row['role_id'] == 11) { ?>

    <tr>

        <td class="text-right"> KPI </td>

        <td>

            <input type="text" name="targets" class="form-control" value="<?php echo $row['targets'] ?>" />

        </td>

    </tr>

<?php } ?>