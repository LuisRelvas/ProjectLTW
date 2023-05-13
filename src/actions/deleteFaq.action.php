<?php
  declare(strict_types = 1);
  require_once(dirname(__DIR__).'/database/connection.db.php');
  require_once(dirname(__DIR__).'/classes/ticket.class.php');
  require_once(dirname(__DIR__).'/classes/session.class.php');
  require_once(dirname(__DIR__).'/classes/department.class.php');
  require_once(dirname(__DIR__).'/utils/validator.php');
  $session = new Session();

    $db = getDatabaseConnection();
    $stmt = $db->prepare('DELETE from faq where question = ? and answer = ?');
    $stmt -> execute([$_GET['question'], $_GET['answer']]);
    header('Location: ../pages/index.php');
