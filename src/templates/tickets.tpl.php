<?php
declare(strict_types = 1); 
require_once(dirname(__DIR__).'/database/connection.db.php');
require_once(dirname(__DIR__).'/classes/ticket.class.php');
require_once(dirname(__DIR__).'/classes/user.class.php');
require_once(dirname(__DIR__).'/classes/session.class.php');
require_once(dirname(__DIR__).'/classes/hashtag.class.php');
require_once(dirname(__DIR__).'/classes/ticket.class.php');
require_once(dirname(__DIR__).'/templates/tickets.tpl.php');
require_once(dirname(__DIR__).'/templates/departments.tpl.php');
require_once(dirname(__DIR__).'/classes/department.class.php');
require_once(dirname(__DIR__).'/classes/hashtag.class.php');
require_once(dirname(__DIR__).'/classes/reply.class.php');
require_once(dirname(__DIR__).'/templates/user.tlp.php');


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
    if($tickets) {
    foreach($tickets as $ticket){
        ?> <h3 class="loginItem"><a href="../pages/ticketseeonly.php?ticket_id=<?=$ticket->ticket_id?>" ><?= $ticket->ticket_id ?></a></h3> <?php
        ?> <h2><?= $ticket->description?></h2> <?php
    }
}
else { 
    ?> <h2>Não tens tickets</h2> <?php
}
}


function drawDepartmentTickets(int $id) {
    $db = getDatabaseConnection(); 
    
    ?> 
    <form action="../actions/orderTickets.action.php" method="POST">
    <select name ="order" id="order">
        <option value="0">Date</option>
        <option value="1">Ticket Id Crescente</option>
        <option value="2">Ticket Id Decrescente</option>
    </select>
    <input id="button" type="submit" value="Entrar">   
    </form>
    <?php 
    $tickets = Department::getTicketsDepartment($db,$id,$_SESSION['order']);
    if($tickets) {
        ?> <h2>Seleciona um metodo de ordenação dos tickets do teu departamento</h2> <?php
    foreach($tickets as $ticket){
        ?> <h3 class="loginItem"><a href="../pages/ticketseeonly.php?ticket_id=<?=$ticket->ticket_id?>" ><?= $ticket->ticket_id ?></a></h3> <?php
        ?> <h2><?= $ticket->description?></h2> <?php
    }
}
    else {
        ?> <h2>Não estás associado a nenhum departamento por favor contacta um admistrador</h2> <?php
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

function drawinfoTicket(int $ticket_id) { 
    $db = getDatabaseConnection();
    $stmt = $db->prepare('select ticketHashtag.hashtag_id from ticket,ticketHashtag where ticket.ticket_id = ? and ticket.ticket_id = ticketHashtag.ticket_id');
    $stmt->execute(array($ticket_id));
    $hashtag_id = $stmt->fetchAll(PDO::FETCH_COLUMN);
    $ticket = Ticket::getinfoTicket($db,$ticket_id);
    $text = Reply::getReplies($ticket_id);
    foreach($text as $reply){
        ?><h2><?=($reply['text'])?></h2><?php
        ?><h2><?= '_' ?></h2><?php
    }
    $department_name = Department::getDepartmentName($db,$ticket->department_id);
    $_SESSION['ticket_id'] = $ticket->ticket_id;
    if(($ticket->status_id)==1){
        $status = "Open";
    } else if(($ticket->status_id)==2){
        $status= "Assigned";
    } else if(($ticket->status_id)==3){
        $status = "Closed";
    }

    ?><h2><?=htmlentities(strval($ticket->ticket_id))?></h2><?php
    ?><h2><?=htmlentities($department_name)?></h2><?php
    ?><h2><?=htmlentities($ticket->initial_date)?></h2><?php
    ?><h2><?=htmlentities($ticket->description)?></h2><?php
    ?><h2><?=htmlentities($ticket->tittle)?></h2><?php
    ?><h2><?=htmlentities($status)?></h2><?php
    $user = User::getUser($db,$_SESSION['id']);
    $agent_name = User::getUser($db,$ticket->agent_id);
    foreach($hashtag_id as $hashtags_id){
        ?><?php $hashtag = Hashtag::getHashtag($hashtags_id)?><?php
        if($hashtag == "null"){
            continue;
        }
        if($user->role != 2) { 
        ?><h2><a href="../actions/removeHashtag.action.php?hashtag_id=<?=$hashtags_id?>"><h2><?=$hashtag?></h2></a><?php
    }
    else {
        ?><h2><?=$hashtag?></h2><?php
    }

    }
    
    
    if(($ticket->agent_id == -1 ) && ($user->role == 0 || $user->role == 1)) { 
        drawProfilesearch();

    } else {
        ?><h2><?=htmlentities(strval($agent_name->name))?></h2><?php
    }
    if($user->role == 0 || $user->role == 1)  { 
        drawTagsSearch();
        ?><h2><a href="../actions/removeticket.action.php?ticket_id=<?=$ticket->ticket_id?>"><h2>Delete ticket</h2></a><?php
        drawAnswerFaq(); 
    }
    

    ?><h2><a href="../edit/ticket.edit.php?ticket_id=<?=$ticket->ticket_id?>"><h2>Editar ticket</h2></a>


<?php if($user->role == 0 ||$user->id == $ticket->id  || $agent_name -> id == $_SESSION['id']){     ?>
<form action="../actions/submitAnswer.action.php?ticket_id=<?=$ticket->ticket_id?>" method="POST">
    <label for="answer">Answer:</label>
    <textarea name="answer" id="answer" rows="5" cols="50"></textarea>
    <input type="hidden" name="ticket_id" value="<?= $ticket_id ?>">
    <input type="submit" value="Submit Answer">
</form>
    <?php } ?>
    <?php
}


function drawaddHashtags() {  ?>
    <div id = "form">
    <form action="../actions/addHashtagDB.action.php" method ="post">
          <label>Hashtag: <input type="text" name="hashtag" required="required" value="<?=$_SESSION['input']['hashtag newUser']?>"></label>
          <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
          <input id="button" type="submit" value="Validar Hashtag">
      </form>
<?php



}

function drawTagsSearch() { ?>
    <section id = "searching2">
      <select id = "critério2" > 
        <option value = "nameH1">Hashtag</option>
      </select>
      <input id="searchtag" type="text" placeholder="pesquisa">
      <section id="searchtags">
      </section>
  </section> <?php 
}

function drawAnswerFaq() { 
    $db = getDatabaseConnection(); 
    $stmt = $db->prepare('SELECT answer FROM faq');
    $stmt->execute();
    $answers = $stmt->fetchAll(PDO::FETCH_COLUMN);
    ?>
    <form action ="../actions/addAnswersFaq.action.php?ticket_id=<?=$_GET['ticket_id']?>"method = "post" id = "form">
          <label>Answer:</label>
          <select name="answer">
            <optgroup label="List:">
                <?php foreach ($answers as $answer) { ?>
                    <option value="<?= $answer ?>"><?= $answer ?></option>
                <?php }  ?>
            </optgroup>
        </select>
        <input id="button" type="submit" value="Validar Hashtag">
    </form>




 <?php   }

function drawaddHashtag(){ ?>
        <div id = "form">
        <form action="../actions/addHashtag.action.php" method ="post">
              <label>Name: <input type="text" name="tag" required="required" value="<?=$_SESSION['input']['hashtag newUser']?>"></label>
              <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
              <input id="button" type="submit" value="Adicionar Hashtag">
          </form>
    </div>
    <?php

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

function drawllTickets_id(){ ?>
    <?php 
    $db = getDatabaseConnection();
    $stmt = $db->prepare('SELECT ticket_id FROM ticket');
    $stmt->execute();
    $tickets_id = $stmt->fetchAll(PDO::FETCH_COLUMN);
    ?>
    <div id = "form">
          <label>Ticket_id:</label>
          <select name="ticket_id">
            <optgroup label="List:">
                <?php foreach ($tickets_id as $ticket_id) { ?>
                    <option value="<?= $ticket_id ?>"><?= $ticket_id ?></option>
                <?php }  ?>
            </optgroup>
        </select>
</div>

<?php
}

function addAgentDepartment() { ?>
<?php 
$db = getDatabaseConnection();
$stmt = $db->prepare('SELECT DISTINCT user.username FROM agent,user where user.id = agent.id');
$stmt->execute();
$agents_names = $stmt->fetchAll(PDO::FETCH_COLUMN);
$db1 = getDatabaseConnection();
$stmt1 = $db1->prepare('SELECT DISTINCT department.name FROM department');
$stmt1->execute();
$departments = $stmt1->fetchAll(PDO::FETCH_COLUMN);
?>
<div id = "form">
    <form action ="../actions/addAgentDepartment.action.php" method="POST">
      <label>Agent:</label>
      <select name="agent">
        <optgroup label="List:">
            <?php foreach ($agents_names as $agent_name) { ?>
                <option value="<?= $agent_name ?>"><?= $agent_name ?></option>
            <?php }  ?>
        </optgroup>
    </select>
    <label>Department:</label>
      <select name="department">
        <optgroup label="List:">
            <?php foreach ($departments as $department) { ?>
                <option value="<?= $department ?>"><?= $department ?></option>
            <?php }  ?>
        </optgroup>
    </select>
    <input id="button" type="submit" value="Adicionar">
    </form>
<?php }

function drawTicket(int $id) { ?>
    <section id ="ticket">
        <h2>Ticket Management</h2>
        <form action = "../pages/ticketadd.php" method = "post">
            <label>ADD TICKET</label>
            <input id="button" type="submit" value="Entrar">
        </form>
        <h1 class = "ticketitem"><a href="../pages/ticketsee.php">SEE TICKET</a></h1>
        <?php 
        $db = getDatabaseConnection();
        $user = User::getUser($db,$id); 
        if($user->role == 0){
        ?>
        <form action = "../pages/ticketmanage.php" method = "post">
            <label>MANAGE TICKET</label>
            <input id="button" type="submit" value="Entrar">
        </form>
        <?php } ?>
 <?php }




function drawFaq(){ ?>
    <?php 
    $db = getDatabaseConnection();
    $stmt = $db->prepare('SELECT question,answer FROM faq limit 3');
    $stmt->execute();
    $hashtags = $stmt->fetchAll();
    ?>
    <div id = "faq"> 
            <h1>FAQ</h1>
            <?php foreach($hashtags as $hashtag){ ?>
                <h2><?= $hashtag['question'] ?></h2>
                <p><?= $hashtag['answer'] ?></p>
           <?php } ?>


    </div>

<?php
}




function drawEditTicketForm() { ?>
    <?php 
    $db = getDatabaseConnection();
    $stmt = $db ->prepare('SELECT name from department');
    $stmt->execute();
    $departments = $stmt->fetchAll(PDO::FETCH_COLUMN);
    ?>
    <section id="editTicket">
        <h1>Editar Ticket</h1> 
            <form action="../actions/editTicket.action.php" method="post">
                <?php 
                $db = getDatabaseConnection();
                $user = User::getUser($db,$_SESSION['id']);
                $ticket = Ticket::getinfoTicket($db, intval($_GET['ticket_id']));
                if($user->role == 1 || $user->role == 0){ ?>
            
        <select name="department">
            <optgroup label="Choose only one">
                <?php foreach ($departments as $department) { ?>
                    <option value="<?= $department ?>"><?= $department ?></option>
                <?php }  ?>
            </optgroup>
        </select>
        <?php } ?>
            <label>Tittle: <input type="text" name="tittle" required="required" value="<?=htmlentities($ticket->tittle)?>"></label>
            <label>Description: <input type="text" name="description" required="required" value="<?=htmlentities($ticket->description)?>"></label>
            <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>" >
            <input id="button" type="submit" value="Concluir edição" >
        </form>

    </section> <?php }

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

function drawllHashtags(){ ?>
    <?php 
    $db = getDatabaseConnection();
    $stmt = $db->prepare('SELECT tag FROM hashtag');
    $stmt->execute();
    $hashtags = $stmt->fetchAll(PDO::FETCH_COLUMN);
    ?>
<head>
    <title>Show All Hashtags</title>
</head>
<body>
    <div id="form">
        <form action="../" method="post">
            <label>Hashtag:</label>
            <select id="hashtag-select" name="hashtag">
                <optgroup label="List:">
                    <?php foreach ($hashtags as $hashtag) { ?>
                        <option value="<?= $hashtag ?>"><?= $hashtag ?></option>
                    <?php }  ?>
                    
                </optgroup>
            </select>
            <section id="allhashtag">
            </section>
        </form>
    </div>
</body>


<?php
}


function drawallDepartments(){ ?>
    <?php 
    $db = getDatabaseConnection();
    $stmt = $db->prepare('SELECT name FROM department');
    $stmt->execute();
    $departments = $stmt->fetchAll(PDO::FETCH_COLUMN);
    ?>
<head>
    <title>Show All Hashtags</title>
</head>
<body>
    <div id="form">
        <form action="../" method="post">
            <label>Department:</label>
            <select id="department-select" name="department">
                <optgroup label="List:">
                    <?php foreach ($departments as $department) { ?>
                        <option value="<?= $department ?>"><?= $department ?></option>
                    <?php }  ?>
                    
                </optgroup>
            </select>
            <section id="alldepartment">
            </section>
        </form>
    </div>
</body>


<?php
}


function drawallStatus(){ ?>
    <?php 
    $db = getDatabaseConnection();
    $stmt = $db->prepare('SELECT name FROM status');
    $stmt->execute();
    $status = $stmt->fetchAll(PDO::FETCH_COLUMN);
    ?>
<head>
    <title>Show All Hashtags</title>
</head>
<body>
    <div id="form">
        <form action="../" method="post">
            <label>Status:</label>
            <select id="status-select" name="status">
                <optgroup label="List:">
                    <?php foreach ($status as $statu) { ?>
                        <option value="<?= $statu ?>"><?= $statu ?></option>
                    <?php }  ?>
                </optgroup>
            </select>
            <section id="allstatus">
            </section>
        </form>
    </div>
</body>


<?php
}






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