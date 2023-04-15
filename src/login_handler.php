<?php
include_once('init.php');
include_once('user.php');
if(($userID = isLoginCorrect($_POST['username'], $_POST['password'])) != -1){

    echo "Login Successful";
	

} else {
	echo "Login Failed";
}

?>
