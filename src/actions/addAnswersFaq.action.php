<?php
  declare(strict_types = 1);
  require_once(dirname(__DIR__).'/database/connection.db.php');
  require_once(dirname(__DIR__).'/classes/ticket.class.php');
  require_once(dirname(__DIR__).'/classes/session.class.php');
  require_once(dirname(__DIR__).'/classes/department.class.php');
  require_once(dirname(__DIR__).'/classes/hashtag.class.php');
  require_once(dirname(__DIR__).'/classes/reply.class.php');

  $session = new Session(); 
  if($_POST['csrf'] != $_SESSION['csrf']){
    $session->addMessage('error', 'Ocorreu um erro ao processar a sua requisição');
    header('Location: ../pages/ticketsee.php');
    die();
  }
  if($_SESSION['role'] == 2 || !$session->isLoggedIn()) { 
    $session->addMessage('error', 'Não tem permissões para aceder a esta página');
    header('Location: ../pages/index.php');
    die();
  }
    Reply::addReply(intval($_GET['ticket_id']),$_POST['answer'] );
  


