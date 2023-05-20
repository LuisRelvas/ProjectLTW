<?php
  declare(strict_types = 1);
  require_once(dirname(__DIR__).'/database/connection.db.php');
  require_once(dirname(__DIR__).'/classes/ticket.class.php');
  require_once(dirname(__DIR__).'/classes/session.class.php');
  require_once(dirname(__DIR__).'/classes/department.class.php');
  require_once(dirname(__DIR__).'/utils/validator.php');
  require_once(dirname(__DIR__).'/templates/common.php');
  $session = new Session();
  if($_GET['csrf'] != $_SESSION['csrf']){
    $session->addMessage('error', 'Ocorreu um erro ao processar a sua requisição');
    header('Location: ../pages/index.php');
    die();
  }
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
