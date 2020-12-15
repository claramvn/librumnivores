<?php
$title = 'Contact';
?>

<!-- CONTENT -->
<?php ob_start(); ?>

<div class="content">

    <!-- BACK HOME -->
    <div class="links"><a href="index.php<?php if(isset($_GET['f'])){ echo '?f=' . $this->cleanParam($_GET['f']);}?>">Accueil</a> <span class="red"><i class=" fas
                    fa-chevron-right"></i><i class="fas fa-chevron-right"></i></span> Contact</div>

    <!-- FORM -->
    <div class="display_form">
        <h1>Contact <span class="red"><i class="fas fa-square"></i></span></h1>
        <form action="index.php?action=contact<?php if(isset($_GET['f'])){ echo '&amp;f=' . $this->cleanParam($_GET['f']);}?>" method="post">
            <div class="form-group">
                <label>NOM D'UTILISATEUR <span class="asterisk">*</span></label>
                <input type="text" class="form-control" id="user_name_contact" name="user_name" value="<?= $name ?>" required>
            </div>
            <div class="form-group">
                <label>E-MAIL<span class="asterisk">*</span></label>
                <input type="email" class="form-control" id="user_email_contact" name="user_email" value="<?= $email ?>" required>
            </div>
            <div class="form-group">
            <label>MESSAGE<span class="asterisk">*</span></label>
            <textarea class="form-control" id="user_message" name="user_message" rows="8" minlength="15" required><?= $message ?></textarea>
            </div>
            <div id="mentions_required"><p><span class="asterisk">*</span> OBLIGATOIRE</div>
            <input id="button_contact" name="button_contact" type="submit" class="btn btn-primary" value="ENVOYER" />
        </form>

        <!-- ERRORS & SUCCESS -->
        <?php if (!empty($errors)) { ?>
            <div class="errors"><?= implode('<br/>', $errors) ?></div><br /><br />
        <?php } else if (!empty($success)) { ?>
            <div class="success"><?=  $success ?></div><br /><br />
        <?php } ?>

    </div>
</div>

<script src="Public/js/form.js"></script>
<script>objetForm.initContact();</script>

<?php $content = ob_get_clean(); ?>
<?php require('App/View/template.php');