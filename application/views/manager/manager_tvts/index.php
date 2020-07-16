<div class="row">

    <div class="col-md-10 col-md-offset-1">

        <h3 class="text-center marginbottom20"> Danh sách các TVTS (<?php echo $total_tvts; ?>)</h3>

    </div>

</div>

<div class="pagination">

    <?php echo isset($pagination) ? $pagination : ''; ?>

    <!-- ==================== Đặt tên class muốn hiển thị modal ở đây =======================-->

    <button class="btn btn-success btn_manage_tvts" tvts_id="0"> Thêm TVTS mới </button>
    
    <!-- <a class=" btn btn-success add-new-tvts-modal" href="<?php echo base_url('quan-ly/them-tvts.html'); ?>
    ">
        Thêm TVTS mới
    </a> -->

    <!-- ===================================================================================-->

</div>

<div class="number_paging"> 

    <?php echo 'Hiển thị ' . $this->begin_paging . ' - ' . $this->end_paging . ' của ' . $this->total_paging . ' TVTS'; ?>

</div>

<form action="#" method="GET" class="form-inline">

    <table class="table table-bordered list_contact">

        <thead>

            <tr>

                <?php

                if (isset($table)) {

                    foreach ($table as $value) {

                        $this->load->view('manager/manager_tvts/show_table/head/' . $value);

                    }

                }

                ?>

            </tr>

        </thead>

        <tbody>

            <?php
            if (isset($tvts)) {
               
                foreach ($tvts as $key => $value) {

                    ?>

                    <tr class="">

                        <?php

                        $data['value'] = $value;
                        
                        foreach ($table as $value2) {

                            $this->load->view('manager/manager_tvts/show_table/body/' . $value2, $data);

                        }

                        ?>

                    </tr>

                    <?php

                }

            }

            ?>

        </tbody>

    </table>

    <!-- <input type="submit" class="btn btn-success" value="Tìm" /> -->

</form>

<div class="number_paging"> 

    <?php echo 'Hiển thị ' . $this->begin_paging . ' - ' . $this->end_paging . ' của ' . $this->total_paging . ' tvts'; ?>

</div>

<div class="pagination">

    <?php echo isset($pagination) ? $pagination : ''; ?>

    <!-- ==================== Đặt tên class muốn hiển thị modal ở đây =======================-->

    <!-- <button class="btn btn-success btn_manage_teacher" tvts_id="0"> Thêm tvts mới </button> -->

    <!-- ============================================================ =======================-->

</div>

<?php

$this->load->view('manager/manager_tvts/modal/edit_tvts');

