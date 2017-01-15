<?php
  include ('../header.php');
if (isset($_GET['action'])){
  if ($_GET['action']=='logout'){
    unset($_SESSION['username']);
    unset($_SESSION['user_id']);
    //The JS below causes a refresh so that the users information is not longer displayed anywhere
?>
      <script>	 window.location = "/index.php";  </script>
    <?php
	}
}

?>
<script src='../js/login.js'></script>
 
<!-- form style from old version -->
  <style type="text/css">
	fieldset{width:520px; margin: 0 auto;}
	legend{font-weight:bold; font-size:14px;}
	label{float:left; width:70px; margin-left:10px;}
	.lleft{margin-left:80px;}
	.input{width:150px;margin-left:5px}
  </style>

    <div>
      <fieldset>
	<legend>User Login</legend>
	<form id='LoginForm' name="LoginForm" method="post">
	<br/>
	  <p>
	    <label for="username" class="label">Username:</label>
	    <input id="username" name="username" type="text" class="input" />
	  <p/>
	  <br/>
	  <p>
	    <label for="password" class="label">Password:</label>
	    <input id="password" name="password" type="password" class="input" />
	  <p/>
	  <br/>
	  <p>
	    <input type="submit" name="submit" value="Log In" class="lleft" />
	    <input type="button" name="forgot" id="forgot" value="Forgot My Password" />
	    <a href="signup.php">Sign up for contribution</a>
	  </p>
	  <br/>
	</form>
      </fieldset>
    </div>
 
<!-- -->  

<?php include ('../footer.php'); ?>
    
