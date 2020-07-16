<?php if($value['id'] > 0) { ?>

<td class="text-center">

    <div class="btn-group">

        <a href="#"

           class="btn btn-danger btn_delete_tvts"

           tvts_id="<?php echo $value['id']; ?>"

           title="Xóa TVTS"> 

            <i class="fa fa-trash-o" aria-hidden="true"></i>

        </a>

        <a href="#"

           class="btn btn-warning btn_manage_tvts"

           tvts_id="<?php echo $value['id']; ?>"

           title="Chỉnh sửa TVTS"> 

            <i class="fa fa-pencil-square" aria-hidden="true"></i>

        </a>

    </div>

</td>

<?php } 