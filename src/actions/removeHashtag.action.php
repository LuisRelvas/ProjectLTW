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
    $stmt2 = $db->prepare('INSERT INTO changes(ticket_id,id,text) VALUES (?,?,?)');
    $stmt2->execute(array($_SESSION['ticket_id'],$_SESSION['id'],'Removeu a hashtag '.$hashtag_id.' ao ticket'));
    header('Location: ../pages/ticketseeonly.php?ticket_id='.$_SESSION['ticket_id'].'');


  ?>