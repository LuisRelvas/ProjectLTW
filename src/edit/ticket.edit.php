<?php
  declare(strict_types = 1);
  require_once(dirname(__DIR__).'/database/connection.db.php');
  require_once(dirname(__DIR__).'/classes/ticket.class.php');
  require_once(dirname(__DIR__).'/templates/common.php');
  require_once(dirname(__DIR__).'/templates/tickets.tpl.php');
  require_once(dirname(__DIR__).'/classes/session.class.php');
  require_once(dirname(__DIR__).'/classes/department.class.php');
  $session = new Session();
  
  if (!$session->isLoggedIn()) {
    $session->addMessage('error', "Não tem permissão para editar este perfil");
    die(header('Location: ../pages/denied.php'));
  } 
  
  $db = getDatabaseConnection();
  $ticket = Ticket::getinfoTicket($db, intval($_GET['ticket_id']));
  if(($_SESSION['id'] != $ticket->id ) && $_SESSION['role'] == 2){
    drawHeader($session); 
    drawAcessDenied();
    drawFooter();
  }
  else {
  $_SESSION['input']['department_id oldUser'] = intval($_SESSION['input']['department_id oldUser']) ?? $ticket->department_id;
  $_SESSION['input']['status_id oldUser'] = intval($_SESSION['input']['status_if oldUser']) ?? $ticket->status_id;
  $_SESSION['input']['tittle oldUser'] = $_SESSION['input']['tittle oldUser'] ?? $ticket->tittle;
  $_SESSION['input']['description oldUser'] = $_SESSION['input']['description oldUser'] ?? $ticket->description;
  drawHeader($session);
  if (count($session->getMessages())) drawMessages($session);
  drawEditTicketForm();
  drawFooter();
}
?>