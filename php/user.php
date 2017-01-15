<?php
include ('phpClass/users_class.php');
session_start();

$action = isset($_POST['action']) ? $_POST['action'] : null;
$username = isset($_POST['username']) ? $_POST['username'] : null;
$password = isset($_POST['password']) ? $_POST['password'] : null;
$email = isset($_POST['email']) ? $_POST['email'] : null;
$notification = isset($_POST['notification']) ? $_POST['notification']: null;
$user = new User;

/*
$action = 'recover_password';
$username = 'chris';
$email = 'new@new.new';
$notification = 1;
$password = 'test';
*/

if ($action == 'login'){
  $result = $user->login($username, $password);
  echo json_encode($result);
} else if ($action == 'signup'){
  $result = $user->add_user($username, $password, $email);
  echo json_encode($result);
} else if($action == 'retrieve'){
  $result = $user->get_user_info($_SESSION['username']);
  echo json_encode($result);
} else if($action == 'modify_user'){
  $result = $user->modify_user_info($_SESSION['username'], $password, $email, $notification);
  echo json_encode($result);
} else if($action = 'recover_password'){
  $result = $user->send_recovery_email($username);
  echo json_encode($result);
} else if ($action == ''){
  echo 'problem';
}

?>