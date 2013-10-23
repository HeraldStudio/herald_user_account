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
			dataType: 'text',
			data: {username: username, password: password},
		})
		.done(function(data) {
			alert(data);
			//console.log("success");
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
		
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
			//console.log("success");
		  alert(data);
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
		
	});
});