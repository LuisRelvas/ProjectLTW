<?php
  declare(strict_types = 1);
  require_once(dirname(__DIR__).'/database/connection.db.php');
  require_once(dirname(__DIR__).'/classes/user.class.php');
  require_once(dirname(__DIR__).'/classes/session.class.php');
  require_once(dirname(__DIR__).'/classes/hashtag.class.php');
  require_once(dirname(__DIR__).'/classes/department.class.php');
  $session = new Session();

  $db = getDatabaseConnection();

  $department = Department::showDepartment($db,$_GET['value']);

  echo json_encode($department);
  
?>