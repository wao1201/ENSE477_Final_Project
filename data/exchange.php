<?php 
    include ('../header.php'); 
    include ('../secure_page.php');
include ('../php/phpClass/users_class.php');

$userID=$_SESSION['user_id'];

$userClass = new User();
$result = $userClass->get_user_info($user);
$user_type = $result['user_type'];

if($user_type == 1){
  //Do nothing
} else {
  die("You cannot upload files without being a power user");
}

?>

<link href="../css/csvUP.css" rel="stylesheet" type="text/css" />
<!--<script src='../js/exchange.js'></script>-->

<!-- Below is the website main files -->	

<p class="p1">

<fieldset>
    <legend>Bulk Data Upload</legend>
	<form action="fileUpload.php" id="fileUpload" name="fileUpload" enctype="multipart/form-data" method="POST">
    <br />
    
    <p>
    <label for="bulk data" class="label">Data File:</label>
	<input type="file" name="file" id="file">
	</p>
	<br />

    <p>
    <input type="submit" name="submit" value="Upload" class="bdleft" />
    </p>
    <br />

    </form>
    </fieldset>
    <div align="center">
	The maximum CSV file size we accept is 7MB. It will take a while to load on our server.
	</div>
				
</p>



</div>
</div>

<!-- Above is the website main files -->

<?php include ('../footer.php'); ?>