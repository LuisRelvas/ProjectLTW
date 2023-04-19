<?php
declare(strict_types = 1); 
require_once(dirname(__DIR__).'/database/connection.db.php');
require_once(dirname(__DIR__).'classes/ticket.class.php');

function drawTickets(int $ticket_id) {
    $db = getDatabaseConnection();
    $ticket = Ticket::getTicket($db, $ticket_id);
    
    
    
}

?>