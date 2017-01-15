<?php
include ('../header.php');
include ('../php/phpClass/users_class.php');
?>

<!-- Below is the website main files -->	

<?php

$code = isset($_GET['code']) ? $_GET['code'] : null;
$username = isset($_GET['username']) ? $_GET['username'] : null;

$password = mcrypt_create_iv(8, MCRYPT_DEV_URANDOM);
$password = hash('crc32', $password, false);

$userOBJ = new User;

$result = $userOBJ->reset_password($username, $password, $code);

if($result == 1){
  echo "Here is your new password.  Once you have logged in you can change it to something more meaningfull: ";
  echo $password;
} else {
  echo 'This has already been used to reset a password.  Please click "forgot my password" again on the login page to resend anoth email';
}

?>


<p class="p1">

</p>

<!-- Above is the website main files -->

<?php include ('../footer.php'); ?>