<?php
  declare(strict_types = 1);
require_once(dirname(__DIR__).'/templates/common.php');
require_once(dirname(__DIR__).'/templates/user.tlp.php');
require_once(dirname(__DIR__).'/database/connection.db.php');
require_once(dirname(__DIR__).'/classes/session.class.php');
require_once(dirname(__DIR__).'/classes/user.class.php');

  $session = new Session();

  $_SESSION['input']['username newUser'] = $_SESSION['input']['username newUser'] ?? "";
  $_SESSION['input']['name newUser'] = $_SESSION['input']['name newUser'] ?? "";
  $_SESSION['input']['email newUser'] = $_SESSION['input']['email newUser'] ?? "";
  $_SESSION['input']['password1 newUser'] = $_SESSION['input']['password1 newUser'] ?? "";
  $_SESSION['input']['password2 newUser'] = $_SESSION['input']['password2 newUser'] ?? "";
  drawHeader($session);
  if (count($session->getMessages())) drawMessages($session);
  drawRegisterUser();
  drawFooter();
?>