<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8" />
    <title>- Librumnivores - <?= $title ?>
    </title>
    <!-- META VIEWPORT -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- META TAGS -->
    <meta name="description"
        content="Besoin de répertorier vos livres ? Munissez-vous de l'application Librumnivores et créez votre bibliothèque en ligne ! Cataloguez vos livres préférés, listez vos souhaits les plus chers et faites-vous des pense-bêtes pour vous souvenir de vos prêts à durée illimitée !" />
    <meta name="keywords" lang="fr"
        content=" Librumnivores, bibliothèque, livres, titre, auteur, édition, isbn" />
    <!-- OPEN GRAPH DATA -->
    <meta property="og:title" content="Librumnivores - Votre bibliothèque en ligne" />
    <meta property="og:type" content="website" />
    <meta property="og:image" content="Public/img/favicon.png" />
    <meta property="og:description"
        content="Besoin de répertorier vos livres ? Munissez-vous de l'application Librumnivores et créez votre bibliothèque en ligne ! Cataloguez vos livres préférés, listez vos souhaits les plus chers et faites-vous des pense-bêtes pour vous souvenir de vos prêts à durée illimitée !" />
    <!-- TWITTER CARD DATA -->
    <meta name="twitter:card" content="Librumnivores - Votre bibliothèque en ligne" />
    <meta name="twitter:title" content="Librumnivores" />
    <meta name="twitter:description"
        content="Besoin de répertorier vos livres ? Munissez-vous de l'application Librumnivores et créez votre bibliothèque en ligne ! Cataloguez vos livres préférés, listez vos souhaits les plus chers et faites-vous des pense-bêtes pour vous souvenir de vos prêts à durée illimitée !" />
    <meta name="twitter:image" content="Public/img/favicon.png" />
    <!-- FAVICON -->
    <link rel="icon" type="image/png" href="Public/img/favicon.png" />
    <!-- FONTAWESOME -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
        integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <!-- GOOGLE FONT : Grenze Gotisch  --> 
    <link href="https://fonts.googleapis.com/css2?family=Grenze+Gotisch:wght@200&display=swap" rel="stylesheet">
    <!-- GOOGLE FONT : Montserrat --> 
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200&display=swap" rel="stylesheet">
    <!-- BOOTSTRAP -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <!-- CSS -->
    <link href="Public/css/style.css" rel="stylesheet" />
</head>


<body>

    <!-- HEADER --> 
    <header id="header">
        <nav id="nav_header" class="navbar navbar-expand-lg navbar-light">
            <div id="intro_header">
                <div>
                    <p id="librum"><a href="index.php">LIBRUMNIVORES</a> <?php if($this->isLogged()) { ?>
                    <a id="avatar_header" href="index.php?action=updateProfil<?php if(isset($_GET['f'])){ echo '&amp;f=' . $this->cleanParam($_GET['f']);} else { echo '&amp;f=all'; } ?>" title="PROFIL"><img src="Public/img/avatar/<?php echo $this->user['avatar_user']?>" alt="Librumnivores - avatar utilisateur" /></a>
                    <?php } ?></p>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"><i class="fas fa-bars"></i></span></button>
                </div>
                <div id="navbarNav" class="collapse navbar-collapse">
                    <ul class="navbar-nav">
                    <?php   
                    if ($this->isLogged()) { 
                    ?>
                        <li class="nav-item"><a class="nav-link">Bienvenue à toi <?php echo ' ' . $this->user['name_user'] . ' ';?> <span class="logged"><i class="fas fa-square"></i></span></a></li>
                        <li class="nav-item"><a class="nav-link" href="index.php<?php if(isset($_GET['f'])){ echo '?f=' . $this->cleanParam($_GET['f']);} else { echo '?f=all'; } ?>">ACCUEIL <span class="sr-only">(current)</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="index.php?action=listBooks<?php if(isset($_GET['f'])){ echo '&amp;f=' . $this->cleanParam($_GET['f']);} else { echo '&amp;f=all'; } ?>">BIBLIOTHÈQUE</a></li>
                        <li class="nav-item"><a class="nav-link" href="index.php?action=listWishBooks<?php if(isset($_GET['f'])){ echo '&amp;f=' . $this->cleanParam($_GET['f']);} else { echo '&amp;f=all'; } ?>">SOUHAITS</a></li>
                        <li class="nav-item"><a class="nav-link" href="index.php?action=listFavoritesBooks<?php if(isset($_GET['f'])){ echo '&amp;f=' . $this->cleanParam($_GET['f']);} else { echo '&amp;f=all'; } ?>">FAVORIS</a></li>
                        <li class="nav-item"><a class="nav-link" href="index.php?action=listLentBooks<?php if(isset($_GET['f'])){ echo '&amp;f=' . $this->cleanParam($_GET['f']);} else { echo '&amp;f=all'; } ?>">PRÊTS</a></li>
                        <li class="nav-item"><a class="nav-link" href="index.php?action=logout">DÉCONNEXION</a></li>
                        <li class="nav-item"><a class="nav-link" id="btn_toggle_theme" tabindex="-1" aria-disabled="true"><i class="fas fa-adjust"></i></a></li>
                    <?php } else {?>
                        <li class="nav-item"><a class="nav-link" href="index.php?action=home#slogan">FONCTIONNALITÉS <span class="sr-only">(current)</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="index.php?action=connection">MON COMPTE</a></li>
                        <li class="nav-item"><a class="nav-link" href="index.php?action=register">CRÉER UN COMPTE</a></li>
                        <li class="nav-item"><a class="nav-link" id="btn_toggle_theme" tabindex="-1" aria-disabled="true"><i class="fas fa-adjust"></i></a></li>
                    <?php } ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- SECTIONS -->
    <?= $content ?>

    <!-- CONTACT --> 
    <div id="contact">
        <p><a href="index.php?action=contact<?php if(isset($_GET['f'])){ echo '&amp;f=' . $this->cleanParam($_GET['f']);}?>"><span class="red"><i class="fas fa-square"></i></span> CONTACTER LIBRUMNIVORES <span class="red"><i class="fas fa-square"></i></span></a></p>
    </div>

    <!-- ARROW GO TOP -->
    <p id="arrow"><a href="#"><i class="fas fa-arrow-up"></i></a></p>


    <!-- FOOTER -->
    <footer>
        <p><a href="index.php?action=mentions<?php if(isset($_GET['f'])){ echo '&amp;f=' . $this->cleanParam($_GET['f']);}?>">MENTIONS LÉGALES</a></p>
        <p> © COPYRIGHT 2020 - CLARA MORVAN ® - Tous droits réservés.</p>
        <p><a href="index.php?action=privacyPolicy<?php if(isset($_GET['f'])){ echo '&amp;f=' . $this->cleanParam($_GET['f']);}?>">POLITIQUE DE CONFIDENTIALITÉ</a></p>
    </footer>

    
    <!-- SCRIPT -->
    <script src="Public/js/theme.js"></script>

    <!-- BOOTSTRAP -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</body>

</html>