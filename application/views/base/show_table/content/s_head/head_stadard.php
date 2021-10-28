<?php
    $style = (in_array($key, ['priority', 'number_student', 'total_lesson'])) ? 'style="width: 4%;"' : '';
?>
<th class="<?php echo 'tbl_' . $this->controller . '_' . $key; echo ($key=='notes')?' tbl_last_note':'';?>" id="<?php echo 'th_' . $key; ?>" <?php echo $style ?>>
    <?php echo $value['name_display'] ?>
</th>
