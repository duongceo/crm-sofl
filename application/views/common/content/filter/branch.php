<?php if (isset($branch)) { ?>
    <tr>
        <td class="text-right"> Cơ sở </td>
        <td>
            <select class="form-control selectpicker" name="filter_branch_id[]" multiple>
                <option value="0">UNKNOWN</option>
                <?php foreach ($branch as $key => $value) { ?>
                    <option value="<?php echo $value['id']; ?>" 
                    <?php
                        if (isset($_GET['filter_branch_id'])) {
                            foreach ($_GET['filter_branch_id'] as $value2) {
                                if ($value2 == $value['id']) {
                                    echo 'selected';
                                    break;
                                }
                            }
                        }
                    ?>>
                    <?php echo $value['name']; ?>
                    </option>
                <?php } ?>
            </select>
        </td>
    </tr>
<?php } ?>