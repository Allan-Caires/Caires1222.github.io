<?php 
    require('db/conect.php');
    
    if(isset($_GET['cod_confirm']) && !empty($_GET['cod_confirm'])){
    
        //LIMPAR O GET
        $cod = limparPost($_GET['cod_confirm']);
    
        //CONSULTAR SE ALGUM USUARIO TEM ESSE CODIGO DE CONFIRMACAO
        //VERIFICAR SE EXISTE ESTE USUÁRIO
        $sql = $pdo->prepare("SELECT * FROM usuarios WHERE codigo_confirmacao=? LIMIT 1");
        $sql->execute(array($cod));
        $usuario = $sql->fetch(PDO::FETCH_ASSOC);
        if($usuario){
            //ATUALIZAR O STATUS PARA CONFIRMADO
            $status = "confirmado";
            $sql = $pdo->prepare("UPDATE usuarios SET status=? WHERE codigo_confirmacao=?");
            if($sql->execute(array($status,$cod))){            
                header('location: login.php?result=ok');
            }
        }else{
           echo "<h1>Código de confirmação inválido!</h1>";
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
        <title>Obrigado!</title>
            <!-- adsense -->
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-4731328267307804"
     crossorigin="anonymous"></script>
     
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

        
        <div>
            <div class="footer text-faded text-center py-5 my-5">
                <h1>Obrigado pelo cadastro, bons estudos!</h1>
                <div class="intro-button mx-auto"><a class="btn btn-primary btn-xl" href="http://localhost/Projeto-FN/legislacao.php">Ir para seus estudos</a></div>
                <center><script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
<lottie-player src="https://assets4.lottiefiles.com/packages/lf20_iCh2iurm2e.json"  background="transparent"  speed="1"  style="width: 300px; height: 300px;"  loop  autoplay></lottie-player></center>
            </div>
        </div>
        
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
        <script src="./js/jquery-3.6.3.min.js"></script>
        
    </body>
</html>
