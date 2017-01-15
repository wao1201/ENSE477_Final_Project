<?php
	include("../php/rate_con.php");
	session_start();

	$user = $_SESSION['username'];
	
	if($user != ""){
		if($_POST['id']){
			$id = $_POST['id'];
			$id = mysql_escape_String($id);

			//Verify username in rating_ip table
			$ip_sql=mysql_query("SELECT bind_user FROM rating_ip WHERE sig_id_fk='$id' AND bind_user='$user'");
			$count=mysql_num_rows($ip_sql);

			if($count==0){
				// update rating
				$sql = "UPDATE sighting SET rating_up=rating_up+1 WHERE sighting_id='$id'";
				mysql_query( $sql);
				// insert user who rate it and sighting id in rating_ip table
				$sql_in = "INSERT INTO rating_ip (sig_id_fk, bind_user) values ('$id', '$user')";
				mysql_query( $sql_in);
				echo "<script>alert('Thanks for rating this sighting');</script>";
			}
			else{
				echo "<script>alert('You have already rated for this sighting');</script>";
			}

			$result = mysql_query("SELECT rating_up FROM sighting WHERE sighting_id='$id'");
			$row = mysql_fetch_array($result);
			$up_value = $row['rating_up'];
			echo $up_value;	
		}
	}
	else{
		echo "<script>alert('You need login to rate');</script>";
	}
?>