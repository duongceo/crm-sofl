
<!DOCTYPE html>
<html lang="vi" xmlns="http://www.w3.org/1999/xhtml" prefix="og: http://ogp.me/ns#">
    <head>
        <title>Mẫu đánh giá Nhật</title>

        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <link rel="stylesheet" href="<?php echo base_url() ?>public/feedback_student/css/bootstrap.min.css"/>
        <link rel="stylesheet" href="<?php echo base_url() ?>public/feedback_student/css/style.css"/>
    </head>

    <body>
        <div class="wraper">
            <div class="bg-do">
                <div class="">
                    <div class="row can-deu">
                        <div class="col-md-20 form ">
                            <div class="pd-tb-20"><span class="span-1">Thông tin học viên</span></div>
                            <div class="col-md-24">
                                <div class="form-group">
                                    <label class="text-nau">Họ và tên học viên</label>
                                    <input id="keyword1" type="text" value="<?php echo $student['name'] ?>" placeholder="Họ và tên học viên" name="name" class="form-control"/>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="text-nau">Số điện thoại</label>
                                    <input id="keyword1" type="text" value="<?php echo $student['phone'] ?>" placeholder="Số điện thoại" name="phone" class="form-control"/>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="text-nau">Ngày sinh</label>
                                    <input id="keyword1" type="text" value="<?php echo date('d/m/Y', $student['birthday']) ?>" placeholder="Ngày sinh" name="date" class="form-control"/>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="text-nau">Khóa học</label>
                                    <input id="keyword1" type="text" value="<?php echo $student['course'] ?>" placeholder="Khóa học" name="cate" class="form-control"/>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="text-nau">Mã lớp</label>
                                    <input id="keyword1" type="text" value="<?php echo $student['class_study_id'] ?>" placeholder="Mã lớp" name="class" class="form-control"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4"><img src="<?php echo base_url() ?>public/feedback_student/images/cup.png" style="max-width:100%" /></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-24">

                        <div class="khoi-bo row text-justify">
                            <div class="col-md-17">
                                <div class="titles"><span >Chuyên cần</span></div>
                                <div>Anh/chị đã tham gia <?php echo $diligence ?>/<?php echo $class['total_lesson'] ?> ( số buổi tham gia/tổng số buổi).</div>
                            </div>
                            <div class="col-md-7">

                                <div class="khung-d text-center">
                                    <div class="title-d"><span >Điểm kiểm tra</span></div>
                                    <div class="diem"><?php echo $feedback['score'] ?></div>
                                </div>
                            </div>

                            <div class="col-md-24">
                                <div><span class="titles">Chia sẻ của giáo viên</span></div>
                                <div>
                                    <?php echo $feedback['feedback'] ?>
                                </div>
                            </div>

                            <div class="col-md-24">
                                <div class="titles"><span >Lời cám ơn</span></div>
                                <div>
                                    SOFL chân thành cảm ơn Anh/Chị <?php echo $student['name'] ?> đã tham gia học tại SOFL khoá <?php echo $course ?>
                                    <br/>Hy vọng rằng Anh/Chị đã có những trải nghiệm bổ ích khi tham gia học <?php echo $course ?>
                                    <br/>Nếu có điều gì chưa làm hài lòng Anh/Chị, SOFL thực xin lỗi và rất mong Anh/Chị có thể chia sẻ qua hotline Chăm sóc: 0963 604 299 để SOFL có thể rút kinh nghiệm, hoàn thiện tốt hơn và đồng hành cùng Anh/Chị trong các khoá học tiếp theo.
                                    <br/>Xin chúc Anh/Chị thành công trên con đường chinh phục <?php echo $course ?>
                                    <br/>Cảm ơn Anh/Chị đã là một phần quan trọng không thể thiếu của SOFL.
                                </div>
                            </div>

                            <div class="clear"></div>

                            <div class="row mr-t-40">
                                <div class="col-md-16">
                                    <img src="images/cc.png" />
                                </div>

                                <div class="col-md-8 text-center">
                                    <div class="mr-b-40">Xác nhận của Trung tâm </div>
                                    <div> Đã xác nhận </div>
                                </div>
                                <div class="clear"></div>
                            </div>

                            <div class="row mr-t-10">
                                <div class="col-md-12">SOFL Giao tiếp dễ dàng - Vững vàng JLPT</div>
                                <div class="col-md-12">...........................................................................</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>