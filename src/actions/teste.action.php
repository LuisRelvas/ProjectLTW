<?php
  declare(strict_types = 1);
  require_once(dirname(__DIR__).'/database/connection.db.php');
  require_once(dirname(__DIR__).'/classes/ticket.class.php');
  require_once(dirname(__DIR__).'/classes/session.class.php');
  require_once(dirname(__DIR__).'/classes/reply.class.php');
  require_once(dirname(__DIR__).'/templates/tickets.tpl.php');
  $session = new Session();
  $db = getDatabaseConnection(); 


  $stmt->$db->prepare( "SELECT * from department where department = ?"); 
$stmt->execute(array($_GET['q']));
$teste = $stmt ->fetchAll();

?>