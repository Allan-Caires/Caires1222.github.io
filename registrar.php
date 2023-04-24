<?php
require('db/conect.php');

//REQUERIMENTO DO PHPMAILER
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'db/PHPMailer/src/Exception.php';
require 'db/PHPMailer/src/PHPMailer.php';
require 'db/PHPMailer/src/SMTP.php';

// verificar se existe de acordo com o campo
if(isset($_POST['nome_completo']) && isset($_POST['email']) && isset($_POST['senha']) && isset($_POST['repete_senha'])){
    // verificar se todos foram preenchidos
    if(empty($_POST['nome_completo']) or empty($_POST['email']) or empty($_POST['senha']) or empty($_POST['repete_senha']) or empty($_POST['termos'])){
        $erro_geral = "Todos os campos são obrigatórios!";
    }else{
        // receber e limpar valores do post
        $nome = limparPost($_POST['nome_completo']);
        $email = limparPost($_POST['email']);
        $senha = limparPost($_POST['senha']);
        $senha_cript = sha1($senha);
        $repete_senha = limparPost($_POST['repete_senha']);
        $checkbox = limparPost($_POST['termos']);

        // verificar
        if (!preg_match("/^[a-zA-Z-' ]*$/",$nome)) {
            $erro_nome = "Somente letras e espaços em branco";
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $erro_email = "Email inválido";
        }

        if(strlen($senha) <6){
            $erro_senha = "Mínimo 6 dígitos";
        }

        if($senha !== $repete_senha){
            $erro_repete_senha = "Senhas não conferem";
        }

        if($checkbox !=="ok"){
            $erro_checkbox = "Desmarcado";
        }

        if(!isset($erro_geral) && !isset($erro_nome) && !isset($erro_email) && !isset($erro_senha) && !isset($erro_repete_senha) && !isset($erro_checkbox)){
            // verificar se o email ja está cadastrado
            $sql = $pdo->prepare("SELECT * FROM usuarios WHERE email=? LIMIT 1");
            $sql->execute(array($email));
            $usuario = $sql->fetch();

            // se nao existir adicionar
            if(!$usuario){
                $recupera_senha = "";
                $token = "";
                $codigo_confirmacao = uniqid();
                $status = "novo";
                $data_cadastro = date('d/m/y');
                $sql = $pdo->prepare("INSERT INTO usuarios VALUES(null,?,?,?,?,?,?,?,?)");
                if($sql->execute(array($nome,$email,$senha_cript,$recupera_senha,$token,$codigo_confirmacao,$status,$data_cadastro))){
                    // sendo local
                    if($modo == "producao"){
                        header('location: login.php?result=ok');
                    }
                    // sendo produção
                    if($modo == "producao"){
                        // enviar email
                        $mail = new PHPMailer(true);

                        try {
                            //Recipients
                            $mail->setFrom('projeto.fn.218@gmail.com', 'ProjetoFN'); //quem manda o email
                            $mail->addAddress($email, $nome);
                            //Content
                            $mail->isHTML(true);    //Set email format to HTML
                            $mail->Subject = 'Confirme seu cadasro!'; //titulo do email
                            $mail->Body    = '<h1 style="">ProjetoFN <img src="assets/img/chapeu-militar.png"></h1><br><br>< href="https://projetofuzileironaval.com/confirmacao.php?cod_confirm='.$codigo_confirmacao.'">Confirmar E-mail</a>'; //corpo do email

                            $mail->send();
                            header('location: obrigado.html');

                        } catch (Exception $e) {
                            echo "Ocorreu um erro ao enviar o email: {$mail->ErrorInfo}";
                        }
                    }
                }
            }else{
                // já existe mostrar erro
                $erro_geral = "Usuario já cadastrado!";
            }
        }

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
        <title>Cadastrar</title>
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

            h1 {
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

            .link {
                color: #00c3ff;
                text-decoration: underline;
            }

            /* .input-group {
                width: 90%;
            } */

            .input-icon {
                width: 60px;
                position: absolute;
            }

            input[type='checkbox'] {
                display: inline-block;
                height: 20px;
                width: 5%;
                vertical-align: middle;
            }

            label {
                display: inline-block;
                width: 85%;
                font-size: 13px;
                margin-top: 15px;
                cursor: pointer;
                word-wrap: break-word;
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
            
            .erro-input{
                border: solid 1px rgba(255, 0, 0, 0.774);
            }

            .erro{
                color: rgba(255, 0, 0, 0.774);
                font-weight: bold;
            }

        </style>

    </head>
    <body>

        <section class="page-section cta">
           
           <div class="container">
                <div class="group">
                    <form method="post">

                        <img src="assets/img/chapeu-militar.png">
                        <h1 class="mb-3">Cadastrar</h1>

                        <?php if(isset($erro_geral)){ ?>
                            <div class="erro-geral mb-3 animate__animated animate__heartBeat">
                        <?php echo $erro_geral; ?>
                            </div>
                        <?php } ?>
                        
                
                        <div class="input-group">
                            <img class="input-icon" src="assets/img/card.png">
                            <input <?php if(isset($erro_geral) or isset($erro_nome)){echo 'class="erro-input"';}?> name="nome_completo"  type="text" placeholder="Nome Completo" <?php if(isset($nome)){echo "value='$nome'";}?> required>
                            <?php if(isset($erro_nome)){?>
                                <div class="erro mb-3"><?php echo $erro_nome; ?> </div>
                            <?php } ?>
                            
                        </div>
                
                        <div class="input-group">
                            <img class="input-icon" src="assets/img/user.png">
                            <input <?php if(isset($erro_geral) or isset($erro_email)){echo 'class="erro-input"';}?> name="email"  type="email" placeholder="Seu melhor email" <?php if(isset($email)){echo "value='$email'";}?> required>
                            <?php if(isset($erro_email)){?>
                                <div class="erro mb-3"><?php echo $erro_email; ?> </div>
                            <?php } ?>
                        </div>
                
                        <div class="input-group">
                            <img class="input-icon" src="assets/img/lock.png">
                            <input <?php if(isset($erro_geral) or isset($erro_senha)){echo 'class="erro-input"';}?> name="senha"  type="password" placeholder="Senha mínimo 6 Dígitos" <?php if(isset($senha)){echo "value='$senha'";}?> required>
                            <?php if(isset($erro_senha)){?>
                                <div class="erro mb-3"><?php echo $erro_senha; ?> </div>
                            <?php } ?>
                        </div>
                
                        <div class="input-group">
                            <img class="input-icon" src="assets/img/lock-open.png">
                            <input <?php if(isset($erro_geral) or isset($erro_repete_senha)){echo 'class="erro-input"';}?> name="repete_senha"  type="password" placeholder="Repita a senha criada" <?php if(isset($repete_senha)){echo "value='$repete_senha'";}?> required>
                            <?php if(isset($erro_repete_senha)){?>
                                <div class="erro mb-3"><?php echo $erro_repete_senha; ?> </div>
                            <?php } ?>
                        </div>   
                        
                        <div <?php if(isset($erro_geral) or isset($erro_checkbox)){echo 'class="input-group erro-input"';}else{echo 'class"input-group"';}?> class="">
                            <input type="checkbox" id="termos" name="termos" value="ok" <?php if(isset($termos)){echo "value='$termos'";}?> required>
                            <?php if(isset($erro_checkbox)){?>
                                <div class="erro mb-3"><?php echo $erro_checkbox; ?> </div>
                            <?php } ?>
                            <label for="termos">Ao se cadastrar você concorda com a nossa <a class="link" href="termos.php">Política de Privacidade</a> e os <a class="link" href="uso.php">Termos de uso</a></label>
                        </div>  
                        
                        <button class="btn-blue" type="submit">Cadastrar</button><br>
                        <a href="login.php">Já tenho uma conta</a>
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
    </body>
</html>
