<?php 
declare(strict_types = 1);
require_once(dirname(__DIR__).'/pages/common.php');
require_once(dirname(__DIR__).'/classes/session.class.php');
require_once(dirname(__DIR__).'/classes/ticket.class.php'); 
require_once(dirname(__DIR__).'/templates/tickets.tpl.php');


$session = new Session();


drawHeader($session);
if(!$session->isLoggedIn() || $SESSION['id'] != $_GET['id']) {
    $session->addMessage('error','You are not allowed to access this page');
}

drawTicketsperHashtag($_GET['hashtag_name']);




?>