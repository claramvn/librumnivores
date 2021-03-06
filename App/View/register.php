<?php
$title = 'Inscription';
?>

<!-- CONTENT -->
<?php ob_start(); ?>

<div class="content">

    <!-- BACK HOME -->
    <div class="links"><a href="index.php<?php if(isset($_GET['f'])){ echo '?f=' . $this->cleanParam($_GET['f']);}?>">Accueil</a> <span class="red"><i class=" fas
                    fa-chevron-right"></i><i class="fas fa-chevron-right"></i></span> Inscription</div>

    <!-- FORM -->
    <div class="display_form">
        <h1>Inscription <span class="red"><i class="fas fa-square"></i></span></h1><br/><br/>
        <form action="index.php?action=register" method="post">
            <div class="form-group">
                <label>NOM D'UTILISATEUR <span class="asterisk">*</span></label>
                <input type="text" class="form-control" id="user_name_register" name="user_name" value="<?= $name ?>" required>
            </div>
            <div class="form-group">
                <label>E-MAIL <span class="asterisk">*</span></label>
                <input type="email" class="form-control" id="user_email_register" name="user_email" value="<?= $email ?>" required>
            </div>
            <div class="form-group">
                <label>MOT DE PASSE <span class="asterisk">*</span></label>
                <input type="password" class="form-control" id="user_pass_register" name="user_pass" placeholder="minimum 6 caractères" minlength="6" required>
            </div>
            <div class="form-group">
                <label>CONFIRMATION DE MOT DE PASSE <span class="asterisk">*</span></label>
                <input type="password" class="form-control" id="user_confirm_pass" name="user_confirm_pass" minlength="6" required>
            </div>
            <div id="mentions_required"><p><span class="asterisk">*</span> OBLIGATOIRE</div>
            <input id="button_register" type="submit" class="btn btn-primary" name="button_register" value="S'INSCRIRE" />
        </form>

        <!-- ERRORS -->
        <?php if (!empty($errors)) { ?>
            <div class="errors"><?= implode('<br/>', $errors) ?></div><br /><br />
        <?php } ?>
        
    </div>
</div>

<!-- SCRIPT JS -->
<script src="Public/js/form.js"></script>
<script>objetForm.initRegister();</script>

<?php $content = ob_get_clean(); ?>
<?php require('App/View/template.php');