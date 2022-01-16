<td class="text-center">
    <?php
        if (!empty($value['date_refund'])) {
            echo date('d/m/Y H:i', $value['date_refund']);
        }
    ?>
</td>