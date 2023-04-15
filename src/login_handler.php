<?php
include_once('init.php');
include_once('user.php');
if(($user_id = isLoginCorrect($_POST['username'], $_POST['password'])) != -1){

    setCurrentUser($user_id, $_POST['username']);
    header('Location: register.php');
	

} else {
	echo "1234";
}

?>
