
<div class="row">

    <div class="col-md-10 col-md-offset-1">

        <h3 class="text-center marginbottom35"> Tải file đối soát đơn hàng L8 Vnpost (Lưu ý chọn sheet active trước khi đối soát)</h3>

    </div>

</div>

<!--<form action="#" method="POST" id="action_contact" class="form-inline" enctype="multipart/form-data">

    <div class="row">

        <div class="col-md-6 col-md-offset-3">

            <div class="panel panel-primary">

                <div class="panel-heading">

                    <h3 class="panel-title">Vui lòng chọn file excel</h3>

                </div>

                <div class="panel-body">

                    <div class="form-group">

                        <input type="file"  id="image" name="file" class="marginbottom20">

                        <input type="submit" class="btn btn-success" value="Tải lên" name="submit" />

                    </div>

                </div>

            </div>

        </div>

    </div>

</form>-->

<input type="hidden" value="doi-soat-l8-vnpost.html" id="redirect-dropzone" />

<div class="row">

    <div class="col-md-6 col-md-offset-3">

        <div class="panel panel-primary">

            <div class="panel-heading">

                <h3 class="panel-title">Vui lòng chọn file excel vnpost</h3>

            </div>

            <div class="panel-body">

                <form action="#" method="POST" class="dropzone needsclick dz-clickable" id="dropzoneFileUpload">

                </form>

            </div>

        </div>

    </div>

</div>

<div class="row">

    <div class="col-md-10 col-md-offset-1">

        <h3 class="text-center marginbottom35"> Tải file khảo sát để soát đơn hàng L8 Vnpost </h3>

    </div>

</div>

<div class="row">
    <div class="col-md-5 col-md-offset-4">
        <form action="<?php echo base_url('CODS/check_L8_vnpost/update_code_check')?>" method="POST" class="form-inline" role="form" enctype="multipart/form-data">

            <div class="form-group">
            
                <input type="file" name="file" class="form-control" value="">

            </div>

            <button type="submit" class="btn btn-primary">Gửi</button>
        </form>
    </div>
</div>

