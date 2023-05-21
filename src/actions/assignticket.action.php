<?php
  declare(strict_types = 1);
  
  require_once(dirname(__DIR__).'/classes/session.class.php');
  $session = new Session();
  require_once(dirname(__DIR__).'/database/connection.db.php');
  require_once(dirname(__DIR__).'/classes/ticket.class.php');
  require_once(dirname(__DIR__).'/classes/user.class.php');
  require_once(dirname(__DIR__).'/templates/tickets.tpl.php');
  if($_GET['csrf']!= $_SESSION['csrf']){
    $session->addMessage('error', 'Ocorreu um erro ao processar a sua requisição');
    header('Location: ../pages/ticketsee.php');
    die();
  }
  if($_SESSION['role'] == 2 || !$session->isLoggedIn()) { 
    $session->addMessage('error', 'Não tem permissões para aceder a esta página');
    header('Location: ../pages/index.php');
    die();
  }
    $db = getDatabaseConnection();
    $ticket_id = intval($_GET['ticket_id']);
    $id = intval($_GET['id']);
    $user = User::getUser($db,$id);
    if($user && ($user->role == 0 || $user->role == 1)){
        Ticket::assignTicket($db, $ticket_id,$id);
        $session->addMessage('success', "Ticket atribuido com sucesso" );
        header('Location: ../pages/ticketseeonly.php?ticket_id='.$ticket_id.'');
    }
    else {
        $session->addMessage('error', "Tens de atribuir um id de um agente/adminstrador válido" );
        header('Location: ../pages/ticketseeonly.php?ticket_id='.$ticket_id.'');
    }
    


  ?>