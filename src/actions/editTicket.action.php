<?php
  declare(strict_types = 1);
  require_once(dirname(__DIR__).'/database/connection.db.php');
  require_once(dirname(__DIR__).'/classes/ticket.class.php');
  require_once(dirname(__DIR__).'/classes/session.class.php');
  require_once(dirname(__DIR__).'/classes/department.class.php');
  require_once(dirname(__DIR__).'/utils/validator.php');
  $session = new Session();

  if (!$session->isLoggedIn()) {
    $session->addMessage('error', "Ação não disponível");
    die(header('Location: ../pages/index.php'));
  } 
  $_SESSION['input']['department_name oldUser'] = ($_POST['department']);
  $_SESSION['input']['tittle oldUser'] = htmlentities($_POST['tittle']);
  $_SESSION['input']['description oldUser'] = htmlentities($_POST['description']);


  $db = getDatabaseConnection();
  $ticket = Ticket::getinfoTicket($db, $_SESSION['ticket_id']);
  $department = Department::getDepartmentId($_POST['department']);
  if($department == "null"){
    $session->addMessage('error', "Departamento não existe");
    header('Location: ../edit/ticket.edit.php');
    die();
  }
  else if ($ticket && $department != "null") {
    $ticket->department_id = $department;
    $ticket->tittle = $_POST['tittle'];
    $ticket->description = $_POST['description'];

    $ticket->save($db);
  }

  unset($_SESSION['input']);

  $session->addMessage('success', "Alterações gravadas com sucesso");
  header('Location: ../pages/ticket.php?id='. $ticket->ticket_id);
?>