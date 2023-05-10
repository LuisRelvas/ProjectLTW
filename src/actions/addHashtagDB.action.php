<?php
  declare(strict_types = 1);
  require_once(dirname(__DIR__).'/database/connection.db.php');
  require_once(dirname(__DIR__).'/classes/ticket.class.php');
  require_once(dirname(__DIR__).'/classes/session.class.php');
  require_once(dirname(__DIR__).'/classes/department.class.php');
  require_once(dirname(__DIR__).'/classes/hashtag.class.php');
  require_once(dirname(__DIR__).'/templates/tickets.tpl.php');
  $session = new Session(); 
  
    $_SESSION['input']['hashtag newUser'] = htmlentities($_POST['hashtag']);
    $db = getDatabaseConnection();
    $stmt = $db->prepare('INSERT INTO hashtag(tag) VALUES (?)');
    $stmt->execute(array($_POST['hashtag']));
    unset($_SESSION['input']);
    header('Location: ../pages/ticket.php');


    



  ?>