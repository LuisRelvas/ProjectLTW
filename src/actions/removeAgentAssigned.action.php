<?php 
  declare(strict_types = 1);
  require_once(dirname(__DIR__).'/database/connection.db.php');
  require_once(dirname(__DIR__).'/classes/ticket.class.php');
  require_once(dirname(__DIR__).'/classes/user.class.php');
  require_once(dirname(__DIR__).'/classes/session.class.php');
  require_once(dirname(__DIR__).'/classes/department.class.php');


    $session = new Session();
    if($_SESSION['csrf'] != $_GET['csrf']){
        $session->addMessage('error', 'Ocorreu um erro ao processar a sua requisição');
        header('Location: ../pages/ticketsee.php');
        die();
    }
    $db = getDatabaseConnection(); 
    $stmt = $db->prepare('SELECT * FROM ticket where ticket_id = ? and agent_id = ?');
    $stmt->execute(array($_GET['ticket_id'],$_GET['agent_id']));
    $ticket = $stmt->fetch();
    if($ticket) { 
        $stmt1 = $db->prepare('UPDATE ticket SET agent_id = -1 WHERE ticket_id = ? and agent_id = ?');
        $stmt1->execute(array($_GET['ticket_id'],$_GET['agent_id']));
        $session->addMessage('success','Agente removido com sucesso');
        header('Location: ../pages/ticketseeonly.php?ticket_id='.$_GET['ticket_id']);
    }
    else if(!$ticket){
        $session->addMessage('warning','Ticket já não estava atribuido a esse agente');
        header('Location: ../pages/ticketsee.php');}

  ?>