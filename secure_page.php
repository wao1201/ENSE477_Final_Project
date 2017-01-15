<?php
if (!isset($_SESSION['username']))
  {
    header('Location: /user/login.php');
  }
?>