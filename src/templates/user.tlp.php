<?php 
declare(strict_types = 1); 
require_once(dirname(__DIR__).'/database/connection.db.php');
require_once(dirname(__DIR__).'/classes/user.class.php');
require_once(dirname(__DIR__).'/classes/department.class.php');



function drawUser(int $id) { 
    $session = new Session();
    
    $db = getDatabaseConnection();
    $user = User::getUser($db, $id);
    $admin = User::getUser($db, $_SESSION['id']);
    if($user) { 
    ?><div class="user-data">
        <label for="name">Nome:</label>
        <span><?=htmlentities($user->name)?></span>
    </div><?php

    ?><div class="user-data">
        <label for="username">Username:</label>
        <span><?=htmlentities($user->username)?></span>
    </div><?php

    ?><div class="user-data">
        <label for="email">E-mail:</label>
        <span><?=htmlentities($user->email)?></span>
    </div><?php

    ?><div class="user-data">
    <label for="role">Role:</label>
    <?php 
        if ($user->role == 0) {
            $role = 'Admin';
        } else if ($user->role == 1) {
            $role = 'Agente';
        } else {
            $role = 'Usuario';
        }
    ?>
    <span><?=htmlentities($role)?></span>
    </div><?php
    if($admin->role == 0) {
        $departments = Department::getDepartmentAgent($db, $user->id);
        drawProfilesearch();
        $counter = User::countTickets($db, $user->id);
    }
    else if($admin->role == 1) { 
        $departments = Department::getDepartmentAgent($db, $user->id);
        drawProfilesearch();
        $counter = User::countTickets($db, $user->id);
    }
    
    if($user->role != 2){ ?>

    <div class="user-data">
        <label for="department">Departamento:</label>
        <span><?php foreach($departments as $department) {  ?></span>
        <span><?php 
        $department_name = Department::getDepartmentName($db, $department['department_id']);
        echo($department_name)
        ?></span>
        <?php } ?>
    </div>
    <div class="user-data">
        <label for="counter">Tickets Fechados:</label>
        <span><?=($counter)?></span>
    </div><?php
    } ?>

    <?php
    if(($admin->id == $_GET['id']) || ($admin->role == 0)){ ?>
    
    <form action="../edit/profile.edit.php?id=<?=$id?>" method="post">
    <input id="edit-profile-button" type="submit" value="Editar Perfil">
    </form>
</h1><?php
    }}
    else { 
        $session->addMessage('error', 'Utilizador não encontrado');
        die(header('Location: ../pages/profilephp'));
    }
    ?>
    <section id="more"><?php
    
    }


    function drawEditUserForm() { ?>
        <div id="editProfile">
            <h1>Editar perfil</h1>
            <form action="../actions/editProfile.action.php?id=<?=$_GET['id']?>" method="post">
            <?php
            if($_SESSION['id'] == $_GET['id'] || $_SESSION['role'] == 0){
            $db = getDatabaseConnection();
            $stmt = $db->prepare('SELECT distinct(role) FROM user');
            $stmt->execute();
            $roles = $stmt->fetchAll(PDO::FETCH_COLUMN);
            $admin = User::getUser($db, $_SESSION['id']);
            $user = User::getUser($db, intval($_GET['id'])); 
            
            if($_SESSION['role'] != 2) {
            ?>
            
                <label> Role: </label> <?php } ?> <?php
                if($admin->role == 0) { ?>
        <select name="role">
            <optgroup label="Choose only one">
                <?php foreach ($roles as $role) { ?>
                    <option value="<?= $role ?>"><?= $role ?></option>
                <?php }  ?>
            </optgroup>
        </select>

            <?php } ?>
                <label>Nome: <input type="text" name="name" required="required" value="<?=htmlentities($user->name)?>"></label>
                <label>Username: <input type="text" name="username" required="required" value="<?=htmlentities($user->username)?>"></label>
                <label>Email: <input type="email" name="email" required="required" value="<?=htmlentities($user->email)?>"></label>
                <label>Antiga password: <input type="password" name="password1"></label>
                <label>Nova password: <input type="password" name="password2"></label>
                <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
                <input id="button" type="submit" value="Concluir Edição" >
            </form>
                </div>

        </section> <?php }  
    else{ 
        drawAcessDenied();
    }   
}
    function drawRegisterUser() { ?>
        <section id="registerUser">
            <h1>Register</h1>
            <form action="../actions/addUser.action.php" method="post">
                <label>Username: <input type="text" name = "username" required="required" value="<?=htmlentities($_SESSION['input']['username newUser'])?>"></label>
                <label>Name: <input type="text" name="name" required="required" value="<?=htmlentities($_SESSION['input']['name newUser'])?>"></label>
                <label>Email: <input type="email" name="email" required="required" value="<?=htmlentities($_SESSION['input']['email newUser'])?>"></label>
                <label>Password: <input type="password" name="password1" required="required" value="<?=htmlentities($_SESSION['input']['password1 newUser'])?>"></label>
                <label>Confirme password: <input type="password" name="password2" required="required" value="<?=htmlentities($_SESSION['input']['password2 newUser'])?>"></label>
                <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
                <input id="button" type="submit" value="Concluir Registo">
            </form>
        </section> <?php 
      }

      function drawllUsernames(){ ?>
        <?php 
        $db = getDatabaseConnection();
        $stmt = $db->prepare('SELECT username FROM user');
        $stmt->execute();
        $usernames = $stmt->fetchAll(PDO::FETCH_COLUMN);
        ?>
        <div id = "all-usernames">
        <form action="../" method ="post">
              <label>Username:</label>
              <select name="status">
                <optgroup label="List:">
                    <?php foreach ($usernames as $username) { ?>
                        <option value="<?= $username ?>"><?= $username ?></option>
                    <?php }  ?>
                </optgroup>
            </select>
          </form>
    </div>
    
    <?php
    }

    function drawProfilesearch() { ?>
        <section id = "searching1">
          <select id = "criterio1" > 
            <option value = "nameT1">Username</option>
          </select>
          <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
          <input id="searchprofile" type="text" placeholder="pesquisa">
          <section id="searchprofiles">

          </section>
      </section> <?php 
    }

    

      ?>
      