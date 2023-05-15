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
    if ($_POST['password1'] === $_POST['password2'] && valid_password($_POST['password1']) && valid_name($_POST['name']) && valid_email($_POST['email']) && valid_name($_POST['username'])) {

        $stmt = $db->prepare('INSERT INTO user(username, name, email, password) VALUES (?, ?, ?, ?)');
        $stmt->execute(array($_POST['username'], $_POST['name'], $_POST['email'],password_hash($_POST['password1'], PASSWORD_DEFAULT)));
        unset($_SESSION['input']);
        header('Location: ../pages/login.php');
        echo "User added successfully";

    } else {
        header('Location: ../pages/register.php');
    }

    
?>