<?php
declare(strict_types = 1); 
require_once(dirname(__DIR__).'/database/connection.db.php');
require_once(dirname(__DIR__).'/classes/ticket.class.php');
require_once(dirname(__DIR__).'/classes/user.class.php');



function drawallTickets(int $id) { 
    $db = getDatabaseConnection();
    $tickets = Ticket::getallTickets($db);
    foreach($tickets as $ticket){
        var_dump($ticket);
    } 
}

function drawmyTickets(int $id){ 
    $db = getDatabaseConnection();
    $tickets = Ticket::getmyTickets($db,$id);
    foreach($tickets as $ticket){
        var_dump($ticket);
    }
}

function drawinfoTicket(int $ticket_id){ 
    $db = getDatabaseConnection();
    $ticket = Ticket::getinfoTicket($db,$ticket_id);
    ?><h2><?=htmlentities(strval($ticket->ticket_id))?></h2><?php
    ?><h2><?=htmlentities($ticket->initial_date)?></h2><?php
    ?><h2><?=htmlentities($ticket->description)?></h2><?php
    ?><h2><?=htmlentities($ticket->tittle)?></h2><?php
   
}


?>