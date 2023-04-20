<?php
declare(strict_types = 1); 
require_once(dirname(__DIR__).'/database/connection.db.php');
require_once(dirname(__DIR__).'/classes/ticket.class.php');

function drawmyTickets(int $id) { 
    $db = getDatabaseConnection();
    $tickets = Ticket::getallTickets($db, $id);
    foreach($tickets as $ticket){
        var_dump($ticket);
    }
    
    
    
    
}

?>