<?php
  declare(strict_types = 1);
  require_once(dirname(__DIR__).'/database/connection.db.php');
  require_once(dirname(__DIR__).'/classes/ticket.class.php');
  require_once(dirname(__DIR__).'/classes/session.class.php');
  require_once(dirname(__DIR__).'/classes/department.class.php');
  $session = new Session(); 
  $_SESSION['input']['department_name newUser'] = htmlentities($_POST['department_name']);
  $department_id = Department::getDepartmentId($_POST['department_name']);
  $db = getDatabaseConnection();
  $stmt4 = $db->prepare('SELECT * FROM department WHERE name = ?');
  $stmt4->execute(array($_POST['department_name']));
  $department = $stmt4->fetch();
  if($department){
    $session->addMessage('error', "Departamento já existe!");
    header('Location: ../pages/ticketmanage.php');
    exit();
  }
  else if(!$department){
  $stmt = $db->prepare('INSERT INTO department(name) VALUES (?)');
  $stmt->execute(array($_POST['department_name']));
  $stmt1 = $db->prepare('SELECT id FROM user WHERE role = ?'); 
  $stmt1->execute(array(0));
  $users = $stmt1->fetchAll();
  foreach($users as $user) { 
    $stmt3 = $db->prepare('SELECT FROM agent(id,department_id) VALUES (?,?)');
    $stmt3->execute(array($user['id'],$department_id));
    $agent = $stmt3->fetch();
    if(!$agent){
    $stmt2 = $db->prepare('INSERT INTO agent(id,department_id) VALUES (?,?)');
    $stmt2->execute(array($user['id'],$department_id));}
    if($agent) { 
      $session->addMessage('error', "Esse agente já está associado a esse departamento!");
      header('Location: ../pages/ticketmanage.php');
      exit();

    }
  }
  }
  unset($_SESSION['input']);
  $session->addMessage('success', "Ticket adicionado com sucesso!");
  header('Location: ../pages/ticket.php');
    



  ?>