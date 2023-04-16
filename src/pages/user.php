<?php
require_once(dirname(__DIR__).'/pages/main.php');
require_once(dirname(__DIR__).'/classes/session.class.php');
  declare(strict_types = 1);
  $session = new Session();

  $_SESSION['input']['email login'] = $_SESSION['input']['email login'] ?? "";
  $_SESSION['input']['password login'] = $_SESSION['input']['password login'] ?? "";

?>