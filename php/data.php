<?php
include ('phpClass/data_class.php');
session_start();  //Uncomment this line

$action = isset($_POST['action']) ? $_POST['action'] : null;
$common_name = isset($_POST['common_name']) ? $_POST['common_name'] : 'all';
$sex = isset($_POST['sex']) ? $_POST['sex'] : 'all';
//$user = isset($_POST['user']) ? $_POST['user'] : $_SESSION['username'];
$user = isset($_POST['user']) ? $_POST['user'] : null;
$rating = isset($_POST['rating']) ? $_POST['rating'] : 0;
$start_date = isset($_POST['start_date']) ? $_POST['start_date'] : '1000-01-01';
$end_date = isset($_POST['end_date']) ? $_POST['end_date'] : '9999-12-31';
$start_time = isset($_POST['start_time']) ? $_POST['start_time'] : '00:00:00';
$end_time = isset($_POST['end_time']) ? $_POST['end_time'] : '23:59:59';

$data = new Data;

/*
$action = 'get_data';
$start_date = '1000-01-01';
$end_date = '9999-12-31';
$start_time = '00:00:00';
$end_time = '23:59:59';
//$user = 'emma';
$common_name = "all";
*/
//error_reporting(E_ALL);
if ($action == 'get_data'){  
  $result = $data->get_data($user, $common_name, $sex, $rating, $start_date, $end_date, $start_time, $end_time);
  if (isset($_SESSION['username'])){
    $data->write_to_CSV($result);
  }
  echo json_encode($result);
} elseif ($action == 'get_common_name'){
  $result = $data->get_common_name();
  echo json_encode($result);
} elseif ($action == 'download_CSV'){
  if (isset($_SESSION['username'])){
    $path = '../media/downloads/'.$_SESSION['username'].'/export.csv';
  } else {
    $path = false;
  }
  echo json_encode($path);
}

?>