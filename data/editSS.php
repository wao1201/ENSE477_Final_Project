<?php 
    include ('../header.php'); 
    include ('../secure_page.php');
    include ('../php/phpClass/data_class.php');


     $aname = $_POST['aname'];
     $atime = $_POST['stime'];
     $adate = $_POST['sdate'];
     $latitude = $_POST['latitude'];
     $longitude = $_POST['longitude'];
     $agchoice = $_POST['agchoice'];
     $age = $_POST['age'];
     $aschoice = $_POST['aschoice'];
     $adescription = $_POST['description'];
     $sightingID = $_POST['sightingID'];
     $edit_user = $_SESSION['username'];

     $dataClass = new Data();
     $data = array($aname,$atime,$adate,$latitude,$longitude,$agchoice,$aschoice,$adescription,$age,$edit_user);

     $h = $dataClass->edit_sighting($data, $sightingID);
?>
