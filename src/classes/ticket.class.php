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
        
    );
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
    

    function save($db) {
      $stmt = $db->prepare('UPDATE ticket SET department_id = ?, tittle = ?, description = ? WHERE ticket_id = ?');
      $stmt->execute(array($this->department_id,$this->tittle, $this->description,$this->ticket_id));
  }

  static function assignTicket(PDO $db,int $ticket_id,int $agent_id){
    $stmt = $db->prepare('UPDATE ticket SET status_id = 1,agent_id = ? WHERE ticket_id = ?');
    $stmt->execute(array($agent_id,$ticket_id));

  }

  static function removeTicket($db, $ticket_id){
    $db1 = getDatabaseConnection();
    $stmt = $db->prepare('DELETE FROM ticket WHERE ticket_id = ?');
    $stmt->execute(array($ticket_id));
    $stmt1 = $db1->prepare('DELETE FROM ticketHashtag WHERE ticket_id = ?');
    $stmt1->execute(array($ticket_id));

  }

}
  ?>