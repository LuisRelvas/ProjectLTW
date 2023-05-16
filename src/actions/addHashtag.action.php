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
  $stmt1 = $db->prepare('SELECT * FROM ticketHashtag WHERE ticket_id = ? AND hashtag_id = ?');
  $stmt1->execute(array($_SESSION['ticket_id'],$hashtag_id));
  $check = $stmt1->fetch();
  if(!$check){
  $stmt = $db->prepare('INSERT into ticketHashtag(ticket_id,hashtag_id) values (?,?)');
  $stmt->execute(array($_SESSION['ticket_id'],$hashtag_id));
  $session->addMessage('success', "Hashtag adicionada com sucesso ao ticket!");
  
}
  else if($check) { 
    $session->addMessage('error', "Hashtag ja estava adicionada ao ticket!");
  

  }
  $stmt2 = $db->prepare('INSERT INTO changes(ticket_id,id,text) VALUES (?,?,?)');
  $stmt2->execute(array($_SESSION['ticket_id'],$_SESSION['id'],'Adicionou a hashtag '.$_GET['tag'].' ao ticket'));
  unset($_SESSION['input']);
  header('Location: ../pages/ticketseeonly.php?ticket_id='.$_SESSION['ticket_id'].'');
  
    



  ?>