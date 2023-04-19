<?php
  declare(strict_types = 1);
  
  require_once(dirname(__DIR__).'/classes/session.class.php');
  $session = new Session();
  require_once(dirname(__DIR__).'/database/connection.db.php');
  require_once(dirname(__DIR__).'/classes/user.class.php');

  $db = getDatabaseConnection();
  $user = User::getUserWithPassword($db, $_POST['email'], $_POST['password']);
  if ($user) {
    $session->setId($user->id);
    $session->setName($user->name);
    $session->addMessage('success', "Login efetuado com sucesso. Bem-vindo de volta, " . $session->getName() . "!");
    header('Location: ../pages/index.php');
    
  } else {
  
    echo "Login inválido, por favor introduz as credencias corretas"; 
    
  }

?>
