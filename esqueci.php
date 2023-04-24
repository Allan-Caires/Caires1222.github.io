<?php
    require('db/conect.php');

    //REQUERIMENTO DO PHPMAILER
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'db/PHPMailer/src/Exception.php';
    require 'db/PHPMailer/src/PHPMailer.php';
    require 'db/PHPMailer/src/SMTP.php';

    
    if(isset($_POST['email']) && !empty($_POST['email'])){
         // receber os dados do post e limpar
         $email = limparPost($_POST['email']);
         $status = "confirmado";

          // verificar se existe o usuario
        $sql = $pdo->prepare("SELECT * FROM usuarios WHERE email=? AND status=? LIMIT 1");
        $sql->execute(array($email,$status));
        $usuario = $sql->fetch(PDO::FETCH_ASSOC);

        if($usuario){
            // existe o usuario

            {
                // enviar email
                $mail = new PHPMailer(true);
                $cod = sha1(uniqid());

                // atualizar o codigo de recuperação do usuario no banco
                $sql = $pdo->prepare("UPDATE usuarios SET recupera_senha=? WHERE email=?");
                if($sql->execute(array($cod,$email))){
                    
                    try {
                        //Recipients
                        $mail->setFrom('projeto.fn.218@gmail.com', 'ProjetoFN'); //quem manda o email
                        $mail->addAddress($email, $nome);
                        //Content
                        $mail->isHTML(true);    //Set email format to HTML
                        $mail->Subject = 'Recuperar Senha!'; //titulo do email
                        $mail->Body    = '<h1 style="">ProjetoFN <img src="assets/img/chapeu-militar.png"></h1><br><br>< href="https://projetofuzileironaval.com/recuperar-senha.php?cod='.$cod.'">Recuperar Senha</a>'; //corpo do email
    
                        $mail->send();
                        header('location: email-enviado-recupera.html');
    
                    } catch (Exception $e) {
                        echo "Ocorreu um erro ao enviar o email: {$mail->ErrorInfo}";
                    }
                }

                }

                

    }else{
        $erro_usuario = "Usuário não encontrado!";
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
        <title>Esqueceu a senha</title>
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
                <h2 class="pb-2">Recuperar Senha</h2>

                <?php if(isset($erro_usuario)){ ?>
                            <div class="erro-geral mb-3 animate__animated animate__heartBeat">
                        <?php echo $erro_usuario; ?>
                            </div>
                        <?php } ?>
                
                <div class="input-group">
                    <img class="input-icon" src="assets/img/user.png">
                    <input type="email" name="email" placeholder="Digite seu email" required>
                </div>
            
                <button class="btn-blue mx-1" type="submit">Recuperar Senha</button><br>
                <a href="login.php">Voltar para login</a>
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

    </body>
</html>
