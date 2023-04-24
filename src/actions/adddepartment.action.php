<?php
  declare(strict_types = 1);
  require_once(dirname(__DIR__).'/database/connection.db.php');
  require_once(dirname(__DIR__).'/classes/ticket.class.php');
  require_once(dirname(__DIR__).'/classes/session.class.php');
  require_once(dirname(__DIR__).'/classes/department.class.php');
  $session = new Session(); 
  $_SESSION['input']['department_name newUser'] = htmlentities($_POST['department_name']);
  $db = getDatabaseConnection();

  $stmt = $db->prepare('INSERT INTO department(name) VALUES (?)');
  $stmt->execute(array($_POST['department_name']));
  unset($_SESSION['input']);
  $session->addMessage('success', "Ticket adicionado com sucesso!");
  header('Location: ../pages/ticket.php');
    



  ?>