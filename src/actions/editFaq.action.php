<?php
  declare(strict_types = 1);
  require_once(dirname(__DIR__).'/database/connection.db.php');
  require_once(dirname(__DIR__).'/classes/ticket.class.php');
  require_once(dirname(__DIR__).'/classes/session.class.php');
  require_once(dirname(__DIR__).'/classes/department.class.php');
  require_once(dirname(__DIR__).'/utils/validator.php');
  $session = new Session();

  $db = getDatabaseConnection();
  $stmt = $db->prepare('UPDATE faq SET question = ? , answer = ? WHERE faq_id = ?');
    $stmt -> execute([$_POST['question'], $_POST['answer'], $_GET['faq_id']]);
    header('Location: ../pages/index.php');
  