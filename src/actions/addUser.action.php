<?php
    declare(strict_types = 1);
    require_once(dirname(__DIR__).'/database/connection.db.php');
    require_once(dirname(__DIR__).'/classes/session.class.php');
    require_once(dirname(__DIR__).'/utils/validator.php');
    $session = new Session();
    
    $_SESSION['input']['username newUser'] = htmlentities($_POST['username']);
    $_SESSION['input']['name newUser'] = htmlentities($_POST['name']);
    $_SESSION['input']['email newUser'] = htmlentities($_POST['email']);
    $_SESSION['input']['password1 newUser'] = htmlentities($_POST['password1']);
    $_SESSION['input']['password2 newUser'] = htmlentities($_POST['password2']);

    $db = getDatabaseConnection();
    $stmt1 = $db->prepare('SELECT * FROM user WHERE username = ?'); 
    $stmt1->execute(array($_POST['username']));
    $username = $stmt1->fetch();
    $stmt2 = $db->prepare('SELECT * FROM user where email = ?'); 
    $stmt2->execute(array($_POST['email']));
    $email = $stmt2->fetch();
    if($username) {
        $session->addMessage('error', 'Username already exists');
        header('Location: ../pages/register.php');
        die();
     }
    if($email) { 
        $session->addMessage('error', 'Email already exists');
        header('Location: ../pages/register.php');
        die();
    }

    if($email && $username) {
        $session->addMessage('error', 'Email and Username already exists');
        header('Location: ../pages/register.php');
        die();
    }
    
    else if ($_POST['password1'] == $_POST['password2'] && valid_password($_POST['password1']) && valid_name($_POST['name']) && valid_email($_POST['email']) && valid_name($_POST['username'])) {

        $stmt = $db->prepare('INSERT INTO user(username, name, email, password) VALUES (?, ?, ?, ?)');
        $stmt->execute(array($_POST['username'], $_POST['name'], $_POST['email'],password_hash($_POST['password1'], PASSWORD_DEFAULT)));
        unset($_SESSION['input']);
        $session->addMessage('success', 'User registado com sucesso');
        header('Location: ../pages/login.php');
        
    } else {
        $session->addMessage('error', 'Invalid input');
        header('Location: ../pages/register.php');
    }

    
?>