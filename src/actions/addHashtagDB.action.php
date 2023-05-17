<?php
  declare(strict_types = 1);
  require_once(dirname(__DIR__).'/database/connection.db.php');
  require_once(dirname(__DIR__).'/classes/ticket.class.php');
  require_once(dirname(__DIR__).'/classes/session.class.php');
  require_once(dirname(__DIR__).'/classes/department.class.php');
  require_once(dirname(__DIR__).'/classes/hashtag.class.php');
  require_once(dirname(__DIR__).'/templates/tickets.tpl.php');
  require_once(dirname(__DIR__).'/templates/common.php');
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
    $_SESSION['input']['hashtag newUser'] = htmlentities($_POST['hashtag']);
    $db = getDatabaseConnection();
    $stmt1 = $db->prepare('SELECT * FROM hashtag WHERE tag = ?');
    $stmt1->execute(array($_POST['hashtag']));
    $var = $stmt1->fetchAll();
    if($var) { 
      $session->addMessage('error', "Hashtag já existe, adiciona uma nova!");
      unset($_SESSION['input']);
      header('Location: ../pages/ticketmanage.php');
      die();
    }
    else {
    $stmt = $db->prepare('INSERT INTO hashtag(tag) VALUES (?)');
    $stmt->execute(array($_POST['hashtag']));
    unset($_SESSION['input']);
    $session->addMessage('success', "Hashtag adicionada com sucesso!");
    header('Location: ../pages/ticketmanage.php');}


    



  ?>