<?php
  declare(strict_types = 1);
  require_once(dirname(__DIR__).'/database/connection.db.php');
  require_once(dirname(__DIR__).'/classes/ticket.class.php');
  require_once(dirname(__DIR__).'/classes/session.class.php');
  require_once(dirname(__DIR__).'/classes/department.class.php');
  require_once(dirname(__DIR__).'/classes/hashtag.class.php');
  require_once(dirname(__DIR__).'/templates/tickets.tpl.php');
  $session = new Session(); 

  $db = getDatabaseConnection();
  $stmt = $db->prepare('INSERT INTO faq (question, answer) VALUES (?,?)');
  $stmt -> execute([$_POST['question'], $_POST['answer']]);
  header('Location: ../pages/index.php');