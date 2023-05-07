<?php 
declare(strict_types = 1);
require_once(dirname(__DIR__).'/pages/common.php');
require_once(dirname(__DIR__).'/templates/user.tlp.php');
require_once(dirname(__DIR__).'/database/connection.db.php');
require_once(dirname(__DIR__).'/classes/session.class.php');
require_once(dirname(__DIR__).'/classes/user.class.php');

$session = new Session();

if(!$session->isLoggedIn() || $SESSION['id'] != $_GET['id']) {
    $session->addMessage('error','You are not allowed to access this page');
}

drawHeader($session);
if(count($session->getMessages())){
    //drawMessages($session);
    //printf('hello');
}
if($session->isLoggedIn())
    drawUser(intval($_GET['id']));

drawAcessDenied();


    

?>


