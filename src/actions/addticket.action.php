<?php
  declare(strict_types = 1);
  require_once(dirname(__DIR__).'/database/connection.db.php');
  require_once(dirname(__DIR__).'/classes/ticket.class.php');
  require_once(dirname(__DIR__).'/classes/session.class.php');
  $session = new Session(); 
  $_SESSION['input']['description newUser'] = htmlentities($_POST['description']);
  $_SESSION['input']['tittle newUser'] = htmlentities($_POST['tittle']);
  $_SESSION['input']['initial_date newUser'] = date("Y-m-d");
  $_SESSION['input']['status_id'] = 0;
  $db = getDatabaseConnection();
  $stmt = $db->prepare('INSERT INTO ticket(id,department_id,status_id,tittle,description,initial_date) VALUES (?,?,?,?,?, ?)');
  $stmt->execute(array($_SESSION['id'],$_SESSION['input']['department_id newUser'], $_SESSION['input']['status_id'],$_POST['tittle'], $_POST['description'], $_SESSION['input']['initial_date newUser']));
  ?>
