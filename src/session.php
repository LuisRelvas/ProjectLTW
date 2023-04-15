<?php
    session_start();
    function setCurrentUser($user_id, $username) {
    	$_SESSION['username'] = $username;
    	$_SESSION['user_ID'] = $user_id;
   }

   function getUserID() {
       if(isset($_SESSION['user_id'])) {
            return $_SESSION['user_id'];
       } else {
           return null;
       }

   }

   function getUsername() {
    if(isset($_SESSION['username'])) {
         return $_SESSION['username'];
    } else {
        return null;
    }

}
?>