<?php
  declare(strict_types = 1);

  require_once('user.class.php');

  class Ticket { 
    public int $ticket_id;

    public int $department_id; 

    public int $status_id;

    public string $tittle;

    public string $description;

    public string $initial_date;

    public function __construct(int $ticket_id, int $department_id, int $status_id, string $tittle, string $description, string $initial_date) { 
        $this->ticket_id = $ticket_id;
        $this->department_id = $department_id;
        $this->status_id = $status_id;
        $this->tittle = $tittle;
        $this->description = $description;
        $this->initial_date = $initial_date;
      }

    static function getallTickets(PDO $db) : array { 
      
        $stmt = $db->prepare('SELECT * FROM ticket');
        $stmt->execute();
        $ticket = $stmt->fetch();
        while ($ticket = $stmt->fetch()) {
          $tickets[] = new Ticket(
              $ticket['ticket_id'],
              $ticket['department_id'],
              $ticket['status_id'],
              $ticket['tittle'],
              $ticket['description'],
              $ticket['initial_date']
          );
      }
      return $tickets;
    }


  }
  ?>