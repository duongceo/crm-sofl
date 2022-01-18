
<div class="row">
    <h1 class="text-center">Danh sách order giáo viên bản ngữ</h1>
</div>

<div class="container">
<!--    <div>-->
<!--        <form action="#" method="GET" id="action_contact" class="form-inline">-->
<!--            --><?php //$this->load->view('common/content/filter'); ?>
<!--        </form>-->
<!--    </div>-->

    <div class="row">
        <div class="col-md-10">
            <div class="text-left">
                <a class="btn btn-primary" data-toggle="modal" href='#modal-id'>Đặt lịch giáo viên bản ngữ</a>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Ngày đặt lịch</th>
                    <th>Lớp</th>
                    <th>Xác nhận phòng ĐT</th>
                    <th>Giáo viên</th>
                    <th>Thông tin giáo viên</th>
                    <th>Người đặt lịch</th>
                </tr>
            </thead>

            <tbody id="log-body">
            <?php if (isset($order_teacher) && !empty($order_teacher)) { ?>
                <?php foreach ($order_teacher as $item){ ?>
                    <tr>
                        <td class="text-center">
                            <?php echo date('d-m-Y', $item['day_order']); ?>
                        </td>
                        <td class="text-center">
                            <?php echo $item['class_study_id']; ?>
                        </td>
                        <td class="text-center">
                            <?php if ($item['paid_status']) { ?>
                                <p class="bg-success">Đã xác nhận</p>
                            <?php } else { ?>
                                <p class="bg-warning">Chưa xác nhận</p>
<!--                                --><?php //if ($this->role_id == 14) { ?>
<!--                                    <a class="btn btn-xs btn-primary btn_paid_cost_branch">Thanh toán</a>-->
<!--                                --><?php //} ?>
                            <?php } ?>
                        </td>
                        <td class="text-center">
                            <?php echo ($item['has_teacher']) ? 'Có GV' : 'Chưa có GV'; ?>
                        </td>
                        <td class="text-center">
                            <?php echo $item['teacher_name']; ?>
                        </td>
                        <td class="text-center">
                            <?php echo $item['user_order_name']; ?>
                        </td>
                    </tr>
                <?php } ?>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modal-id" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Order giáo viên bản ngữ</h4>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url('staff_managers/teacher/order_teacher_abroad') ?>" method="POST" class="form-inline" role="form">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-striped table-bordered table-hover table-1 table-view-1">
                                <tr>
                                    <td  class="text-right">Ngày học</td>
                                    <td>
                                        <input type="text" class="form-control datepicker" name="day_order" style="width: 100%;">
                                    </td>
                                </tr>

                                <tr>
                                    <td class="text-right">Lớp</td>
                                    <td>
                                        <select class="form-control select_search" name="class_study_id">
                                            <option value=""> Lớp </option>
                                            <?php foreach ($class_study as $key => $value) { ?>
                                                <option value="<?php echo $value['class_study_id'] ?>"> <?php echo $value['class_study_id'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="col-md-6">
                            <table class="table table-striped table-bordered table-hover table-2 table-view-2">
                                <tr>
                                    <td class="text-right">
                                        Xác nhận của phòng đào tạo
                                    </td>
                                    <td>
                                        <input type="checkbox" class="switch_select" name="confirm" value="1" data-off-text="Chưa xác nhận" data-on-text="Đã xác nhận" data-handle-width="100">
                                    </td>
                                </tr>

                                <tr>
                                    <td class="text-right">
                                        Có giáo viên không ?
                                    </td>
                                    <td>
                                        <input type="checkbox" class="switch_select" name="has_teacher" value="1" data-off-text="Chưa có" data-on-text="Đã có" data-handle-width="100">
                                    </td>
                                </tr>

                                <tr>
                                    <td class="text-right">Giảng viên</td>
                                    <td>
                                        <select class="form-control select_search" name="teacher_id">
                                            <option value="0"> Chọn giảng viên</option>
                                            <?php foreach ($teacher as $key => $value) { ?>
                                                <option value="<?php echo $value['id'] ?>"> <?php echo $value['name'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-success btn-lg" style="width: 130px;">Lưu</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(".switch_select").bootstrapSwitch();
</script>

<script>
	$(document).ready(function() {
		$('.select_search').select2({
			width: '100%',
		});
	});
</script>
