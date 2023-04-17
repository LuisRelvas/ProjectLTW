<?php 
    declare(strict_types = 1);
    function drawHeader() { ?>
        <!DOCTYPE html>
        <html lang="PT-pt">
            <head>
                <title>Trouble Ticket FEUP</title>
                <meta
                    name = "LTW Project"
                    encoding = "utf-8"
                    author = "Relvas, Domingues, Angy"
                >
                <link rel="stylesheet" href="../css/main.css">
                <link rel="stylesheet" href="../css/login.css">
                <link rel="stylesheet" href="../css/register.css">
                <link rel="stylesheet" href="../css/ulala.css">
            </head>
            <body>
                <header>
                    <nav id="topbar" >
                        <a class="item" href="../pages/index.php"><h3>Trouble Ticket</h3></a>
                        <?php 
                            if (isset($_SESSION['user_id'])) drawLoginUser($_SESSION['user_id'], $_SESSION['name']);
                            else drawDefaultUser(); 
                        ?>
                    </nav>
                </header>
            <main> <?php 
        }

        function drawLoginUser(int $user_id, string $name) { ?>
            <section id="login">
                <h3 class="loginItem"><a href="../actions/logout.action.php">Logout</a></h3>
                <h3 class="loginItem"><?=$name?></h3>
            </section>
        <?php 
        }

        function drawDefaultUser() { ?>
            <section id="login">
                <h3 class="loginItem"><a href="../pages/login.php">Login</a></h3>
                <h3 class="loginItem"><a href="../pages/register.php">Register</a></h3>
            </section>
        <?php 
        }

        function drawLogin(Session $session) { ?>
            <section id="loginpage">
                <h1>Login</h1>
                <form action = "../actions/login.action.php" method = "post">
                    <label>Email: <input type="email" name="email" value="<?=htmlentities($_SESSION['input']['email login'])?>"></label>
                    <label>Password:<input type="password" name="password" value="<?=htmlentities($_SESSION['input']['password login'])?>"></label>
                    <input id="button" type="submit" value="Entrar">
                </form>
            </section> <?php 
        }

        function drawBanner() { ?>
            <section id="banner">
                <header><h1>Trouble Ticket</h1>
                <a href="../pages/profile.php">Profile</a>
            </header>
            </section> <?php 
        }

        function drawAcessDenied() { ?>
            <section id="accessDenied">
                <h2>Voltar para a <a href="../pages/register.php">página principal</a></h2>  
            </section> 
        <?php } 
function drawMessages(Session $session) { ?>
<section id="messages">
    <?php foreach ($session->getMessages() as $message) { ?>
        <article class="<?=$message['type']?>">
        <i class='fas fa-exclamation-circle'></i>
        <?=$message['text']?>
        </article>
    <?php } ?> </section> 
<?php } ?>
