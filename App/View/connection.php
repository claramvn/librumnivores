<?php
$title = 'Connexion';
?>

<!-- CONTENT -->
<?php ob_start(); ?>

<div class="content">

    <!-- BACK HOME -->
    <div class="links"><a href="index.php<?php if(isset($_GET['f'])){ echo '?f=' . $this->cleanParam($_GET['f']);}?>">Accueil</a> <span class="red"><i class=" fas
                    fa-chevron-right"></i><i class="fas fa-chevron-right"></i></span> Connexion</div>

    <!-- FORM -->
    <div id="connection" class="display_form">
        <h1>Connexion <span class="red"><i class="fas fa-square"></i></span></h1><br/><br/>
        <form action="index.php?action=connection" method="post">
            <div class="form-group">
                <label>NOM D'UTILISATEUR</label>
                <input type="text" class="form-control" id="user_name_connection" name="user_name" value="<?= $name?>" required>
            </div>
                <div class="form-group">
                <label>MOT DE PASSE</label>
                <input type="password" class="form-control" id="user_pass_connection" name="user_pass" required>
            </div>
            <button id="button_connection" name="button_connection" type="submit" class="btn btn-primary">SE CONNECTER</button>
        </form>

        <!-- ERRORS -->
        <?php if (!empty($errors)) { ?>
            <div class="errors"><?= implode('<br/>', $errors) ?></div><br /><br />
        <?php } ?>

        <div id="link_reset_pass_request"><a href="index.php?action=resetPassRequest">Mot de passe oublié ?</a></div>
        
    </div>
</div>

<script src="Public/js/form.js"></script>
<script>objetForm.initConnection();</script>

<?php $content = ob_get_clean(); ?>
<?php require('App/View/template.php');
