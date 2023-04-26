<?php
declare(strict_types = 1); 
require_once(dirname(__DIR__).'/database/connection.db.php');
require_once(dirname(__DIR__).'/classes/ticket.class.php');
require_once(dirname(__DIR__).'/classes/user.class.php');
require_once(dirname(__DIR__).'/classes/session.class.php');
require_once(dirname(__DIR__).'/classes/ticket.class.php');
require_once(dirname(__DIR__).'/templates/tickets.tpl.php');
require_once(dirname(__DIR__).'/templates/departments.tpl.php');
require_once(dirname(__DIR__).'/classes/department.class.php');
require_once(dirname(__DIR__).'/classes/hashtag.class.php');

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

function drawTicketsperHashtag(string $name){ 
    
    $db = getDatabaseConnection();
    $tickets = Ticket::gethashtagTickets($db,$name);
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
    $tag = Hashtag::getHashtag($ticket->hashtag_id);

    $department_name = Department::getDepartmentName($db,$ticket->department_id);
    $_SESSION['ticket_id'] = $ticket->ticket_id;
    if(($ticket->status_id)==0){
        $status = "Pendente";
    } else if(($ticket->status_id)==1){
        $status= "Em progresso";
    } else if(($ticket->status_id)==2){
        $status = "Concluído";
    }

    if(($ticket->hashtag_id))
    ?><h2><?=htmlentities(strval($ticket->ticket_id))?></h2><?php
    ?><h2><?=htmlentities($department_name)?></h2><?php
    ?><h2><?=htmlentities($ticket->initial_date)?></h2><?php
    ?><h2><?=htmlentities($ticket->description)?></h2><?php
    ?><h2><?=htmlentities($ticket->tittle)?></h2><?php
    ?><h2><?=htmlentities($status)?></h2><?php
    ?><h2><a href="../pages/tickethashtag.php?hashtag_name=<?=$tag?>"><h2><?=htmlentities(strval($tag))?></h2></a><?php
    $user = User::getUser($db,$_SESSION['id']);
    $agent_name = User::getUser($db,$ticket->agent_id);
    if(($ticket->agent_id == -1 ) && ($user->role == 0 || $user->role == 1)) { 
        drawAssignTicket();

    } else {
        ?><h2><?=htmlentities(strval($agent_name->name))?></h2><?php
    }
    if($user->role == 0 || $user->role == 1 || $ticket->id == $_SESSION['id'])  { 
        ?><h2><a href="../actions/removeticket.action.php?ticket_id=<?=$ticket->ticket_id?>"><h2>Delete ticket</h2></a><?php
    }

    ?><h2><a href="../edit/ticket.edit.php?ticket_id=<?=$ticket->ticket_id?>"><h2>Editar ticket</h2></a><?php
}

function drawaddTicket(){ ?>
    <?php 
    $db = getDatabaseConnection();
    $stmt = $db->prepare('SELECT name FROM department');
    $stmt->execute();
    $departments = $stmt->fetchAll(PDO::FETCH_COLUMN);

   

    ?>
    <div id = "form">
    <form action="../actions/addticket.action.php" method ="post">
          <label>Tittle: <input type="text" name="tittle" required="required" value="<?=$_SESSION['input']['tittle newUser']?>"></label>
          <select name="department">
            <optgroup label="Choose only one">
                <?php foreach ($departments as $department) { ?>
                    <option value="<?= $department ?>"><?= $department ?></option>
                <?php }  ?>
            </optgroup>
        </select>
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
        <option value = "nameU">User Id</option>
        <option value = "nameS">Username </option>
        <option value = "nameD">Department</option>
        <option value = "nameSt">Status</option>
      </select>
      <input id="searchticket" type="text" placeholder="pesquisa">
      <section id="searchtickets">
      </section>
  </section> <?php 
}

function drawEditTicketForm() { ?>
    <section id="editTicket">
        <h1>Editar Ticket</h1> 
            <form action="../actions/editTicket.action.php" method="post">
                <?php 
                $db = getDatabaseConnection();
                $user = User::getUser($db,$_SESSION['id']);
                $ticket = Ticket::getinfoTicket($db, intval($_GET['ticket_id']));
                if($user->role == 1 || $user->role == 0){ ?>
            
            <label>Department: <input type="number" name="department_id" required="required" value="<?=$ticket->department_id?>"></label><?php } ?>


            <label>Tittle: <input type="text" name="tittle" required="required" value="<?=htmlentities($ticket->tittle)?>"></label>
            <label>Description: <input type="text" name="description" required="required" value="<?=htmlentities($ticket->description)?>"></label>
            <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>" >
            <input id="button" type="submit" value="Concluir edição" >
        </form>

    </section> <?php }


function drawAssignTicket() { ?>
    <section id="assignTicket">
        <h1>Assign Ticket</h1>
        <form action="../actions/assignticket.action.php" method="post">
            <label>Agent id: <input type="number" name="agent_id" required="required" value="<?=htmlentities(strval($_SESSION['input']['agent_id oldUser']))?>"></label>
            <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
            <input id="button" type="submit" value="Concluir" >
        </form>
    </section> <?php
}


?>