<?php
  declare(strict_types = 1);
  require_once(dirname(__DIR__).'/database/connection.db.php');
  require_once(dirname(__DIR__).'/classes/ticket.class.php');
  require_once(dirname(__DIR__).'/classes/session.class.php');
  require_once(dirname(__DIR__).'/classes/department.class.php');
  require_once(dirname(__DIR__).'/utils/validator.php');
  $session = new Session();
  
  if($_POST['csrf'] != $_SESSION['csrf']){
    $session->addMessage('error', "Ocorreu um problema a processar a sua requisição");
    die(header('Location: ../pages/index.php'));
  } 

  if (!$session->isLoggedIn()) {
    $session->addMessage('error', "Ação não disponível");
    die(header('Location: ../pages/index.php'));
  }

  if(!valid_name($_POST['tittle'])||!valid_name($_POST['description'])) {
    $session->addMessage('error', 'Um dos parametros contém caracteres inválidos');
    header('Location: ../pages/ticketsee.php');
    die();
  }
  $db = getDatabaseConnection();
  $ticket = Ticket::getinfoTicket($db, $_SESSION['ticket_id']);
  if($_POST['department'] == null || $_POST['status'] == null){
    $_POST['department'] = $ticket->department_id;
    $_POST['status'] = $ticket->status_id;
    $name = Department::getDepartmentName($db, $_POST['department']);
    $department = Department::getDepartmentId($name);
    
  }
  else {
  $status = Ticket::getStatusId($db, $_POST['status']);
  $_POST['status'] = $status;
  $department = Department::getDepartmentId($_POST['department']);
}
  if($department == "null"){
    $session->addMessage('error', "Departamento não existe");
    header('Location: ../edit/ticket.edit.php');
    die();
  }
  if($status == "null"){
    $session->addMessage('error', "Estado não existe");
    header('Location: ../edit/ticket.edit.php');
  }
  else if ($ticket && $department != "null" && $status != "null" && valid_name($_POST['tittle']) && valid_name($_POST['description'])) {
    $ticket->department_id = $department;
    $ticket->tittle = $_POST['tittle'];
    $ticket->description = $_POST['description'];
    $ticket->status_id = $_POST['status'];
    $ticket->save($db,$ticket->ticket_id);
  }

  unset($_SESSION['input']);

  $session->addMessage('success', "Alterações gravadas com sucesso");
  header('Location: ../pages/ticketsee.php');
?>