<?php 
declare(strict_types = 1);
require_once(dirname(__DIR__).'/templates/common.php');
require_once(dirname(__DIR__).'/classes/session.class.php');
require_once(dirname(__DIR__).'/classes/ticket.class.php'); 
require_once(dirname(__DIR__).'/classes/department.class.php');
require_once(dirname(__DIR__).'/templates/tickets.tpl.php');


$session = new Session();

drawHeader($session);
if (count($session->getMessages())) drawMessages($session);
if(!$session->isLoggedIn()) {
    drawAcessDenied();
    $session->addMessage('error','Voce nao tem permissao para aceder a esta pagina');
}
drawmyTickets($_SESSION['id']);
drawDepartmentTickets($_SESSION['id']);
drawFooter();



?>