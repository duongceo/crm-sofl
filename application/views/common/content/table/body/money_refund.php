<td class="text-center">
    <?php if (!empty($value['money_refund'])) { ?>
        <p><?php echo h_number_format($value['money_refund']); ?></p>
        <?php if ($this->role_id == '13') { ?>
            <button class="btn btn-xs btn-primary btn_paid_cost_branch" type_money="refund" cost_id="<?php echo  $value['id'] ?>">Thanh toán</button>
        <?php } ?>
    <?php } ?>
</td>
