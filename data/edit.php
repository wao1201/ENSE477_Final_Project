<?php 
    include ('../header.php'); 
    include ('../secure_page.php');
    include ('../php/phpClass/users_class.php');
    include ('../php/phpClass/data_class.php');
    
    $user = $_SESSION['username'];
    $userID=$_SESSION['user_id'];
    
    $sighting_id = $_GET['sightingID'];
	$sighting_time = $_GET['time'];
	$sighting_date = $_GET['date'];
	$lat = $_GET['lat'];
	$lon = $_GET['lon'];
	$animal_name = $_GET['aname'];
	$animal_sex = $_GET['sex'];
	$animal_age = $_GET['age'];
	$animal_status = $_GET['status'];
	$description = $_GET['descrip'];
    
    // get user type   
    $userClass = new User();
	$result = $userClass->get_user_info($user);
	$user_type = $result['user_type'];
	// get userID of this sighting's creator
	$dataClass = new Data();
	$creatorID = $dataClass->get_creatorID($sighting_id);
    
    if($user_type == 1 || $userID == $creatorID){
     // do nothing
    }
    else {
    	die("You cannot edit this sighting because you are not power user or creator of this sighting.");
    }

?>

<link href="../css/uploadSS.css" rel="stylesheet" type="text/css" />

<link rel="stylesheet" type="text/css" media="all" href="../css/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="../js/jsDatePick.min.1.3.js"></script>
<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"datePik",
			dateFormat:"%Y-%m-%d"
		});
	};
</script>

<script type="text/javascript" src="../js/ngtime/ng_all.js"></script>
<script type="text/javascript" src="../js/ngtime/ng_ui.js"></script>
<script type="text/javascript" src="../js/ngtime/components/timepicker.js"></script>
<script type="text/javascript">
ng.ready( function() {
    var my_timepicker = new ng.TimePicker({
        input:'timepicker',
        format:'H:i',
        server_format:'H:i',
        use24:true,
        start:'00:00 am'
    });
});
</script>

<script src="../js/jquery-2.0.3.min.js"></script>
<script src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>

<link rel="stylesheet" type="text/css" href="../css/jquery-gmaps-latlon-picker.css"/>
<script src="../js/jquery-gmaps-latlon-picker.js"></script>

<!-- Below is the website main files -->

<p class="p1">

<fieldset id="submit">
    <legend>Update Sighting Detail</legend>
    <form action="editSS.php" id="editSS" name="editSS" enctype="multipart/form-data" method="POST">
    <br />
  
    <p>
    <label for="animalname" class="label">Animal Name:</label>
    <input type="text" name="aname" class="input" value="<?php echo $animal_name; ?>"/>
    </p>
    <br />
    
    <p>
    <label for="sightingtime" class="label">Time:</label>
    <input type="text" name="stime" class="input" value="<?php echo $sighting_time; ?>" id="timepicker" />
    </p>
    <br />

    <p>
    <label for="sightingdate" class="label">Date:</label>
    <input type="text" name="sdate" class="input" value="<?php echo $sighting_date; ?>" id="datePik" />
    </p>
    <br />
    
    <p>
    <label for="sightinglocation" class="label">Location:</label>
    <fieldset id = "map" class="gllpLatlonPicker">
    	<div class="gllpMap">Google Maps</div>
    	<input type="hidden" name="latitude" class="gllpLatitude" value="<?php echo $lat; ?>"/>
    	<input type="hidden" name="longitude" class="gllpLongitude" value="<?php echo $lon; ?>"/>
    	<input type="hidden" class="gllpZoom" value="13"/>
	</fieldset>
    </p>
    <br />

    <p>
    <label for="animalgender" class="label">Animal Gender:</label>
    <input type="radio" name="agchoice" value="Male" <?php echo ($animal_sex=='Male')?'checked':'' ?> />Male
	<input type="radio" name="agchoice" value="Female" <?php echo ($animal_sex=='Female')?'checked':'' ?> style="margin-left:20px;"/>Female
	<input type="radio" name="agchoice" value="Unknown" <?php echo ($animal_sex=='Unknown')?'checked':'' ?> style="margin-left:20px;"/>Not Sure
    </p>
    <br />
    
    <p>
    <label for="animalage" class="label">Animal Age:</label>
    <input type="text" name="age" placeholder="Do you know its age?" class="input" value="<?php echo $animal_age; ?>"/>
    </p>
    <br />

    <p>
    <label for="animalstatus" class="label">Animal Status:</label>
    <input type="radio" name="aschoice" value="Live" <?php echo ($animal_satus=='Live')?'checked':'' ?> />Live
	<input type="radio" name="aschoice" value="Dead" <?php echo ($animal_status=='Dead')?'checked':'' ?> style="margin-left:25px;"/>Dead
    </p>
    <br />

    <p>
    <label for="sightingdescription" class="label">Description:</label>
    <textarea name="description" rows="5" cols="10" class="textarea" ><?php echo $description; ?></textarea>
    </p>
    <br />

    <p>
    <input type="hidden" name="sightingID" value="<?php echo $sighting_id; ?>" />
    <input type="submit" name="submit" value="Update" class="ssleft" />
    </p>
    <br />

    </form>
    </fieldset>

</p>



</div>
</div>

<!-- Above is the website main files -->

<?php include ('../footer.php'); ?>