<?php switch ($row['level_language_id']) {
	case 'CB':
		echo '<td class="text-center">Cơ Bản</td>';
		break;
	case 'NC':
		echo '<td class="text-center">Nâng Cao</td>';
		break;

	default:
		echo '<td class="text-center" style="background-color: red; color: #fff">Chưa có trình độ lớp học</td>';
		break;
} ?>
