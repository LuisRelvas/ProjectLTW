<?php 
declare(strict_types = 1);
require_once(dirname(__DIR__).'/templates/common.php');
require_once(dirname(__DIR__).'/templates/user.tlp.php');
require_once(dirname(__DIR__).'/database/connection.db.php');
require_once(dirname(__DIR__).'/classes/session.class.php');
require_once(dirname(__DIR__).'/classes/user.class.php');

$session = new Session();
$db = getDatabaseConnection();
drawHeader($session);
drawTicket($_SESSION['id']);


?>