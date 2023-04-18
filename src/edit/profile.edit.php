<?php
  declare(strict_types = 1);
  require_once(dirname(__DIR__).'/database/connection.db.php');
  require_once(dirname(__DIR__).'/classes/user.class.php');
  require_once(dirname(__DIR__).'/pages/common.php');
  require_once(dirname(__DIR__).'/templates/user.tlp.php');
  require_once(dirname(__DIR__).'/classes/session.class.php');
  $session = new Session();
  
  if (!$session->isLoggedIn()) {
    $session->addMessage('error', "Não tem permissão para editar este perfil");
    die(header('Location: ../pages/denied.php'));
  } 

  $db = getDatabaseConnection();
  $user = User::getUser($db, $_SESSION['id']);

  $_SESSION['input']['nome oldUser'] = $_SESSION['input']['nome oldUser'] ?? $user->name;
  $_SESSION['input']['username oldUser'] = $_SESSION['input']['username oldUser'] ?? $user->username;
  $_SESSION['input']['email oldUser'] = $_SESSION['input']['email oldUser'] ?? $user->email;
  $_SESSION['input']['password1 oldUser'] = $_SESSION['input']['password1 oldUser'] ?? "";
  $_SESSION['input']['password2 oldUser'] = $_SESSION['input']['password2 oldUser'] ?? "";

  drawHeader();
  if (count($session->getMessages())) drawMessages($session);
  drawEditUserForm(); 
?>