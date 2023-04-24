<?php
    require('db/conect.php');
    
    if(isset($_POST['email']) && isset($_POST['senha']) && !empty($_POST['email']) && !empty($_POST['senha'])){
        // receber os dados do post e limpar
        $email = limparPost($_POST['email']);
        $senha = limparPost($_POST['senha']);
        $senha_cript = sha1($senha);
        

        // verificar se existe o usuario
        $sql = $pdo->prepare("SELECT * FROM usuarios WHERE email=? AND senha=? LIMIT 1");
        $sql->execute(array($email,$senha_cript));
        $usuario = $sql->fetch(PDO::FETCH_ASSOC);

        if($usuario){
            // existe o usuario
            // verificar se o usuario foi confirmado
            if($usuario['status']=="confirmado"){
                // criar um token
                $token = sha1(uniqid().date('d-m-Y-H-i-s'));

                // atualizar o token do usuario no banco
                $sql = $pdo->prepare("UPDATE usuarios SET token=? WHERE email=? AND senha=?");
                if($sql->execute(array($token,$email,$senha_cript))){
                    // armazenar o token na sessão
                    $_SESSION['TOKEN'] = $token;
                    header('location: legislacao.php');
                }
            }else{
                $erro_login = "Confirme a mensagem que foi enviada ao seu email!";
            }
      
        }else{
            $erro_login = "Usuario ou senha incorretos!";
        }
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>login</title>
        <link rel="icon" type="image/x-icon" href="assets/img/chapeu-militar.png" />
        <!-- Font Awesome icons (free version)-->
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css?family=Lora:400,400i,700,700i" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
        <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

        <style>

            body{
                font-family: Arial, Helvetica, sans-serif;
            }

            .group{
                display: flex;
                flex-flow: row wrap;
                justify-content: center;
                align-items: center;
                text-align: center;
            }

            form{
                width: 400px;
                background-color: white;
                padding: 3%;
                border: solid 2px #341c14;
                border-radius: 8px;
                box-shadow: 0px 0px 20px #bebebe54;
                padding: 40px 20px 20px;
            }

            h2 {
                font-size: 2rem;
                width: 100%;
                text-align: center;
                font-weight: 900;
            }

            input {
                width: 95%;
                height: 60px;
                border-radius: 5px;
                border: 1px solid #ccc;
                margin-bottom: 15px;
                margin-left: 5%;
                padding-left: 20%;
            }

            input:focus {
                outline-color: #341c14;
            }

            .btn-blue {
                width: 90%;
                padding: 20px;
                margin: 20px 0px 20px 0px;
                cursor: pointer;
                background: #341c14;
                color: white;
                font-size: 18px;
                font-weight: bold;
                border: none;
                border-radius: 5px;
                transition: 0.5s ease;
            }

            .btn-blue:hover {
                 background: #4b2b21;
            }

            a {
                text-decoration: none;
                margin-top: 10px;
                margin-bottom: 20px;
                color: black;
            }

            a:hover {
                color: #4b2b21;
            }

            /* .input-group {
                width: 90%;
            } */

            .input-icon {
                width: 60px;
                position: absolute;
            }

            .sucesso{
                background-color: rgba(0,255,127);
                border-radius: 5px;
                width: 80%;
                height: 60px;
                border-radius: 10px;  
                margin-left: 8%;
                align-items: center;
                justify-content: center;
                color: white;
                font-weight: 900;
                display: flex;
                font-size: large;
            }

            .oculto{
                display: none;
            }

            .erro-geral{
                background-color: rgba(255, 0, 0, 0.774);
                border-radius: 5px;
                width: 95%;
                height: 60px;
                border-radius: 5px;  
                margin-right: 5%;
                align-items: center;
                justify-content: center;
                color: white;
                font-weight: 900;
                display: flex;
                font-size: large;
            }

            .erro-login{
                background-color: rgba(255, 0, 0, 0.774);
                border-radius: 5px;
                width: 95%;
                height: 60px;
                border-radius: 5px;  
                margin-right: 5%;
                align-items: center;
                justify-content: center;
                color: white;
                font-weight: 900;
                display: flex;
                font-size: large;
            }

        </style>

    </head>
    <body>

        <section class="page-section cta">
           
           <div class="container">
                <div class="group">
            <form method="post">
                
                <img src="assets/img/chapeu-militar.png">
                <h2 class="pb-2">Login</h2>

                <?php if(isset($_GET['result']) && ($_GET['result']=="ok")){ ?>
                    <div class="sucesso animate__animated animate__tada mb-3">
                    Cadastrado com sucesso!
                    </div>
                <?php } ?>

                <?php if(isset($erro_login)){ ?>
                            <div class="erro-geral mb-3 animate__animated animate__heartBeat">
                        <?php echo $erro_login; ?>
                            </div>
                        <?php } ?>
                
                <div class="input-group">
                    <img class="input-icon" src="assets/img/user.png">
                    <input type="email" name="email" placeholder="Digite seu email" required>
                </div>
                
                <div class="input-group">
                    <img class="input-icon" src="assets/img/lock.png">
                    <input type="password" name="senha" placeholder="Digite sua senha" required>
                </div>
                <a href="esqueci.php">Esqueceu a senha?</a>
                <button class="btn-blue mx-1" type="submit">Fazer Login</button><br>
                <a href="registrar.php">Ainda não tenho cadastro</a>
            </form>
               </div>
           </div>

        </section>
        <footer class="footer text-faded text-center py-5">
            <div class="container"><p class="m-0 small">Contato: <address>projeto.fn.218@gmail.com</address></p></div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
        <script src="./js/jquery-3.6.3.min.js"></script>

        <?php if(isset($_GET['result']) && ($_GET['result']=="ok")){ ?>
        <script>
            setTimeout(() => {
                $('.sucesso').hide();
            }, 3000);
        </script>
        <?php } ?>

    </body>
</html>
