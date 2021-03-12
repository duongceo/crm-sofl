
<!--<td class="center tbl_link">-->
<!--	--><?php
//	if (isset($value['link_id']) && !empty($value['link_id'])) {
//		foreach ($link as $key2 => $value2) {
//			if ($value2['id'] == $value['link_id']) { ?>
<!--				<a href="--><?php //echo 'http://'.$value2['url']; ?><!--" style="color: blue" target="blank">link landingpage</a>-->
<!--	--><?php
//				break;
//			}
//		}
//	} else echo 'không có langdingpage';
//	?>
<!--</td>-->

<td class="text-center tbl_link">
	<?php if (isset($value['link_id']) && $value['link_id'] != '0') {
		echo $value['link_id'];
	} else {
		echo 'UNKNOWN';
	}
	?>
</td>

