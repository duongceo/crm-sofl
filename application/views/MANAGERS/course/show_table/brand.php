<!-- <?php if ($row['brand_id'] == 1) { ?>
	<td class="text-center">Lakita</td>
<?php } else if ($row['brand_id'] == 2) { ?>
	<td class="text-center">Eduhealth</td>
<?php } else if ($row['brand_id'] == 3) { ?>
	<td class="text-center">Yeahfood</td>
<?php } else { ?>
	<td class="text-center" style="background-color: red">Chưa có thương hiệu</td>
<?php } ?> -->

<?php switch ($row['brand_id']) {
	case 1:
		echo '<td class="text-center">Lakita</td>';
		break;
	case 2:
		echo '<td class="text-center">Eduhealth</td>';
		break;
	case 3:
		echo '<td class="text-center">Yeahfood</td>';
		break;
	case 5:
		echo '<td class="text-center">Agency</td>';
		break;
	default:
		echo '<td class="text-danger">Chưa có thương hiệu</td>';
		break;
} ?>