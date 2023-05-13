<?php
  declare(strict_types = 1);
  
  require_once(dirname(__DIR__).'/classes/session.class.php');
  $session = new Session();
  require_once(dirname(__DIR__).'/database/connection.db.php');
  require_once(dirname(__DIR__).'/classes/ticket.class.php');
  require_once(dirname(__DIR__).'/templates/tickets.tpl.php');

    $db = getDatabaseConnection();
    $ticket_id = intval($_GET['ticket_id']);
    Ticket::removeTicket($db, $ticket_id);
    $stmt1 = $db->prepare('INSERT INTO changes(ticket_id,id,text) VALUES (?,?,?)');
    $stmt1->execute(array($ticket_id,$_SESSION['id'],'Removeu o ticket '.$ticket_id.''));
    header('Location: ../pages/ticketsee.php');


  ?>