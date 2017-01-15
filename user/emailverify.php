<?php include ('../header.php'); ?>

<!-- Below is the website main files -->	

<p class="p1"></p>

<?php     
	mysql_connect("localhost","root","chriswei") or die(mysql_error());
	mysql_select_db("animal") or die(mysql_error());
             
	if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])){
	
    // Verify data
    $email = mysql_escape_string($_GET['email']); // get email variable
    $hash = mysql_escape_string($_GET['hash']); // get hash variable
                 
    $search = mysql_query("SELECT email, email_verified, hash FROM user WHERE email='".$email."' AND email_verified='0' AND hash='".$hash."'") or die(mysql_error()); 
    $match  = mysql_num_rows($search);
                 
    	if($match > 0){
        	// get a match, then activate the account
        	mysql_query("UPDATE user SET email_verified='1' WHERE email='".$email."' AND email_verified='0' AND hash='".$hash."'") or die(mysql_error());
        	echo 'Congrats! Your account has been activated. You can now login and contribute to our community.';
    	}
    	else{
        	// invalid url or account has already been activated.
        	echo 'The url is either invalid or you have already activated your account.';
    	}
    }
	else{
    // Invalid approach
    	echo 'Invalid approach, please use the link that has been send to your email address.';
}

?>






</div>
</div>

<!-- Above is the website main files -->

<?php include ('../footer.php'); ?>