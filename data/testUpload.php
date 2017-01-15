<?php
mysqli_report(MYSQLI_REPORT_ALL);
include ('../php/phpClass/data_class.php');

$aname = 'Delete This';
$atime = '23:23:23';
$adate = '2014-14-14';
$latitude = '50.4121';
$longitude = '-104.58';
$agchoice = 'femail';
$age = '14';
$aschoice = 'Live';
$adescription = 'Test from Test File';
$dest = 'testlocation';

$dataClass = new Data();
$data = array($aname,$atime,$adate,$latitude,$longitude,$agchoice,$aschoice,$adescription,$age,$dest);

$h = $dataClass->add_sighting($data, 15);
var_dump($h);
?>