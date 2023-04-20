<?php
declare(strict_types = 1); 
require_once(dirname(__DIR__).'/database/connection.db.php');
require_once(dirname(__DIR__).'/classes/ticket.class.php');
require_once(dirname(__DIR__).'/classes/user.class.php');



function drawallTickets(array $tickets) { 
    $db = getDatabaseConnection();
    $tickets = Ticket::getallTickets($db);
    $user = User::getUser($db,$_SESSION['id']);
    if($user->role == 0 || $user->role == 1) { 
    foreach($tickets as $ticket){
        ?> <h2><?= $ticket->ticket_id, $ticket->id, $ticket->tittle, $ticket->initial_date, $ticket->agent_id?></h2> <?php
    } }
    drawmyTickets($user->id);    
    }


function drawmyTickets(int $id){ 
    $db = getDatabaseConnection();
    $tickets = Ticket::getmyTickets($db,$id);
    foreach($tickets as $ticket){
        ?> <h3 class="loginItem"><a href="../pages/ticketseeonly.php?ticket_id=<?=$ticket->ticket_id?>" ><?= $ticket->ticket_id ?></a></h3> <?php
        ?> <h2><?= $ticket->description?></h2> <?php
    }
}

function drawgetTicketid() { ?>
    <section id="ticketpage">
    <h1>Ticket</h1>
    <form action = "../actions/seeticket.action.php" method = "post">
        <label>Ticket id: <input type="number" name="ticket_id" placeholder="ticket_id"></label>
        <input id="button" type="submit" value="Entrar">
    </form>
</section>
<?php
}

function drawinfoTicket(int $ticket_id){ 
    $db = getDatabaseConnection();
    $ticket = Ticket::getinfoTicket($db,$ticket_id);
    ?><h2><?=htmlentities(strval($ticket->ticket_id))?></h2><?php
    ?><h2><?=htmlentities($ticket->initial_date)?></h2><?php
    ?><h2><?=htmlentities($ticket->description)?></h2><?php
    ?><h2><?=htmlentities($ticket->tittle)?></h2><?php
    ?><h2><?=htmlentities(strval($ticket->agent_id))?></h2><?php

        
}

function drawaddTicket(){ ?>
    <div id = "form">
    <form action="../actions/addTicket.action.php" method ="post">
          <label>ticket_id: <input type="text" name = "id" required="required" value="<?=htmlentities($_SESSION['input']['id newUser'])?>"></label>
          <label>username: <input type="text" name="username" required="required" value="<?=htmlentities($_SESSION['input']['username newUser'])?>"></label>
          <label>Tittle: <input type="text" name="name" required="required" value="<?=$_SESSION['input']['name newUser']?>"></label>
          <label>Description: <input type="email" name="email" required="required" value="<?=htmlentities($_SESSION['input']['email newUser'])?>"></label>
          <label>Password: <input type="password" name="password1" required="required" value="<?=htmlentities($_SESSION['input']['password1 newUser'])?>"></label>
          <label>Confirme password: <input type="password" name="password2" required="required" value="<?=htmlentities($_SESSION['input']['password2 newUser'])?>"></label>
          <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
          <input id="button" type="submit" value="Concluir registo">
      </form>
</div>

<?php
}



?>