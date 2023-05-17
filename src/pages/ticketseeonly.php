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
    $session->addMessage('error','You are not allowed to access this page');
    drawAcessDenied();
}
$db = getDatabaseConnection(); //Conexao base de dados
$ticket = Ticket::getinfoTicket($db, intval($_GET['ticket_id'])); //Vou buscar a informaçao do ticket
$stmt1 = $db->prepare('SELECT * FROM agent where id = ? and department_id = ?');
$stmt1->execute(array($_SESSION['id'], $ticket->department_id));
$var1 = $stmt1->fetchAll(); //se o agente estiver atribuido ao departamento do ticket entao var1 vai ter valor
if($ticket || $var1) { //se ticket definido entao pode ser o user, se o $var1 tiver definido pode ser o agente do ticket 
if($ticket->id != $_SESSION['id'] && $_SESSION['role'] != 1 && $_SESSION['role'] != 0) { //se os ids nao corresponderem é porque é user
    drawAcessDenied();
}
else{ //neste momento so vai poder ver se fores dono do ticket ou se fores agente ou admin
    if($_SESSION['id'] == $ticket->id || $var1){ //se ele for o agente do ticket pode ver
drawinfoTicket(intval($_GET['ticket_id']));}
        if($var1) {  //se ele for o agente do ticket entao vai poder ver o que foi alterado
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