
<?php if (isset($level_language)) { ?>
    <tr>
        <td class="text-right"> Khóa học</td>
        <td>
            <select class="form-control level_language_id item_id" name="filter_level_language_id[]" multiple style="width: 100%;">
                <?php foreach ($level_language as $value) { ?>
                    <option value="<?php echo $value['id']; ?>"
                        <?php
                        if (isset($_GET['filter_level_language_id'])) {
                            foreach ($_GET['filter_level_language_id'] as $value2) {
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

    <script>
        $(document).ready(function() {
            $('.level_language_id').select2({
                placeholder: 'Tìm kiếm',
            });
        });
    </script>
<?php } ?>
