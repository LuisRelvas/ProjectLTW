<?php
  declare(strict_types = 1);

  require_once('user.class.php');

  class Ticket { 
    public int $ticket_id;

    public int $id;

    public int $department_id; 

    public int $status_id;

    public string $tittle;

    public string $description;

    public string $initial_date;

    public function __construct(int $ticket_id, int $id,  int $department_id, int $status_id, string $tittle, string $description, string $initial_date) { 
        $this->ticket_id = $ticket_id;
        $this->id = $id;
        $this->department_id = $department_id;
        $this->status_id = $status_id;
        $this->tittle = $tittle;
        $this->description = $description;
        $this->initial_date = $initial_date;
      }
      public function getId() {
        return $this->id;
    }

    static function getallTickets(PDO $db) : array { 
      
        $stmt = $db->prepare('SELECT ticket_id,id,department_id,status_id,tittle,description,initial_date FROM ticket');
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
              $ticket['initial_date']
          );
      }
      return $tickets;
    }

    static function getmyTickets(PDO $db, int $id) : array{ 
      $stmt = $db->prepare('SELECT ticket_id,id,department_id,status_id,tittle,description,initial_date FROM ticket where id = ?');
      $stmt->execute(array($id));
      while($ticket = $stmt->fetch()){
        $tickets[] = new Ticket(
          $ticket['ticket_id'],
          $ticket['id'],
          $ticket['department_id'],
          $ticket['status_id'],
          $ticket['tittle'],
          $ticket['description'],
          $ticket['initial_date']
        );
      }
      return $tickets;
    }

    static function getinfoTicket(PDO $db, int $ticket_id) : ?Ticket { 
      $stmt = $db->prepare('SELECT ticket_id,id,department_id,status_id,tittle,description,initial_date FROM ticket where ticket_id = ?');
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
    );
    }
  }
  ?>