<?php
  declare(strict_types = 1);
  
  require_once(dirname(__DIR__).'/classes/session.class.php');
  $session = new Session();
  require_once(dirname(__DIR__).'/database/connection.db.php');
  require_once(dirname(__DIR__).'/classes/hashtag.class.php');
  require_once(dirname(__DIR__).'/templates/tickets.tpl.php');

    $db = getDatabaseConnection();
    $hashtag_id = intval($_GET['hashtag_id']);
    Hashtag::removeHashtag($db, $hashtag_id);
    header('Location: ../pages/ticketseeonly.php?ticket_id='.$_SESSION['ticket_id'].'');


  ?>