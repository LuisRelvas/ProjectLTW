<?php
  declare(strict_types = 1);
  require_once(dirname(__DIR__).'/database/connection.db.php');
  require_once(dirname(__DIR__).'/classes/ticket.class.php');
  require_once(dirname(__DIR__).'/classes/session.class.php');
  require_once(dirname(__DIR__).'/classes/reply.class.php');
  $session = new Session();
  if($_POST['csrf'] != $_SESSION['csrf']){
    $session->addMessage('error', 'Ocorreu um erro ao processar a sua requisição');
    header('Location: ../pages/ticketseeonly.php?ticket_id='.$_GET['ticket_id']);
    die();
  }
    if(!$session->isLoggedIn()) {
      $session->addMessage('error', 'Não tem permissões para aceder a esta página');
      header('Location: ../pages/index.php');
      die();
    }
    if(!valid_name(($_POST['answer']))) {
      $session->addMessage('error', 'Introduz uma resposta válida');
      header('Location: ../pages/ticketseeonly.php?ticket_id='.$_GET['ticket_id']);
      die(); 
    }
    $db = getDatabaseConnection();
    $ticket_id = intval($_GET['ticket_id']);
    $text = $_POST['answer'];
    $stmt = $db->prepare('INSERT INTO reply(ticket_id, id, text) VALUES (?, ?, ?)');
    $stmt->execute(array($ticket_id, $_SESSION['id'], $text));
    header('Location: ../pages/ticketseeonly.php?ticket_id='.$ticket_id);