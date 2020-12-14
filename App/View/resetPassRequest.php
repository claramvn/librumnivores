<?php
$title = 'Demande de réinitialisation de mot de passe';
?>

<!-- CONTENT -->
<?php ob_start(); ?>

<div class="content">

    <!-- BACK HOME -->
    <div class="links"><a href="index.php<?php if(isset($_GET['f'])){ echo '?f=' . $this->cleanParam($_GET['f']);}?>">Accueil</a> <span class="red"><i class=" fas
                    fa-chevron-right"></i><i class="fas fa-chevron-right"></i></span> Réinitialiser le mot de passe</div>

    <!-- FORM -->
    <div class="display_form">
        <h1>Réinitialiser le mot de passe <span class="red"><i class="fas fa-square"></i></span></h1><br/><br/>
        <?php if (empty($success)) { ?>
        <p id="instructions">Veuillez saisir votre adresse e-mail ci-dessous afin de recevoir les instructions pour créer un nouveau mot de passe.</p><br/><br/>
        <form action="index.php?action=resetPassRequest" method="post">
            <div class="form-group">
                <label>E-MAIL <span class="asterisk">*</span></label>
                <input type="email" class="form-control" id="user_email_reset_pass_request" name="user_email_reset_pass_request" value="<?= $email ?>" required>
            </div>
            <div id="mentions_required"><p><span class="asterisk">*</span> OBLIGATOIRE</div>
            <input id="button_reset_pass_request" type="submit" class="btn btn-primary" name="button_reset_pass_request" value="RÉINITIALISER LE MOT DE PASSE" />
        </form>
   
        <!-- ERRORS/SUCCESS -->
        <?php if (!empty($errors)) { ?>
            <div class="errors"><?= implode('<br/>', $errors) ?></div><br /><br />
        <?php } } else { ?>
            <div><?= implode('<br/>', $success) ?></div><br /><br />
        <?php } ?>
        
    </div>
</div>

<!-- SCRIPT JS -->
<script src="Public/js/form.js"></script>
<script>objetForm.initResetPassRequest();</script>

<?php $content = ob_get_clean(); ?>
<?php require('App/View/template.php');