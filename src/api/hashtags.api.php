<?php
  declare(strict_types = 1);
  require_once(dirname(__DIR__).'/database/connection.db.php');
  require_once(dirname(__DIR__).'/classes/user.class.php');
  require_once(dirname(__DIR__).'/classes/session.class.php');
  require_once(dirname(__DIR__).'/classes/hashtag.class.php');

  $session = new Session();

  $db = getDatabaseConnection();

  $tags = Hashtag::search($db, $_GET['search'], $_GET['type'],$_GET['csrf']);
  
  echo json_encode($tags);
?>