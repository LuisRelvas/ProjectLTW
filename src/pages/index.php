<?php
  declare(strict_types = 1);
  require_once('../pages/common.php');
  require_once('../database/connection.db.php');
  require_once(dirname(__DIR__).'/classes/session.class.php');
  $session = new Session();

  $db = getDatabaseConnection();
  if (count($session->getMessages())) drawMessages($session);
  drawHeader();
  drawBanner();
  
?>