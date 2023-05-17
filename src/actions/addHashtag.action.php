<?php
  declare(strict_types = 1);
  require_once(dirname(__DIR__).'/database/connection.db.php');
  require_once(dirname(__DIR__).'/classes/ticket.class.php');
  require_once(dirname(__DIR__).'/classes/session.class.php');
  require_once(dirname(__DIR__).'/classes/department.class.php');
  require_once(dirname(__DIR__).'/classes/hashtag.class.php');
  require_once(dirname(__DIR__).'/classes/user.class.php');
  require_once(dirname(__DIR__).'/templates/common.php');

  $session = new Session();   
  if($_SESSION['csrf'] != $_GET['csrf']) {
    drawAcessDenied();
    header('Location: ../pages/index.php');
    die();
  }
  if($_SESSION['role'] == 2 || !$session->isLoggedIn()) { 
    $session->addMessage('error', 'Não tem permissões para aceder a esta página');
    header('Location: ../pages/index.php');
    die();
  }
  
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
  $name = Hashtag::getHashtag($hashtag_id);
  $user = User::getUser($db,$_SESSION['id']);
  $stmt2 = $db->prepare('INSERT INTO changes(ticket_id,id,text) VALUES (?,?,?)');
  $stmt2->execute(array($_SESSION['ticket_id'],$_SESSION['id'], $user->name .' adicionou a hashtag '.$name.' ao ticket'));
  
}
  else if($check) { 
    $session->addMessage('error', "Hashtag ja estava adicionada ao ticket!");
  }
  
  unset($_SESSION['input']);
  header('Location: ../pages/ticketseeonly.php?ticket_id='.$_SESSION['ticket_id'].'');
  
    



  ?>