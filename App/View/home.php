<?php
$title = 'Accueil';
?>

<!-- CONTENT -->
<?php ob_start(); ?>

<!-- SLIDER --> 
<div id="slider"><img id="mainImage" src="Public/img/cover3.png" alt="cover librumnivores"/></div>

<!-- SLOGAN --> 
<div id="slogan" class="container">
    <p>Votre bibliothèque personnelle en ligne </p>  
</div>

<!-- FEATURES --> 
<div class="features">
    <h1>01<span class="red"><i class="fas fa-square"></i></span></h1>
    <h2>BIBLIOTHÈQUE</h2><br/><br/>
    <h3>Répertoriez vos livres sur Librumnivores et créez votre bibliothèque en ligne. Ajoutez ces derniers à l'aide de leurs numéros ISBN et profitez de notre plateforme accessible sur mobile, tablette et ordinateur. Autrement dit, régalez-vous !</h3> 
</div>
<div class="features_right">
    <h1>02<span class="red"><i class="fas fa-square"></i></span></h1>
    <h2>SOUHAITS</h2><br/><br/>
    <h3>Profitez de la rubrique des souhaits afin d'y ajouter les différents ouvrages qu'il vous plairait d'acquérir, de lire ou bien même de dévorer.</h3>
</div>
<div class="features">
    <h1>03<span class="red"><i class="fas fa-square"></i></span></h1>
    <h2>FAVORIS</h2><br/><br/>
    <h3>Constituez votre liste de favoris. Toutes vos oeuvres préférées, les plus marquantes, vos bestsellers à partager sans modération.</h3>
</div>
<div class="features_right">
    <h1>04<span class="red"><i class="fas fa-square"></i></span></h1>
    <h2>PRÊTS</h2><br/><br/>
    <h3>Indiquez dans la rubrique des prêts les ouvrages que vous avez généreusement prétés à vos proches, amis, collègues, voisins. N'accusez plus votre belle-mère d'appropriation de biens appartenant à autrui !</h3>
</div>

<!-- DARK MODE --> 
<div id="feature_dark_mode">
    <div>
        <h1>MODE SOMBRE</h1>
        <h2>Jour/Nuit Jour/Nuit</h2>
        <p>Librumnivores a pensé à tout ! Séléctionnez le mode sombre et offrez-vous une lecture des plus agréable dans l'obscurité. Ménagez par la même occasion la batterie 
        de vos appareils. Changez de style comme vous changez de chemise !</p>
    </div>
    <div><img src="Public/img/darkmode.png" alt="Librumnivores dark mode" /></div>
</div>

<!-- FRIEZE --> 
<div id="frieze">
    <img src="Public/img/frieze.png" alt="frise librumnivores" />
</div>

<script src="Public/js/slider.js"></script>

<?php $content = ob_get_clean(); ?>
<?php require('App/View/template.php');
