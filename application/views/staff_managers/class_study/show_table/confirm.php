<td class="text-center" column="confirm">
    <?php if (!empty($row['user_confirm'])) { ?>
        <p class="bg-success"> Đã xác nhận </p>
    <?php } else { ?>
        <?php if ($this->role_id == 3) { ?>
            <button style="margin-right: 0" type="button" class="btn btn-success confirm_class">
                Xác nhận
            </button>
        <?php } else { ?>
            <p class="bg-danger"> Chưa xác nhận </p>
        <?php } ?>
    <?php } ?>
</td>
