<?php
  declare(strict_types = 1);
  require_once(dirname(__DIR__).'/database/connection.db.php');
  require_once(dirname(__DIR__).'/classes/ticket.class.php');
  require_once(dirname(__DIR__).'/classes/session.class.php');
  require_once(dirname(__DIR__).'/classes/department.class.php');

  $session = new Session();
  if($_SESSION['csrf'] != $_POST['csrf']) {
    drawAcessDenied();
    header('Location: ../pages/index.php');
    die();
  }
  if(!$session->isLoggedIn()) { 
    $session->addMessage('error', 'Não tem permissões para aceder a esta página');
    header('Location: ../pages/index.php');
    die();
  }
  if(!valid_answer($_POST['tittle'])||!valid_answer($_POST['description'])) {
    $session->addMessage('error', 'Um dos parametros contém caracteres inválidos');
    header('Location: ../pages/ticketadd.php');
    die(); 
  }
  $_SESSION['input']['description newUser'] = htmlentities($_POST['description']);
  $_SESSION['input']['tittle newUser'] = htmlentities($_POST['tittle']);
  $_SESSION['input']['initial_date newUser'] = date("Y-m-d");
  $_SESSION['input']['status_id'] = 0;
  $_SESSION['input']['department_name newUser'] = $_POST['department'];

  

  $department_id = Department::getDepartmentId($_SESSION['input']['department_name newUser']);
  $_SESSION['input']['department_id newUser'] = $department_id;
  $db = getDatabaseConnection();
 
  $stmt = $db->prepare('INSERT INTO ticket(id,department_id,status_id,tittle,description,initial_date) VALUES (?,?,?,?,?,?)');
  $stmt->execute(array($_SESSION['id'],$_SESSION['input']['department_id newUser'], 1 ,$_POST['tittle'], $_POST['description'], $_SESSION['input']['initial_date newUser']));
  $ticket_id = $db->lastInsertId();
  $stmt1 = $db->prepare('INSERT INTO ticketHashtag(ticket_id) values (?)');
  $stmt1 -> execute(array(intval($ticket_id)));
  unset($_SESSION['input']);  
  $session->addMessage('success', "Ticket adicionado com sucesso!");
  header('Location: ../pages/ticketseeonly.php?ticket_id='.$ticket_id.'');
  
  
  ?>
