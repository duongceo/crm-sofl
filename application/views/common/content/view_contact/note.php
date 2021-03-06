<?php if(!empty($notes)) { ?>
<tr>
    <td class="text-right"> Ghi chú </td>
    <td> 
        <?php if (!empty($notes)) { ?>
            <table class="table table-bordered table-striped tbl-note">
                <thead>
                    <tr>
                        <th>
                            STT
                        </th>   
                        <th>
                            Nội dung
                        </th> 
                        <th>
                            Thời gian
                        </th> 
                        <th>
                            Người viết
                        </th>   
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($notes as $key => $value) { ?>
                        <tr>
                            <td class="text-center">
                                <?php echo $key + 1; ?>
                            </td>
                            <td>
                                <?php echo $value['content']; ?>
                            </td>
                            <td class="text-center">
                                <?php echo date(_DATE_FORMAT_, $value['time_created']); ?>
                            </td>
                            <td class="text-center">
                                <?php
                                    foreach ($staffs as $key2 => $value2) {
                                        if ($value['sale_id'] == $value2['id']) {
                                            echo $value2['name'];
                                            break;
                                        }
                                    }
                                ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } ?>
    </td>
</tr>
<?php } ?>
