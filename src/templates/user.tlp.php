<?php 
declare(strict_types = 1); 
require_once(dirname(__DIR__).'/database/connection.db.php');
require_once(dirname(__DIR__).'/classes/user.class.php');



function drawUser(int $id) { 
    
    $db = getDatabaseConnection();
    $user = User::getUser($db, $id);
    $admin = User::getUser($db, $_SESSION['id']);
    ?><h2><?=htmlentities($user->name)?></h2><?php
    ?><h2><?=htmlentities($user->username)?></h2><?php
    ?><h2><?=htmlentities($user->email)?></h2><?php
    if($user->role == 0) { 
        ?><h2><?php echo 'Admin' ?></h2><?php
    }
    else if ($user->role == 1){
        ?><h2><?php echo 'Agent' ?></h2><?php
    }
    else {
        ?><h2><?php echo 'User' ?></h2><?php
    }
    if($admin->role == 0) { 
        drawProfilesearch();
    }
    else if($admin->role == 1) { 
        drawProfilesearch();
    }
    ?> 
    <?php if(($admin->id == $_GET['id']) || ($admin->role == 0)){ ?>
    <a href="../edit/profile.edit.php?id=<?=$id?>"><h2>Editar perfil</h2></a> <?php } ?><?php
    
    ?>
    <section id="more"><?php
    
    } function drawEditUserForm() { ?>
        <section id="editProfile">
            <h1>Editar perfil</h1>
            <form action="../actions/editProfile.action.php?id=<?=$_GET['id']?>" method="post">
            <?php 
            $db = getDatabaseConnection();
            $stmt = $db->prepare('SELECT distinct(role) FROM user');
            $stmt->execute();
            $roles = $stmt->fetchAll(PDO::FETCH_COLUMN);
            $admin = User::getUser($db, $_SESSION['id']);
            $user = User::getUser($db, intval($_GET['id'])); 
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
                <label>Username: <input type="text" name="username" required="required" value="<?=htmlentities($_SESSION['input']['username oldUser'])?>"></label>
                <label>Email: <input type="email" name="email" required="required" value="<?=htmlentities($_SESSION['input']['email oldUser'])?>"></label>
                <label>Antiga password: <input type="password" name="password1"></label>
                <label>Nova password: <input type="password" name="password2"></label>
                <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
                <input id="button" type="submit" value="Concluir edição" >
            </form>

        </section> <?php 
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
                <input id="button" type="submit" value="Concluir registo">
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
          <select id = "critério1" > 
            <option value = "nameT1">Username</option>
          </select>
          <input id="searchprofile" type="text" placeholder="pesquisa">
          <section id="searchprofiles">
          </section>
      </section> <?php 
    }

    

      ?>
      