<form method="post" action="<?php echo base_url(); ?>MANAGERS/manager_tvts/action_edit_tvts/<?php echo $rows['id']; ?>" class="form_submit">

    <div class="row" style="margin-right: 5px; margin-left: 5px;">

        <div class="col-md-6">

            <table class="table table-striped table-bordered table-hover table-1 table-view-1 heavyTable">

                <tr>

                    <td class="text-right"> Username </td>

                    <td>  

                        <input type="text" class="form-control" name="username" value="<?php echo $rows['username']; ?>" />

                    </td>

                </tr>

                <?php //if ($rows['password'] == '') { ?>

                    <tr>

                        <td class="text-right"> Mật khẩu </td>

                        <td>  

                            <input type="password" class="form-control" name="password" />

                        </td>

                    </tr>

                    <!-- <tr>

                        <td class="text-right"> Nhập lại mật khẩu </td>

                        <td>  

                            <input type="password" class="form-control" name="re-password" value="" />

                        </td>

                    </tr> -->

                <?php //} ?>

                <tr>

                    <td class="text-right"> Họ tên </td>

                    <td>  

                        <input type="text" class="form-control" name="name" value="<?php echo $rows['name']; ?>" />

                    </td>

                </tr>



            </table>

        </div>

        <div class="col-md-6">

            <table class="table table-striped table-bordered table-hover table-2 table-view-2">

                <tr>

                    <td class="text-right"> Email </td>

                    <td>  

                        <input type="text" class="form-control" name="email" value="<?php echo $rows['email']; ?>" />

                    </td>

                </tr>

                <tr>

                    <td class="text-right"> Số điện thoại </td>

                    <td>  

                        <input type="text" class="form-control" name="phone" value="<?php echo $rows['phone']; ?>"  />

                        <input type="hidden" class="form-control" name="role_id" value="1"  />

                    </td>

                </tr>


                <tr>

                    <td class="text-right"> Hoạt động </td>

                    <td>  

                        <input type="text" class="form-control" name="active" value="<?php echo $rows['active']; ?>" />

                    </td>

                </tr>

                <tr>

                    <td class="text-right"> Định mức </td>

                    <td>  

                        <input type="text" class="form-control" name="max_contact" value="<?php echo $rows['max_contact']; ?>" />

                    </td>

                </tr>

            </table>

        </div>

    </div>

    <div class="text-center">

        <button type="submit" class="btn btn-success btn-lg">Lưu Lại</button>

    </div>

</form>

