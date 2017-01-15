<?php
class User {

  function send_recovery_email($user){
    //connect to DB 
    $con=mysqli_connect("localhost","root","chriswei","animal");
    //Check if user exists
    $query = "SELECT email FROM user WHERE username = ?";
    if ($sql = mysqli_prepare($con, $query)){
      $r = mysqli_stmt_bind_param($sql, 's', $user);
    }    

    $r = mysqli_stmt_execute($sql);
    if (!$r){
      $result['error'] = 'Query Failed';
      return $result;
    }
    mysqli_stmt_bind_result($sql, $email);
    
    $user_exists = false;
    while (mysqli_stmt_fetch($sql)){  //User exists
      $user_exists = true;
    }

    if ($user_exists){
      $recovery_code = mcrypt_create_iv(32, MCRYPT_DEV_URANDOM);
      $recovery_code = hash('sha256', $recovery_code, false);

      $query = "UPDATE user SET recovery_code=? WHERE username=?";
      if ($sql = mysqli_prepare($con, $query)){
	mysqli_stmt_bind_param($sql, 'ss', $recovery_code, $user);
      }    
      echo 'execute';
      $r = mysqli_stmt_execute($sql);
      

      $link = 'whatsinmyyard.ca/user/passwordrecovery.php?username='.$user.'&code='.$recovery_code;
      $message = "Click on this link to resent your password: ".$link;
      $result = mail($email, 'Password Recovery', $message, 'From: noreply@whatsinmyyard.ca');
    } else {
      $result[error] = "User does not exists";
    }
    return $result;
  }

  function reset_password($user, $password, $code){

    //connect to DB 
    $con=mysqli_connect("localhost","root","chriswei","animal");

    //Generate salt
    $salt = mcrypt_create_iv(32, MCRYPT_DEV_URANDOM);
    $salt = hash('sha256', $salt, false);
    $hashed = hash('sha256', $salt.$password, false);

    //Write to DB
    $query = "UPDATE user SET salt=?, password=? WHERE recovery_code=? AND username=?";
    if ($sql = mysqli_prepare($con, $query)){
      mysqli_stmt_bind_param($sql, 'ssss',$salt, $hashed, $code, $user);
    }    
    $r = mysqli_stmt_execute($sql);
    $r = mysqli_affected_rows($con);

    /*
    $query = "UPDATE user SET salt=?, password=? WHERE recovery_code='2' AND username=?";
    if ($sql = mysqli_prepare($con, $query)){
      mysqli_stmt_bind_param($sql, 'sss', $salt, $hashed, $user);
    }    
    $r = mysqli_stmt_execute($sql);

    */

    if ($r){
      $code = '0';
      //Erase code for future pasword resets
      $query = "UPDATE user SET recovery_code=? WHERE username=?";
      if ($sql = mysqli_prepare($con, $query)){
	mysqli_stmt_bind_param($sql, 'ss', $code, $user);
      }    
      $r1 = mysqli_stmt_execute($sql);
    }

    return $r;
  }
  
  function login($user, $password){
    //connect to DB 
    $con=mysqli_connect("localhost","root","chriswei","animal");

    $result = mysqli_query($con,"SELECT * FROM user WHERE username = '$user'");
    if ($row=mysqli_fetch_row($result)){  
      $salt = $row[3];
      
      // for email verify
     $verified = $row[9];
      
      $hashed = hash('sha256', $salt.$password, false);
      /*
    	if ($hashed == $row[2]){
			$_SESSION['username'] = $row[1];
			$_SESSION['user_id'] = $row[0];
			if($verified != 1){
				}
		mysqli_close($con);
		return(true);
    	}
    	*/
    	
    	if ($hashed == $row[2]){
			if($verified != 1){
				return 2;
			}
			$_SESSION['username'] = $row[1];
			$_SESSION['user_id'] = $row[0];
		mysqli_close($con);
		return(1);
    	}
    }
    
    //CLose DB Connection
    mysqli_close($con);
    return(3);
}

  function add_user($user, $password, $email){
    //connect to DB 
    $con=mysqli_connect("localhost","root","chriswei","animal");
    $return = array();

    //Check if username is taken
    $result = mysqli_query($con,"SELECT * FROM user WHERE username = '$user'");
    while ($row=mysqli_fetch_row($result)){
      $return[error] = 'username';
      mysqli_close($con);
      return($return);
    }

    $salt = mcrypt_create_iv(32, MCRYPT_DEV_URANDOM);
    $salt = hash('sha256', $salt, false);
    $hashed = hash('sha256', $salt.$password, false);
 
// ================   
    $reg_date = date("Y-m-d");
// ================     
    // for email verify
    $hash = md5( rand(0,1000) ); // used for email verify, randomly generated number 
// ================     
    $result = mysqli_query($con, "INSERT INTO user (username, password, salt, email, reputation, user_type, notification, date_registered, hash) VALUES ('$user', '$hashed', '$salt', '$email', 0, 0, 1, '$reg_date', '$hash')");
// ================

	$subject = 'User Email Verification'; // email subject
	// email body
	$message = '
 
Thanks for signing up!
Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.
 
	------------------------
	Username: '.$user.'
	------------------------
 
Please click this link to activate your account: http://www.whatsinmyyard.ca/user/emailverify.php?email='.$email.'&hash='.$hash.'
 
	'; // email body
                     
	$header = 'From: noreply@whatsinmyyard.ca' . "\r\n"; // our email header
	mail($email, $subject, $message, $header); // Send our email

// ================ 
    
    return(true);
    //CLose DB Connection
    mysqli_close($con);
    if ($result){
      return(true);
    } else {
      return(false);
    }
}

  function get_user_info($user){
    //connect to DB 
    $con=mysqli_connect("localhost","root","chriswei","animal");
    $result = mysqli_query($con,"SELECT * FROM user WHERE username = '$user'");
    $return = array();
    if ($row=mysqli_fetch_row($result)){  
      $return['username'] = $row[1];
      $return['email'] = $row[4];
      $return['reputation'] = $row[5];
      $return['user_type'] = $row[6];
      $return['notification'] = $row[7];
      $return['date_registered'] = $row[8];
      mysqli_close($con);
      return($return);
    }
    
    //CLose DB Connection
    mysqli_close($con);
    return(false);
  }

  function modify_user_info($user, $password, $email, $notification){
    //connect to DB 
    $con=mysqli_connect("localhost","root","chriswei","animal");
    $return = array();

    if($password == ''){  //If they are changing something other than the password
      $result = mysqli_query($con, "UPDATE user SET email = '$email', notification = '$notification' WHERE username = '$user'");
    } else {  //If they are changing something including the password
      $salt = mcrypt_create_iv(32, MCRYPT_DEV_URANDOM);
      $salt = hash('sha256', $salt, false);
      $hashed = hash('sha256', $salt.$password, false);

      $result = mysqli_query($con, "UPDATE user SET password = '$hashed', salt = '$salt', email = '$email', notification = 'notification' WHERE username = '$user'");
    }

    //CLose DB Connection
    mysqli_close($con);
    if ($result){
      return(true);
    } else {
      return(false);
    }
  }

}

?>
