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

if (count($session->getMessages())) drawMessages($session);
if(!$session->isLoggedIn()) {
    $session->addMessage('error','Voce nao tem permissao para aceder a esta pagina');
    drawAcessDenied();
}
$db = getDatabaseConnection(); 
$ticket = Ticket::getinfoTicket($db, intval($_GET['ticket_id'])); 
if($ticket){
$var1 = User::checkAgent($db, $_SESSION['id'],$ticket->department_id);}
if($ticket || $var1) { 
if($ticket->id != $_SESSION['id'] && $_SESSION['role'] != 1 && $_SESSION['role'] != 0) { 
    drawAcessDenied();
}
else{ 
    if($_SESSION['id'] == $ticket->id || $var1){ 
drawinfoTicket(intval($_GET['ticket_id']));}
        if($var1) { 
            drawChangesTicket(intval($_GET['ticket_id']));
        }
}
}
if($ticket == null) {
    if($_SESSION['role'] == 0 || $_SESSION['role'] == 1) {
        $session->addMessage('error','O ticket que procura nao existe');
        die(header('Location: ../pages/ticketsee.php'));
    }
    else{
        drawAcessDenied();
    }
}
drawFooter();

?>