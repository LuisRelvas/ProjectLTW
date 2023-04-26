<?php
  declare(strict_types = 1);
  require_once(dirname(__DIR__).'/database/connection.db.php');
  require_once(dirname(__DIR__).'/classes/ticket.class.php');
  require_once(dirname(__DIR__).'/classes/session.class.php');
  require_once(dirname(__DIR__).'/classes/department.class.php');
  require_once(dirname(__DIR__).'/classes/hashtag.class.php');
  $session = new Session(); 
  
  $_SESSION['input']['hashtag newUser'] = $_GET['tag'];
  $hashtag_id = Hashtag::getHashtagID(strval($_GET['tag']));
  $db = getDatabaseConnection();
  $stmt = $db->prepare('INSERT into ticketHashtag(ticket_id,hashtag_id) values (?,?)');
  $stmt->execute(array($_SESSION['ticket_id'],$hashtag_id));
  unset($_SESSION['input']);
  $session->addMessage('success', "Ticket adicionado com sucesso!");
  header('Location: ../pages/ticket.php');
    



  ?>