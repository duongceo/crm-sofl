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
		echo '<td class="text-center" style="background-color: red; color: #fff">Chưa có thương hiệu</td>';
		break;
} ?>