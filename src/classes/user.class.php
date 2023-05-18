<?php
    
  declare(strict_types = 1);
  require_once(dirname(__DIR__).'/utils/validator.php');

  class User {

    public int $id;
    public int $role;
    public string $username;
    public string $name;
    public string $email;
    public string $password;

    public function __construct(int $id, int $role, string $username, string $name, string $email) { 
      $this->id = $id;
      $this->role = $role;
      $this->username = $username;
      $this->name = $name;
      $this->email = $email;
    }
    static function getUserWithPassword(PDO $db, string $email, string $password) : ?User {
      if(valid_email($email)){
      $stmt = $db->prepare('SELECT id,role,username,name,email,password FROM user WHERE email = ?');
      $stmt->execute(array(strtolower($email)));
      $user = $stmt->fetch();
      if($user['email'] == null || $user['password'] == null){
        header('Location: ../pages/login.php');
        return null;

      }
      if(password_verify($password,$user['password']) && $user['email'] == $email){
        return new User(
          intval($user['id']),
          $user['role'],
          $user['username'],
          $user['name'],
          $user['email'],
        );
      }
      else return null;
    }
  }

  static function getRole(PDO $db,int $role) : string {
      if($role == 0){
        return "Admin";
      }
      else if($role == 1){
        return "Agent";
      }
      else if($role == 2){
        return "User";
      }
      else return "Unknown";
  }

  static function countTickets(PDO $db,int $id) : int {
    $stmt = $db->prepare('SELECT COUNT(*) FROM changes WHERE id = ? and closed_id = 1');
    $stmt->execute(array($id));
    $count = $stmt->fetch();
    return $count['COUNT(*)'];

  }

    public function getName() : string {
      $names = explode(" ", $this->name);
      return count($names) > 1 ? $names[0] . " " . $names[count($names)-1] : $names[0];
    }

    static function getUserId(PDO $db,string $username) : ?User { 
      $stmt = $db -> prepare('SELECT id,role,username,name,email from user where username = ?');
      $stmt->execute(array($username));
      $user = $stmt->fetch();
      if($user){
      return new User(
        intval($user['id']),
        $user['role'],
        $user['username'],
        $user['name'],
        $user['email'],
      );
    }
    else return null;
      
    }

    static function getUser(PDO $db, int $id) : ?User {
      
      $stmt = $db->prepare('SELECT id,role,username,name,email,password FROM user WHERE id = ?');
      $stmt->execute(array(intval($id)));
      $user = $stmt->fetch();
      if($user){
      return new User(
          $user['id'],
          $user['role'],
          $user['username'],
          $user['name'],
          $user['email']
          
      );}
      else return null;
    } 

    static function getPass(PDO $db, int $id) : string {
      
      $stmt = $db->prepare('SELECT id,role,username,name,email,password FROM user WHERE id = ?');
      $stmt->execute(array(intval($id)));
      $user = $stmt->fetch();
      return $user['password'];
    }

    static function savePass(PDO $db, int $id, string $password) {
      $hashed_password = password_hash($password, PASSWORD_DEFAULT);
      $stmt = $db->prepare('UPDATE user SET password = ? WHERE id = ?');
      $stmt->execute(array($hashed_password, $id));
    
    }
    function save($db) {
      $session = new Session();
      if($this->role == 0) {
        $stmt1 = $db->prepare('SELECT * FROM department');
        $stmt1->execute();
        $department = $stmt1->fetchAll();
        foreach($department as $departments){ 
          $stmt3 = $db->prepare('SELECT * FROM agent where id = ? and department_id = ?');
          $stmt3->execute(array($this->id,$departments['department_id']));
          $agent = $stmt3->fetch();
          if(!$agent) { 
            
          $stmt2 = $db->prepare('INSERT INTO agent (id,department_id) VALUES (?,?)');
          $stmt2->execute(array($this->id,$departments['department_id']));}
        }
      }
      if($this->role == 1) {
        $stmt1 = $db->prepare('DELETE FROM agent WHERE id = ? ');
        $stmt1->execute(array($this->id));
        $stmt2 = $db->prepare('INSERT INTO agent (id,department_id) VALUES (?,?)');
        $stmt2->execute(array($this->id,1));
      }

      if($this->role == 2) { 
        $stmt1 = $db->prepare('DELETE FROM agent where id = ?');
        $stmt1->execute(array($this->id));
      }
      $stmt = $db->prepare('UPDATE user SET role = ? ,username = ?, name = ?, email = ? WHERE id = ?');
      $stmt->execute(array($this->role, $this->username, $this->name, $this->email,$this->id));
      
  }
  static function search(PDO $db, string $search, string $type) : array {

    $querie = '';
    $result = array();

    switch ($type) {
      case "nameT1":
          $querie = 'SELECT * FROM user WHERE username LIKE ?';
          break;
      default:  
          return $result;
    }

    $stmt = $db->prepare($querie);
    $stmt->execute(array('%'.$search.'%'));

    while ($user = $stmt->fetch()) {
      $result[] = new User(
        $user['id'],
        $user['role'],
        $user['username'],
        $user['name'],
        $user['email'],
      );
    }
    return $result;
  }
  
  static function search2(PDO $db, string $search, string $type) : array {

    $querie = '';
    $result = array();

    switch ($type) {
      case "nameA1":
          $querie = 'SELECT * FROM user WHERE username LIKE ?';
          break;
      default:  
          return $result;
    }

    $stmt = $db->prepare($querie);
    $stmt->execute(array('%'.$search.'%'));

    while ($user = $stmt->fetch()) {
      $result[] = new User(
        $user['id'],
        $user['role'],
        $user['username'],
        $user['name'],
        $user['email'],
      );
    }
    return $result;
  } 
}



?>