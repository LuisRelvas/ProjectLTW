<?php 
declare(strict_types = 1); 
require_once(dirname(__DIR__).'/database/connection.db.php');
require_once(dirname(__DIR__).'/classes/user.class.php');



function drawUser(int $id) { 
            
    $db = getDatabaseConnection();
    $user = User::getUser($db, $id);
    ?><h2><?=htmlentities($user->name)?></h2><?php
    ?><h2><?=htmlentities($user->username)?></h2><?php
    ?><h2><?=htmlentities($user->email)?></h2><?php
    if($user->role == 0) { 
        ?><h2><?php echo 'Admin' ?></h2><?php
    }
    else if($user->role == 1) { 
        ?><h2><?php echo 'Agent' ?></h2><?php
    }
    else {
        ?><h2><?php echo 'User' ?></h2><?php
    }
    
    ?>
    <section id="more"><?php
    
    } 
    ?>