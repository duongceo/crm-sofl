<tr>

    <td class="text-right"> Số điện thoại </td>

    <td>
		<div class="input-group">
			<input type="tel" class="form-control" value="<?php echo $rows['phone']; ?>" name="phone" />

			<div class="input-group-btn">

				<button class="btn btn-success btn-call-phone">Gọi ngay</button>

			</div>
		</div>

    </td>

</tr>

<script>
	$('.btn-call-phone').on('click', function(e) {
		e.preventDefault();
		var phone = $('[name="phone"]').val();
		// alert(phone);
		omiSDK.makeCall(phone);
	});
</script>

<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>-->
<!--<script src="https://minio.infra.omicrm.com/statics/web-sdk/v14/sdk.min.js"></script>-->
<!--<script>-->
<!--	$(document).ready(function () {-->
<!--		var config = {-->
<!--			theme: 'fuji',-->
<!--			language: "vi", // Ngôn ngữ giao diện dialog-->
<!--			register_fn: function (data) { //Sự kiện xảy ra khi ghi danh tổng đài-->
<!--				console.log(data);-->
<!--			},-->
<!--			incall_fn: function (data) { //Sự kiện xảy ra khi thay đổi trạng thái trong cuộc gọi-->
<!--				console.log(data);-->
<!--			},-->
<!--			accept_fn: function (data) { //Sự kiện xảy ra khi cuộc gọi được chấp nhận-->
<!--				console.log(data);-->
<!--			},-->
<!--			accept_out_fn: function (data) { //Sự kiện xảy ra khi cuộc gọi được chấp nhật trên một thiết bị khác-->
<!--				console.log(data);-->
<!--			},-->
<!--			invite_fn: function (data) { //Sự kiện xảy ra khi có một cuộc gọi tới-->
<!--				console.log(data);-->
<!--			},-->
<!--			invite_2fn: function (data) {//Sự kiện xảy ra khi đang trong cuộc gọi với một thuê bao, thì có thuê bao khác gọi tới-->
<!--				console.log(data);-->
<!--			},-->
<!--			ping_fn: function (data) { //Kiểm tra tính hiệu cuộc gọi-->
<!--				console.log(data);-->
<!--			},-->
<!--			endcall_fn: function (data) { //Sự kiện xảy ra khi cuộc gọi kết thúc-->
<!--				console.log(data);-->
<!--			}-->
<!--		};-->
<!--		/** Thông tin ghi danh tổng đài được lấy từ OMI. Cấu hình >> Tổng đài >> Số nội bộ **/-->
<!--		omiSDK.init(config, function () {-->
<!--			var params = {-->
<!--				domain: "nvquang28971",-->
<!--				username: "101",-->
<!--				password: "o4nCXS2Rtt"-->
<!--			};-->
<!--			omiSDK.register(params);-->
<!--		});-->
<!--	});-->
<!---->
<!--	$('.btn-call').on('click', function(e) {-->
<!--		e.preventDefault();-->
<!--		var phone = $('[name="phone"]').val();-->
<!--		// alert(phone);-->
<!--		omiSDK.makeCall(phone);-->
<!--	});-->
<!--</script>-->
