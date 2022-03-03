<td class="text-center cost_branch">
    <?php if (!empty($value['money_refund'])) { ?>
        <p><?php echo h_number_format($value['money_refund']); ?></p>
        <?php if ($this->role_id == 13) { ?>
            <?php if (empty($value['paid_status'])) { ?>
                <button class="btn btn-xs btn-primary btn_paid_cost_branch" type_money="refund" cost_id="<?php echo  $value['id'] ?>">Thanh toán</button>
            <?php } else { ?>
                <p class="bg-success">Đã thanh toán</p>
            <?php } ?>
        <?php } ?>
    <?php } ?>
</td>
