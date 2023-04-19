<?php 
declare(strict_types = 1);
require_once(dirname(__DIR__).'/pages/common.php');
require_once(dirname(__DIR__).'/database/connection.db.php');
require_once(dirname(__DIR__).'/classes/session.class.php');
require_once(dirname(__DIR__).'/classes/ticket.class.php'); 


$session = new Session();

var_dump($SESSION['ticket_id']);
die();

if(!$session->isLoggedIn() || $SESSION['id'] != $_GET['id']) {
    $session->addMessage('error','You are not allowed to access this page');
}





?>