<?php $idCopy = h_generateRandomString();?>

<td class="text-center tbl_phone btn-copy view_contact_phone" id-copy="<?php echo $idCopy?>"

    data-clipboard-text="<?php echo trim($value['phone']); ?>">

    <?php echo h_phone_format($value['phone']); ?>

    <?php if (!$this->agent->mobile) { ?>

        <input type="text" id="input-copy-<?php echo $idCopy?>" value="<?php echo $value['phone'];?>" />

    <?php } ?>

<!--    <sup>

        <i class="fa fa-clipboard btn-copy" aria-hidden="true" data-clipboard-text="<?php echo trim($value['phone']); ?>"></i>

    </sup>-->

</td>
