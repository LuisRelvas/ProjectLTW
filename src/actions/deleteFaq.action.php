<?php
  declare(strict_types = 1);
  require_once(dirname(__DIR__).'/database/connection.db.php');
  require_once(dirname(__DIR__).'/classes/ticket.class.php');
  require_once(dirname(__DIR__).'/classes/session.class.php');
  require_once(dirname(__DIR__).'/classes/department.class.php');
  require_once(dirname(__DIR__).'/utils/validator.php');
  $session = new Session();
  if($_SESSION['role'] == 2 || !$session->isLoggedIn()) { 
    $session->addMessage('error', 'Não tem permissões para aceder a esta página');
    header('Location: ../pages/index.php');
    die();
  }

    $db = getDatabaseConnection();
    $stmt = $db->prepare('DELETE from faq where question = ? and answer = ?');
    $stmt -> execute([$_GET['question'], $_GET['answer']]);
    $session->addMessage('success', 'FAQ apagada com sucesso');
    header('Location: ../pages/index.php');
