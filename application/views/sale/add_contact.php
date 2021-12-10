
<?php  $data['rows'] = $_GET ?>
<h3 class="text-center paddingtop20"> Thêm mới 1 contact</h3>
<?php echo validation_errors(); ?>
<form method="post" action="<?php echo base_url('sale/add_contact'); ?>">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-xs-12">
                <table class="table table-bordered table-hover filter-contact filter-tbl-1">
                    <?php
                        if (isset($add_left)) {
                            foreach ($add_left as $key => $value) {
                                $this->load->view('common/content/edit_contact/' . $value, $data);
                            }
                        }
                    ?>

                    <?php if (in_array($this->role_id, [1, 3, 6, 11, 12])) { ?>
                    <tr>
                        <td class="text-right"> Nhân viên sale </td>
                        <td>
                            <select class="form-control selectpicker" name="sale_staff_id">
                                <option value="0"> Chọn nhân viên sale </option>
                                <?php foreach ($staffs as $key => $value) { ?>
                                    <option value="<?php echo $value['id']; ?>">
                                        <?php echo $value['name']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <?php } ?>

                    <tr>
                        <td class="text-right"> Nguồn </td>
                        <td>
                            <select class="form-control selectpicker" name="source_id">
                                <option value="1"> Inbox Facebook </option>
                                <?php foreach ($sources as $key => $value) { ?>
                                    <option value="<?php echo $value['id']; ?>"
                                        <?php if ($_GET['source_id'] == $value['id']) echo "selected"; ?>>
                                        <?php echo $value['name']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="col-md-6 col-xs-12">
                <table class="table table-bordered table-hover filter-contact filter-tbl-2">
                    <?php
                        if (isset($add_right)) {
                            foreach ($add_right as $key => $value) {
                                $this->load->view('common/content/edit_contact/' . $value, $data);
                            }
                        }
                    ?>
                </table>
            </div>
            <input type="hidden" name="contact_old_id" value="<?php echo (isset($_GET['contact_old_id'])) ? $_GET['contact_old_id'] : '' ?>">

            <div class="clearfix"></div>

            <div class="text-center">
                <button type="submit" class="btn btn-success btn-lg"> <i class="fa fa-floppy-o" aria-hidden="true"></i> &nbsp; Lưu Lại</button>
            </div>
        </div>
    </div>
</form>

<script type="text/javascript">
    $(function () {
        $('.datetimepicker').datetimepicker({
            format: 'DD-MM-YYYY HH:mm'
        });
    });
</script>