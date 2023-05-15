<?php
  declare(strict_types = 1);
  require_once(dirname(__DIR__).'/templates/common.php');
  require_once(dirname(__DIR__).'/classes/session.class.php');
  $session = new Session();

  drawHeader($session);
  if (count($session->getMessages())) drawMessages($session);
  drawLogin();
  drawFooter();
?>