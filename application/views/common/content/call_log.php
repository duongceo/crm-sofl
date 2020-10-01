<table class="table table-striped table-bordered table-hover call-log">

    <thead>

        <tr>

            <th>

                Lần gọi 

            </th>

            <th>

                Thời gian

            </th>

            <th>

                Người gọi

            </th>

            <th>

                Trạng thái gọi

            </th>

            <th>

                Trạng thái contact

            </th>

			<th>

				Trạng thái học viên

			</th>


            <th class="content-change">

                Nội dung thay đổi

            </th>

        </tr>

    </thead>

    <tbody>

        <?php

        if (isset($call_logs)) {

            foreach ($call_logs as $key_call_log => $value_call_log) {

                ?>

                <tr>

                    <td>

                        Lần gọi thứ <?php echo $key_call_log + 1; ?>

                    </td>

                    <td>

                        <?php echo date('d/m/Y H:i:s', $value_call_log['time_created']); ?>

                    </td>

                    <td>

                        <?php echo $value_call_log['staff_name']; ?>

                    </td>

                    <td>

                        <?php echo $value_call_log['call_status_desc']; ?>

                    </td>

                    <td class="text-center">

                        <?php echo $value_call_log['level_contact_id']; ?>

                    </td>

					<td class="text-center">

						<?php echo $value_call_log['level_student_id']; ?>

					</td>


                    <td>

                        <?php echo html_entity_decode($value_call_log['content_change']); ?>

                    </td>

                </tr>

                <?php

            }

        }

        ?>

    </tbody>

</table>
