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
    ?><h2><?=htmlentities(strval($ticket->status_id))?></h2><?php
    ?><h2><?=htmlentities(strval($ticket->agent_id))?></h2><?php

        
}

function drawaddTicket(){ ?>
    <div id = "form">
    <form action="../actions/addticket.action.php" method ="post">
          <label>Tittle: <input type="text" name="tittle" required="required" value="<?=$_SESSION['input']['tittle newUser']?>"></label>
          <select name = "Department">
            <optgroup label = "Choose only one">
                <option value = "IT">IT <?php $_SESSION['input']['department_id newUser'] = 0 ?></option>
                <option value = "IT2">IT2<?php $_SESSION['input']['department_id newUser'] = 1 ?></option>
                <option value = "IT3">IT3<?php $_SESSION['input']['department_id newUser'] = 2 ?></option>
            </optgroup> 
          <label>Description: <input type="text" name="description" required="required" value="<?=($_SESSION['input']['description newUser'])?>"></label>
          <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
          <input id="button" type="submit" value="Validar Ticket">
      </form>
</div>

<?php
}

function drawTicketSearch() { ?>
    <section id = "searching">
      <select id = "critério" > 
        <option value = "nameT">Ticket Id</option>
      </select>
      <input id="searchticket" type="number" placeholder="pesquisa">
      <section id="searchtickets">
      </section>
  </section> <?php 
}


?>