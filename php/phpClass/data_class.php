<?php
class Data {

  function write_to_CSV($result){
    $userID=$_SESSION['user_id'];
    $user=$_SESSION['username'];

    $dest_dir= "/var/www/html/media/downloads/".$user."/";
     
    if( !is_dir($dest_dir) || !is_writeable($dest_dir) )
    {
      if(!mkdir($dest_dir, 0777, true))
        die("The expected directory ".$dest_dir." encountered errors");
    }

    $fp = fopen($dest_dir.'export.csv', 'w');

    foreach($result as $r){
      fputcsv($fp, $r);
    }
    
    fclose($fp);
    return true;
  }

  function get_common_name(){
    $con=mysqli_connect("localhost","root","chriswei","animal");

    if ($sql = mysqli_prepare($con, 'SELECT common_name FROM animal')){
    }    

    $r = mysqli_stmt_execute($sql);
    
    mysqli_stmt_bind_result($sql, $names);

    //Puts results into an array so they can be passed nicly as JSON data
    $result = array();
    while (mysqli_stmt_fetch($sql)){
      array_push($result, $names);
    }
    return($result);
    mysqli_close($con);
  }
  
  //function to get sighting's creator
  function get_creatorID($sightingID){
  	$con=mysqli_connect("localhost","root","chriswei","animal");  
    if($sql = mysqli_prepare($con, "SELECT user_id FROM sighting WHERE sighting_id = ?")){
      mysqli_stmt_bind_param($sql, 'i', $sightingID);
    }
    mysqli_stmt_execute($sql);
    mysqli_stmt_bind_result($sql, $result);
    $userID;
    if (mysqli_stmt_fetch($sql)){
      $userID = $result;
    }
    mysqli_stmt_free_result($sql);
    return($userID);
    mysqli_close($con);
  }


  function get_data($user, $common_name, $sex, $rating, $start_date, $end_date, $start_time, $end_time){

    $string = 'ssss';
    if($common_name == 'all'){
      $common_name = 'a.common_name';
      $string .= 'i';
    } else {
      $string .= 's';
    }

    if($sex == 'all'){
      $sex = 's.sex';
      $string .= 'i';
    } else {
      $string .= 's';
    }

    if($user == null){
      $user = 'u.username';
      $string .= 'i';
    } else {
      $string .= 's';
    }

    $string .='i';  //This is for rating

    $con=mysqli_connect("localhost","root","chriswei","animal");
    $query = 'SELECT a.common_name, s.time, s.date, s.sex, s.status, s.description, s.age, s.image, u.username, s.lat, s.lon, s.sighting_id, s.date_created, s.date_edited, s.edited_by FROM sighting AS s JOIN animal AS a ON s.animal_id = a.animal_id JOIN user AS u ON u.user_id = s.user_id WHERE ? <= s.date AND s.date <= ? AND ? <= s.time AND s.time <= ? AND a.common_name = ? AND s.sex = ? AND u.username = ? AND s.rating_up-s.rating_down >= ?';

      if ($sql = mysqli_prepare($con, $query)){
	mysqli_stmt_bind_param($sql, $string , $start_date, $end_date, $start_time, $end_time, $common_name, $sex, $user, $rating);
      }    

    $r = mysqli_stmt_execute($sql);

    mysqli_stmt_bind_result($sql, $animal, $time, $date, $sex, $status, $description, $age, $image, $user, $lat, $lon, $sightingID, $date_created, $date_edited, $edited_by);

    //Puts results into an array so they can be passed nicly as JSON data
    $result = array();
    while (mysqli_stmt_fetch($sql)){
	array_push($result, array($animal, $time, $date, $sex, $status, $description, $age, $image, $user, $sightingID, $lat, $lon, $date_created, $date_edited, $edited_by));
    }

    return($result);
    mysqli_close($con);
  }

  //Note the requried data and time format by mySQL (Date: yyyy-mm-dd, Time: hh:mm:ss)
  function add_sighting($data, $userID){
    mysqli_report(MYSQLI_REPORT_OFF);
    //connect to DB 
    $con=mysqli_connect("localhost","root","chriswei","animal");
    
    $data[0] = strtolower($data[0]);//Ensure name is in lowercase

    // check if the animal exist in DB
    if ($sql = mysqli_prepare($con, "SELECT animal_id FROM animal WHERE common_name=?")){
      mysqli_stmt_bind_param($sql, 's', $data[0]);
    }
    mysqli_stmt_execute($sql);
    mysqli_stmt_bind_result($sql, $result);
    
    //if the animal does not exist in the database add it
    if (mysqli_stmt_fetch($sql)){
      $r = true;
    } else {
      if($sql = mysqli_prepare($con, "INSERT INTO animal(common_name) VALUES(?)")){
	mysqli_stmt_bind_param($sql, 's', $data[0]);
      }
      $r = mysqli_stmt_execute($sql);
    }
	// error check
    if(!$r){
      return (false);
    }
    mysqli_stmt_free_result($sql);

    //how retireve the id of the animal
    if($sql = mysqli_prepare($con, "SELECT animal_id FROM animal WHERE common_name=?")){
      mysqli_stmt_bind_param($sql, 's', $data[0]);
    }

    mysqli_stmt_execute($sql);
    mysqli_stmt_bind_result($sql, $result);
    $animalID;
    date_default_timezone_set('America/Swift_Current');
    $create_date = date("Y-m-d"); // set create date for sighting
    //if the animal does not exist in the database add it
    if (mysqli_stmt_fetch($sql)){
      $animalID = $result;
    }
    mysqli_stmt_free_result($sql);
// added: now will add sighting create date to DB
    $r1 = "before";
    //    var_dump($data);
    //    mysqli_report(MYSQLI_REPORT_ALL);
    if( isset($data[9]) ){
      //      echo "image";
      if ($sql = mysqli_prepare($con, "INSERT INTO sighting(animal_id,user_id,time,date,lat,lon,sex,status,description,age,image,date_created) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)")){
	mysqli_stmt_bind_param($sql, 'iissddssssss', $animalID,$userID,$data[1],$data[2],$data[3],$data[4],$data[5],$data[6],$data[7],$data[8],$data[9],$create_date);
      }
    } else {
      //      echo "no image";
      if ($sql = mysqli_prepare($con, "INSERT INTO sighting(animal_id,user_id,time,date,lat,lon,sex,status,description,age,date_created) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)")){
	//        echo "sql sucess";
	mysqli_stmt_bind_param($sql, 'iissddsssss', $animalID,$userID,$data[1],$data[2],$data[3],$data[4],$data[5],$data[6],$data[7],$data[8],$create_date);
      }
  }
    //    var_dump($sql);
    $r = mysqli_stmt_execute($sql);
    mysqli_close($con);
    return($r);
    
  }//end add_sighting

  function edit_sighting($data, $sightingID){
  
  	$con=mysqli_connect("localhost","root","chriswei","animal");
  	
  	// check if the animal exist in DB
    if ($sql = mysqli_prepare($con, "SELECT animal_id FROM animal WHERE common_name=?")){
      mysqli_stmt_bind_param($sql, 's', $data[0]);
    }
    mysqli_stmt_execute($sql);
    mysqli_stmt_bind_result($sql, $result);
    
    //if the animal does not exist in the database add it
    if (mysqli_stmt_fetch($sql)){
      $r = true;
    } else {
      if($sql = mysqli_prepare($con, "INSERT INTO animal(common_name) VALUES(?)")){
	mysqli_stmt_bind_param($sql, 's', $data[0]);
      }
      $r = mysqli_stmt_execute($sql);
    }
	// error check
    if(!$r){
      return (false);
    }
    mysqli_stmt_free_result($sql);

    //how retireve the id of the animal
    if($sql = mysqli_prepare($con, "SELECT animal_id FROM animal WHERE common_name=?")){
      mysqli_stmt_bind_param($sql, 's', $data[0]);
    }

    mysqli_stmt_execute($sql);
    mysqli_stmt_bind_result($sql, $result);
    $animalID;
    //if the animal does not exist in the database add it
    if (mysqli_stmt_fetch($sql)){
      $animalID = $result;
    }
    mysqli_stmt_free_result($sql);
  	
  	//mySQL update * where sighting_id  = $sighitngID
  	$sql = "UPDATE sighting SET animal_id=?, time=?, date=?, lat=?, lon=?, sex=?, status=?, description=?, age=?, edited_by=?, date_edited=? WHERE sighting_id=?";
  	$stmt = $con->prepare($sql);
  	$edited_date = date("Y-m-d");
  	$stmt->bind_param('issddssssssi', $animalID, $data[1], $data[2], $data[3], $data[4], $data[5], $data[6], $data[7], $data[8], $data[9], $edited_date, $sightingID);	
  	$stmt->execute();
	
	//reset filter for rating table
	$sql = "DELETE FROM rating_ip WHERE sig_id_fk = ? AND bind_user = ?";
	$stmt = $con->prepare($sql);
	$user=$_SESSION['username'];
	$stmt->bind_param('is', $sightingID, $user);
	$stmt->execute();

	if ($stmt->errno) {
  		echo "FAILURE!!! " . $stmt->error();
	}
	else 
		echo "Thanks, this sighting has been updated.";
	$stmt->close();
  	
  }//End edit_sighting


}//end class

?>