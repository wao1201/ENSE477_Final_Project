$(document).ready(function(){

	var email_pattern = new RegExp('^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9-\.]+\.[a-zA-Z]{2,4}$');

	var user_pattern = new RegExp('^[a-zA-Z0-9_]*$');

	$("#SignupForm").submit(function(){
		var username = $('#username').val();
		var password = $('#password').val();
		var repass = $('#repass').val();
		var email = $('#email').val();

		if( (username=="") || (username.length<=3) || (username.length>=15) ){
		    alert("Please enter a username or within right range");
		    return false;
		} else if (!user_pattern.test(username)){
		    alert("Only letters and numbers allowed");		    
		    return false;
		}

		if( (password=="") || (password.length < 6) ){
		    alert("Please enter a password");
		    return false;
		}
		if(password!=repass){
		    alert("Passwords do not match");
		    return false;
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
			type: "post",
			    url: "../php/user.php",
			    data: {action: 'signup', username: username, password: password, email: email},
			    error: function(data){
			    alert(data);
			}
		    }).done(function(data){
			    data = JSON.parse(data);
			    if(data.error){
				alert("Error: " + data.error);
			    } else {
				alert("Success! Please check your email Inbox for the verification email.");
				window.location="../index.php";
			    }
			});//ajax done
		return false;
	    });//Submit Event handler
    });//Document ready
