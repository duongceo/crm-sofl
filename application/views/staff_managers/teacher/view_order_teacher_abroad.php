
<div class="row">
    <h1 class="text-center">Danh sách order giáo viên bản ngữ</h1>
</div>

<div class="container">
    <div>
        <form action="#" method="GET" id="action_contact" class="form-inline">
            <?php $this->load->view('common/content/filter'); ?>
        </form>
    </div>

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
                    <th>Giờ</th>
                    <th>Lớp</th>
                    <th>Nội dung</th>
                    <th>Xác nhận phòng ĐT</th>
                    <th>Giáo viên</th>
                    <th>Thông tin giáo viên</th>
                    <th>Người đặt lịch</th>
                    <?php if ($this->role_id == 14) { ?>
                        <th>Xác nhận</th>
                    <?php } ?>
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
                            <?php echo $item['time_study']; ?>
                        </td>
                        <td class="text-center">
                            <?php echo $item['class_study_id']; ?>
                        </td>
                        <td>
                            <?php echo $item['content_order']; ?>
                        </td>
                        <td class="text-center">
                            <?php if ($item['confirm']) { ?>
                                <p class="bg-success">Đã xác nhận</p>
                            <?php } else { ?>
                                <p class="bg-warning">Chưa xác nhận</p>
                            <?php } ?>
                        </td>
                        <td class="text-center">
                            <?php echo ($item['has_teacher']) ? '<p class="bg-success">Có giáo viên</p>' : '<p class="bg-warning">Chưa có giáo viên</p>'; ?>
                        </td>
                        <td class="text-center">
                            <?php echo $item['teacher_name']; ?>
                        </td>
                        <td class="text-center">
                            <?php echo $item['user_order_name']; ?>
                        </td>
                        <?php if ($this->role_id == 14) { ?>
                            <td class="text-center">
                                <button class="btn btn-primary confirm_order_teacher_abroad" order_id="<?php echo $item['id']; ?>">
                                    Xác nhận lịch
                                </button>
                            </td>
                        <?php } ?>
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
                                    <td  class="text-right">Ngày cần học</td>
                                    <td>
                                        <input type="text" class="form-control datepicker" name="day_order" style="width: 100%;">
                                    </td>
                                </tr>

                                <tr>
                                    <td class="text-right">
                                        Nội dung
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <textarea class="form-control" rows="2" cols="30" name="content_order"></textarea>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="col-md-6">
                            <table class="table table-striped table-bordered table-hover table-2 table-view-2">
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
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-success btn-lg" style="width: 130px;">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.select_search').select2({
            width: '100%',
        });
    });
</script>