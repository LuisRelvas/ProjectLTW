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
  if($_SESSION['role'] == 2 || $_SESSION['role'] == 1 || !$session->isLoggedIn()) { 
    $session->addMessage('error', 'Não tem permissões para aceder a esta página');
    header('Location: ../pages/index.php');
    die();
  }

  if(!valid_name($_POST['status'])) {
    $session->addMessage('error', 'Status contém caracteres inválidos');
    header('Location: ../pages/ticketmanage.php');
    die(); 
  }
  $_SESSION['input']['status newUser'] = htmlentities($_POST['status']);
  $db = getDatabaseConnection();
  $stmt1 = $db->prepare('SELECT * FROM status WHERE name = ?');
  $stmt1->execute(array($_POST['status']));
  $var = $stmt1->fetchAll();
  if($var) { 
    $session->addMessage('error', "Status já existe, adicione um novo!");
    unset($_SESSION['input']);
    header('Location: ../pages/ticketmanage.php');
    die();
  }
  else {
  $stmt = $db->prepare('INSERT INTO status(name) VALUES (?)');
  $stmt->execute(array($_POST['status']));
  unset($_SESSION['input']);
  $session->addMessage('success', "Status adicionada com sucesso!");
  header('Location: ../pages/ticketmanage.php');}



  ?>