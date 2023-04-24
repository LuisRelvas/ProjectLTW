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

}

