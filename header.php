<?php
include ('constants.php');
session_start();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head profile="http://www.w3.org/2005/10/profile">
<link rel="icon" 
      type="image/png" 
      href="/images/favicon.ico">
      
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>What's in My Yard? - Regina Urban Wildlife Watcher</title>

<link href="/css/style.css" rel="stylesheet" type="text/css" />
<link href="/css/layout.css" rel="stylesheet" type="text/css" />

<script src="/js/jquery-2.0.3.min.js"></script>

</head>

<body>
	<div id="header_tall">
		<div id="main">
		
			<div id="header">
				<div class="h_logo">
						<div class="left">
						<a href="/index.php"><img src="/images/header/logo_banner.png"></a><br />
					</div>
					<div class="right">
					
<?php 
//Checks if user is logged in and displays information accordingly
if(isset($_SESSION['username'])){
    echo "Welcome: ".$_SESSION['username'];     //Probably want the user name to link to the profile page eventualy
    echo '<br /><a href="/user/login.php?action=logout">Logout</a>';   //Just takes you to the home page right now
} else {
    echo '<a href="/user/login.php">Sign In</a> <a href="/user/signup.php">Sign Up</a>';
}
?>

                    </div>
					<div class="clear"></div>
				</div>
				<div id="menu">
					<div class="rightbg">
						<div class="leftbg">
							<div class="padding">
								<ul>
									<li><a href="/data/submit.php">Submit Sightings</a></li>
									<li><a href="/data/table.php">Explore Sightings</a></li>
									<li><a href="/data/exchange.php">CSV Upload</a></li>
									<li><a href="/user/yard.php">My Account</a></li>
									<li><a href="/help.php">Help</a></li>
									<li class="last"><a href="/about.php">About</a></li>
								</ul>
								<br class="clear" />
							</div>
						</div>
					</div>
				</div>
	
			<div id="middle">
				<div class="indent">
<!--					<img alt="" src="/images/header/7-t1.gif" /><br />  -->

<!-- Above is the website hearder file -->			