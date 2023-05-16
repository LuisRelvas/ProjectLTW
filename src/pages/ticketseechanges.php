<?php 
declare(strict_types = 1);
require_once(dirname(__DIR__).'/templates/common.php');
require_once(dirname(__DIR__).'/classes/session.class.php');
require_once(dirname(__DIR__).'/classes/ticket.class.php'); 
require_once(dirname(__DIR__).'/templates/tickets.tpl.php');
require_once(dirname(__DIR__).'/classes/department.class.php'); 
require_once(dirname(__DIR__).'/templates/departments.tpl.php');

$session = new Session();


if(!$session->isLoggedIn() || $SESSION['id'] != $_GET['id']) {
    $session->addMessage('error','You are not allowed to access this page');
}

drawHeader($session);
if (count($session->getMessages())) drawMessages($session);

$db = getDatabaseConnection();
$stmt = $db->prepare('SELECT * FROM changes WHERE ticket_id = ? and id = ?');
$stmt->execute(array(intval($_GET['ticket_id']), $_SESSION['id']));
$var = $stmt->fetchAll();
foreach($var as $va) { ?>

    <h2><?=$va['text']?></h2><?php
}
drawFooter();
