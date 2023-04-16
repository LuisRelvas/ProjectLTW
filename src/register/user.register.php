<?php
  declare(strict_types = 1);
  require_once(dirname(__DIR__).'/pages/main.php');
  require_once(dirname(__DIR__).'/pages/user.php');
  require_once(dirname(__DIR__).'/classes/session.class.php');
  $session = new Session();


  $_SESSION['input']['user_id newUser'] = $_SESSION['input']['user_id newUser'] ?? "";
  $_SESSION['input']['username newUser'] = $_SESSION['input']['username newUser'] ?? "";
  $_SESSION['input']['name newUser'] = $_SESSION['input']['name newUser'] ?? "";
  $_SESSION['input']['email newUser'] = $_SESSION['input']['email newUser'] ?? "";
  $_SESSION['input']['password1 newUser'] = $_SESSION['input']['password1 newUser'] ?? "";
  $_SESSION['input']['password2 newUser'] = $_SESSION['input']['password2 newUser'] ?? "";

?>