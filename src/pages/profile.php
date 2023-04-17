<?php 
declare(strict_types = 1);
require_once(dirname(__DIR__).'/pages/common.php');
require_once(dirname(__DIR__).'/database/connection.db.php');
require_once(dirname(__DIR__).'/classes/session.class.php');
require_once(dirname(__DIR__).'/classes/user.class.php');
require_once(dirname(__DIR__).'/classes/session.class.php');

$session = new Session();

if(!$session->isLoggedIn() || $SESSION['user_id'] != $_GET['user_id']) {
    $session->addMessage('error','You are not allowed to access this page');
}
drawUser(intval($_GET['user_id']));
if(count($session->getMessages())) drawMessages($session);

