<?php if (isset($status_for_lecture)) { ?>
    <tr>
        <td class="text-right"> Trạng thái CT học </td>
        <td>
            <select class="form-control selectpicker" name="filter_status_lecture_id[]" multiple>
                <?php
                foreach ($status_for_lecture as $key => $value) {
                    ?>
                    <option value="<?php echo $value['id']; ?>"
                        <?php
                        if (isset($_GET['filter_status_lecture_id'])) {
                            foreach ($_GET['filter_status_lecture_id'] as $value2) {
                                if ($value2 == $value['id']) {
                                    echo 'selected';
                                    break;
                                }
                            }
                        }
                        ?>>
                        <?php echo $value['status']; ?>
                    </option>
                    <?php
                }
                ?>
            </select>
        </td>
    </tr>
<?php } ?>