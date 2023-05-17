<?php
  declare(strict_types = 1);
  require_once(dirname(__DIR__).'/database/connection.db.php');
  require_once(dirname(__DIR__).'/classes/ticket.class.php');
  require_once(dirname(__DIR__).'/classes/session.class.php');
  require_once(dirname(__DIR__).'/classes/reply.class.php');
  require_once(dirname(__DIR__).'/templates/tickets.tpl.php');
  $session = new Session();
  $db = getDatabaseConnection(); 
  if(!$session->isLoggedIn()) { 
    $session->addMessage('error', 'Não tem permissões para aceder a esta página');
    header('Location: ../pages/index.php');
    die();
  }

  $stmt = $db ->prepare( 'SELECT ticket.ticket_id,user.username from hashtag,ticket,user where ticket.id = user.id and hashtag.hashtag_id = ticket.hashtag_id and hashtag.tag = ?');
  $stmt->execute(array($_GET['q']));
  $hashtag_id = $stmt ->fetchAll();
  foreach($hashtag_id as $hashtags_id) { 
    echo("Ticket id: ".$hashtags_id['ticket_id']."<br>");
    echo("Customer name: ".$hashtags_id['username']."<br>");
  }