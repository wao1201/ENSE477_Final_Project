<?php 
    include ('../header.php'); 
    include ('../secure_page.php');
?>

<link href="../css/uploadSS.css" rel="stylesheet" type="text/css" />

<link rel="stylesheet" type="text/css" media="all" href="../css/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="../js/jsDatePick.min.1.3.js"></script>
<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"datePikr",
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
    <legend>Upload Single Sighting</legend>
    <form action="uploadSS.php" id="uploadSS" name="uploadSS" enctype="multipart/form-data" method="POST">
    <br />
    
    <p>
    <label for="sighting photo" class="label">Sighting Photo:</label>
	<input type="file" name="file">
	</p>
	<br />
    
    <p>
    <label for="animalname" class="label">Animal Name:</label>
    <input type="text" name="aname" placeholder="What did you see?" class="input" />
    </p>
    <br />
    
    <p>
    <label for="sightingtime" class="label">Time:</label>
    <input type="text" name="atime" placeholder="What time did you see it?" class="input" id="timepicker" />
    </p>
    <br />

    <p>
    <label for="sightingdate" class="label">Date:</label>
    <input type="text" name="adate" placeholder="Which day did you see it?" class="input" id="datePikr" />
    </p>
    <br />

    <p>
    <label for="sightinglocation" class="label">Location: <br /><br /> Drag the red marker or double click the map to select your location.</label>
    <fieldset id = "submit_map" class="gllpLatlonPicker">
    	<div class="gllpMap">Google Maps</div>
    	<input type="hidden" name="latitude" class="gllpLatitude" value="50.4547"/>
    	<input type="hidden" name="longitude" class="gllpLongitude" value="-104.607"/>
    	<input type="hidden" class="gllpZoom" value="11"/>
	</fieldset>
    </p>
    <br />

    <p>
    <label for="animalgender" class="label">Animal Gender:</label>
    <input type="radio" name="agchoice" value="Male" />Male
	<input type="radio" name="agchoice" value="Female" style="margin-left:20px;"/>Female
	<input type="radio" name="agchoice" value="Unknown" checked="checked" style="margin-left:20px;"/>Not Sure
    </p>
    <br />
    
    <p>
    <label for="animalage" class="label">Animal Age:</label>
    <input type="text" name="age" placeholder="Do you know its age?" class="input" />
    </p>
    <br />

    <p>
    <label for="animalstatus" class="label">Animal Status:</label>
    <input type="radio" name="aschoice" value="Live" checked="checked"/>Live
	<input type="radio" name="aschoice" value="Dead" style="margin-left:25px;"/>Dead
    </p>
    <br />

    <p>
    <label for="sightingdescription" class="label">Description:</label>
    <textarea name="adescription" rows="5" cols="10" class="textarea" placeholder="Please leave some description about your sighting here."></textarea>
    </p>
    <br />

    <p>
    <input type="submit" name="submit" value="Upload" class="ssleft" />
    </p>
    <br />

    </form>
    </fieldset>
			
</p>



</div>
</div>

<!-- Above is the website main files -->

<?php include ('../footer.php'); ?>