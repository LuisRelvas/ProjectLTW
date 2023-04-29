<?php 
    declare(strict_types = 1);
    function drawHeader(Session $session) { ?>
        <!DOCTYPE html>
        <html lang="PT-pt">
            <head>
                <title>Trouble Ticket FEUP</title>
                <meta
                    name = "LTW Project"
                    encoding = "utf-8"
                    author = "Relvas, Domingos, Angy"
                >
                <link rel="stylesheet" href="../css/header_style.css">
                <script src="../javascript/searchticket.js" defer></script>
                <script src="../javascript/searchprofile.js" defer></script>
               
            </head>
            <body>
                <header>
                        <a href="../pages/index.php">
                            <img src="https://dec.fe.up.pt/wp-content/uploads/2021/03/logo-feup-white.png" alt="Logo of site">
                        </a>
                        <?php
                            if ($session->isLoggedIn()) 
                            drawLoginUser($session->getId(), $session->getName());
                            else drawDefaultUser();
                        ?>
            
                </header>
            </body>
            <?php 
        }

        function drawLoginUser(int $id, string $name) { ?>
            <section id="login">
                <h3 class="loginItem"><a href="../actions/logout.action.php">Logout</a></h3>
                <h3 class="loginItem"><?=$name?></h3>
                <h3 class="loginItem"><?=$id?></h3>
                <h3 class="loginItem"><a href="../pages/profile.php?id=<?=$id?>" >PERFIL</a></h3> 
            </section>
        <?php 
        }

        function drawDefaultUser() { ?>
            <div id="login">
                <h3 class="loginItem"><a href="../pages/login.php">Login</a></h3>
                <h3 class="loginItem"><a href="../pages/register.php">Register</a></h3>
                <h3 class ="loginItem"><a href="teste">FAQ</a></h3>
            </div>
        <?php 
        }

        function drawLogin() { ?>
            <section id="loginpage">
                <h1>Login</h1>
                <form action = "../actions/login.action.php" method = "post">
                    <label>Email: <input type="email" name="email" placeholder="email"></label>
                    <label>Password:<input type="password" name="password" placeholder="password"></label>
                    <input id="button" type="submit" value="Entrar">
                </form>
            </section> <?php 
        }

        function drawBanner() { ?>
            <section id="banner">
                <!-- <header><h1>Trouble Ticket</h1> -->
            </header>
            <h1 class = "loginItem"><a href="../pages/ticket.php">TICKET</a></h1>
            </section> <?php 
        }

        function drawAcessDenied() { ?>
            <section id="accessDenied">
                <h2>Voltar para a <a href="../pages/register.php">página principal</a></h2>  
            </section> 
        <?php } 
        
        function drawTicket(int $id) { ?>
            <section id ="ticket">
                <h2>Ticket Management</h2>
                <form action = "../pages/ticketadd.php" method = "post">
                    <label>ADD TICKET</label>
                    <input id="button" type="submit" value="Entrar">
                </form>
                <h1 class = "ticketitem"><a href="../pages/ticketsee.php">SEE TICKET</a></h1>
                <form action = "../pages/ticketmanage.php" method = "post">
                    <label>MANAGE TICKET</label>
                    <input id="button" type="submit" value="Entrar">
                </form>
         <?php }

        


function drawMessages(Session $session) { ?>
    <section id="messages">
        <?php foreach ($session->getMessages() as $message) { ?>
            <article class="<?=$message['type']?>">
                <i class='fas fa-exclamation-circle'></i>
            <?=$message['text']?>
            </article>
        <?php } ?> 
    </section> 
<?php } ?>
