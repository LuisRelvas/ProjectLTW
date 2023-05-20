<?php
  declare(strict_types = 1);

  require_once('user.class.php');
  require_once('session.class.php');

  class Ticket { 
    public int $ticket_id;

    public int $id;

    public int $department_id; 

    public int $status_id;

    public string $tittle;

    public string $description;

    public string $initial_date;

    public int $hashtag_id;

    public int $agent_id;

   

    public function __construct(int $ticket_id, int $id,  int $department_id, int $status_id, string $tittle, string $description, string $initial_date,int $hashtag_id, int $agent_id) { 
        $this->ticket_id = $ticket_id;
        $this->id = $id;
        $this->department_id = $department_id;
        $this->status_id = $status_id;
        $this->tittle = $tittle;
        $this->description = $description;
        $this->initial_date = $initial_date;
        $this->hashtag_id = $hashtag_id; 
        $this->agent_id = $agent_id;
        
      }
      public function getId() {
        return $this->id;
    }

    static function getallTickets(PDO $db) : array { 
      
        $stmt = $db->prepare('SELECT ticket_id,id,department_id,status_id,tittle,description,initial_date,hashtag_id,agent_id FROM ticket');
        $stmt->execute();
        $ticket = $stmt->fetch();
        while ($ticket = $stmt->fetch()) {
          $tickets[] = new Ticket(
              $ticket['ticket_id'],
              $ticket['id'],
              $ticket['department_id'],
              $ticket['status_id'],
              $ticket['tittle'],
              $ticket['description'],
              $ticket['initial_date'],
              $ticket['hashtag_id'],
              $ticket['agent_id']
              
          );
      }
      return $tickets;
    }

    static function gethashtagTickets(PDO $db, string $name) : array { 
      $stmt = $db->prepare('SELECT ticket.ticket_id,ticket.id,ticket.department_id,ticket.status_id,ticket.tittle,ticket.description,ticket.initial_date,ticket.hashtag_id,ticket.agent_id from ticket,hashtag where ticket.hashtag_id = hashtag.hashtag_id and hashtag.tag = ?');
      $stmt->execute(array($name));
      while($ticket = $stmt->fetch()){
        $tickets[] = new Ticket(
            $ticket['ticket_id'],
            $ticket['id'],
            $ticket['department_id'],
            $ticket['status_id'],
            $ticket['tittle'],
            $ticket['description'],
            $ticket['initial_date'],
            $ticket['hashtag_id'],
            $ticket['agent_id']

        );
      }
      return $tickets;
    }

    static function showStatus(PDO $db, string $value) : array {

      $querie = '';
      $result = array();

      $querie = 'SELECT * FROM ticket,status WHERE ticket.status_id = status.status_id and status.name LIKE ?';
      $stmt = $db->prepare($querie);
      $stmt->execute(array($_GET['value']));
      
      while ($ticket = $stmt->fetch()) {
        $result[] = new Ticket(
          $ticket['ticket_id'],
          $ticket['id'],
          $ticket['department_id'],
          $ticket['status_id'],
          $ticket['tittle'],
          $ticket['description'],
          $ticket['initial_date'],
          $ticket['hashtag_id'],
          $ticket['agent_id']
        );
      }
      return $result;
    }

    static function showChanges(PDO $db, int $ticket_id) : ?array{ 
      $stmt = $db->prepare('SELECT * FROM changes WHERE ticket_id = ? and closed_id = 0');
      $stmt->execute(array(intval($_GET['ticket_id'])));
      $var = $stmt->fetchAll();
      if($var) { 
        return $var;
      }
      else { 
        return null;
      }
    }

    static function getmyTickets(PDO $db, int $id) : ?array{ 
      $stmt = $db->prepare('SELECT ticket_id,id,department_id,status_id,tittle,description,initial_date,hashtag_id,agent_id FROM ticket where id = ?');
      $stmt->execute(array($id));
      while($ticket = $stmt->fetch()){
        $tickets[] = new Ticket(
          $ticket['ticket_id'],
          $ticket['id'],
          $ticket['department_id'],
          $ticket['status_id'],
          $ticket['tittle'],
          $ticket['description'],
          $ticket['initial_date'],
          $ticket['hashtag_id'],
          $ticket['agent_id']
        );
      }
      if($tickets == null) { 
        return null;
      }
      else { 
      return $tickets;}
    }

    static function getinfoTicket(PDO $db, int $ticket_id) : ?Ticket { 
    
      $stmt = $db->prepare('SELECT ticket_id,id,department_id,status_id,tittle,description,initial_date,hashtag_id,agent_id FROM ticket where ticket_id = ?');
      $stmt->execute(array($ticket_id));
      $ticket = $stmt->fetch();
      if($ticket){
      return new Ticket(
        $ticket['ticket_id'],
        $ticket['id'],
        $ticket['department_id'],
        $ticket['status_id'],
        $ticket['tittle'],
        $ticket['description'],
        $ticket['initial_date'],
        $ticket['hashtag_id'],
        $ticket['agent_id']
        
    );}
    else
    return null;
    }

    static function search(PDO $db, string $search, string $type) : array {

      $querie = '';
      $result = array();

      switch ($type) {
        case "nameT":
            $querie = 'SELECT * FROM ticket WHERE ticket_id LIKE ?';
            break;
        case "nameU":
            $querie = 'SELECT * FROM ticket WHERE id LIKE ?';
            break;
        case "nameS": 
            $querie = 'SELECT * FROM ticket,user WHERE ticket.id = user.id and username LIKE ?';
            break;
        case "nameD":
            $querie = 'SELECT * FROM ticket,department WHERE ticket.department_id = department.department_id and department.name LIKE ?';
            break;
        case "nameSt":
            $querie = 'SELECT * FROM ticket,status WHERE status.status_id = ticket.status_id and status.name LIKE ?';
            break;
        default:  
            return $result;
      }

      $stmt = $db->prepare($querie);
      $stmt->execute(array('%'.$search.'%'));

      while ($ticket = $stmt->fetch()) {
        $result[] = new Ticket(
          $ticket['ticket_id'],
        $ticket['id'],
        $ticket['department_id'],
        $ticket['status_id'],
        $ticket['tittle'],
        $ticket['description'],
        $ticket['initial_date'],
        $ticket['hashtag_id'],
        $ticket['agent_id']
        
        );
      }
      return $result;
    }

    static function getStatusName(PDO $db, int $status_id) : string {
      $stmt = $db->prepare('SELECT name FROM status WHERE status_id = ?');
      $stmt->execute(array($status_id));
      $status = $stmt->fetch();
      return $status['name'];

    }
    

    function save(PDO $db,int $ticket_id) {


      $user = User::getUser($db,$_SESSION['id']);
      $ticket = Ticket::getinfoTicket($db,$ticket_id);

      $stmt1 = $db->prepare('UPDATE ticket SET department_id = ?,status_id = ? ,tittle = ?,description = ? WHERE ticket_id = ?');
      $stmt1->execute(array($this->department_id,$this->status_id,$this->tittle, $this->description,$this->ticket_id,));


      
      if($this->tittle != $ticket->tittle){
      $stmt2 = $db->prepare('INSERT INTO changes(ticket_id,id,text) VALUES (?,?,?)');
      $stmt2->execute(array($ticket_id,$_SESSION['id'],'O título do ticket foram alterados por '.$user->name . ' de ' . $ticket->tittle . ' para ' . $this->tittle));
      }
      if($this->description != $ticket->description){
        $stmt3 = $db->prepare('INSERT INTO changes(ticket_id,id,text) VALUES (?,?,?)');
        $stmt3->execute(array($ticket_id,$_SESSION['id'],'A descrição do ticket foram alterados por '.$user->name . ' de ' . $ticket->description . ' para ' . $this->description));
      }
      if($this->department_id != $ticket->department_id){
        $department_name_new = Department::getDepartmentName($db,$this->department_id);
        $department_name_old = Department::getDepartmentName($db,$ticket->department_id);
        $stmt4 = $db->prepare('INSERT INTO changes(ticket_id,id,text) VALUES (?,?,?)');
        $stmt4->execute(array($ticket_id,$_SESSION['id'],'O departamento do ticket foi alterado por '.$user->name . ' de ' . $department_name_old . ' para ' . $department_name_new ));
      }
      if($this->status_id != $ticket->status_id){
        $status_name_new = Ticket::getStatusName($db,$this->status_id);
        $status_name_old = Ticket::getStatusName($db,$ticket->status_id);
        $stmt5 = $db->prepare('INSERT INTO changes(ticket_id,id,text) VALUES (?,?,?)');
        $stmt5->execute(array($ticket_id,$_SESSION['id'],'O status do ticket foi alterado por '.$user->name.' de ' . $status_name_old . ' para ' . $status_name_new ));
      }
      else if($this->department_id == $ticket->department_id && $this->status_id == $ticket->status_id && $this->tittle == $ticket->tittle && $this->description == $ticket->description){ 
        $stmt5 = $db->prepare('INSERT INTO changes(ticket_id,id,text) VALUES (?,?,?)');
        $stmt5->execute(array($ticket_id,$_SESSION['id'],'Não foram feitas alterações no ticket por '.$user->name));
      }

  }

  static function assignTicket(PDO $db,int $ticket_id,int $agent_id){
    $stmt = $db->prepare('UPDATE ticket SET status_id = 2,agent_id = ? WHERE ticket_id = ?');
    $stmt->execute(array($agent_id,$ticket_id));
    $stmt1 = $db->prepare('INSERT INTO changes (ticket_id,id,text) VALUES (?,?,?)');
    $agent_name = User::getUser($db,$agent_id);
    $admin_name = User::getUser($db,$_SESSION['id']);
    $stmt1->execute(array($ticket_id,$_SESSION['id'],'O ticket foi atribuido ao agente '.$agent_name->name . ' pelo '.$admin_name->name . ' e o status alterou de Open para Assigned'));
  }

  static function removeTicket($db, $ticket_id){
    $db1 = getDatabaseConnection();
    $stmt = $db->prepare('DELETE FROM ticket WHERE ticket_id = ?');
    $stmt->execute(array($ticket_id));
    $stmt1 = $db1->prepare('DELETE FROM ticketHashtag WHERE ticket_id = ?');
    $stmt1->execute(array($ticket_id));

  }

  static function getStatusId(PDO $db, string $status_name) : int{
    $stmt = $db->prepare('SELECT status_id FROM status WHERE name = ?');
    $stmt->execute(array($status_name));
    $status_id = $stmt->fetch();
    return $status_id['status_id'];
  }

  static function getFaqId(PDO $db,string $question,string $answer) : int{
    $stmt = $db->prepare('SELECT faq_id FROM faq WHERE question = ? and answer = ?');
    $stmt->execute(([$question,$answer]));
    $faq_id = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($faq_id !== false) {
      $faq_id = (int) $faq_id['faq_id'];
      return $faq_id;
  } else {
      return 0; 
  }
  }

}
  ?>