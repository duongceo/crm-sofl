<td class="text-center">
    <?php
        if (!empty($value['date_paid_refund'])) {
            echo date('d/m/Y H:i', $value['date_paid_refund']);
        }
    ?>
</td>