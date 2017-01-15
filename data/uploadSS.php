<?php 
    include ('../header.php'); 
    include ('../secure_page.php');
    include ('../php/phpClass/data_class.php');

    $userID=$_SESSION['user_id'];
    $user=$_SESSION['username'];

    $dest_dir="../media/$user/".date(Ymd);
 
    if( !is_dir($dest_dir) || !is_writeable($dest_dir) )
    {

      if(!mkdir($dest_dir, 0777, true))
        die("The expected directory ".$dest_dir." encountered errors");
    }
 
    $type=array("png","jpg","jpeg");
 
    $upfile=$_FILES['file'];

if($_FILES['file']['name'] != NULL)
{
 
    function fileext($filename)
    {
        return substr(strrchr($filename, '.'), 1);
    }
 
    if( !in_array( strtolower( fileext($upfile['name'] ) ),$type) )
     {
        $text=implode(",",$type);
        echo "Sorry, you cannot upload this file type: ",$text;
     }
     else
     {
        $dest=$dest_dir.'/'.date("His")."_".$upfile['name'];
 
        $state=move_uploaded_file($upfile['tmp_name'],$dest);
 
        if ($state)
        {
	  //Do nothing
        }
        else
        {
            switch($upfile['error'])
            {
                case 1 : die("File size is larger than php.ini: upload_max_filesize");
                case 2 : die("File is too large");
                case 3 : die("Only part of file has been uploaded");
                case 4 : die("No file has been uploaded");
                case 5 : die("Cannot find the expected directory");
                case 6 : die("File cannot be written");
            }
        }
     }
}

$aname = $_POST['aname'];
$atime = $_POST['atime'];
$adate = $_POST['adate'];
$latitude = $_POST['latitude'];
$longitude = $_POST['longitude'];
$agchoice = $_POST['agchoice'];
$age = $_POST['age'];
$aschoice = $_POST['aschoice'];
$adescription = $_POST['adescription'];

$valid_date = true;

if(empty($aname)){
  echo("Please enter a name.  ");
  $valid_date = false;
}
if(empty($atime)){
  print("Please enter a time.  ");
  $valid_date = false;
}
if(empty($adate)){
  print("Please enter a date.  ");
  $valid_date = false;
}

if($valid_date){
  $dataClass = new Data();
  $data = array($aname,$atime,$adate,$latitude,$longitude,$agchoice,$aschoice,$adescription,$age,$dest);
  
  $h = $dataClass->add_sighting($data, $userID);

  if($h){
    print("Thanks for your contribution!");
  } else {
    print("There was a problem with the upload.  Please visit the help page for assisance");
  }
}

?>
