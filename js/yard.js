$(document).ready(function(){

	var email_pattern = new RegExp('^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9-\.]+\.[a-zA-Z]{2,4}$');

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

		if(password != ""){
			if(password!=repass){
		    	alert("Passwords do not match");
		    	return false;
			}

			if(password.length < 6){
		    	alert("Password must be at least 6 characters");
		    	return false;
			}
		}
		
		if(email==""){
		    alert("Please enter an email address");
		    return false;
		}
		else if (!email_pattern.test(email)){
		    alert("Please enter a valid email address");
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