<?php
  declare(strict_types = 1);
  
require_once(dirname(__DIR__).'/classes/session.class.php');

require_once(dirname(__DIR__).'/database/connection.db.php');
require_once(dirname(__DIR__).'/classes/user.class.php');
require_once(dirname(__DIR__).'/classes/ticket.class.php');
require_once(dirname(__DIR__).'/classes/department.class.php');
require_once(dirname(__DIR__).'/templates/tickets.tpl.php');

$session = new Session();

$integer = intval($_POST['order']); 

$db = getDatabaseConnection();
$tickets = Department::getTicketsDepartment($db,$_SESSION['id'],$integer);
$_SESSION['order'] = $integer;
header('Location: ../pages/ticketsee.php');


