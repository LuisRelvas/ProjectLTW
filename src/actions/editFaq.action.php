<?php
  declare(strict_types = 1);
  require_once(dirname(__DIR__).'/database/connection.db.php');
  require_once(dirname(__DIR__).'/classes/ticket.class.php');
  require_once(dirname(__DIR__).'/classes/session.class.php');
  require_once(dirname(__DIR__).'/classes/department.class.php');
  require_once(dirname(__DIR__).'/utils/validator.php');
  $session = new Session();
  if($_POST['csrf'] != $_SESSION['csrf']){
    $session->addMessage('error', 'Ocorreu um erro ao processar a sua requisição');
    header('Location: ../pages/ticketmanage.php');
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
  $stmt = $db->prepare('UPDATE faq SET question = ? , answer = ? WHERE faq_id = ?');
    $stmt -> execute([$_POST['question'], $_POST['answer'], $_GET['faq_id']]);
    $session->addMessage('success', 'FAQ editada com sucesso');
    header('Location: ../pages/index.php');
  