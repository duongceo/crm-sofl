<!DOCTYPE html>

<html lang="en">

    <head>

        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

        <meta charset="utf-8">

        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="shortcut icon" href="<?php echo base_url(); ?>style/img/logo.png" type="image/x-icon" />

        <title>CRM SOFL</title>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<!--        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">-->

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.1/animate.min.css">

        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />

        <link href="https://cdnjs.cloudflare.com/ajax/libs/flipclock/0.7.8/flipclock.min.css" type="text/css" rel="stylesheet" />

        <link href="<?php echo base_url(); ?>style/build/css/custom.min.css?ver=<?php echo _VER_CACHED_; ?>" rel="stylesheet">

        <link href="<?php echo base_url(); ?>style/css/style.css?ver=<?php echo _VER_CACHED_; ?>" rel="stylesheet" type="text/css" />

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">

        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/2.1.25/daterangepicker.min.css" />

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.1.1/min/dropzone.min.css" />

		<!--JQuery 2-->
		<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
		<script type="text/javascript">
			var $j2 = $.noConflict();
			// alert(j2().jquery);
		</script>

		<!--JQuery 3-->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<!--		<script type="text/javascript">-->
		<!--			var j3 = $.noConflict();-->
		<!--			alert(j3().jquery);-->
		<!--		</script>-->

		<?php if ($this->controller == 'sale' || $this->controller == 'cod') { ?>
			<script src="https://minio.infra.omicrm.com/statics/web-sdk/v14/sdk.min.js"></script>
			<script>
				$(document).ready(function () {
					var config = {
						theme: 'fuji',
						language: "vi", /* Ngôn ngữ giao diện dialog */
						register_fn: function (data) { /* Sự kiện xảy ra khi ghi danh tổng đài */
							console.log(data);
						},
						incall_fn: function (data) { /* Sự kiện xảy ra khi thay đổi trạng thái trong cuộc gọi */
							console.log(data);
						},
						accept_fn: function (data) { /* Sự kiện xảy ra khi cuộc gọi được chấp nhận */
							console.log(data);
						},
						accept_out_fn: function (data) { /* Sự kiện xảy ra khi cuộc gọi được chấp nhật trên một thiết bị khác */
							console.log(data);
						},
						invite_fn: function (data) { /* Sự kiện xảy ra khi có một cuộc gọi tới */
							console.log(data);
						},
						invite_2fn: function (data) { /*Sự kiện xảy ra khi đang trong cuộc gọi với một thuê bao, thì có thuê bao khác gọi tới */
							console.log(data);
						},
						ping_fn: function (data) { /* Kiểm tra tính hiệu cuộc gọi */
							console.log(data);
						},
						endcall_fn: function (data) { /* Sự kiện xảy ra khi cuộc gọi kết thúc */
							console.log(data);
						}
					};
					/** Thông tin ghi danh tổng đài được lấy từ OMI. Cấu hình >> Tổng đài >> Số nội bộ **/
					omiSDK.init(config, function () {
						var params = {
							domain: "nvquang28971",
							username: "101",
							password: "o4nCXS2Rtt"
						};
						omiSDK.register(params);
					});
				});
			</script>
		<?php } ?>

        <link href="<?php echo base_url(); ?>vendors/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.css" rel="stylesheet" type="text/css"/>

        <script src="<?php echo base_url(); ?>vendors/bootstrap-switch/dist/js/bootstrap-switch.js" type="text/javascript"></script>
		
		<link rel="stylesheet" href="<?php echo base_url(); ?>style/css/common/style3.css">
        <!-- Scrollbar Custom CSS -->
		
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">
		
		<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
		<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>

<!--		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>-->

        <style>

            .modal.fade{

                opacity:1;

            }

            .modal.fade .modal-dialog {

                -webkit-transform: translate(0);

                -moz-transform: translate(0);

                transform: translate(0);

            }

        </style>

        <script type="text/javascript">

            (function (p, u, s, h) {

                p._pcq = p._pcq || [];

                p._pcq.push(['_currentTime', Date.now()]);

                s = u.createElement('script');

                s.type = 'text/javascript';

                s.async = true;

                s.src = 'https://cdn.pushcrew.com/js/42d3963a092f7239329a7355e48b5db1.js';

                h = u.getElementsByTagName('script')[0];

                h.parentNode.insertBefore(s, h);

            })(window, document);

        </script>

    </head>



