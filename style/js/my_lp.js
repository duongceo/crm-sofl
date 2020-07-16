/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(function () {
	//thời gian chuyển slide
	/* $('.carousel').carousel({
        interval: 10000
    }); */
	/*============ đặt chiều cao cho carousel ===========*/
	var max_height = 0;
	$(".student-content").each(function () {
		if (max_height < $(this).height())
			max_height = $(this).height();
	});
	$(".student-content").each(function () {
		$(this).height(max_height);
	});

	/*========================== đồng hồ đếm ngược =================*/
	countdown();
	setInterval(function () {
		countdown();
	}, 1000);
	var d = new Date();
	$(".fullyear").text(d.getDate() + '/' + (d.getMonth() + 1) + '/' + d.getFullYear());
	$("a[href^='#']").click(function () {
		var url = window.location.href;
		var idDiv = $(this).attr("href").substr(1, $(this).attr("href").length);
		var sizeEnough = $(window).height() - $('#' + idDiv).height();
		$('html,body').animate({
			scrollTop: $($(this).attr("href")).offset().top - ($(window).height() - $('#' + idDiv).height())
		}, 1000);
	});
});


/* add email getresponse */
$(document).on("submit", ".e_form_submit", function (e) {
	var obj = $(this);
	if (check_lienhe(obj)) {
		document.getElementById("name_grp").value=obj.find('input[name="name"]').val();
		document.getElementById("email_grp").value=obj.find('input[name="email"]').val();
		$.ajax({
			url: "https://app.getresponse.com/add_subscriber.html",
			type: "POST",
			data: $("#myform").serialize(),
			success: function (data) {
			},
			error: function () {
			},
			complete: function () {
			}
		});

		$(".popup-wrapper").show();
		setTimeout(function(){
			$(".popup-wrapper").hide();
		}, 3000);
	}
	else{
		e.preventDefault();
	}
});
/* end add */


function countdown() {
	var d = new Date();
	var r_hours = 24 - d.getHours();
	r_hours = (r_hours < 10) ? '0' + r_hours : r_hours;
	var r_minus = 59 - d.getMinutes();
	r_minus = (r_minus < 10) ? '0' + r_minus : r_minus;
	var r_seconds = 59 - d.getSeconds();
	r_seconds = (r_seconds < 10) ? '0' + r_seconds : r_seconds;
	$(".num-hour").text(r_hours);
	$(".num-minute").text(r_minus);
	$(".num-second").text(r_seconds);
}


function check_lienhe(obj) {
	var button = obj.find('.e_btn_submit');
	var email = obj.find('input[name="email"]').val();
	var name = obj.find('input[name="name"]').val();
	var phone = obj.find('input[name="phone"]').val();

	if ((name.trim() == "") || (name == "Họ tên *")) {
		alert("Vui lòng nhập họ và tên của bạn");
		obj.find('input[name="name"]').focus();
		return (false);
	}

	if (!validateEmail(email)) {
		alert("Vui lòng nhập đúng email của bạn");
		obj.find('input[name="email"]').focus();
		return (false);
	}

	if (!validatePhone(phone)) {
		alert("Vui lòng nhập đúng số Điện thoại");
		obj.find('input[name="phone"]').focus();
		return (false);
	}
	button.attr('disabled', 'disabled');
	return true;
}

function validateEmail(email) {
	var re = /[A-Z0-9._%+-]+@[A-Z0-9-]+.+.[A-Z]{2,4}/igm;
	return re.test(email);
}

function validatePhone(tel) {
	var re = /^\+?\d{1,3}?[- .]?\(?(?:\d{2,3})\)?[- .]?\d\d\d[- .]?\d\d\d\d$/;
	return re.test(tel);
}
