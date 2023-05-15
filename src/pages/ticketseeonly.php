<?php 
declare(strict_types = 1);
require_once(dirname(__DIR__).'/templates/common.php');
require_once(dirname(__DIR__).'/classes/session.class.php');
require_once(dirname(__DIR__).'/classes/ticket.class.php'); 
require_once(dirname(__DIR__).'/templates/tickets.tpl.php');
require_once(dirname(__DIR__).'/classes/department.class.php'); 
require_once(dirname(__DIR__).'/templates/departments.tpl.php');

$session = new Session();



drawHeader($session);
if(!$session->isLoggedIn() || $SESSION['id'] != $_GET['id']) {
    $session->addMessage('error','You are not allowed to access this page');
}
$db = getDatabaseConnection();
$ticket = Ticket::getinfoTicket($db, intval($_GET['ticket_id']));
if($ticket->id != $_SESSION['id'] && $_SESSION['role'] != 0 && $_SESSION['role'] != 1) {
    drawAcessDenied();
}
else{
drawinfoTicket(intval($_GET['ticket_id']));}

if($_SESSION['role'] == 0 || $_SESSION['role'] == 1){
    drawChangesTicket(intval($_GET['ticket_id']));
}
drawFooter();


?>