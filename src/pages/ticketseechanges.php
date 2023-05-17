<?php 
declare(strict_types = 1);
require_once(dirname(__DIR__).'/templates/common.php');
require_once(dirname(__DIR__).'/classes/session.class.php');
require_once(dirname(__DIR__).'/classes/user.class.php');
require_once(dirname(__DIR__).'/classes/ticket.class.php'); 
require_once(dirname(__DIR__).'/templates/tickets.tpl.php');
require_once(dirname(__DIR__).'/classes/department.class.php'); 
require_once(dirname(__DIR__).'/templates/departments.tpl.php');

$session = new Session();


if(!$session->isLoggedIn()) {
    $session->addMessage('error','You are not allowed to access this page');
}
drawHeader($session); 
if (count($session->getMessages())) drawMessages($session);

$db = getDatabaseConnection();
$stmt = $db->prepare('SELECT * FROM changes WHERE ticket_id = ? and closed_id = 0');
$stmt->execute(array(intval($_GET['ticket_id'])));
$var = $stmt->fetchAll();
$ticket = Ticket::getinfoTicket($db, intval($_GET['ticket_id']));
if($ticket == "NULL") { 
    ?><h2>O ticket que procura nao existe</h2><?php
}else {
$stmt1 = $db->prepare('SELECT * FROM agent where id = ? and department_id = ?');
$stmt1->execute(array($_SESSION['id'], $ticket->department_id));
$var1 = $stmt1->fetchAll();
if($var1 || $_SESSION['role'] == 0){
if($var){
foreach($var as $va) { ?>
    <h2><?=$va['text']?></h2><?php
} ?>
<?php } 
    else{
        ?><h2>O ticket ainda nao sofreu qualquer tipo de alterações</h2><?php
    }

}


else{ 
    drawAcessDenied();
 } 
drawFooter();}
?>
