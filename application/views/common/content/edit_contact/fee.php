<tr>

    <td class="text-right"> Học phí </td>

    <td>  

        <div class="form-group">

            <label for="price-purchase" class="sr-only">Học Phí</label>

            <input type="text" class="form-control edit-contact-price-purchase money" value="<?php echo $rows['fee']; ?>" name="fee"/>

        </div>

    </td>

</tr>

<script  type="text/javascript">
	$('.money').simpleMoneyFormat();
</script>
