/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

show_number_selected_row = () => {
    let numberOfChecked = $('input.tbl-item-checkbox:checked').length;
    let totalCheckboxes = $('input.tbl-item-checkbox').length;
    /* Lấy tổng giá */
    let sum = 0;
    for (i = 0; i < numberOfChecked; i++) {
    	if ($($('input.tbl-item-checkbox:checked')[i]).parent().parent().find('.paid_real').text() == 0) {
			sum += 0;
		} else {
			sum += parseInt($($('input.tbl-item-checkbox:checked')[i]).parent().parent().find('.paid_real').text());
		}
		/*sum += parseInt($($('input.tbl-item-checkbox:checked')[i]).parent().parent().find('.paid_real').text());*/
    }
    /*sum *= 1000;*/
    $.notify(`Đã chọn: ${numberOfChecked} / ${totalCheckboxes}. tổng tiền = ${sum.toLocaleString()}`, {
        position: "top left",
        className: 'success',
        showDuration: 200,
        autoHideDelay: 3000
    });
};

unselect_not_checked = () => {
    $('input.tbl-item-checkbox').each(
            () => {
        if (!$(this).is(":checked")) {
            $(this).parent().parent().removeClass('checked');
        }
    });
};

unselect_checked = () => {
    $('input.tbl-item-checkbox').each(
            () => {
        if ($(this).is(":checked")) {
            $(this).parent().parent().removeClass('checked');
        }
    });
};
uncheck_checked = () => {
    $('input.tbl-item-checkbox').each(
            () => {
        if ($(this).is(":checked")) {
            $(this).prop("checked", false);
        }
    });
};
uncheck_not_checked = () => {
    $('input.tbl-item-checkbox').each(
            () => {
        if (!$(this).is(":checked")) {
            $(this).prop("checked", false);
        }
    });
};

right_context_menu_display = (controller, contact_id, contact_name, duplicate_id, contact_phone) => {
    $(".load-new-contact-id").attr('data-contact-id', contact_id);
    // $("a.view_duplicate").attr("duplicate_id", duplicate_id);
	/*$("a.restore-infor").attr('data-contact-id', contact_id);*/

    /* Nếu chọn nhiều contact thì ẩn menu xem chi tiết contact và phân 1 contact */
    var numberOfChecked = $('input.tbl-item-checkbox:checked').length;
    /*console.log(numberOfChecked);*/
    if (numberOfChecked > 1) {
        $(".one-item-selected").addClass("hidden");
        $(".multi-item-selected").removeClass('hidden');
    } else {
        $(".one-item-selected").removeClass("hidden");
        $(".multi-item-selected").addClass('hidden');
    }
	
	$(".note_contact").attr('contact_name', contact_name);
	$(".set_data_contact").attr({'contact_id':contact_id, 'contact_name':contact_name});
    $(".update_cost_student").attr('contact_id', contact_id);
    $(".show_feedback_student").attr('contact_id', contact_id);

    if (controller === 'manager' || controller === 'care_page') {
        $(".divide_one_contact_achor").attr('contact_id', contact_id);
        $(".divide_one_contact_achor").attr('contact_name', contact_name);
        /* Nếu contact trùng thì ẩn tính năng bàn giao contact */
        if (numberOfChecked < 1) {
            if (duplicate_id > 0) {
                $(".divide_one_contact_achor").addClass('hidden');
            }
            /* Nếu contact không trùng thì ẩn tính năng xem contact trùng */
            else {
                $(".divide_one_contact_achor").removeClass('hidden');
            }
        }
    } else if (controller === 'sale' || controller === 'student') {
        $(".transfer_one_contact").attr('contact_id', contact_id);
        $(".transfer_one_contact").attr('contact_name', contact_name);
		/* $(".transfer_one_contact_to_manager").attr('contact_id', contact_id); */
		/* $(".transfer_one_contact_to_manager").attr('contact_name', contact_name) */
		$(".merge_contact").attr('contact_id', contact_id);
		$(".merge_contact").attr('contact_name', contact_name);
        $(".refund_contact").attr('contact_id', contact_id);
    }
};

const _SO_MAY_SAI_ = 1;
const _KHONG_NGHE_MAY_ = 2;
const _NHAM_MAY_ = 3;
const _DA_LIEN_LAC_DUOC_ = 4;
const _CONTACT_CHET_ = 5;

const _CHUA_CHAM_SOC_ = 0;
const _TU_CHOI_MUA_ = 3;
const _DONG_Y_MUA_ = 4;

check_edit_contact = () => {
    let call_status_id = $("select[name='call_status_id']").val();
    let date_recall = $(".date_recall").val();
    // var class_study_id = $('select[name="class_study_id"]').val();
    // var fee = $('[name="fee"]').val();
    // var paid = $('[name="paid"]').val();
    let customer_care_call_id = $("select[name='customer_care_call_id']").val();
    let level_contact = $("select[name='level_contact_id']").val();

    if (customer_care_call_id == 0) {
        $.alert({
            theme: 'modern',
            type: 'red',
            title: 'Có lỗi xảy ra!',
            content: 'Bạn cần cập nhật trạng thái gọi!'
        });
        return false;
    }

    // if ($("select.edit_payment_method_rgt").val() == 0) {
    //     $.alert({
    //         theme: 'modern',
    //         type: 'red',
    //         title: 'Có lỗi xảy ra!',
    //         content: 'Bạn cần cập nhật hình thức thanh toán!'
    //     });
    //     return false;
    // }
	
    if (call_status_id == 0) {
		if ($("#input_controller").val() == 'sale') {
			$.alert({
				theme: 'modern',
				type: 'red',
				title: 'Có lỗi xảy ra!',
				content: 'Bạn cần cập nhật trạng thái gọi!'
			});
			return false;
		}
    }

    if (check_logic_call_stt_level(call_status_id, level_contact) == false) {
		$.alert({
			theme: 'modern',
			type: 'red',
			title: 'Có lỗi xảy ra!',
			content: 'Trạng thái gọi và trạng thái contact không logic! Bạn cần cập nhật chính xác để dữ liệu của chúng ta được sạch sẽ!'
		});
		return false;
	}

    /*
    if (check_rule_call_stt(call_status_id, ordering_status_id) == false) {
        $.alert({
            theme: 'modern',
            type: 'red',
            title: 'Có lỗi xảy ra!',
            content: 'Trạng thái gọi và trạng thái đơn hàng không logic! Bạn cần cập nhật chính xác để dữ liệu của chúng ta được sạch sẽ!'
        });
        return false;
    }

     */

    if (date_recall !== undefined) {
        if (date_recall != '') {
            if (now_greater_than_input_date(date_recall)) {
                $.alert({
                    theme: 'modern',
                    type: 'red',
                    title: 'Có lỗi xảy ra!',
                    content: 'Ngày gọi lại không thể là một ngày trước ngày hôm nay!'
                });
                return false;
            }
            if (check_rule_call_stt_and_date_recall(call_status_id, level_contact, date_recall)) {
                $.alert({
                    theme: 'modern',
                    type: 'red',
                    title: 'Có lỗi xảy ra!',
                    content: 'Nếu contact không liên lạc được hoặc không thể chăm sóc được nữa thì không thể có ngày gọi lại lớn hơn ngày hiện tại!'
                });
                return false;
            }
        }
    }
	/*
    if (class_study_id == 0) {
        $.alert({
            theme: 'modern',
            type: 'red',
            title: 'Có lỗi xảy ra!',
            content: 'Vui lòng chọn mã lớp học!'
        });
        return false;
    }
	*/
	
	/*
    if (fee != 0) {
    	fee = fee.replaceAll(',', '');
    	if (fee.length < 6 || fee.length > 7) {
			$.alert({
				theme: 'modern',
				type: 'red',
				title: 'Có lỗi xảy ra!',
				content: 'Vui lòng điền đúng mức học phí'
			});
			return false;
		}
    }
	*/
	
	/*
	if (paid != 0) {
		paid = paid.replaceAll(',', '');
		if (paid.length < 6 || paid.length > 7 || (parseInt(paid) > parseInt(fee))) {
			$.alert({
				theme: 'modern',
				type: 'red',
				title: 'Có lỗi xảy ra!',
				content: 'Vui lòng điền đúng mức thanh toán'
			});
			return false;
		}
    }
	*/
	
    return true;
};

check_logic_call_stt_level = (call_status_id, level_contact) => {
	if (call_status_id == _SO_MAY_SAI_ || call_status_id == _KHONG_NGHE_MAY_ || call_status_id == _NHAM_MAY_) {
		if (level_contact != '') {
			return false;
		}
	}
	return true;
};

check_rule_call_stt_and_date_recall = (call_status_id, level_contact, date_recall) => {
    if (stop_care(call_status_id, level_contact) && now_greater_than_input_date(date_recall)) {
        return true;
    }
    return false;
};

let condition_level = ['L4', 'L4.1', 'L4.2', 'L4.3', 'L4.4', 'L4.5'];
stop_care = (call_status_id, level_contact) => {
    if (call_status_id == _SO_MAY_SAI_ || call_status_id == _NHAM_MAY_ || call_status_id == _KHONG_NGHE_MAY_) {
    	if (condition_level.indexOf(level_contact) != -1) {
			return true;
		}
    }
    return false;
};

now_greater_than_input_date = date_string => {
    let date_arr = date_string.split(/-/);
    let year = date_arr[2];
    let month = date_arr[1];
    let day = date_arr[0];
    let now_timestamp = new Date();
    now_timestamp = now_timestamp.getTime();
    let input_timestamp = new Date(year, month - 1, day);
    input_timestamp = input_timestamp.getTime();
    return (now_timestamp > input_timestamp);
};

setEqualTableHeight = () => {
    if ($(".table-view-1").height() > $(".table-view-2").height()) {
        $(".table-view-2").height($(".table-view-1").height());
    } else {
        $(".table-view-1").height($(".table-view-2").height());
    }
    if ($(".table-edit-1").height() > $(".table-edit-2").height()) {
        $(".table-edit-2").height($(".table-edit-1").height());
    } else {
        $(".table-view-1").height($(".table-view-2").height());
    }
    if ($(".table-1").height() > $(".table-2").height()) {
        $(".table-2").height($(".table-1").height());
    } else {
        $(".table-1").height($(".table-2").height());
    }
    
    if ($(".table-add-1").height() > $(".table-add-2").height()) {
        $(".table-add-2").height($(".table-add-1").height());
    } else {
        $(".table-add-1").height($(".table-add-2").height());
    }
};
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$.fn.setFixTable = function (_tableID) {
    let cloneHead = $($(this).children()[0]).clone();
    $(this).prepend(cloneHead);
    let fixedHead = $(this).children()[0];
    let originHead = $(this).children()[1];
    $(originHead).addClass("table-head-pos");
    $(fixedHead).addClass("fixed-table").css("display", "none");
    let key = 1;
    $(".table-head-pos>tr>th").each(function () {
        $(this).attr('id', 'th_fix_id_' + key++);
    });
    key = 1;
    $(".fixed-table>tr>th").each(function () {
        $(this).attr('id', 'f_th_fix_id_' + key++);
    });

    $(document).on('scroll', function () {
        if ($(".table-head-pos").length && $("html").scrollTop() > ($(".table-head-pos").offset().top)) {
            $(".fixed-table").css({
                "display": "block"
            });
            $('[id^="th_"]').each(function () {
                let myID = $(this).attr("id");
                let mywidth = $(this).width();
                let myheight = $(this).height();
                $("#f_" + myID).width(mywidth);
                $("#f_" + myID).height(myheight);
            });
        } else {
            $(".fixed-table").css({
                "display": "none"
            });
        }
    });
};

/*
 * loại bỏ phần tử trùng trong mảng
 */
Array.prototype.unique = function () {
    return this.filter(function (elem, index, self) {
        return index == self.indexOf(elem); // lấy chỉ số đầu tiên
    });
};

let url = $("#base_url").val() + "sale/noti_contact_recall";
noti = () => {
    $.ajax({
        url: url,
        type: "POST",
        dataType: 'json',
        success: data => {
            $('#num_noti').html(data.num_noti);
            let content_noti = ``;
            $.each(data.contacts_noti, function () {
                content_noti += `<li class="content_noti">`;
                content_noti += `<a href="#"
									style="color: #000000"
                                    title="Chăm sóc contact"
                                    class="ajax-request-modal"
                                    data-contact-id ="${this.id}"
                                    data-modal-name="edit-contact-modal"
                                    data_type_modal="${data.type_modal}"
                                    data-url="common/show_edit_contact_modal"> ${this.name}  - ${this.phone} - Thời gian gọi lại ${this.date_recall} 
                                    </a>`;
                content_noti += `</li>`;
            });
            $('#noti_contact_recall').html(content_noti);
            if (data.num_noti > 0) {
                let title = '(' + data.num_noti + ')  CONTACT CẦN GỌI LẠI';
                $("title").text(title);
            }

            /*
            if (typeof data.sound !== 'undefined') {
                $("#notificate_sound")[0].play();
                notify = new Notification(
					data.message,
					{
						body: 'Click vào đây để xem ngay!',
						icon: $("#base_url").val() + 'public/images/logo2.png',
						tag: 'https://crm2.lakita.vn/quan-ly/trang-chu.html',
						sound: $("#base_url").val() + 'public/mp3/new-contact.mp3',
						image: data.image
					}
                );
                var append = ` <div style="position: fixed; right:10px; bottom: 10px; z-index: 999999999; 
                                    background-color: #fff; display: inline-block; width: 30%; border-radius: 5px" class="my-notify">
							<div style="position:absolute; right: 5px; top:5px; cursor: pointer" class="close-notify"> 
								<i class="fa fa-times-circle" style="font-size: 18px;" aria-hidden="true"></i> 
							</div>    
							<div style="float:left; width: 35%; padding: 2%">
								<img src="https://crm2.lakita.vn/public/images/logo2.png" style="width: 70%"/>
							</div>
							<div style="float:left; width:65%; padding: 2%">
								<h4> ${data.message} </h4>
								<div>
									<img src="${data.image}" style="width: 90%"/>
								</div>
							</div>
					   </div>`;

                $('body').append(append);
                setTimeout(function () {
                    $(".my-notify").remove();
                }, 10000);
            }
            */
        }
    });
};

if ($("#input_controller").val() == 'sale' || ($("#input_controller").val() == 'student' && $("#input_role_id").val() == 12)) {
    setInterval(noti, 10000);
}

$(".action-contact-admin").confirm({
    theme: 'supervan', // 'material', 'bootstrap',
    title: "Bạn có chắc chắn với hành động này không?",
    content: '',
    buttons: {
        confirm: {
            text: 'Có',
            action: function () {
				var contactIdArray = [];
				$('input[type="checkbox"]').each(
					function () {
						if ($(this).is(":checked")) {
							contactIdArray.push($(this).val());
						}
					}
				);

                var _this = this.$target;
                // var contactID = _this.attr("data-contact-id");
                var url = $("#base_url").val() + _this.attr("data-url");

                $.ajax({
                    type: "POST",
                    url: url,
                    data: {
                        /*contact_id: contactID*/
						contact_id: contactIdArray
                    },
					success: data => {
						if (data === '1') {
							$.alert({
								theme: 'modern',
								title: _this.attr("data-answer"),
								content: '',
								buttons: {
									confirm: {
										text: 'OK',
										action: function () {
											location.reload();
										}
									}
								}
							});
						} else {
							alert('Bạn chưa tích vào ô chọn contact');
						}
					},
                    error: errorThrown => alert(errorThrown)
                });
            }},
        cancel: {
            text: 'Hủy',
            action: function () {
            }}
    }
});

$(document).on('click', 'a.add_item', function (e) {
    e.preventDefault();
    let url = $("#url_add_item").val();
    $.ajax({
        url: url,
        type: "POST",
        success: function (data) {
            $("div.replace_content_add_item_modal").html(data);
        },
        complete: function () {
            $(".add_item_modal").modal("show");
        }
    });
});

$(".delete_item").confirm({
	theme: 'supervan', // 'material', 'bootstrap',
	title: 'Bạn có chắc chắn muốn xóa dòng này không?',
	// content: 'Hãy nhớ thứ tự xóa là xóa ad => xóa adset => xóa campaign.',
	buttons: {
		confirm: {
			text: 'Xóa',
			action: function () {
				var _this = this.$target;
				var item_id = _this.attr("item_id");
				$.ajax({
					type: "POST",
					url: $("#url_delete_item").val(),
					data: {
						item_id: item_id
					},
					success: function (data) {
						console.log(data);
						if (data === '1') {
							location.reload();
						} else {
							alert(data);
						}
					},
					error: function (errorThrown) {
						alert('Không thể xóa do foreign-key, liên hệ admin để biết thêm chi tiết');
					}
				});
			}},
		cancel: {
			text: 'Nope',
			action: function () {
			}
		},
		somethingElse: {
			text: 'Khác',
			btnClass: 'btn-blue',
			keys: ['enter', 'shift'],
			action: function () {
			}
		}
	}
});

$(document).on('click', 'li.edit_item', function (e) {
	e.preventDefault();
	let item_id = $(this).attr("item_id");
	let url = $(this).attr("edit-url");
	let modalName = $(this).attr("data-modal-name");
	// alert(url); return false;
	$.ajax({
		url: url,
		type: "POST",
		data: {
			item_id: item_id
		},
		success: function (data) {
			$("." + modalName).remove();
			let newModal = `<div class="${modalName}"></div>`;
			$(".modal-append-to").append(newModal);
			$(`.${modalName}`).html(data);
		},
		complete: function () {
			$(`.${modalName} .modal`).modal("show");
		}
	});
});

$(document).on('click', '.adset-detail', function (e) {
    e.preventDefault();
	let url = $(this).attr("data-url");
	let modalName = $(this).attr("data-modal-name");
    $.ajax({
        url: url,
        type: "GET",
        data: {
            adsetId: $(this).attr("adset-id"),
            adsetName: $(this).text()
        },
        success: function (data) {
            $("." + modalName).remove();
            var newModal = `<div class="${modalName}"></div>`;
            $(".modal-append-to").append(newModal);
            $(`.${modalName}`).html(data);
        },
        complete: function () {
            $(`.${modalName} .modal`).modal("show");
        }
    });
});

$(document).on('click', '.campaign-detail', function (e) {
    e.preventDefault();
    let url = $(this).attr("data-url");
	let modalName = $(this).attr("data-modal-name");
    $.ajax({
        url: url,
        type: "GET",
        data: {
            campaignId: $(this).attr("campaign-id"),
            campaignName: $(this).text()
        },
        success: function (data) {
            $("." + modalName).remove();
            var newModal = `<div class="${modalName}"></div>`;
            $(".modal-append-to").append(newModal);
            $(`.${modalName}`).html(data);
        },
        complete: function () {
            $(`.${modalName} .modal`).modal("show");
        }
    });
});

$(document).on('click', '.form_plugin', function (e) {
    e.preventDefault();
    let item_id = $(this).attr("item_id");
	let url = $('#base_url').val() + $(this).attr("edit-url");
	let modalName = $(this).attr("data-modal-name");
    
    $.ajax({
        url: url,
        type: "POST",
        data: {
            item_id: item_id
        },
        success: function (data) {
            $("." + modalName).remove();
            var newModal = `<div class="${modalName}"></div>`;
            $(".modal-append-to").append(newModal);
            $(`.${modalName}`).html(data);
        },
        complete: function () {
            $(`.${modalName} .modal`).modal("show");
        }
    });
});

/*
 * Real order
 */

$('th[class^="order_new_"]').on('click', function () {
    var myclass = $(this).attr("class");
    myclass = myclass.split(/ /);
    myclass = myclass[0];
    $('input[class^="order_new_"]').not("input." + myclass).attr('value', '0');
    if ($("input." + myclass).val() === '0') {
        $("input." + myclass).attr('value', 'ASC').promise().done(
			function () {
				$("#form_item").submit();
			}
        );
        return;
    }

    if ($("input." + myclass).val() === 'ASC') {
        $("input." + myclass).val('DESC').promise().done(
			function () {
				$("#form_item").submit();
			}
        );
        return;
    }

    if ($("input." + myclass).val() === 'DESC') {
        $("input." + myclass).val('0').promise().done(
			function () {
				$("#form_item").submit();
			}
        );
        return;
    }
});


/*Real filter*/
$(".real_filter").on('change', function () {
    $("#form_item").submit();
});

/*
 * Cố định thanh <thead> và phần search của table
 */

$(function() {
    $(".table-fixed-head").setFixTable();
});

$(document).on("change", '.toggle-input [name="edit_active"]', function () {
    var active = ($(this).prop('checked')) ? '1' : '0';
    var item_id = $(this).attr("item_id");
    $.ajax({
        type: "POST",
        url:  $(this).attr("data-url"),
        data: {
            active: active,
            item_id: item_id
        },
        success: function (data) {
            if (data == '1') {
                $.notify('Lưu thành công', {
                    position: "top left",
                    className: 'success',
                    showDuration: 200,
                    autoHideDelay: 2000
                });
            } else {
                alert("Có lỗi xảy ra! Vui lòng liên hệ admin.");
            }
        },
        error: function (errorThrown) {
            alert(errorThrown);
        }
    });
});



/* click để khôi phục contact*/
$(".restore-multi-infor").on('click', function (e) {
    e.preventDefault();
    $("#action_contact").attr("action", $("#base_url").val() + "common/restore_infor");
    $("#action_contact").submit();
});
$(".restore-infor").on('click', function (e) {
    e.preventDefault();
    var data_contact_id = $(this).attr("data-contact-id");
    $("input[value='"+data_contact_id+"']").prop( "checked", true );
    $("#action_contact").attr("action", $("#base_url").val() + "common/restore_infor");
    $("#action_contact").submit();
});

//add-new-contact-modal
$(document).on("click", ".add-new-contact-modal", function (e) {
    e.preventDefault();
    var modalName = 'add-new-contact-modal-show';
    $.ajax({
        url: $(this).attr('href'),
        type: "POST",
        success: data => {
            $("." + modalName).remove();
            var newModal = `<div class="${modalName}"></div>`;
            $(".modal-append-to").append(newModal);
            $(`.${modalName}`).html(data);
        },
        complete: () => $(`.${modalName} .modal`).modal("show")
    });

});

$(document).on('click', '.btn-action-add-new-contact', function (e) {
    e.preventDefault();
    $.ajax({
        url: $(".form_add_new_contact_modal").attr('action'),
        type: "POST",
        data: $(".form_add_new_contact_modal").serialize(),
        dataType: 'json',
        beforeSend: () => $(".popup-wrapper").show(),
        success: data => {
            if (data.success == 1) {
                /*$("#send_email_sound")[0].play();*/
                $.notify(data.message, {
                    position: "top left",
                    className: 'success',
                    showDuration: 200,
                    autoHideDelay: 5000
                });
                $(".popup-wrapper").hide();
                $('.add-new-contact-modal-show .modal').modal("hide");
            } else {
                $('.add-new-contact-modal-show .modal').modal("hide");
                var modalName = 'add-new-contact-modal-show';
                setTimeout(function () {
                    $(".modal-append-to").empty();
                    var newModal = `<div class="${modalName}"></div>`;
                    $(".modal-append-to").append(newModal);
                    $(`.${modalName}`).html(data.content);
                    $(`.add-new-contact-modal-show .modal`).modal("show");
                    /*$("#send_email_error")[0].play();*/
                    $.notify('Có lỗi xảy ra! Nội dung: ' + data.message, {
                        position: "top left",
                        className: 'error',
                        showDuration: 200,
                        autoHideDelay: 7000
                    });
                    $(".popup-wrapper").hide();
                }, 1000);
            }
        }
    });
});

/*
 $(document).on('click', '.edit_contact', function (e) {
 e.preventDefault();
 $(".checked").removeClass("checked");
 $(this).parent().parent().addClass("checked");
 var contact_id = $(this).attr("contact_id");
 var url = $("#base_url").val() + "common/show_edit_contact_modal";
 $.ajax({
 url: url,
 type: "POST",
 data: {
 contact_id: contact_id
 },
 success: data => {
 $(".modal-view-contact").remove();
 var modalViewContactDetail = "<div class='modal-view-contact'></div>";
 $(".modal-append-to").append(modalViewContactDetail);
 $(".modal-view-contact").html(data);
 },
 complete: () => $(".edit_contact_modal").modal("show")
 });
 }); 
 */

$(document).on('click', '.btn-edit-contact', function (e) {
    e.preventDefault();
    if (check_edit_contact() == false) {
        return false;
    }
    var url = $(this).parents('.form_edit_contact_modal').attr("action");
    var contact_id = $(this).parents('.form_edit_contact_modal').attr("contact_id");

    $.ajax({
        url: url,
        type: "POST",
        dataType: 'json',
        data: $(".form_edit_contact_modal").serialize(),
        beforeSend: () => $(".popup-wrapper").show(),
        success: data => {
            if (data.success == 1) {
                /*$("#send_email_sound")[0].play();*/
                $.notify(data.message, {
                    position: "bottom left",
                    className: 'success',
                    showDuration: 200,
                    autoHideDelay: 5000
                });
                $(".edit_contact_modal").modal("hide");

                if((data.role == 10 && data.hide == 1) || data.role == 1){
                    $('tr[contact_id="' + contact_id + '"]').remove();
                }
            } else {
                /*$("#send_email_error")[0].play();*/
                $.notify('Có lỗi xảy ra! Nội dung: ' + data.message, {
                    position: "top left",
                    className: 'error',
                    showDuration: 200,
                    autoHideDelay: 7000
                });
            }
        },
        complete: () => $(".popup-wrapper").hide()
    });
});

$(document).on('change', 'select.note-cod-sample', function () {
    $('[name="note_cod"]').val($(this).val());
});

/*
 $('.edit_contact_modal').on('shown.bs.modal', function () {
 $('.datetimepicker').datetimepicker(
 {
 format: 'DD-MM-YYYY HH:mm'
 });
 if ($("select.edit_payment_method_rgt").val() != 2) {
 $(".tbl_bank").hide();
 }
 if ($("select.edit_payment_method_rgt").val() != 1) {
 $(".tbl_cod").hide();
 }
 });
 */

$(function () {
    setTimeout( () => {
        if ($(".filter-tbl-1").height() > $(".filter-tbl-2").height()) {
            $(".filter-tbl-2").height($(".filter-tbl-1").height());
        } else {
            $(".filter-tbl-1").height($(".filter-tbl-2").height());
        }
    }, 500);
});

$('.view_contact_star_modal').on('hide.bs.modal', () => setTimeout(() => $("div.replace_content_view_contact_star").html(""), 1000));

/*
 * Hiển thị menu chuột phải
 */
$(document).on('contextmenu', 'tr.custom_right_menu', function (e) {
    e.preventDefault();
    /*
     * Lấy các thuộc tính của contact
     */
    let contact_id = $(this).attr('contact_id');
    let contact_name = $(this).attr('contact_name');
    let duplicate_id = $(this).attr("duplicate_id");
    let contact_phone = $(this).attr("contact_phone");
    let controller = $("#input_controller").val();
    right_context_menu_display(controller, contact_id, contact_name, duplicate_id, contact_phone);

    /* lớp học */
    let item_id = $(this).attr('item_id');
    $(".delete_item, .edit_item, .form_plugin, .view_student, .edit_class, .class_own_teacher").attr('item_id', item_id);
    let editURL = $(this).attr('edit-url');
    $(".edit_item").attr('edit-url', editURL);

    let class_study_id = $(this).attr('class_study_id');
    $(".mechanism_teacher, .email_contract, .check_L7, .show_feedback_student").attr('class_study_id', class_study_id);

    let menu = $(".menu");
    menu.hide();
    let pageX = e.pageX;
    let pageY = e.pageY;
    menu.css({top: pageY, left: pageX});
    let mwidth = menu.width();
    let mheight = menu.height();
    let screenWidth = $(window).width();
    let screenHeight = $(window).height();
    let scrTop = $(window).scrollTop();
    /*
     * Nếu "tọa độ trái chuột" + "chiều dài menu" > "chiều dài trình duyệt" 
     * thì hiển thị sang bên phải tọa độ click
     */
    if (pageX + mwidth > screenWidth) {
        menu.css({left: pageX - mwidth});
    }
    /*
     * Nếu "tọa độ top chuột" + "chiều cao menu" > "chiều cao trình duyệt" + "chiều dài cuộn chuột"
     * thì hiển thị lên trên tọa độ click
     */
    if (pageY + mheight > screenHeight + scrTop) {
        menu.css({top: pageY - mheight});
    }
    menu.show();
    /*
     * Nếu dòng đó đang không chọn (đã click trái) thì bỏ chọn và bỏ check những dòng đã chọn
     */
    let is_checked_input = $(this).find('input[type="checkbox"]');
    if (is_checked_input[0] !== undefined) {
        if (!is_checked_input[0].checked) {
            $(".checked").removeClass("checked");
            uncheck_checked();
        } else {
            unselect_not_checked();
        }
        $(this).addClass('checked'); /*.find('[name="contact_id[]"]').prop('checked', true); */
    }
});


/*
 * High light vào các dòng khi click trái để chọn 
 */
$(document).on("click", "td.tbl_name, td.tbl_address", function () {
    if ($(this).parent().hasClass('checked')) {
        $(this).parent().removeClass('checked');
    } else {
        $(this).parent().addClass('checked');
    }
    let input_checkbox = $(this).parent().find('.tbl-item-checkbox');
    if (input_checkbox.is(":checked")) {
        input_checkbox.prop('checked', false);
    } else {
        input_checkbox.prop('checked', true);
    }
    unselect_not_checked();
    show_number_selected_row();
});

$("html").on("click", function (e) {
    $(".menu").hide();
    $(".menu-item").hide();
    // Nếu click ra ngoài bảng thì bỏ chọn các contact
    if (e.target.className.indexOf("form-inline") !== -1 || e.target.className.indexOf("number_paging") !== -1)
    {
        $("input.tbl-item-checkbox").prop('checked', false);
        $('.checked').removeClass('checked');

    }
});

/*
 * Khi check vào 1 item nào đó sẽ đánh dấu item đó (hiện màu xanh)
 */
/*
$(document).on('change', 'input.tbl-item-checkbox', function (e) {
    if (this.checked) {
        $(this).parent().parent().addClass('checked');
    } else {
        $(this).parent().parent().removeClass('checked');
    }
    // Hiển thị số lượng dòng đã check
    var numberOfChecked = $('input.tbl-item-checkbox:checked').length;
    var totalCheckboxes = $('input.tbl-item-checkbox').length;
    $.notify('Đã chọn: ' + numberOfChecked + '/' + totalCheckboxes, {
        position: "top left",
        className: 'success',
        showDuration: 200,
        autoHideDelay: 1000
    });
});
*/
/*=============================chọn tất cả  ===========================================*/
var checked = true;
$(document).on('click', '.check_all', function () {
    checked = !checked;
    if (checked) {
        $(".list_contact input.tbl-item-checkbox").each(
			function () {
				$(this).prop("checked", false);
				$(this).parent().parent().removeClass('checked');
			}
        );
    } else {
        $(".list_contact input.tbl-item-checkbox").each(
			function () {
				$(this).prop("checked", true);
				$(this).parent().parent().addClass('checked');
			}
        );
        show_number_selected_row();
    }
});

$(".datepicker").datepicker({
		dateFormat: "dd-mm-yy"
	}
);

/*
 * Tham khảo http://www.daterangepicker.com/#usage
 */

var d = new Date();
var currDate = d.getDate() + '-' + (d.getMonth() + 1) + '-' + d.getFullYear();
var pastDate = d.getDate() + '-' + d.getMonth() + '-' + d.getFullYear();
$(".daterangepicker").daterangepicker({
    "autoApply": true,
    autoUpdateInput: false,
    locale: {
        format: 'DD/MM/YYYY',
        cancelLabel: 'Clear'
    },
    ranges: {
        'Hôm nay': [moment(), moment()],
        'Hôm qua': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        '7 ngày vừa qua': [moment().subtract(6, 'days'), moment()],
        '30 ngày vừa qua': [moment().subtract(29, 'days'), moment()],
        'Tuần này': [moment().startOf('isoWeek'), moment().endOf('isoWeek')],
        'Tuần trước': [moment().subtract(1, 'weeks').startOf('isoWeek'), moment().subtract(1, 'weeks').endOf('isoWeek')],
        'Tháng này': [moment().startOf('month'), moment().endOf('month')],
        'Tháng trước': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    },
    "alwaysShowCalendars": true,
//    "startDate": pastDate,
//    "endDate": currDate
}).on({
    'apply.daterangepicker': function (ev, picker) {
        $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
    },
    'cancel.daterangepicker': function (ev, picker) {
        $(this).val('');
    }
});

$(".daterangepicker2").daterangepicker({
    "timePicker24Hour": true,
     timePicker: true,
    "autoApply": true,
    autoUpdateInput: false,
    locale: {
        format: 'DD/MM/YYYY H:mm',
        cancelLabel: 'Clear'
    },
    ranges: {
        'Hôm nay': [moment(), moment()],
        'Hôm qua': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        '7 ngày vừa qua': [moment().subtract(6, 'days'), moment()],
        '30 ngày vừa qua': [moment().subtract(29, 'days'), moment()],
        'Tuần này': [moment().startOf('isoWeek'), moment().endOf('isoWeek')],
        'Tuần trước': [moment().subtract(1, 'weeks').startOf('isoWeek'), moment().subtract(1, 'weeks').endOf('isoWeek')],
        'Tháng này': [moment().startOf('month'), moment().endOf('month')],
        'Tháng trước': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    },
    "alwaysShowCalendars": true,
//    "startDate": pastDate,
//    "endDate": currDate
}).on({
    'apply.daterangepicker': function (ev, picker) {
        $(this).val(picker.startDate.format('DD/MM/YYYY H:mm') + ' - ' + picker.endDate.format('DD/MM/YYYY H:mm'));
    },
    'cancel.daterangepicker': function (ev, picker) {
        $(this).val('');
    }
});

/*======================= reset datepicker ========================================================*/
$(".reset_datepicker").click(function (e) {
    e.preventDefault();
    $("#datepicker").val("");
});
$(document).on('focus', '.datepicker', function(){
    $(this).addClass('zindex1');
});

$(document).on('blur', '.datepicker', function(){
    $(this).removeClass('zindex1');
});

$(document).on("click", ".view_contact_phone", function () {
    var textCopy = document.getElementById("input-copy-"+$(this).attr('id-copy'));
    console.log(textCopy);
    textCopy.select();
    document.execCommand('copy');
    $.notify("Copy thành công vào clipboard", {
        position: "bottom left",
        className: 'success',
        showDuration: 200,
        autoHideDelay: 2000
    });
});

Dropzone.options.dropzoneFileUpload = {
    dictDefaultMessage: "Thả file vào đây hoặc click vào đây để upload",
    acceptedFiles: ".xls, .xlsx",
    maxFilesize: 10,
    init: function () {
        this.on("addedfile", function () {
				$(".popup-wrapper").show();
			}).on("success", function () {
            	//console.log(e);
            	location.href = $("#redirect-dropzone").val();
			}).on("error", function () {
				$(".popup-wrapper").hide();
        });
    }
};

$(document).ready(function () {
    $("input.filter_contact").click(function (e) {
        e.preventDefault();
        $("#action_contact").attr("action", "#").attr("method", "GET");
        $("#action_contact").submit();
    });
    $("input.reset_form").click(function (e) {
        e.preventDefault();
        $('option[value=0]').attr('selected', 'selected');
        $('option[value="empty"]').attr('selected', 'selected');
        $(".datepicker").val('');
        $("input[type='text']").val('');
       // $("#action_contact option:selected").prop("selected", false);
        $('.selectpicker').selectpicker('deselectAll');
    });
    $('select.filter').on('change', function (e) {
        e.preventDefault();
        $("#action_contact").attr("action", "#").attr("method", "GET");
        $("#action_contact").submit();
    });

    /*========================= SORT =================================*/
    $('th[class^="order_"]').click(function () {
        var myclass = $(this).attr("class");
        myclass = myclass.split(/ /);
        myclass = myclass[0];
        $('input[class^="order_"]').not("input." + myclass).attr('value', '0');
        if ($("input." + myclass).val() === '0') {
            $("input." + myclass).attr('value', 'ASC').promise().done(
				function () {
					$("#action_contact").attr("action", "#").attr("method", "GET");
					$("#action_contact").submit();
				}
            );
            return;
        }
        if ($("input." + myclass).val() === 'ASC') {
            $("input." + myclass).val('DESC').promise().done(
				function () {
					$("#action_contact").attr("action", "#").attr("method", "GET");
					$("#action_contact").submit();
				}
            );
            return;
        }
        if ($("input." + myclass).val() === 'DESC') {
            $("input." + myclass).val('0').promise().done(
				function () {
					$("#action_contact").attr("action", "#").attr("method", "GET");
					$("#action_contact").submit();
				}
            );
            return;
        }

    });
});

$(function () {
    /*
     * Thêm hiệu ứng khi hover vào dropdown bootstrap 
     */
    $('.dropdown-hover').hover(function () {
        $(this).find('.dropdown-menu').stop(true, true).fadeIn(200);
        $(this).find('.child_menu').stop(true, true).fadeIn(200);
    }, function () {
        $(this).find('.dropdown-menu').stop(true, true).fadeOut(200);
        $(this).find('.child_menu').stop(true, true).fadeOut(200);
    });

    /* Sửa lại value của thẻ input curr_url */
    $("#curr_url").val(location.href);

    /* Nếu click vào nút filter nâng cao thì đổi icon */
    $(document).on('click', '.show-more-table-info', function (e) {
        e.stopPropagation();
        let contactId = $(this).attr('contact-id');
        $("#" + contactId).toggle("slow");
        let isHide = $(this).attr('is-hide');
        if (isHide == '1') {
            $(this).attr('is-hide', '0');
            $(this).html('<i class="fa fa-minus-circle" aria-hidden="true"></i>');
        } else {
            $(this).attr('is-hide', '1');
            $(this).html('<i class="fa fa-plus-circle" aria-hidden="true"></i>');
        }
        console.log(1);
    });

    /* Nếu filter nâng cao được mở ra thì điều chỉnh chiều cao 2 cột bằng nhau */
	if($('#input_controller').val() == 'affiliate'){
		$('#collapse-filter').show();
	}
	 
    $('#collapse-filter').on('shown.bs.collapse', function () {
        $(this).prev().find(".fa").removeClass("fa-arrow-circle-down").addClass("fa-arrow-circle-up");
        if ($(".filter-tbl-1").height() > $(".filter-tbl-2").height()) {
            $(".filter-tbl-2").height($(".filter-tbl-1").height());
        } else {
            $(".filter-tbl-1").height($(".filter-tbl-2").height());
        }
    });

    $('#collapse-filter').on('hidden.bs.collapse', function () {
        $(this).prev().find(".fa").removeClass("fa-arrow-circle-up").addClass("fa-arrow-circle-down");
    });
    /* Kiểm tra xem có biến search là view_detail_contact không, nếu có sẽ hiển thị chi tiết contact */
    let searchParams = new URLSearchParams(window.location.search);
    if (searchParams.has('view_detail_contact')) {
        var contatctID = $.trim(searchParams.get('view_detail_contact'));
        $(".view-detail-contact-by-get-url").remove();
        $('body').append(`<a href="#" 
                               class="ajax-request-modal view-detail-contact-by-get-url"
                               data-contact-id ="${contatctID}"
                               data-modal-name="view-detail-contact-div"
                               data-url="common/view_detail_contact">`);
        $(".view-detail-contact-by-get-url").click();
        $(".view-detail-contact-by-get-url").remove();
    }
});

/* 32b339fca68db27aa480 -- f3c70a5a0960d7b811c9*/

Pusher.logToConsole = true;
var pusher = new Pusher('f3c70a5a0960d7b811c9', {
    cluster: 'ap1',
    encrypted: true
});
var channel = pusher.subscribe('my-channel');
channel.bind('notice', function (data) {
    /*$("#notificate")[0].play();*/
    n = new Notification(
		data.title, {
			body: data.message,
			icon: $("#base_url").val() + 'public/images/logo2.png',
			// tag: 'https://crm2.lakita.vn/quan-ly/trang-chu.html',
			sound: $("#base_url").val() + 'public/mp3/new-contact.mp3',
			image: data.image,
			"data": data.url || ''
		});
    n.onclick = function (e) {
        window.location.href = e.target.data;
    };

    if (($("#input_controller").val() === 'manager' && $("#input_method").val() === 'index') || $("#input_controller").val() === 'marketer' && $("#input_method").val() === 'index') {
        setTimeout(function () {
            location.reload();
        }, 4000);
    }
});

channel.bind('callLog', function (data) {
    if (data.success == '1') {
        /*$("#call-log-L6-sound")[0].play();*/
        n = new Notification(
			data.title,
			{
				body: data.message,
				icon: $("#base_url").val() + 'public/images/logo2.png',
				tag: 'https://crm2.lakita.vn/quan-ly/trang-chu.html',
				image: data.image
			});
    } else {
        /*$("#call-log-sound")[0].play();*/
    }
});

channel.bind('marketer_note', function (data) {
	if (data.success == '1') {
		$("#marketer-note-sound")[0].play();
		n = new Notification(
			data.title,
			{
				body: data.message,
				icon: $("#base_url").val() + 'public/images/logo2.png',
				tag: 'https://crm2.lakita.vn/quan-ly/trang-chu.html',
				image: data.image
			}
		);
		
		if ($("#input_controller").val() === 'sale' && data.sale === $("#input_user_id").val()) {
			var append = ` <div style="position: fixed; left:10px; bottom: 10px; z-index: 999999999; 
                                    background-color: #fff; display: inline-block; width: 30%; border-radius: 5px" class="my-notify">
                                        <div style="position:absolute; right: 5px; top:5px; cursor: pointer" class="close-notify"> 
                                            <i class="fa fa-times-circle" style="font-size: 20px;" aria-hidden="true"></i> 
                                        </div>    
                                        
                                        <div style="float:left; width:90%; padding: 2%">
                                            <h4> ${data.message} </h4>
                                        </div>
                                   </div>`;

			$('body').append(append);
		}
		
	} else {
		$("#send_email_sound")[0].play();
	}
});

$(document).on("click", ".close-notify", function () {
    $(".my-notify").remove();
});

$('li.mega-dropdown').mouseover(() => $(".black-over").css('bottom', '0%')).mouseout(() => $(".black-over").css('bottom', '100%'));

$(document).on('hide.bs.modal', '.navbar-search-modal', function () {
    $('.navbar-search-modal').remove();
});
$(document).on('hide.bs.modal', '.view-all-contact-courses-modal', function () {
    $('.view-all-contact-courses-modal').remove();
});

$(document).on('hide.bs.modal', '.modal', function () {
    if ($(this).find(".modal-dialog").attr('class').search('btn-very-lg') != -1) {
        $(this).find(".modal-dialog").attr('class', 'modal-dialog fadeOut animated btn-very-lg');
    } else if ($(this).find(".modal-dialog").attr('class').search('modal-lg') != -1) {
        $(this).find(".modal-dialog").attr('class', 'modal-dialog fadeOut animated modal-lg');
    } else {
        $(this).find(".modal-dialog").attr('class', 'modal-dialog fadeOut animated');
    }
});

$(document).on('show.bs.modal', '.modal', function () {
    /*
     * Nạp lại các date picker
     */
    $('.selectpicker').selectpicker({});
    $(".datepicker").datepicker({dateFormat: "dd-mm-yy"});
    $(".reset_datepicker").click(function (e) {
        e.preventDefault();
        // $(".datepicker").val("");
        $(this).parent().parent().find(".datepicker").val('');
		$(this).parent().parent().find(".datetimepicker").val('');
    });
    $('.datetimepicker').datetimepicker({
		format: 'DD-MM-YYYY HH:mm'
	});

    setTimeout(function () {
        setEqualTableHeight();
    }, 2500);

    if ($(this).find(".modal-dialog").attr('class').search('btn-very-lg') != -1) {
        $(this).find(".modal-dialog").attr('class', 'modal-dialog fadeIn animated btn-very-lg');
    } else if ($(this).find(".modal-dialog").attr('class').search('modal-lg') != -1) {
        $(this).find(".modal-dialog").attr('class', 'modal-dialog fadeIn animated modal-lg');
    } else {
        $(this).find(".modal-dialog").attr('class', 'modal-dialog fadeIn animated');
    }
    var zIndex = 1040 + (10 * $('.modal:visible').length);
    $(this).css('z-index', zIndex);
    setTimeout(function () {
        $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
    }, 0);
});

/*
Xem tất cả contact mà có đăng kí nhiều lần
 */
$(document).on("click", ".ajax-request-modal", function (e) {
    e.stopPropagation();
    e.preventDefault();
    var _this = $(this);
    setTimeout(function () {
     	if($(".checked").length) {
			$(".checked").removeClass("checked");
		}
       /*   _this.parent().parent().addClass("checked"); */

        var contact_id = _this.attr("data-contact-id");
        var url = $("#base_url").val() + _this.attr("data-url");
        var modalName = _this.attr("data-modal-name");
        var controller = _this.attr("data-controller");
        let type_modal = _this.attr("data_type_modal");
		
        $.ajax({
            url: url,
            type: "POST",
            dataType: 'json',
            data: {
                contact_id: contact_id,
                controller: controller,
				type_modal: type_modal
            },
            success: data => {
                /* console.log(data); */
                if (data.success == 0) {
                    /*$("#send_email_error")[0].play();*/
                    $.notify(data.message, {
                        position: "top left",
                        className: 'error',
                        showDuration: 200,
                        autoHideDelay: 7000
                    });
                    return false;
                } else {
                    $("." + modalName).remove();
                    var newModal = `<div class="${modalName}"></div>`;
                    $(".modal-append-to").append(newModal);
                    $(`.${modalName}`).html(data.message);
                }
            },
            complete: () => $(`.${modalName} .modal`).modal("show")
        });
    }, 100);
});

$(document).on('click', '.change-form-submit-url', function (e) {
    e.preventDefault();
    var form = $(this).data("form-id");
    var action = $(this).data("action");
    var method = $(this).data("method");
    var url = $("#base_url").val() + action;
    $("#" + form).attr("action", url).attr("method", method).submit(); 
});

var modalName = "navbar-search-modal";
$(function () {
    var locationHash = location.hash;
    if (locationHash.indexOf("search") > -1) {
        var hashSearch = locationHash.substring(1);
        var searchArr = hashSearch.split("=");
        var searchStr = searchArr[1];
        $(".input-navbar-search").val(searchStr);
        $.ajax({
            url: $("#base_url").val() + $("#input_controller").val() + '/search',
            type: "GET",
            data: {
                search_all: searchStr
            },
            success: data => {
                $("." + modalName).remove();
                var newModal = `<div class="${modalName}"></div>`;
                if ($("#action_contact").length) {
                    $("#action_contact").append(newModal);
                } else {
                    $(".modal-append-to").append(newModal);
                }
                $(`.${modalName}`).html(data);
            },
            complete: () => $(`.${modalName} .navbar-search-modal`).modal("show")
        });
    }
});

$(".btn-navbar-search").click(function (e) {
    e.preventDefault();
    if ($(".input-navbar-search").val() == '') {
        /*$("#send_email_error")[0].play();*/
        $.notify('Vui lòng nhập nội dung tìm kiếm!', {
            position: "top left",
            className: 'error',
            showDuration: 200,
            autoHideDelay: 7000
        });
        return false;
    }
    var locationOrigin = location.href.split("#");
    location.href = locationOrigin[0] + '#search=' + $(".input-navbar-search").val();

    if ($("#input_sub_folder").val() != '') {
    	var url = $("#base_url").val() + $("#input_sub_folder").val() + '/' + $("#input_controller").val() + '/search';
	} else {
		var url = $("#base_url").val() + $("#input_controller").val() + '/search';
	}

    $.ajax({
        url: url,
        type: "GET",
        data: {
            search_all: $(".input-navbar-search").val()
        },
        success: data => {
            $("." + modalName).remove();
            var newModal = `<div class="${modalName}"></div>`;
            if ($("#action_contact").length) {
                $("#action_contact").append(newModal);
            } else {
                $(".modal-append-to").append(newModal);
            }
            $(`.${modalName}`).html(data);
        },
        complete: () => $(`.${modalName} .navbar-search-modal`).modal("show")
    });
});

/*<a href="#" class="anchor-navbar-search">6899</a> */
$(".anchor-navbar-search").click(function (e) {
    e.preventDefault();
    $.ajax({
        url: $("#base_url").val() + $("#input_controller").val() + '/search',
        type: "GET",
        data: {
            search_all: $.trim($(this).text())
        },
        success: data => {
            $("." + modalName).remove();
            var newModal = `<div class="${modalName}"></div>`;
            if ($("#action_contact").length) {
                $("#action_contact").append(newModal);
            } else {
                $(".modal-append-to").append(newModal);
            }
            $(`.${modalName}`).html(data);
        },
        complete: () => $(`.${modalName} .navbar-search-modal`).modal("show")
    });
});

$(document).on('click', '.export-to-excel', function (e) {
    e.preventDefault();
    if ($('input.tbl-item-checkbox:checked').length == 0) {
        $.alert({
            theme: 'modern',
            type: 'red',
            title: 'Có lỗi xảy ra!',
            content: 'Vui lòng chọn contact cần xuất ra file excel!'
        });
    } else {
        $(".popup-wrapper").show();
        setTimeout(function(){ $(".popup-wrapper").hide();}, 3000);
        var form = $(this).data("form-id");
        var action = $(this).data("action");
        var method = $(this).data("method");
        var url = $("#base_url").val() + action;
        $("#" + form).attr("action", url).attr("method", method).submit();
    }
});

$(".export-all-to-excel").remove();
$(".btn-export-all-contact-to-excel").click(function (e) {
	e.preventDefault();
	var formID = $(this).attr('data-form-id');
	$("#"+formID).append('<input type="text" class="export-all-to-excel" name="export_all" value="yes" />');
	$("#"+formID).attr("action", "#").attr("method", "GET").submit();
	$(".export-all-to-excel").remove();
});

/*=================================== chia contact đã chọn (form modal)================================================*/
$(".divide_contact").on('click', function (e) {
    e.preventDefault();
    $("#action_contact").removeClass("form-inline");
    $(".divide_multi_contact_modal").modal("show");
});

//chia đều contact
$(".divide_contact_auto").on('click', function (e) {
    e.preventDefault();
    $("#action_contact").removeClass("form-inline");
    $(".divide_multi_contact_auto_modal").modal("show");
    /*$(".divide_multi_contact_modal").modal("hide");*/
    // alert('chào');
});

/*=================================== chia từng contact một (form modal)================================================*/
$(document).on('click', '.divide_one_contact_achor', function (e) {
    e.preventDefault();
    $("#action_contact").removeClass("form-inline");
    var contact_id = $(this).attr("contact_id");
    $(".checked").removeClass("checked");
    $(this).parent().parent().addClass("checked");
    $("#contact_id_input").val(contact_id);
    var contact_name = $(this).attr("contact_name");
    $("span.contact_name").text(contact_name);
    $(".divide_one_contact_modal").modal("show");
});

/*=================================== chia đều contact đã chọn ================================================*/
/*
$(".divide_contact_even").on('click', function (e) {
    e.preventDefault();
    $("#action_contact").attr("action", $("#base_url").val() + "manager/divide_contact_even");
    $("#action_contact").submit();
});

 */

/*===================================== phân contact bằng ajax ==============*/
$(document).on('click', '.btn-divide-one-contact', function (e) {
    e.preventDefault();
    var url = $(this).parents('#divide_one_contact').attr("action");
    var contact_id = $("#contact_id_input").val();
    $.ajax({
        url: url,
        type: "POST",
        dataType: 'json',
        data: $('#divide_one_contact').serialize(),
        success: data => {
            if (data.success == 1) {
                /*$("#send_email_sound")[0].play();*/
                $.notify(data.message, {
                    position: "top left",
                    className: 'success',
                    showDuration: 200,
                    autoHideDelay: 5000
                });
                $(".divide_one_contact_modal").modal("hide");
                $('tr[contact_id="' + contact_id + '"]').remove();
            } else {
                /*$("#send_email_error")[0].play();*/
                $.notify('Có lỗi xảy ra! Nội dung: ' + data.message, {
                    position: "top left",
                    className: 'error',
                    showDuration: 200,
                    autoHideDelay: 7000
                });
            }
        }
    });
});


$(document).on('click', '.btn-divide-multi-contact', function (e) {
    e.preventDefault();
    let url = $('#base_url').val() + "manager/divide_contact";
    /*Lấy các contact chăm sóc để ẩn đi*/
    let contactIdArray = [];
    $('input[type="checkbox"]').each(
        function () {
            if ($(this).is(":checked")) {
                contactIdArray.push($(this).val());
            }
        }
    );
    $.ajax({
        url: url,
        type: "POST",
        dataType: 'json',
        data: $('#action_contact').serialize(),
        success: data => {
            if (data.success == 1) {
                $("#send_email_sound")[0].play();
                $.notify(data.message, {
                    position: "top left",
                    className: 'success',
                    showDuration: 200,
                    autoHideDelay: 5000
                });
                $(".divide_multi_contact_modal").modal("hide");
                $.each(contactIdArray, function () {
                    $('tr[contact_id="' + this + '"]').remove();
                });
            } else {
                $("#send_email_error")[0].play();
                $.notify('Có lỗi xảy ra! Nội dung: ' + data.message, {
                    position: "top left",
                    className: 'error',
                    showDuration: 200,
                    autoHideDelay: 7000
                });
            }
        }
    });
});

/* phân đều contact*/
$(document).on('click', '.btn-divide-multi-contact-auto', function (e) {
    e.preventDefault();
    let url = $('#base_url').val() + "manager/divide_contact_auto";
    /*
     * Lấy các contact chăm sóc để ẩn đi
     */
    let contactIdArray = [];
    $('input[type="checkbox"]').each(
		function () {
			if ($(this).is(":checked")) {
				contactIdArray.push($(this).val());
			}
		});

    // var sale_id_array = $('#sale_id').val();
    // console.log(sale_id_array);

    /*data = sale_id_array;*/
    // console.log(data);
    // return false;
    var data = $('#action_contact').serialize();
    
    $.ajax({
        url: url,
        type: "POST",
        dataType: 'json',
        data: data,
        success: data => {
            if (data.success == 1) {
                /*$("#send_email_sound")[0].play();*/
                $.notify(data.message, {
                    position: "top left",
                    className: 'success',
                    showDuration: 200,
                    autoHideDelay: 5000
                });
                $(".divide_multi_contact_auto_modal").modal("hide");
                $.each(contactIdArray, function () {
                    $('tr[contact_id="' + this + '"]').remove();
                });
				location.reload();
            } else {
                /*$("#send_email_error")[0].play();*/
                $.notify('Có lỗi xảy ra! Nội dung: ' + data.message, {
                    position: "top left",
                    className: 'error',
                    showDuration: 200,
                    autoHideDelay: 7000
                });
            }
        }
    });
});

$("input.reset_form").on('click', function (e) {
    e.preventDefault();
    $('option[value=0]').attr('selected', 'selected');
    $('option[value="empty"]').attr('selected', 'selected');
    $(".datepicker").val('');
    $("input[type='text']").val('');
    // $("#action_contact option:selected").prop("selected", false);
    $('.selectpicker').selectpicker('deselectAll');
});

$(document).on('click', '.transfer_contact, .transfer_one_contact', function (e) {
    e.preventDefault();
    let action = $(this).attr("class").split(" ");
    if (action[0] == "transfer_contact") {
        $("#action_contact").removeClass("form-inline");
        $(".transfer_multi_contact_modal").modal("show");
    } else {
        $(".checked").removeClass("checked");
        $(this).parent().parent().addClass("checked");
        let contact_id = $(this).attr("contact_id");
        let contact_name = $(this).attr("contact_name");
        $("#contact_id_input").val(contact_id);
        $(".contact_name_replacement").text(contact_name);
        $(".transfer_one_contact_modal").modal("show");
    }
});

$(document).on('change', '[name="add_channel_id"], [name="edit_channel_id"]', function () {
    var channel_id = $(this).val();
    $.ajax({
        url: $('#base_url').val() + 'MANAGERS/link/get_campaign',
        type: "POST",
        data: {
            channel_id: channel_id
        },
        success: function (data) {
            $(".ajax_campaign").html(data);
            $(".ajax_adset").html('');
            $(".ajax_ads").html('');
        },
        complete: function () {
            $('.selectpicker').selectpicker({});
        }
    });
});

$(document).on('change', '[name="add_campaign_id"]', function () {
    var campagin_id = $(this).val();
    $.ajax({
        url: $('#base_url').val() + 'MANAGERS/link/get_adset',
        type: "POST",
        data: {
            campagin_id: campagin_id
        },
        success: function (data) {
            $(".ajax_adset").html(data);
            $(".ajax_ads").html('');
        },
        complete: function () {
            $('.selectpicker').selectpicker({});
        }
    });
});

$(document).on('change', '[name="add_adset_id"]', function () {
    var adset_id = $(this).val();
    $.ajax({
        url: $('#base_url').val() + 'MANAGERS/link/get_ad',
        type: "POST",
        data: {
            adset_id: adset_id
        },

        success: function (data) {
            $(".ajax_ads").html(data);
        },
        complete: function () {
            $('.selectpicker').selectpicker({});
        }
    });
});

$(document).on('change', '[name="add_landingpage_id"]', function () {
    var landingpage_id = $(this).find(":selected").data('url');
    // console.log(landingpage_id); return false;
    var preview_iframe = `<iframe width="100%" height="500px" src="${landingpage_id}"></iframe>`;
    $(".modal-replace-preview-landingpage").html(preview_iframe);
    $(".modal-preview-landingpage").modal('show');
});

$(document).on('change', '[name="add_role_id"]', function () {
	let role_id = $(this).val();
	// console.log(role_id);return false;
	$.ajax({
		url: $('#base_url').val() + 'staff_managers/staff/get_kpi',
		type: "POST",
		data: {
			role_id: role_id
		},

		success: function (data) {
			$(".ajax_kpi").html(data);
            if (role_id == 1) {
                $(".ipphone").show();
            } else {
                $(".ipphone").hide();
            }
		},

		complete: function () {
			$('.selectpicker').selectpicker({});
		}

	});
});

$(document).on('change', '[name="add_branch_id"], [name="add_language_id"], [name="edit_language_id"], [name="filter_arr_multi_language_id"], [name="filter_language_id"]', function () {
	let item_id = $(this).val();
	let type_data = $(this).attr("type");
	// console.log(item_id);return false;
	$.ajax({
		url: $('#base_url').val() + 'staff_managers/class_study/get_data_ajax',
		type: "POST",
		data: {
			data_id: item_id,
			type: type_data
		},

		success: function (data) {
			if (type_data == 'branch') {
				$(".ajax_class_study").html(data);
			} else if (type_data == 'language' || type_data == 'filter_language') {
				$(".ajax_level_language").html(data);
			}
		},

		complete: function () {
			$('.selectpicker').selectpicker({});
		}
	});
});

$(document).on('change', '[name="level_contact_id"], [name="level_student_id"], [name="level_study_id"]', function () {
	let level_id = $(this).val();
	let level_contact_array = ['L1', 'L2', 'L3', 'L4', 'L5'];
	// var level_student_array = ['L6', 'L8'];
	//console.log(level_id);return false;
	$.ajax({
		url: $('#base_url').val() + 'common/get_level_contact',
		type: "POST",
		data: {
			level_id: level_id
		},
		success: function (data) {
			if (level_contact_array.indexOf(level_id) != -1) {
				$(".ajax_level_contact_id").html(data);
			} else if (level_id == 'L7') {
				$(".ajax_level_study_id").html(data);
			}
		},
		complete: function () {
			$('.selectpicker').selectpicker({});
		}
	});
});

$(document).on('change', '[name="language_id"], [name="branch_id"], [name="payment_method_rgt"]', function () {
	let level_id = $(this).val();
	let type = $(this).attr("type");
	// console.log(type);return false;
	$.ajax({
		url: $('#base_url').val() + 'common/get_data_ajax',
		type: "POST",
		data: {
			level_id: level_id,
			type: type
		},
		success: function (data) {
			if (type == 'language') {
				$(".ajax_level_language_id").html(data);
			} else if (type == 'branch') {
				$(".ajax_class_id").html(data);
			} else if (type == 'payment_method_rgt') {
				$(".ajax_payment_method_rgt").html(data);
			}
		},
		complete: function () {
			$('.selectpicker').selectpicker({});
		}
	});
});

$(document).ready(function() {
    $(".show_popup").click(function(){
        $(".popup-wrapper").show();
    })
});

$(document).on("click", ".copy_link_tracking", function () {
    var textCopy = document.getElementById("id_link_tracking_"+$(this).attr('id_link_tracking'));
    console.log(textCopy);
    textCopy.select();
    document.execCommand('copy');
    $.notify("Copy thành công vào clipboard", {
        position: "bottom left",
        className: 'success',
        showDuration: 200,
        autoHideDelay: 2000
    });
})

$.fn.modal.Constructor.prototype.enforceFocus = function() {};

$('.contact-sale-have-to-call').click(function(){
    let type = $(this).attr('type');
    // console.log(type);return false;
    $.ajax({
		type: "POST",
		url: $("#base_url").val() + "sale/sale_have_to_call",
		data: {
			type: type
		},
		beforeSend: function() {
			$(".popup-wrapper").show();
		},
		success: data => {
			console.log(data);
			$(".body-modal-sale-have-to-call").html("");
			$(".body-modal-sale-have-to-call").append(data);
			$('.navbar-sale-have-to-call-modal').modal('show');
		},
		error: errorThrown => {
			alert(errorThrown);
			$(".popup-wrapper").hide();
		},
		complete: function() {
			$(".popup-wrapper").hide();
		},
	});
});

$(".note_contact").on('click', function (e) {
    e.preventDefault();
    let contact_name = $(this).attr('contact_name');
    let contact_id = $(this).attr('data-contact-id');
	$("#contact_id_input_note").val(contact_id);
	//console.log(contact_id);return false;
    $("span.contact_name").text(contact_name);
    $(".note_contact_modal").modal("show");
});

$('.btn-note-contact').on('click', function(e) {
	e.preventDefault();
	url = $('#base_url').val() + "marketer/note_contact";
	let contact_id = $("#contact_id_input_note").val();
    let note = $('#note').val();
    let check_contact = $("input[name='check_contact']:checked").val();
	// console.log(check_contact);return false;
	$.ajax({
		url: url,
		type: "POST",
		dataType: 'json',
		data: {
			contact_id: contact_id,
			note: note,
			check_contact: check_contact
		},
		success: function (data) {
			// console.log(data);return false;
			if (data.success == 1) {
				//$("#marketer-note-sound")[0].play();
				$.notify(data.message, {
					position: "top left",
					className: 'success',
					showDuration: 200,
					autoHideDelay: 5000
				});
				$(".note_contact_modal").modal("hide");
			}
		}
    });
});

$('.view_student').on('click', function (e) {
	e.preventDefault();
	let class_study_id = $(this).attr('item_id');
	let url = $('#base_url').val() + $(this).attr('show_url');
	$.ajax({
		url: url,
		type: 'POST',
		data: {
			class_study_id : class_study_id
		},
		beforeSend: function() {
			$(".popup-wrapper").show();
		},
		success: function (data) {
			$('.body-modal-show-student').html('');
			$('.body-modal-show-student').append(data);
			$('.show_student').modal('show');
		},
		error: function(errorThrown) {
			alert(errorThrown);
			$(".popup-wrapper").hide();
		},
		complete: function() {
			$(".popup-wrapper").hide();
		},
	});
});

$(".btn-export-excel-manager").on('click', function (e) {
	e.preventDefault();
	$("#action_contact").attr("action", $("#base_url").val() + "common/ExportToExcel");
	$("#action_contact").submit();
});

$(".search_phone").on('dblclick', function (e) {
	e.preventDefault();
	let phone_number = $(this).attr('type').trim();
	let url =  $('#base_url').val() + 'sale/get_contact_from_phone';
	$.ajax({
		url: url,
		type: 'POST',
		data: {
			phone_number : phone_number
		},
		// beforeSend: function() {
		// 	$(".popup-wrapper").show();
		// },
		success: function (data) {
			$('.body-modal-show-infor-contact').html('');
			$('.body-modal-show-infor-contact').append(data);
			$('.view_contact_from_ipphone').modal('show');
		},
		error: function(errorThrown) {
			alert(errorThrown);
			$(".popup-wrapper").hide();
		},
		complete: function() {
			$(".popup-wrapper").hide();
		},
	});
});

$(".recall_missed").confirm({
	theme: 'supervan', // 'material', 'bootstrap',
	title: "Bạn có chắc chắn đã gọi số lại không?",
	content: '',
	buttons: {
		confirm: {
			text: 'Có',
			action: function () {
				let phone_number = $('.search_phone').attr("type").trim();
				let url = $("#base_url").val() + 'sale/update_missed_call';
				// alert(url); return false;
				$.ajax({
					type: "POST",
					url: url,
					data: {
						phone_number: phone_number
						/*contact_id: contactIdArray */
					},
					success: data => {
						// console.log(data); return false;
						if (data === '1') {
							window.location.reload();
						} else {
							alert(data);
						}
					},
					error: errorThrown => alert(errorThrown)
				});
			}},
		cancel: {
			text: 'Hủy',
			action: function () {
			}}
	}
});

$(document).on('click', '.merge_contact', function (e) {
	e.preventDefault();
	$(".checked").removeClass("checked");
	$(this).parent().parent().addClass("checked");
	let contact_id = $(this).attr("contact_id");
	let contact_name = $(this).attr("contact_name");
	$("#contact_id_input_merger").val(contact_id);
	$(".contact_name_replacement").text(contact_name);
	$(".merge_contact_modal").modal("show");
});

$(document).on('click', '.update_data_inline', function(e) {
	e.preventDefault();
    let column = $(this).parent().attr('column');
    let value_current = $(this).parent().find('.value_current').val();
	let form = '';
    if (column === 'note') {
        form = '<form class="form-inline"> ' +
        '<textarea style="width: 85%" rows="2" value=""></textarea>' +
        '<button class="btn btn-sm btn-primary update_inline_now">Lưu</button> ' +
        '</form>';
    } else {
        form = '<form class="form-inline"> ' +
            '<input style="max-width: 43%" type="text" value=' + value_current + '> ' +
            '<button class="update_inline_now" mechanism_teacher>Lưu</button> ' +
            '</form>';
    }
	$(this).parent().html(form);
});

$(document).on('click', '.update_inline_now, .confirm_class', function (e) {
	e.preventDefault();
	let url =  $("#base_url").val() + 'staff_managers/class_study/update_data_inline';
	let data_now = $(this).parent().find('input').val();
	let column = $(this).parent().attr('column');
	let class_id = $(this).parent().parent().attr('item_id');
	let date_update = $(this).parent().parent().attr('date_update');
	let lesson_learned = $(this).parent().parent().attr('lesson_learned');
	let _this = $(this);

	if (column === 'note') {
        data_now = $(this).parent().find('textarea').val();
    }

	$.ajax({
		url: url,
		type: 'POST',
		dataType: 'json',
		data: {
			data_now : data_now,
			column : column,
			class_id: class_id,
            date_update: date_update,
            lesson_learned: lesson_learned
		},
		// beforeSend: function() {
		// 	$(".popup-wrapper").show();
		// },
		success: function (data) {
			if (data.success == 1) {
				let content = data_now + '&nbsp; <input type="hidden" class="value_current" value='+data_now+'>' +
					'<button style="margin-right: 0" type="button" class="btn btn-default btn-sm update_data_inline">' +
					'<span class="glyphicon glyphicon-edit"></span>' +
					'</button>';
                if (column === 'note') {
                    content = data_now + '<br><button style="margin-right: 0" type="button" class="btn btn-primary btn-sm update_data_inline">' +
                        '        <span class="glyphicon glyphicon-edit"></span>' +
                        '    </button>';
                }
                if (column == 'confirm') {
                    content = '<p class="bg-success"> Đã xác nhận </p>';
                    _this.parent().html(content);
                }

                let today = new Date();
				let dd = String(today.getDate()).padStart(2, '0');
				let mm = String(today.getMonth() + 1).padStart(2, '0');
				let yyyy = today.getFullYear();

				today = dd + '/' + mm + '/' + yyyy;

				$('.update_inline_now').parent().html(content);
				$('.date_last_update_class').text(today);
			} else {
				alert('Nhập giá trị vào ô');
			}
		},
		error: function(errorThrown) {
			alert(errorThrown);
			$(".popup-wrapper").hide();
		},
		complete: function() {
			$(".popup-wrapper").hide();
		},
	});
});

$(document).on('click', '.check_diligence', function(e) {
	e.preventDefault();
	let contact_id = $(this).attr('contact_id');
	let url = $('#base_url').val() + 'student/check_diligence';
	$.ajax({
		url: url,
		type: 'POST',
		data: {
			contact_id : contact_id
		},
		beforeSend: function() {
			$(".popup-wrapper").show();
		},
		
		success: function (data) {
			$('.body-modal-show-diligence').html('');
			$('.body-modal-show-diligence').append(data);
			$('.show_diligence').modal('show');
		},
		
		error: function(errorThrown) {
			alert(errorThrown);
			$(".popup-wrapper").hide();
		},
		complete: function() {
			$(".popup-wrapper").hide();
		},
	});
});

$(".mechanism_teacher").on('click', function (e) {
    e.preventDefault();
    let class_study_id = $(this).attr('class_study_id');
    $("#class_study_id").val(class_study_id);
    $(".show_mechanism_teacher").modal("show");
});

$('.send_mail_teacher').on('click', function (e) {
    e.preventDefault();
    let teacher_id = $(this).attr('teacher_id');
    let class_study_id = $(this).attr('class_study_id');
    let start_date = $('span#start_date').text();
    let end_date = $('span#end_date').text();
    let _this_ = $(this);

    $.ajax({
        url: $('#base_url').val() + 'staff_managers/teacher/send_mail_salary_teacher',
        type: 'POST',
        dataType: 'json',
        data: {
            teacher_id : teacher_id,
            class_study_id : class_study_id,
            start_date : start_date,
            end_date : end_date
        },
        beforeSend: function() {
            $(".popup-wrapper").show();
        },
        success: function (data) {
            if (data.success) {
                _this_.parent().parent().find('td.paid_salary').html('<p class="bg-success">Đã gửi mail lương</p>');
                // _this_.attr('disabled', true);

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
        error: function(errorThrown) {
            alert(errorThrown);
            $(".popup-wrapper").hide();
        },
        complete: function() {
            $(".popup-wrapper").hide();
        },
    });
});

$(".edit_class").on('click', function (e) {
    e.preventDefault();
    let item_id = $(this).attr("item_id");
    let url = $("#base_url").val() + "staff_managers/class_study/show_edit_care_class";
    let modal_name = 'show_edit_class';

    $.ajax({
        url: url,
        type: "POST",
        data: {
            item_id: item_id
        },
        success: function (data) {
            $("." + modal_name).remove();
            let newModal = `<div class="${modal_name}"></div>`;
            $(".modal-append-to").append(newModal);
            $(`.${modal_name}`).html(data);
        },
        complete: function () {
            $(`.${modal_name} .modal`).modal("show");
        }
    });
    // $(".show_edit_class").modal("show");
});

$(".email_contract").on('click', function (e) {
    e.preventDefault();
    let class_study_id = $(this).attr('class_study_id');
    $("#class_study_id").val(class_study_id);
    $.ajax({
        url: $('#base_url').val() + 'staff_managers/class_study/send_mail_contract',
        type: 'POST',
        dataType: 'json',
        data: {
            class_study_id : class_study_id,
        },
        beforeSend: function() {
            $(".popup-wrapper").show();
        },
        success: function (data) {
            if (data.success) {
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
        error: function(errorThrown) {
            alert(errorThrown);
            $(".popup-wrapper").hide();
        },
        complete: function() {
            $(".popup-wrapper").hide();
        },
    });
});

$(".class_own_teacher").on('click', function (e) {
    e.preventDefault();
    let teacher_id = $(this).attr("item_id");
    let url = $("#base_url").val() + "staff_managers/teacher/show_class_own_teacher";
    let modal_name = 'show_class_own_teacher';

    $.ajax({
        url: url,
        type: "POST",
        data: {
            teacher_id: teacher_id
        },
        success: function (data) {
            // $(".show_class_own_teacher").modal("show");
            $("." + modal_name).remove();
            let newModal = `<div class="${modal_name}"></div>`;
            $(".modal-append-to").append(newModal);
            $(`.${modal_name}`).html(data);
        },
        complete: function () {
            $(`.${modal_name} .modal`).modal("show");
        }
    });
});

$(".check_L7").on('click', function (e) {
    e.preventDefault();
    let class_study_id = $(this).attr("class_study_id");
    let url = $("#base_url").val() + "staff_managers/class_study/show_L7";
    let modal_name = 'show_L7';

    $.ajax({
        url: url,
        type: "POST",
        data: {
            class_study_id: class_study_id
        },
        beforeSend: () => $(".popup-wrapper").show(),
        success: function (data) {
            $("." + modal_name).remove();
            let newModal = `<div class="${modal_name}"></div>`;
            $(".modal-append-to").append(newModal);
            $(`.${modal_name}`).html(data);
        },
        complete: function () {
            $(`.${modal_name} .modal`).modal("show");
            $(".popup-wrapper").hide();
        }
    });
});

$('.paid_salary_teacher').on('click', function (e) {
    e.preventDefault();
    let teacher_id = $(this).attr('teacher_id');
    let class_study_id = $(this).attr('class_study_id');
    let start_date = $('span#start_date').text();
    let end_date = $('span#end_date').text();
    let money = $(this).attr('money');
    let _this_ = $(this);

    $.ajax({
        url: $('#base_url').val() + 'staff_managers/teacher/paid_salary_teacher',
        type: 'POST',
        dataType: 'json',
        data: {
            teacher_id : teacher_id,
            class_study_id : class_study_id,
            start_date : start_date,
            end_date : end_date,
            money : money
        },
        beforeSend: function() {
            $(".popup-wrapper").show();
        },
        success: function (data) {
            if (data.success) {
                _this_.parent().parent().find('td.paid_salary').html('<p class="bg-primary">Đã trả lương</p>');
                // _this_.attr('disabled', true);

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
        error: function(errorThrown) {
            alert(errorThrown);
            $(".popup-wrapper").hide();
        },
        complete: function() {
            $(".popup-wrapper").hide();
        },
    });
});

$(".update_cost_student").on('click', function (e) {
    e.preventDefault();
    $(".checked").removeClass("checked");
    $(this).parent().parent().addClass("checked");
    let contact_id = $(this).attr("contact_id");
    let modal_name = 'view_update_cost_student';

    $.ajax({
        url: $("#base_url").val() + "sale/view_update_cost_student",
        type: "POST",
        data: {
            contact_id: contact_id
        },
        beforeSend: () => $(".popup-wrapper").show(),
        success: function (data) {
            $("." + modal_name).remove();
            let newModal = `<div class="${modal_name}"></div>`;
            $(".modal-append-to").append(newModal);
            $(`.${modal_name}`).html(data);
        },
        complete: function () {
            $(`.${modal_name} .modal`).modal("show");
            $(".popup-wrapper").hide();
        }
    });
    // $(".view_update_cost_student").modal("show");
});

$(".btn_paid_cost_branch").on('click', function (e) {
    e.preventDefault();

    let _this_ = $(this);
    let cost_id = _this_.attr("cost_id");
    let type_money = _this_.attr("type_money");
    $.ajax({
        url: $("#base_url").val() + "student/paid_cost_branch",
        type: "POST",
        dataType: 'json',
        data: {
            cost_id: cost_id,
            type_money: type_money
        },
        beforeSend: () => $(".popup-wrapper").show(),
        success: function (data) {
            if (data.success) {
                _this_.parent().parent().find('td.cost_branch').html('<p class="bg-success">Đã thanh toán</p>');
            } else {
                alert(data.message);
            }
        },
        complete: function () {
            $(".popup-wrapper").hide();
        }
    });
});

$(".confirm_order_teacher_abroad").on('click', function (e) {
    e.preventDefault();
    $(".checked").removeClass("checked");
    let order_id = $(this).attr("order_id");
    let modal_name = 'view_confirm_order_teacher_abroad';

    $.ajax({
        url: $("#base_url").val() + "staff_managers/teacher/view_confirm_order_teacher_abroad",
        type: "POST",
        data: {
            order_id: order_id
        },
        beforeSend: () => $(".popup-wrapper").show(),
        success: function (data) {
            $("." + modal_name).remove();
            let newModal = `<div class="${modal_name}"></div>`;
            $(".modal-append-to").append(newModal);
            $(`.${modal_name}`).html(data);
        },
        complete: function () {
            $(`.${modal_name} .modal`).modal("show");
            $(".popup-wrapper").hide();
        }
    });
});

$(".show_feedback_student").on('click', function (e) {
    e.preventDefault();
    let contact_id = $(this).attr("contact_id");
    let class_study_id = $(this).attr("class_study_id");
    let url = $("#base_url").val() + "student/show_feedback_student?contact_id=" + contact_id + "&class_study_id=" + class_study_id;

    location.assign(url);
});

$(document).on('click', '.delete_common', e => {
    let right = confirm("Bạn có chắc chắn muốn xóa ?");
    if (right === true) {
        let del = $(e.target);
        let delete_id = $(e.target).attr("delete_id");
        let type_delete = $(e.target).attr("type_delete");
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: $("#base_url").val() + "common/delete_common",
            data: {
                delete_id: delete_id,
                type_delete: type_delete
            },
            success: data => {
                if (data.success) {
                    alert(data.message);
                    del.parent().parent().hide();
                } else {
                    alert(data.message);
                }
            },
            error: errorThrown => alert(errorThrown)
        });
        return false;
    }
});

$('.send_mail_salary_staff').on('click', function (e) {
	e.preventDefault();
	let salary_id = $(this).attr('salary_id');
	let _this_ = $(this);

	$.ajax({
		url: $('#base_url').val() + 'staff_managers/staff/send_mail_salary_staff',
		type: 'POST',
		dataType: 'json',
		data: {
			salary_id : salary_id
		},
		beforeSend: function() {
			$(".popup-wrapper").show();
		},
		success: function (data) {
			if (data.success) {
				_this_.parent().parent().find('td.paid_salary_mail').html('<p class="bg-success">Đã gửi mail lương</p>');

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
		error: function(errorThrown) {
			alert(errorThrown);
			$(".popup-wrapper").hide();
		},
	});
});

$('.paid_salary_staff').on('click', function (e) {
	e.preventDefault();
	let salary_id = $(this).attr('salary_id');
	let total_salary_real = $(this).attr('total_salary_real');
	let _this_ = $(this);

	$.ajax({
		url: $('#base_url').val() + 'staff_managers/staff/paid_salary_staff',
		type: 'POST',
		dataType: 'json',
		data: {
			salary_id : salary_id,
            total_salary_real : total_salary_real
		},
		beforeSend: function() {
			$(".popup-wrapper").show();
		},
		success: function (data) {
			if (data.success) {
				_this_.parent().parent().find('td.paid_salary_notification').html('<p class="bg-primary">Đã trả lương</p>');

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
		error: function(errorThrown) {
			alert(errorThrown);
			$(".popup-wrapper").hide();
		},
		complete: function() {
			$(".popup-wrapper").hide();
		},
	});
});





