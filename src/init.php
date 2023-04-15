<?php
  include_once('session.php');
  include_once('connection.php');

  if(isset($_SESSION['ERROR'])){
    $error = $_SESSION['ERROR'];
  	unset($_SESSION['ERROR']);
    
  } else {
  	$error = "";
  }

  if((getUserID() === null || getUsername() === null))
    echo "Login Failed";

?>