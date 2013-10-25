jQuery(document).ready(function($) {
	$('#login').click(function(event) {
		var username = $('#username').val();
		var password = $('#password').val();
		if (username == ''){
			alert("用户名不能为空");
			return;
		}
		if (password == ''){
			alert("密码不能为空");
			return;
		}
		$.ajax({
			url: 'login.php',
			type: 'post',
			dataType: 'json',
			data: {username: username, password: password},
			success: function(data){
				if(data.code == 200){
					window.location = data.redirecturl;
				}else{
					alert(data.message);
				}
			},
			error: function(){
				console.log("error");
			}
		})
	});

	$("#submit").click(function() {
		var cookie = $("#cookie").val();
		$.ajax({
			url: 'getloginuserinfo.php',
			type: 'post',
			dataType: 'text',
			data: {cookie: cookie},
		})
		.done(function(data) {
			console.log(data);
		  //alert(data);
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
		
	});
});