<?php
$title = 'Réinitialisation du mot de passe';
?>

<!-- CONTENT -->
<?php ob_start(); ?>

<div class="content">

    <!-- BACK HOME -->
    <div class="links"><a href="index.php<?php if(isset($_GET['f'])){ echo '?f=' . $this->cleanParam($_GET['f']);}?>">Accueil</a> <span class="red"><i class=" fas
                    fa-chevron-right"></i><i class="fas fa-chevron-right"></i></span> Réinitialisation du mot de passe</div>

    <!-- FORM -->
    <div class="display_form">
        <h1>Réinitialisation du mot de passe <span class="red"><i class="fas fa-square"></i></span></h1><br/><br/>
        <form action="index.php?action=resetPass&token=<?php if(isset($_GET['token']) && !empty($_GET['token'])) { echo $this->cleanParam($_GET['token']);} ?>" method="post">
            <div class="form-group">
                <label>MOT DE PASSE <span class="asterisk">*</span></label>
                <input type="password" class="form-control" id="user_reset_pass" name="user_reset_pass" placeholder="minimum 6 caractères" minlength="6" required>
            </div>
            <div class="form-group">
                <label>CONFIRMATION DE MOT DE PASSE <span class="asterisk">*</span></label>
                <input type="password" class="form-control" id="user_confirm_reset_pass" name="user_confirm_reset_pass" minlength="6" required>
            </div>
            <div id="mentions_required"><p><span class="asterisk">*</span> OBLIGATOIRE</div>
            <input id="button_reset_pass" type="submit" class="btn btn-primary" name="button_reset_pass" value="RÉINITIALISER LE MOT DE PASSE" />
        </form>

        <!-- ERRORS -->
        <?php if (!empty($errors)) { ?>
            <div class="errors"><?= implode('<br/>', $errors) ?></div><br /><br />
        <?php } ?>
        
    </div>
</div>

<!-- SCRIPT JS -->
<script src="Public/js/form.js"></script>
<script>objetForm.initResetPass();</script>

<?php $content = ob_get_clean(); ?>
<?php require('App/View/template.php');