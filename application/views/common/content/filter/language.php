<?php if (isset($language_study)) { ?>
    <tr>
        <td class="text-right"> Ngoại ngữ </td>
        <td>
            <select class="form-control selectpicker" name="filter_language_id[]" multiple>
                <?php
                foreach ($language_study as $key => $value) {
                    ?>
                    <option value="<?php echo $value['id']; ?>"
                    <?php
                    if (isset($_GET['filter_language_id'])) {
                        foreach ($_GET['filter_language_id'] as $value2) {
                            if ($value2 == $value['id']) {
                                echo 'selected';
                                break;
                            }
                        }
                    }
                    ?>>
                        <?php echo $value['name']; ?>
                    </option>
                    <?php
                }
                ?>
            </select>
        </td>
    </tr>
<?php } ?>