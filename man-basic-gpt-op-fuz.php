<?php
require('db/conect.php');

$user = auth($_SESSION['TOKEN']);
if($user){

}else{
    header('location: login.php');
}

?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Manual dos Grupamentos Operativos de Fuzileiros Navais</title>
        <link rel="icon" type="image/x-icon" href="assets/img/chapeu-militar.png" />
        <!-- Font Awesome icons (free version)-->
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css?family=Lora:400,400i,700,700i" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
    <!-- adsense -->
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-4731328267307804"
     crossorigin="anonymous"></script>
     
    </head>
    <body>
        <header>
            <h1 class="site-heading text-center text-faded d-none d-lg-block">
                <span class="site-heading-upper text-primary mb-3">Aprenda jogando</span>
                <span class="site-heading-upper">MANUAL DOS GRUPAMENTOS OPERATIVOS DE FUZILEIROS 
                    NAVAIS</span>
            </h1>
        </header>
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-dark py-lg-4" id="mainNav">
            <div class="container">
                <a class="navbar-brand text-uppercase fw-bold d-lg-none" href="man-basic-gpt-op-fuz.php">MANUAL DOS GPT OP DE FUZNAV</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul style="align-items: center;" class="navbar-nav mx-auto">
                        <li class="nav-item px-lg-4"><a class="nav-link text-uppercase" href="legislacao.php">Legislação</a></li>
                        <li class="nav-item px-lg-4"><a class="nav-link text-uppercase" href="man-fuz-nav.php">MANUAL DO FUZILEIRO NAVAL</a></li>
                        <li class="nav-item px-lg-4"><a class="nav-link text-uppercase" href="man-basic-combat-anf.php"> MANUAL BÁSICO DO COMBATENTE ANFÍBIO</a></li>
                        <li class="nav-item px-lg-4"><a class="nav-link text-uppercase" href="man-basic-gpt-op-fuz.php">MANUAL BÁSICO DOS GRUPAMENTOS OPERATIVOS DE FUZILEIROS 
                            NAVAIS </a></li>
                        <li class="nav-item px-lg-4"><a class="nav-link text-uppercase" href="lidranca.php">DOUTRINA DE LIDERANÇA DA MARINHA</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <section class="page-section cta">
            <div class="container">
                <div class="row">
                    <div class="col-xl-9 mx-auto">
                        <div class="cta-inner bg-faded text-center rounded">
                            <h2 class="section-heading mb-5">
                                <span class="section-heading-upper">Escolha a</span>
                                <span class="section-heading-lower">matéria</span>
                            </h2>
                            <ul class="list-unstyled list-hours mb-5 text-left mx-auto">
                                <li style="color: #000; font-weight: 100;" class="list-unstyled-item list-hours-item d-flex">
                                    Guerra, Conflito, Poder
                                    <span class="ms-auto"><a style="text-decoration: none;" target="_blank" href="/manual-basico-grup-op-de-fuznav/guerra-confli-poder.html">JOGAR</a></span>
                                </li>
                                <li style="color: #000; font-weight: 100;" class="list-unstyled-item list-hours-item d-flex">
                                    Os Fuzileiros Navais
                                    <span class="ms-auto"><a style="text-decoration: none;" target="_blank" href="/manual-basico-grup-op-de-fuznav/fuzileiros-navais.html">JOGAR</a></span>
                                </li>
                            </ul>
                        </div>
                    </div>
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
