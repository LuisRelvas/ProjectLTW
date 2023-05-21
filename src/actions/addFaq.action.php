<?php
  declare(strict_types = 1);
  require_once(dirname(__DIR__).'/database/connection.db.php');
  require_once(dirname(__DIR__).'/classes/ticket.class.php');
  require_once(dirname(__DIR__).'/classes/session.class.php');
  require_once(dirname(__DIR__).'/classes/department.class.php');
  require_once(dirname(__DIR__).'/classes/hashtag.class.php');
  require_once(dirname(__DIR__).'/templates/tickets.tpl.php');

  $session = new Session(); 
  if($_SESSION['csrf'] != $_POST['csrf']) {
    drawAcessDenied();
    header('Location: ../pages/index.php');
    die();
  }
  if($_SESSION['role'] == 2 || !$session->isLoggedIn()) { 
    $session->addMessage('error', 'Não tem permissões para aceder a esta página');
    header('Location: ../pages/index.php');
    die();
  }
  if(!valid_answer($_POST['question'])||!valid_answer($_POST['answer'])) {
    $session->addMessage('error', 'Um dos parametros contém caracteres inválidos');
    header('Location: ../pages/ticketmanage.php');
    die(); 
  }

  $db = getDatabaseConnection();
  $stmt = $db->prepare('INSERT INTO faq (question, answer) VALUES (?,?)');
  $stmt -> execute([$_POST['question'], $_POST['answer']]);
  $session->addMessage('success', 'FAQ adicionada com sucesso!');
  header('Location: ../pages/index.php');