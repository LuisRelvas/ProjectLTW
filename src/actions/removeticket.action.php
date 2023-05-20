<?php
  declare(strict_types = 1);
  
  require_once(dirname(__DIR__).'/classes/session.class.php');
  $session = new Session();
  require_once(dirname(__DIR__).'/database/connection.db.php');
  require_once(dirname(__DIR__).'/classes/ticket.class.php');
  require_once(dirname(__DIR__).'/templates/tickets.tpl.php');
  if($_POST['csrf'] != $_SESSION['csrf']){ 
    $session->addMessage('error', 'Ocorreu um erro a processar a sua requisição');
    header('Location: ../pages/index.php');
    die();
  }
  if($_SESSION['role'] == 2 || !$session->isLoggedIn()) { 
    $session->addMessage('error', 'Não tem permissões para aceder a esta página');
    header('Location: ../pages/index.php');
    die();
  }
    $db = getDatabaseConnection();
    $ticket_id = intval($_GET['ticket_id']);
    Ticket::removeTicket($db, $ticket_id);
    $stmt1 = $db->prepare('INSERT INTO changes(ticket_id,id,text,closed_id) VALUES (?,?,?,?)');
    $stmt1->execute(array($ticket_id,$_SESSION['id'],'Removeu o ticket '.$ticket_id.'',1));
    $stmt2 = $db->prepare('DELETE FROM changes WHERE ticket_id = ? and closed_id = 0');
    $stmt2->execute(array($ticket_id));
    $session->addMessage('success', 'Ticket removido com sucesso');
    header('Location: ../pages/ticketsee.php');


  ?>