$(document).ready(function(){
	$.ajax({
		type: "post",
		    url: "../php/user.php",
		    data: {action: 'retrieve'},
		    error: function(data){ alert(data);}
	    }).done(function(data){
		    data = JSON.parse(data);
		    //   alert(data.email);
		    $('#email').val(data.email);
		    $('#reputation').text(data.reputation);
		    $('#userType').text(data.user_type);
		    if (data.notification == 1){
			$('#notification').prop('checked', true);
		    } else {
			$('#notification').prop('checked', false);
		    }
		});//Ajax Done

	$("#UserModForm").submit(function(){
		var password = $('#password').val();
		var repass = $('#repass').val();
		var email= $('#email').val();
		var notification = 0;
		if ($('#notification').prop('checked')){
		    notification = 1;
		}

		if(password!=repass){
		    alert("Passwords do not match");
		    return false;
		}

		$.ajax({
			type: 'post',
			    url: "../php/user.php",
			    data: {action: 'modify_user', password: password, email: email, notification: notification},
			    error: function(data){ alert(data);}
		    }).done(function(data){
			    data = JSON.parse(data);
			    if (data == true){
				alert("Success!");
				window.location = "/user/yard.php";
			    } else {
				alert("Failed, we dont know why");
			    }
			});
		return false;
	    });//Submit Event handler
    });//Document ready