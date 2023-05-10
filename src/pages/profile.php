<?php 
declare(strict_types = 1);
require_once(dirname(__DIR__).'/templates/common.php');
require_once(dirname(__DIR__).'/templates/user.tlp.php');
require_once(dirname(__DIR__).'/database/connection.db.php');
require_once(dirname(__DIR__).'/classes/session.class.php');
require_once(dirname(__DIR__).'/classes/user.class.php');

$session = new Session();

if(!$session->isLoggedIn() || $SESSION['id'] != intval($_GET['id'])) {
    $session->addMessage('error','You are not allowed to access this page');
}

drawHeader($session);
if(count($session->getMessages())) drawMessages($session);

if(intval($_GET['id']) == $_SESSION['id']){
drawUser(intval($_GET['id']));}

    

?>


