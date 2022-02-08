
<div class="container">
    <div class="row">
        <br>
        <h1 class="text-center">Danh sách học viên điểm danh lớp <b class="text-primary"><?php echo $class ?></b></h1>

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-fixed-head">
                <thead>
                    <tr>
                        <th>Mã lớp</th>
                        <th>Tên học viên</th>
                        <th>Điểm cuối khóa</th>
                        <th>Đánh giá HV</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($contact as $item) { ?>
                        <tr contact_id="<?php echo $item['id']?>">
                            <td class="text-center">
                                <?php echo $item['class_study_id']?>
                                <input type="hidden" name="class_study_id" value="<?php echo $item['class_study_id']?>">
                            </td>
                            <td class="text-center">
                                <?php echo $item['name']?>
                            </td>
                            <td class="text-center">
                                <input type="number" class="form-control" name="score_<?php echo $item['id']?>" value="<?php echo $item['score'] ?>" style="width: 50%; margin-left: 25%;">
                            </td>
                            <td class="text-center">
                                <textarea class="form-control" name="feedback_<?php echo $item['id']?>"><?php echo $item['feedback'] ?></textarea>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <div class="text-center">
                <button type="submit" class="btn btn-lg btn-success btn-feedback">Lưu</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).on('click', '.btn-feedback', function (e) {
        e.preventDefault();
        let statusList = $('tbody tr');
        let data = [];
        for (let i=0; i<statusList.length; i++) {
            let std = {
                'contact_id' : $(statusList[i]).attr('contact_id'),
                'class_study_id' : $('input[name="class_study_id"]').val(),
                'score' : $('[name=score_'+$(statusList[i]).attr('contact_id')+']').val(),
                'feedback' : $('[name=feedback_'+$(statusList[i]).attr('contact_id')+']').val()
            };
            data.push(std)
        }

        if (typeof data === 'undefined' || data.length === 0) {
            alert('Chưa chọn đủ đánh giá cho học viên');
            return false;
        }
        let class_study_id = data[0]['class_id'];

        $.ajax({
            url: $("#base_url").val() + "student/action_feedback_student",
            type: "POST",
            data: {
                data_feedback: JSON.stringify(data),
                class_study_id: class_study_id
            },
            beforeSend: function() {
                $(".popup-wrapper").show();
            },
            success: function (data) {
                data = JSON.parse(data);
                if (data.good) {
                    $.notify(data.message, {
                        position: "top left",
                        className: 'success',
                        showDuration: 200,
                        autoHideDelay: 5000
                    });
                } else {
                    $.notify('Có lỗi xảy ra! Nội dung: ' + data.message, {
                        position: "top left",
                        className: 'error',
                        showDuration: 200,
                        autoHideDelay: 7000
                    });
                }
            },
            complete: function() {
                $(".popup-wrapper").hide();
            },
        });
    });
</script>
