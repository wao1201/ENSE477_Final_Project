<?php 
    include ('../header.php'); 
    //include ('../secure_page.php');
    include ('../php/phpClass/data_class.php');
    include ('../php/rate_con.php');
?>

<link href="../css/sighting.css" rel="stylesheet" type="text/css" />
<link href="../css/rating.css" rel="stylesheet" type="text/css" />

<script src="../js/jquery-2.0.3.min.js"></script>
<script type="text/javascript">
$(function() {
	$(".rate").click(function() {
		var id = $(this).attr("id");
		var name = $(this).attr("name");
		var dataString = 'id='+ id ;
		var parent = $(this);
		if(name=='up'){
			$.ajax({
   			type: "POST",
   			url: "../data/rate_up.php",
   			data: dataString,
   			cache: false,
   			dataType : "html",
   			success: function(html)
   			{
    			$("#up_rate").html(html);
  			}  });
  		}
		else
		{
			$.ajax({
   			type: "POST",
   			url: "../data/rate_down.php",
   			data: dataString,
   			cache: false,
   			dataType : "html",
   			success: function(html)
   			{
    	   		$("#down_rate").html(html);
  			}	});
		}  
		return false;
	});
});
</script>

<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>

<?php
	$animal_name = $_GET['common_name'];
	$sighting_time = $_GET['time'];
	$sighting_date = $_GET['date'];
	$animal_sex = $_GET['sex'];
	$animal_status = $_GET['status'];
	$description = $_GET['description'];
	$animal_age = $_GET['age'];
	$image_path = $_GET['image'];
	$username = $_GET['user'];
	$lat = $_GET['lat'];
	$lon = $_GET['lon'];
	$sighting_id = $_GET['sightingID'];
	$create_date = $_GET['date_created'];
	$edit_date = $_GET['date_edited'];
	$edit_user = $_GET['edited_by'];
	
	$sql=mysql_query("SELECT * FROM sighting WHERE sighting_id = '$sighting_id'");
	while($row=mysql_fetch_array($sql)){
		$up=$row['rating_up'];
		$down=$row['rating_down'];
	}	
?>

<script type="text/javascript">
	$(document).ready(function () {
		var latitude = parseFloat(<?php echo $lat; ?>);
		var longitude = parseFloat(<?php echo $lon; ?>);
		var latlngPos = new google.maps.LatLng(latitude, longitude);
		var myOptions = {
			zoom: 14,
			center: latlngPos,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		};
		map = new google.maps.Map(document.getElementById("map"), myOptions);			
		var marker = new google.maps.Marker({
			position: latlngPos,
			map: map,
			title: "Sighting Location"
		});
	});
</script>

<p class="p1">
<fieldset>
<legend>Sighting Detail</legend>
<div id="scroll_detail" style="overflow-y:auto; height:600px;">
 <table>
    <tr>
    	<td>Sighting Photo:</td>
    	<td> <?php 
    	if($image_path == 'null')
    	{
    		echo 'No photo for this sighting!';
    	}
    	else
    	{
    		echo '<a href='.$image_path.'><img src='.$image_path.' width="50%">' ;
    	}
    	?> </td>
    </tr>
    <tr>
    	<td>Sighting Time:</td>
    	<td><?php echo $sighting_time ?></td>
    </tr>
    <tr>
    	<td>Sighting Date:</td>
    	<td><?php echo $sighting_date ?></td>
    </tr>
    <tr>
    	<td>Sighting Location:</td>
    	<td>
    	<div id="map"></div>
    	</td>
    </tr>
	<tr>
 		<td>Animal Name:</td>
 		<td><?php echo $animal_name ?></td>
    </tr>
    <tr>
    	<td>Animal Sex:</td>
    	<td><?php echo $animal_sex ?></td>
    </tr>
    <tr>
    	<td>Animal Age:</td>
    	<td><?php echo $animal_age ?></td>
    </tr>
    <tr>
    	<td>Animal Status:</td>
    	<td><?php echo $animal_status ?></td>
    </tr>
    <tr>
    	<td>Sighting Description:</td>
    	<td><?php echo $description ?></td>
    </tr>
    <tr>
    	<td>Uploaded by:</td>
    	<td><?php echo $username ?></td>
    </tr>
	<tr>
    	<td>Uploaded on:</td>
    	<td><?php echo $create_date ?></td>
    </tr>
    <tr>
    	<td>Rate this sighting: </td>
    	<td>
    	<div class="box">
			<a href="" class="rate" id="<?php echo $sighting_id; ?>" name="up"><img src="../images/rating/good.jpg" width="40%">
			<span id="up_rate"><?php echo $up; ?></span></a>
		</div>
		<div class="box">
			<a href="" class="rate" id="<?php echo $sighting_id; ?>" name="down"><img src="../images/rating/bad.jpg" width="40%">
			<span id="down_rate"><?php echo $down; ?></span></a>
		</div>
    	</td>
    </tr>  
    <tr>
    	<td>Power user can: </td>
    	<td>
		<?php
		echo '<a href="edit.php?sightingID='.$sighting_id.'&time='.$sighting_time.'&date='.$sighting_date.'&lat='.$lat.'&lon='.$lon.'&aname='.$animal_name.'&sex='.$animal_sex.'&age='.$animal_age.'&status='.$animal_status.'&descrip='.$description.' ">Click here to update this sighting</a>';
		?>
		</td>
    </tr>
	<tr>
    	<td>Last edited by:</td>
    	<td><?php echo $edit_user ?></td>
    </tr>
	<tr>
    	<td>Last edited on:</td>
    	<td><?php echo $edit_date ?></td>
    </tr>
    </table>
</div>
</fieldset>

</p>


</div>
</div>

<!-- Above is the website main files -->

<?php include ('../footer.php');