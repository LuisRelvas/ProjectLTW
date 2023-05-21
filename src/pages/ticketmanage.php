<?php 
declare(strict_types = 1);
require_once(dirname(__DIR__).'/templates/common.php');
require_once(dirname(__DIR__).'/templates/tickets.tpl.php');
require_once(dirname(__DIR__).'/database/connection.db.php');
require_once(dirname(__DIR__).'/classes/session.class.php');
require_once(dirname(__DIR__).'/classes/user.class.php'); 
require_once(dirname(__DIR__).'/templates/departments.tpl.php');
require_once(dirname(__DIR__).'/classes/hashtag.class.php'); 

$session = new Session();



drawHeader($session);
if(!$session->isLoggedIn() || $_SESSION['role'] == 2) { 
    drawAcessDenied();
    $session->addMessage('error','You are not allowed to access this page');
}
else { 
if (count($session->getMessages())) drawMessages($session);
if($_SESSION['role'] == 1) { 
    drawaddHashtags();
    drawaddFaq();

}
else { 
drawllHashtags();
drawallDepartments();
drawallStatus();
drawTicketSearch();
drawaddDepartment();
drawaddHashtags(); 
drawaddStatus();
drawaddFaq();
addAgentDepartment();
removeAgentDepartment();
}
}
drawFooter();

