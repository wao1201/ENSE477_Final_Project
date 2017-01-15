$(document).ready(function(){
	$("#LoginForm").submit(function(){
		var username = $('#username').val();
		var password = $('#password').val();
		if(username==""){
		    alert("Please enter a user name");
		    return false;
		}
		if(password==""){
		    alert("Please enter a password");
		    return false;
		}
		$.ajax({
			type: "POST",
			    url: "../php/user.php",
			    data: {action: 'login', username: username, password: password}
		    }).done(function(data){
			    //something should be done here.
			    if(data == 1){
				window.location="../index.php";
				return true;
			    }
			    else if(data == 2){
				alert('Your email address has not been verified. Please check your Inbox for the email.');
				return false;
			    }
			    else if(data == 3){
				alert('Your username or password is not correct.');
				return false;
			    }
			});//ajax done
		return false;
	    });//Submit Event handler

	$("#forgot").click(function(){
		var username = $('#username').val();

		if(username==""){
		    alert("Please enter your username to recover password");
		    return false;
		}
		alert("An email has been send to the email address associated with the account.  Follow the instructions their to reset your password");
		$.ajax({
			type: "POST",
			    url: "../php/user.php",
			    dataType: "json",
			    data: {action: 'recover_password', username: username}
		    }).done(function(data){
			    //Nothing will execute in here for some reason that is beyond my knowledge of jquery and ajax
			});//ajax done
		
	    });//forgot Event Handler

    });//Document ready