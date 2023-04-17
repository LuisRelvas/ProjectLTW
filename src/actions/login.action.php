<?php
  declare(strict_types = 1);
  require_once(dirname(__DIR__).'/database/connection.db.php');
  require_once(dirname(__DIR__).'/classes/user.class.php');
  require_once(dirname(__DIR__).'/classes/session.class.php');
  $session = new Session();

  $_SESSION['input']['email login'] = htmlentities($_POST['email']);
  $_SESSION['input']['password login'] = htmlentities($_POST['password']);

  

  $db = getDatabaseConnection();
 
  $user = User::getUserWithPassword($db, $_POST['email'], $_POST['password']);
  if ($user) {
    $_SESSION['name'] = $user->getName();
    unset($_SESSION['input']['email login']);
    unset($_SESSION['input']['password login']);
    echo "Bem vindo de volta " . $user->getName();
  } else {
  
    echo "Login inválido, por favor introduz as credencias corretas"; 
    
  }
?>
