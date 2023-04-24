<?php
  declare(strict_types = 1);
  require_once(dirname(__DIR__).'/database/connection.db.php');
  require_once(dirname(__DIR__).'/classes/ticket.class.php');
  require_once(dirname(__DIR__).'/classes/session.class.php');
  require_once(dirname(__DIR__).'/classes/department.class.php');
  $session = new Session();
  $_SESSION['input']['description newUser'] = htmlentities($_POST['description']);
  $_SESSION['input']['tittle newUser'] = htmlentities($_POST['tittle']);
  $_SESSION['input']['initial_date newUser'] = date("Y-m-d");
  $_SESSION['input']['status_id'] = 0;
  $_SESSION['input']['department_name newUser'] = $_POST['department'];
  

  $department_id = Department::getDepartmentId($_SESSION['input']['department_name newUser']);
  $_SESSION['input']['department_id newUser'] = $department_id;
  $db = getDatabaseConnection();
 
  $stmt = $db->prepare('INSERT INTO ticket(id,department_id,status_id,tittle,description,initial_date) VALUES (?,?,?,?,?,?)');
  $stmt->execute(array($_SESSION['id'],$_SESSION['input']['department_id newUser'], $_SESSION['input']['status_id'],$_POST['tittle'], $_POST['description'], $_SESSION['input']['initial_date newUser']));
  
  unset($_SESSION['input']);  
  $session->addMessage('success', "Ticket adicionado com sucesso!");
  header('Location: ../pages/ticket.php');
  
  
  ?>
