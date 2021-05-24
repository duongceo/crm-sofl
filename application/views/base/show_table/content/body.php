<?php
foreach ($rows as $row) {

    ?>

    <tr class="<?php echo (isset($row['warning_class'])) ? $row['warning_class'] : ''; ?> custom_right_menu"

        item_id="<?php echo $row['id']; ?>"

        edit-url="<?php echo base_url().$this->controller_path.'/show_edit_item'?>"

        >

<!--        <td class="text-center tbl_selection">-->
<!---->
<!--            <input type="checkbox" name="item_id[]" value="--><?php //echo $row['id']; ?><!--" class="tbl-item-checkbox"/>-->
<!---->
<!--        </td>-->

        <?php

//		echo '<pre>';print_r($head_tbl);die();

        foreach ($head_tbl as $columm_name => $column_type) {

            if (isset($column_type['display']) && $column_type['display'] == 'none') { //không hiển thị

                continue;

            }

            if (!isset($column_type['type'])) { //text

                //echo "<td class='tbl_" . $columm_name . "'> {$row[$columm_name]} </td>";
				echo "<td class='text-center tbl_'> {$row[$columm_name]} </td>";
            } else {

                switch ($column_type['type']) {

                    case 'currency':

                        $num = is_numeric($row[$columm_name]) ? number_format($row[$columm_name], 0, ",", ".") : $row[$columm_name];

                        echo '<td class="text-center tbl_' . $columm_name . '">' . $num . '</td>';

                        break;

                    case 'datetime':
						$time = ($row[$columm_name] != 0) ? date('d/m/Y', $row[$columm_name]) : '';
                        echo '<td class="text-center tbl_' . $columm_name . '">' . $time . '</td>';

						break;

                    case 'binary':

                        $checked = ($row['active'] == '1') ? 'checked' : '';

                        echo '<td>

                                <div class="toggle-input marginbottom20">

                                    <label class="switch">

                                        <input disabled="disabled" type="checkbox" 

                                        data-url="'.base_url($this->controller_path . '/edit_active').'" name="edit_active" item_id="'. $row['id'] .'" '. $checked .'/>

                                        <span class="slider round"></span>

                                     </label>

                                </div>

                            </td>';

                        break;

                    case 'custom' :

                        $data['row'] = $row;

                        if (isset($column_type['value'])) {
                            $data['value'] = $column_type['value'];
                        } else {
                            $data['value'] = array();
                        }

                        // $data['value'] = $column_type['value'];

                        $this->load->view($this->view_path . '/show_table/' . $columm_name, $data);

                        break;

					case 'active':

						echo ($row['active'] == '1') ? '<th class="text-center tbl_' . $columm_name . '">Đang hoạt động</th>' : '<td class="text-center tbl_' . $columm_name . '">Ko hoạt động</td>';
						break;
                }

            }

        }

        ?>
    </tr>

<?php } ?>
