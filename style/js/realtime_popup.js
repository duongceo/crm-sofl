$(document).ready(function(){
	setInterval(function(){
		var random = Math.floor(Math.random() * 10);
		if (random % 2 == 1) {
			$.get('https://lakita.vn/FB_notification/little_ext', { url: 'https://lakita.vn/styles/v2.0/data.txt' }, function(data) {
				var customers = data.split('\n');
				var infos = [];
				for (var i=0;i<customers.length; i++) {
					var spl = customers[i].split('|');
					infos.push(spl);
				}

				var color_set = ["AliceBlue","BlanchedAlmond","Coral","DarkCyan","DarkOrange","DarkSlateBlue","DarkSlateGrey","DodgerBlue","DeepPink","HotPink","Khaki","LightPink","LightSkyBlue","LightSteelBlue","MistyRose","Plum","CadetBlue","YellowGreen","Violet","Teal","Tan","SlateGray","SandyBrown","Red","PowderBlue","PapayaWhip","PaleVioletRed","Olive","MediumVioletRed","MediumSeaGreen"];

				var flag = Math.floor(Math.random() * 31);
				console.log(flag);

				var top = $(window).height()/2;
				var color = color_set[flag];

				var name = infos[flag][0];
				var address = infos[flag][2];
				var phone = infos[flag][1];
				var time = flag;

				var content = 'Cảm ơn bạn <span style="font-weight: bold">' + name + '</span> có địa chỉ <span style="font-weight: bold">' + address + '</span> và số điện thoại <span style="font-weight: bold">' + phone + '</span> đã đăng ký khóa học!<p style="color: black; font-size: 10px;">' + time + ' phút trước</p>';

				//var div = '<div id="buy-realtime" style="position: fixed;top: ' + top + 'px;left: 20px;z-index: 100;background-color: ' + color + ';color: #fff;padding: 10px;border: 1px solid #fff;border-radius: 5px;max-width: 200px;">' + content + '</div>';
				var div = '<div id="buy-realtime" style="position: fixed;bottom: 0;left: 0px;z-index: 100;background-color: ' + color + ';color: #fff;padding: 10px;border: 1px solid #fff;border-radius: 5px;max-width: 200px;">' + content + '</div>';
				$('body').append(div);

				setTimeout(function(){$('#buy-realtime').fadeOut(500); }, 3000);

				setTimeout(function(){$( "#buy-realtime" ).remove(); }, 3500);
			});

		}

	},5000);

});
