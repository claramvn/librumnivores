<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8" />
    <title>- Librumnivores - <?= $title ?>
    </title>
    <!-- favicon -->
    <link rel="icon" type="image/png" href="Public/img/favicon.png" />
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
        integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <!-- Grenze Gotisch google font --> 
    <link href="https://fonts.googleapis.com/css2?family=Grenze+Gotisch:wght@200&display=swap" rel="stylesheet">
    <!-- Montserrat google font --> 
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200&display=swap" rel="stylesheet">
    <!-- Boostrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <!-- CSS -->
    <link href="Public/css/style.css" rel="stylesheet" />
</head>


<body>

    <!-- HEADER --> 
    <header id="header">
        <div>
            <h1 id="librum"><a href="index.php">LIBRUMNIVORES</a></h1>
        </div>
        <div>
            <nav>
                <ul class="nav">
                    <?php
                    if ($this->isLogged()) { 
                    ?>
                        <li class="nav-item"><a class="nav-link" >Bienvenue à toi <?php echo ' ' . $this->user['name_user'] . ' ';?> <span class="logged"><i class="fas fa-square"></i></span></a></li>
                        <li class="nav-item"><a class="nav-link" href="index.php">ACCUEIL</a></li>
                        <li class="nav-item"><a class="nav-link" href="index.php?action=listBooks">BIBLIOTHÈQUE</a></li>
                        <li class="nav-item"><a class="nav-link" href="index.php?action=listWishBooks">SOUHAITS</a></li>
                        <li class="nav-item"><a class="nav-link" href="index.php?action=listFavoritesBooks">FAVORIS</a></li>
                        <li class="nav-item"><a class="nav-link" href="index.php?action=listLentBooks">PRÊTS</a></li>
                        <li class="nav-item"><a class="nav-link" href="index.php?action=logout">DÉCONNECTION</a></li>
                        <li class="nav-item"><a class="nav-link" id="btn_toggle_theme"><i class="fas fa-adjust"></i></a></li>
                        <?php 
                    } else {
                    ?>
                        <li class="nav-item"><a class="nav-link" href="index.php?action=home#slogan">FONCTIONNALITÉS</a></li>
                        <li class="nav-item"><a class="nav-link" href="index.php?action=connection">MON COMPTE</a></li>
                        <li class="nav-item"><a class="nav-link" href="index.php?action=register">CRÉER UN COMPTE</a></li>
                        <li class="nav-item"><a class="nav-link" id="btn_toggle_theme"><i class="fas fa-adjust"></i></a></li>
                    <?php
                    }
                    ?>
                </ul>
            </nav> 
        </div>
    </header>

    <!-- SECTIONS -->
    <?= $content ?>

    <!-- CONTACT --> 
    <div id="contact">
        <p><a href="index.php?action=contact"><span class="red"><i class="fas fa-square"></i></span> CONTACTER LIBRUMNIVORES <span class="red"><i class="fas fa-square"></i></span></a></p>
        <p>Une question ? Un disfonctionnement ? Faites-nous en part !</p>
    </div>
    <!-- ARROW GO TOP -->
    <p id="arrow"><a href="#"><i class="fas fa-arrow-up"></i></a></p>
    <!-- FOOTER -->
    <footer>
        <p><a href="index.php?action=mentions">MENTIONS LÉGALES</a></p>
        <p> © COPYRIGHT 2020 - CLARA MORVAN ® - Tous droits réservés.</p>
        <p><a href="index.php?action=privacyPolicy">POLITIQUE DE CONFIDENTIALITÉ</a></p>
    </footer>
    <!-- SCRIPT -->
    <script src="Public/js/theme.js"></script>

    <!-- BOOTSTRAP -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</body>

</html>