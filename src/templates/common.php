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
                <link rel="stylesheet" href="../css/login_style.css">
                <link rel="stylesheet" href="../css/ticket_style.css">
                <link rel="stylesheet" href="../css/banner.css">
                <link rel="stylesheet" href="../css/faqAccordion.css">
                <link rel="stylesheet" href="../css/tickets_index.css">
                <link rel="stylesheet" href="../css/register_style.css">
                <link rel="stylesheet" href="../css/profile_style.css">

                <script src="../javascript/searchticket.js" defer></script>
                <script src="../javascript/searchprofile.js" defer></script>
                <script src="../javascript/searchtags.js" defer></script>
                <script>
                         function showDepartment(str) 
                         {
                            if (str == "") {
                                document.getElementById("txtHint").innerHTML = "";
                                return;
                            }
                            const xhttp = new XMLHttpRequest();
                            xhttp.onload = function() {
                            document.getElementById("txtHint").innerHTML = this.responseText;
                            }         
                            xhttp.open("GET", "../actions/getcostumer.action.php?q="+str);
                            xhttp.send();
                        }
  </script>
            <script>
                function showHashtag(str) {
                    if (str == "") {
        document.getElementById("txtHint").innerHTML = "";
        return;
      }
      const xhttp = new XMLHttpRequest();
      xhttp.onload = function() {
        document.getElementById("txtHint").innerHTML = this.responseText;
      }
      xhttp.open("GET", "../actions/getHashtag.action.php?q="+str);
      xhttp.send();

                }


            </script>    
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

            <div id="login">
                <button>
                    <a href="../actions/logout.action.php">Logout</a>
                </button>

                <button>
                    <a href="../pages/profile.php?id=<?=$id?>"><?=$name?></a>
                </button>
            
            </div>
        <?php 
        }

        function drawDefaultUser() { ?>
            <div id="login">
                <button>
                    <a href="../pages/login.php">Login</a>
                </button>

                <button>
                    <a href="../pages/register.php">Registar</a>
                </button>

                <button>
                    <a href="teste">FAQ</a>
                </button>
            
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

        function drawFAQSDefault() { 
            //$faqs = getFAQS();  // using database
            ?>
            <button class="accordion">Como chegar até a FEUP?</button>
            <div class="panel">
                <p>A FEUP (Faculdade de Engenharia da Universidade do Porto) está localizada na Rua Dr. Roberto Frias, s/n, no Porto, Portugal. Existem várias maneiras de chegar à FEUP, dependendo do seu ponto de partida e preferências de transporte.</p>
            </div>

            <button class="accordion">Qual é a ementa da cantina da FEUP?</button>
            <div class="panel">
                <p>As ementas das cantinas universitárias são atualizadas diariamente e disponibilizadas online ou num quadro de avisos na própria cantina. Pode consultar a ementa da cantina da FEUP <a href="https://sigarra.up.pt/up/pt/web_base.gera_pagina?p_pagina=ementa_cantinas">aqui</a>.</p>

</p>            
            </div>

            <script>
            var acc = document.getElementsByClassName("accordion");
            var i;

            for (i = 0; i < acc.length; i++) {
            acc[i].addEventListener("click", function() {
                this.classList.toggle("active");
                var panel = this.nextElementSibling;
                if (panel.style.display === "block") {
                panel.style.display = "none";
                } else {
                panel.style.display = "block";
                }
            });
            }
            </script>

            <?php 

        }

        function drawBanner() { ?>
            


            <section id="banner">
                <!-- <header><h1>Trouble Ticket</h1> -->
                
                </div>
                <div id="index-card">

                <div id="myticketsmenu">

                    <button>
                      <a href="../pages/ticket.php">MyTickets</a>
                    </button>

                    <button>
                      <a href="../pages/ticket.php">Add Ticket</a>
                    </button>

                    <button>
                      <a href="../pages/ticket.php">Remove Ticket</a>
                    </button>
            
                    

                </div>
            </section> <?php 
        }

        function drawAcessDenied() { ?>
            <section id="accessDenied">
                <img id= "deniedImage" src="https://cdn-icons-png.flaticon.com/512/175/175613.png" alt="Access Denied">
                <h2>Access Denied</h2>
                <h3>Sorry, you do not have permission to access this page.</h3>
                <p>You're being redirected...</p>
            </section> 
            <script>
            setTimeout(function(){
                // go to index.php
                    window.location.href = "../pages/index.php";
                }, 3000); // 5000ms = 5 seconds
            </script>
        <?php }  
        
function drawMessages(Session $session) { ?>
    <section id="messages">
        <?php foreach ($session->getMessages() as $message) { ?>
            <div id="welcome-card">
                <img src="https://uxwing.com/wp-content/themes/uxwing/download/signs-and-symbols/welcome-icon.png" alt="Welcome image">

                <article class="<?=$message['type']?>">
                    <i class='fas fa-exclamation-circle'></i>
                    <?=$message['text']?>
                </article>
            </div>
 
        <?php } ?> 
    </section> 
<?php } ?>