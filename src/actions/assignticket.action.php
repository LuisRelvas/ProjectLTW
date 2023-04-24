<?php
  declare(strict_types = 1);
  
  require_once(dirname(__DIR__).'/classes/session.class.php');
  $session = new Session();
  require_once(dirname(__DIR__).'/database/connection.db.php');
  require_once(dirname(__DIR__).'/classes/ticket.class.php');
  require_once(dirname(__DIR__).'/classes/user.class.php');
  require_once(dirname(__DIR__).'/templates/tickets.tpl.php');

    $db = getDatabaseConnection();
    $ticket_id = $_SESSION['ticket_id'];

    $_SESSION['input']['agent_id oldUser'] = htmlentities($_POST['agent_id']);
    $agent_id = intval($_SESSION['input']['agent_id oldUser']);
    $user = User::getUser($db,$agent_id);
    if($user && ($user->role == 0 || $user->role == 1)){
        Ticket::assignTicket($db, $ticket_id,$agent_id);
        header('Location: ../pages/ticketseeonly.php?ticket_id='.$ticket_id.'');
    }
    else {
        $session->addMessage('error', "Tens de atribuir um id de um agente/adminstrador válido" );
        header('Location: ../pages/ticketseeonly.php?ticket_id='.$ticket_id.'');
    }
    


  ?>