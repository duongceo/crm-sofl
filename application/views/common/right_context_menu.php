<div class="menu">
    <ul>
        <?php if ($this->role_id == 3) { ?> <!-- TK quản lý -->
            <li class="divide_one_contact_achor one-item-selected" contact_id="" contact_name="">
                <a>
					<i class="fa fa-hand-pointer-o" aria-hidden="true"></i> &nbsp; &nbsp; Phân contact này cho TVTS...
				</a>
            </li>

            <li class="divide_contact divide_multi_contact multi-item-selected">
                <a>
					<i class="fa fa-hand-paper-o" aria-hidden="true"></i> &nbsp; &nbsp; Phân các contact đã chọn cho TVTS...
				</a>
            </li>

			<li class="divide_contact_auto divide_multi_contact multi-item-selected">
                <a>
					<i class="fa fa-hand-paper-o" aria-hidden="true"></i> &nbsp; &nbsp; Phân đều contact
				</a>
            </li>

			<li class="action-contact-admin load-new-contact-id" data-contact-id ="0" data-answer="Thu hồi thành công contact!" data-url="admin/retrieve_contact">
				<a>
					<i class="fa fa-retweet" aria-hidden="true"></i> &nbsp; &nbsp; Thu hồi
				</a>
			</li>

			<li class="action-contact-admin load-new-contact-id" data-answer="Xóa contact thành công (xóa hẳn)!" data-url="admin/delete_forever_one_contact">
				<a>
					<i class="fa fa-trash" aria-hidden="true"></i> &nbsp; &nbsp; Xóa hẳn
				</a>
			</li>

            <li class="btn-export-excel-manager multi-item-selected">
                <a>
                    <i class="fa fa-file-excel-o" aria-hidden="true"></i> &nbsp; &nbsp; Xuất toàn bộ dữ liệu
                </a>
            </li>

            <?php if ($controller == 'class_study' || $controller == 'level_language') { ?>
                <li class="edit_item" item_id="0" edit-url="" data-modal-name="edit-item-modal">
                    <a>
                        <i class="fa fa-pencil-square" aria-hidden="true"></i> &nbsp; &nbsp; Chỉnh sửa
                    </a>
                </li>

                <li href="#" class="delete_item" item_id="0">
                    <a>
                        <i class="fa fa-trash-o" aria-hidden="true"></i> &nbsp; &nbsp; Xóa dòng
                    </a>
                </li>

                <li class="view_student show-with-item" item_id="0" show_url="staff_managers/class_study/show_student">
                    <a>
                        <i class="fa fa-info-circle" aria-hidden="true"></i> &nbsp; &nbsp; Xem danh sách học viên
                    </a>
                </li>

                <li class="check_L7 show-with-item" class_study_id="">
                    <a>
                        <i class="fa fa-pencil-square" aria-hidden="true"></i> &nbsp; &nbsp;Thống kê tỷ lệ HV đk đi lên
                    </a>
                </li>

                <li class="mechanism_teacher show-with-item" class_study_id="">
                    <a>
                        <i class="fa fa-info-circle" aria-hidden="true"></i> &nbsp; &nbsp; Thêm thưởng phạt giáo viên
                    </a>
                </li>
            <?php } ?>

        <?php } else if ($this->role_id == 1) { ?> <!-- TK Sale -->

            <li class="ajax-request-modal load-new-contact-id edit-one-contact one-item-selected" data-contact-id ="0" data-modal-name="edit-contact-div"
               data-url="common/show_edit_contact_modal">
              <a>
				  <i class="fa fa-pencil-square" aria-hidden="true"></i> &nbsp; &nbsp; Chăm sóc contact này
			  </a>
            </li>

            <li contact_id="0" contact_name="0" class="transfer_one_contact one-item-selected" >
                <a>
					<i class="fa fa-exchange" aria-hidden="true"></i>  &nbsp; &nbsp; Chuyển nhượng contact này
				</a>
            </li>

            <li class="transfer_contact multi-item-selected">
                <a>
					<i class="fa fa-exchange" aria-hidden="true"></i>  &nbsp; &nbsp; Chuyển nhượng các contact đã chọn
				</a>
            </li>

            <?php if ($this->sale_study_abroad) { ?>
                <li contact_id="0" class="update_cost_student one-item-selected">
                    <a>
                        <i class="fa fa-pencil-square" aria-hidden="true"></i>  &nbsp; &nbsp; Cập nhât chi phí
                    </a>
                </li>
            <?php } ?>

        <?php } else if ($this->role_id == 10) { ?>  <!-- TK CSKH -->
            <li class="ajax-request-modal load-new-contact-id edit-one-contact one-item-selected" data-contact-id ="0" data-modal-name="edit-contact-div"
               data-url="common/show_edit_contact_modal">
                <a>
                	<i class="fa fa-pencil-square" aria-hidden="true"></i> &nbsp; &nbsp; Chăm sóc contact này
                </a>
            </li>

        <?php } else if($this->role_id == 6) { //marketing ?>
			<?php if ($controller == 'marketer') { ?>
				<li class="note_contact load-new-contact-id one-item-selected" contact_name="" data-contact-id ="0">
					<a>
						<i class="fa fa-pencil-square" aria-hidden="true"></i> &nbsp; &nbsp; Xét duyệt contact chết
					</a>
				</li>
			<?php } else {?>
				<li  class="edit_item" edit-url="" data-modal-name="edit-item-modal" item_id="0">
					<a>
						<i class="fa fa-pencil-square" aria-hidden="true"></i> &nbsp; &nbsp; Chỉnh sửa
					</a>
				</li>
			<?php } ?>

			<?php if ($controller == 'landingpage') { ?>
				<li class="form_plugin" item_id="0" edit-url="MANAGERS/landingpage/show_plugin_landingpage" data-modal-name="edit-item-modal">
					<a>
						<i class="fa fa-paperclip" aria-hidden="true"></i> &nbsp; &nbsp; Thành phần gắn Landingpage
					</a>
				</li>
			<?php } ?>

		<?php } ?>

        <?php if ($this->role_id == 12) { ?>  <!-- TK TVV cơ sở -->
			<li class="ajax-request-modal load-new-contact-id edit-one-contact one-item-selected show-with-contact" data_type_modal="sale"  data-contact-id="0" data-modal-name="edit-contact-div" data-url="common/show_edit_contact_modal">
				<a>
					<i class="fa fa-pencil-square" aria-hidden="true"></i> &nbsp; &nbsp; Chăm sóc contact này
				</a>
			</li>

			<li class="ajax-request-modal load-new-contact-id edit-one-contact one-item-selected show-with-contact" data_type_modal="customer_care" data-contact-id ="0" data-modal-name="edit-contact-div" data-url="common/show_edit_contact_modal">
				<a>
					<i class="fa fa-pencil-square" aria-hidden="true"></i> &nbsp; &nbsp; Chăm sóc L6 --> L8
				</a>
			</li>

			<li class="check_diligence set_data_contact one-item-selected show-with-contact" contact_id="0" contact_name="0">
				<a>
					<i class="fa fa-exchange" aria-hidden="true"></i> &nbsp; &nbsp; Kiểm tra chuyên cần của học viên
				</a>
			</li>

            <li class="update_cost_student one-item-selected show-with-contact" contact_id="0">
                <a>
                    <i class="fa fa-pencil-square" aria-hidden="true"></i> &nbsp; &nbsp;Hoàn học phí
                </a>
            </li>

            <li class="show_feedback_student one-item-selected show-with-contact" contact_id="0" class_study_id="">
                <a>
                    <i class="fa fa-pencil-square" aria-hidden="true"></i> &nbsp; &nbsp;Xem phiếu đánh giá
                </a>
            </li>

			<?php if ($controller == 'student') { ?>
				<li contact_id="0" contact_name="0" class="transfer_one_contact one-item-selected show-with-contact">
					<a>
						<i class="fa fa-exchange" aria-hidden="true"></i> &nbsp; &nbsp; Chuyển nhượng contact này
					</a>
				</li>

				<li class="merge_contact one-item-selected show-with-contact" contact_id="0" contact_name="0">
					<a>
						<i class="fa fa-exchange" aria-hidden="true"></i> &nbsp; &nbsp; Ghép contact
					</a>
				</li>
			<?php } else { ?>
				<li class="edit_item show-with-item" item_id="0" edit-url="" data-modal-name="edit-item-modal">
					<a>
						<i class="fa fa-pencil-square" aria-hidden="true"></i> &nbsp; &nbsp; Chỉnh sửa
					</a>
				</li>

				<li href="#" class="delete_item show-with-item" item_id="0">
					<a>
						<i class="fa fa-trash-o" aria-hidden="true"></i> &nbsp; &nbsp; Xóa dòng
					</a>
				</li>

				<?php if ($controller == 'class_study') { ?>
                    <li class="edit_class item_not_contact show-with-item" item_id="0">
                        <a>
                            <i class="fa fa-pencil-square" aria-hidden="true"></i> &nbsp; &nbsp;Chăm sóc lớp
                        </a>
                    </li>

					<li class="view_student show-with-item" item_id="0" show_url="staff_managers/class_study/show_student">
                        <a>
                            <i class="fa fa-info-circle" aria-hidden="true"></i> &nbsp; &nbsp; Xem danh sách học viên
                        </a>
                    </li>

                    <li class="check_L7 show-with-item" class_study_id="">
                        <a>
                            <i class="fa fa-pencil-square" aria-hidden="true"></i> &nbsp; &nbsp;Thống kê tỷ lệ HV đk đi lên
                        </a>
                    </li>

                    <li class="mechanism_teacher show-with-item" class_study_id="">
                        <a>
                            <i class="fa fa-info-circle" aria-hidden="true"></i> &nbsp; &nbsp; Thêm thưởng phạt giáo viên
                        </a>
                    </li>

                    <li class="email_contract show-with-item" class_study_id="">
                        <a>
                            <i class="fa fa-info-circle" aria-hidden="true"></i> &nbsp; &nbsp; Gửi mail hợp đồng
                        </a>
                    </li>
				<?php } ?>

                <?php if ($controller == 'teacher') { ?>
                    <li class="class_own_teacher show-with-item">
                        <a>
                            <i class="fa fa-info-circle" aria-hidden="true"></i> &nbsp; &nbsp; Check lớp học
                        </a>
                    </li>
                <?php } ?>

            <?php } ?>
            <li class="ajax-request-modal load-new-contact-id one-item-selected show-with-contact" data-contact-id ="0" data-modal-name="view-detail-contact-div" data-url="common/view_detail_contact">
                <a>
                    <i class="fa fa-info-circle" aria-hidden="true"></i> &nbsp; &nbsp; Chi tiết contact
                </a>
            </li>
        <?php } else if ($this->role_id == 11) { ?> <!-- Trực page -->
			<li class="divide_one_contact_achor one-item-selected" contact_id="" contact_name="">
				<a>
					<i class="fa fa-hand-pointer-o" aria-hidden="true"></i> &nbsp; &nbsp; Phân contact này cho TVTS...
				</a>
			</li>

			<li class="divide_contact divide_multi_contact multi-item-selected">
				<a>
					<i class="fa fa-hand-paper-o" aria-hidden="true"></i> &nbsp; &nbsp; Phân các contact đã chọn cho TVTS...
				</a>
			</li>

			<li class="divide_contact_auto divide_multi_contact multi-item-selected">
				<a>
					<i class="fa fa-hand-paper-o" aria-hidden="true"></i> &nbsp; &nbsp; Phân đều contact
				</a>
			</li>
		<?php } else if ($this->role_id == 7) { ?>
			<li class="edit_item" edit-url="" data-modal-name="edit-item-modal" item_id="0">
				<a>
					<i class="fa fa-pencil-square" aria-hidden="true"></i> &nbsp; &nbsp; Chỉnh sửa
				</a>
			</li>
            <?php if ($controller == 'class_study') { ?>
                <li class="edit_class item_not_contact show-with-item" item_id="0">
                    <a>
                        <i class="fa fa-pencil-square" aria-hidden="true"></i> &nbsp; &nbsp;Chăm sóc lớp
                    </a>
                </li>

                <li class="view_student show-with-item" item_id="0" show_url="staff_managers/class_study/show_student">
                    <a>
                        <i class="fa fa-info-circle" aria-hidden="true"></i> &nbsp; &nbsp; Xem danh sách học viên
                    </a>
                </li>

                <li class="check_L7 show-with-item" class_study_id="">
                    <a>
                        <i class="fa fa-pencil-square" aria-hidden="true"></i> &nbsp; &nbsp;Thống kê tỷ lệ HV đk đi lên
                    </a>
                </li>

                <li class="mechanism_teacher show-with-item" class_study_id="">
                    <a>
                        <i class="fa fa-info-circle" aria-hidden="true"></i> &nbsp; &nbsp; Thêm thưởng phạt giáo viên
                    </a>
                </li>

                <li class="email_contract show-with-item" class_study_id="">
                    <a>
                        <i class="fa fa-info-circle" aria-hidden="true"></i> &nbsp; &nbsp; Gửi mail hợp đồng
                    </a>
                </li>
            <?php } ?>
		<?php } else if ($this->role_id == 14) { ?>
			<li class="edit_item" edit-url="" data-modal-name="edit-item-modal" item_id="0">
				<a>
					<i class="fa fa-pencil-square" aria-hidden="true"></i> &nbsp; &nbsp; Chỉnh sửa
				</a>
			</li>
			<?php if ($controller == 'class_study') { ?>
				<li class="view_student" item_id="0" show_url="staff_managers/class_study/show_student">
					<a>
						<i class="fa fa-info-circle" aria-hidden="true"></i> &nbsp; &nbsp; Xem danh sách học viên
					</a>
				</li>

                <li class="check_L7 show-with-item" class_study_id="">
                    <a>
                        <i class="fa fa-pencil-square" aria-hidden="true"></i> &nbsp; &nbsp;Thống kê tỷ lệ HV đk đi lên
                    </a>
                </li>
			<?php } ?>

            <?php if ($controller == 'teacher') { ?>
                <li class="class_own_teacher show-with-item">
                    <a>
                        <i class="fa fa-info-circle" aria-hidden="true"></i> &nbsp; &nbsp; Check lớp học
                    </a>
                </li>
            <?php } ?>
        <?php } else if ($this->role_id == 8) { ?>
            <li class="check_L7 show-with-item" class_study_id="">
                <a>
                    <i class="fa fa-pencil-square" aria-hidden="true"></i> &nbsp; &nbsp;Thống kê tỷ lệ HV đk đi lên
                </a>
            </li>
        <?php } ?>

        <?php if (!in_array($this->role_id, array(8, 12, 14))) { ?>
            <li class="ajax-request-modal load-new-contact-id one-item-selected" data-contact-id ="0" data-modal-name="view-detail-contact-div" data-url="common/view_detail_contact">
                <a>
                    <i class="fa fa-info-circle" aria-hidden="true"></i> &nbsp; &nbsp; Chi tiết contact
                </a>
            </li>
        <?php } ?>
	</ul>
</div>
