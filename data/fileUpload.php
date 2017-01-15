<?php 
include ('../header.php'); 
include ('../secure_page.php');
include ('../php/phpClass/data_class.php');

//Improves csv performace when working on apple producs
ini_set("auto_detect_line_endings", true);
/*
echo "start";
	$dataClass = new Data;
$result = $dataClass->add_sighting(array('Elk','7:00:00','2013-10-10','50.460345','-104.589786', 'Male', 'Alive', 'Eating grass','3 '), 13);
	var_dump($result);
echo "end";
*/
if ($_FILES["file"]["error"] > 0)
  {
    echo "Error: " . $_FILES["file"]["error"] . "<br>";
    if ($_FILES['file']['error']  == 1){
      echo "<p>Upload Fialed: File too large</p>";
    }
  }
else
  {
    echo "<p>Upload: " . $_FILES["file"]["name"] . "<br>";
    echo "Type: " . $_FILES["file"]["type"] . "<br>";
    echo "Size: " . ($_FILES["file"]["size"] / 1024 / 1024) . " MB<br>";
//    echo "Stored in: " . $_FILES["file"]["tmp_name"] . "</p>";

    $file_path = $_FILES["file"]["tmp_name"];

    if ($_FILES['file']['type'] != 'text/csv'){
      echo "<p>Upload Faild: Bad file type or file was too large</p>";
    } else {
      //Get the file
      $dataClass = new Data;
      if(($handle = fopen($file_path, "r")) !== FALSE) {
	$failedEntries = array();
	while (($data = fgetcsv($handle, 1000, ",")) !== False) {
	  $result = $dataClass->add_sighting($data, $_SESSION['user_id']);
	  if(!$result){
	    var_dump($result);
	    array_push($failedEntries, $data);
	  }
	}
	$num = count($failedEntries);
	if($num > 0){
	  echo "<p>The Following $num Failed:</p>";
	  for ($i=0;$i<$num;$i++){
	    $j = $failedEntries[$i];
	    echo"<p>";
	    foreach($j as $k){
	      echo "$k ";
	    }
	    echo"</p>";
	  }
	} else {
	  echo"<br /><p>All submissions were successfuly added<p>";
	}
      } else {
	echo "<p>Trouble Reading File</p>";
      }
      
    }  
    }


?>

