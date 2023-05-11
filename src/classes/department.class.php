<?php
  declare(strict_types = 1);

  require_once('ticket.class.php');
  require_once('session.class.php');

  class Department { 
    public int $department_id;
    
    public string $name;

    

    public function __construct(int $department_id, string $name) { 
        $this->department_id = $department_id;
        $this->name = $name;
      }

    static public function getDepartmentId(string $name): int {
        $db = getDatabaseConnection();
        $stmt = $db->prepare('SELECT department_id FROM department where name = ?');
        $stmt->execute(array($name));
        $department_id = $stmt->fetch();
        $department_id = ($department_id['department_id']);
        return intval($department_id); 

    }

    static public function getDepartmentName(PDO $db, int $department_id): string {
        $stmt = $db->prepare('SELECT name FROM department where department_id = ?');
        $stmt->execute(array($department_id));
        $name = $stmt->fetch();
        $name = ($name['name']);
        if($name){
        return $name;}
        else{
            return "null";
        }

    }
    static function showDepartment(PDO $db, string $value) : array {

      $querie = '';
      $result = array();

      $querie = 'SELECT * FROM ticket,department WHERE ticket.department_id = department.department_id and department.name LIKE ?';
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

    static public function getTicketsDepartment(PDO $db , int $id, int $integer) : ?array{ 
      
      if($integer == 0){
      $stmt = $db ->prepare('SELECT DISTINCT ticket.ticket_id,ticket.id,ticket.department_id,ticket.status_id,ticket.tittle,ticket.description,ticket.initial_date,ticket.hashtag_id,ticket.agent_id FROM agent,department,ticket where ticket.department_id = department.department_id and agent.department_id = department.department_id and agent.id = ? ORDER BY ticket.initial_date');}
      if($integer == 1){
        $stmt = $db ->prepare('SELECT DISTINCT ticket.ticket_id,ticket.id,ticket.department_id,ticket.status_id,ticket.tittle,ticket.description,ticket.initial_date,ticket.hashtag_id,ticket.agent_id FROM agent,department,ticket where ticket.department_id = department.department_id and agent.department_id = department.department_id and agent.id = ? ORDER BY ticket.ticket_id');
      }
      if($integer == 2) { 
        $stmt = $db ->prepare('SELECT DISTINCT ticket.ticket_id,ticket.id,ticket.department_id,ticket.status_id,ticket.tittle,ticket.description,ticket.initial_date,ticket.hashtag_id,ticket.agent_id FROM agent,department,ticket where ticket.department_id = department.department_id and agent.department_id = department.department_id and agent.id = ? ORDER BY ticket.ticket_id DESC');
      }
      
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
        return $tickets;
    }
    
  }