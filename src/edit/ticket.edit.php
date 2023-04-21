<?php
  declare(strict_types = 1);
  require_once(dirname(__DIR__).'/database/connection.db.php');
  require_once(dirname(__DIR__).'/classes/ticket.class.php');
  require_once(dirname(__DIR__).'/pages/common.php');
  require_once(dirname(__DIR__).'/templates/tickets.tpl.php');
  require_once(dirname(__DIR__).'/classes/session.class.php');
  $session = new Session();
  
  if (!$session->isLoggedIn()) {
    $session->addMessage('error', "Não tem permissão para editar este perfil");
    die(header('Location: ../pages/denied.php'));
  } 
  $db = getDatabaseConnection();
  $ticket = Ticket::getinfoTicket($db, $_SESSION['ticket_id']);


  $_SESSION['input']['tittle oldUser'] = $_SESSION['input']['tittle oldUser'] ?? $ticket->tittle;
  $_SESSION['input']['description oldUser'] = $_SESSION['input']['description oldUser'] ?? $ticket->description;

  drawHeader($session);
  if (count($session->getMessages())) drawMessages($session);
  drawEditTicketForm(); 
?>