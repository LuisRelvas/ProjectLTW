<?php function getID($username) {
    global $dbh;
    try {
      $stmt = $dbh->prepare('SELECT ID FROM user WHERE username = ?');
      $stmt->execute(array($username));
      if($row = $stmt->fetch()){
        return $row['ID'];
      }
    
    }catch(PDOException $e) {
      return -1;
    }
  }

  function getUser($username) {
    global $dbh;
    try {
      $stmt = $dbh->prepare('SELECT user_id, role, username, email FROM user WHERE username = ?');
      $stmt->execute(array($username));
      return $stmt->fetch();
    
    }catch(PDOException $e) {
      return null;
    }
  }

  function isLoginCorrect($username, $password) {
    global $dbh;
    $passwordhashed = hash('sha256', $password);
    try {
      $stmt = $dbh->prepare('SELECT * FROM user WHERE username = ? AND password = ?');
      $stmt->execute(array($username, $passwordhashed));
      if($stmt->fetch() !== false) {
        return getID($username);
      }
      else return -1;

    } catch(PDOException $e) {
      return -1;
    }
  }