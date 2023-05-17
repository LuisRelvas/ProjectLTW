<?php
  declare(strict_types = 1);
  
  require_once(dirname(__DIR__).'/classes/session.class.php');
  $session = new Session();
  require_once(dirname(__DIR__).'/database/connection.db.php');
  require_once(dirname(__DIR__).'/classes/hashtag.class.php');
  require_once(dirname(__DIR__).'/templates/tickets.tpl.php');
  if($_SESSION['role'] == 2 || !$session->isLoggedIn()) { 
    $session->addMessage('error', 'Não tem permissões para aceder a esta página');
    header('Location: ../pages/index.php');
    die();
  }

    $db = getDatabaseConnection();
    $hashtag_id = intval($_GET['hashtag_id']);
    Hashtag::removeHashtag($db, $hashtag_id);
    $stmt2 = $db->prepare('INSERT INTO changes(ticket_id,id,text) VALUES (?,?,?)');
    $user = User::getUser($db,$_SESSION['id']);
    $hashtag_name = Hashtag::getHashtag($hashtag_id);
    $stmt2->execute(array($_SESSION['ticket_id'],$user->name,'Removeu a hashtag '.$hashtag_name.' ao ticket'));
    header('Location: ../pages/ticketseeonly.php?ticket_id='.$_SESSION['ticket_id'].'');


  ?>