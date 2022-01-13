<?php
    $level = array(
        array('LV0', 0, 40),
        array('LV1', 40, 60),
        array('LV2', 60, 70),
        array('LV3', 70, 80),
        array('LV4', 80, 90),
        array('LV5', 90, 100),
        array('LV6', 100, 110),
    );
?>

<tr>
    <td class="text-right"> Level tỷ lệ đi lên </td>
    <td>
        <select class="form-control selectpicker" name="filter_level">
            <option value=""> Chọn level </option>
            <?php foreach ($level as $key => $value) { ?>
                <?php list($name, $limit1, $limit2) = $value ?>
                <option value="<?php echo $name ?>" <?php if ($name == $_GET['filter_level']) echo 'selected'; ?>>
                    <?php echo $name; ?>
                </option>
            <?php } ?>
        </select>
    </td>
</tr>