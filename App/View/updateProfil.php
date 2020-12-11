<?php
$title = 'Mon profil';
?>

<!-- CONTENT -->
<?php ob_start(); ?>

<div class="content">

    <!-- HEADER BOOKCASE -->
    <div id="header_bookcase">
    <div id="intro_header_bookcase">
        <h1>Mon profil <span class="red"><i class="fas fa-square"></i></span></h1>
        <p>Modifier mon profil librumnivores</p>
    </div>
    </div>

    <!-- FORM -->
    <div class="display_form">
        <form action="index.php?action=updateProfil<?php if(isset($_GET['f'])){ echo '&amp;f=' . $this->cleanParam($_GET['f']);} else { echo '&amp;f=all'; } ?>" method="post" enctype="multipart/form-data">
            <div id="block_avatar"> 
                <img src="Public/img/avatar/<?= $avatar ?>" alt="Librumnivores - avatar utilisateur"/>
            </div>
            <div class="form-group">
                <label>IMAGE :</label><br />
                <input type="file" class="form-control-file" id="user_avatar" name="user_avatar" accept="image/png, image/jpeg, image/jpg" />
            </div>
            <div class="form-group">
                <label>NOM D'UTILISATEUR</label>
                <input type="text" class="form-control" id="user_name_profil" name="user_name" value="<?= htmlspecialchars($name) ?>" required>
            </div>
            <div class="form-group">
                <label>E-MAIL</label>
                <input type="email" class="form-control" id="user_email_profil" name="user_email" value="<?= htmlspecialchars($email) ?>" required>
            </div>
            <input id="button_update_profil" type="submit" class="btn btn-primary" name="button_update_profil" value="ACTUALISER MON PROFIL" />
        </form>

        <!-- ERRORS & SUCCESS -->
        <?php if (!empty($errors)) { ?>
        <div class="errors"><?= implode('<br/>', $errors) ?></div><br /><br />
        <?php } else if (!empty($success)) { ?>
        <div class="success"><?= implode('<br/>', $success) ?></div><br /><br />
        <?php } ?>
    </div>


    <!-- DELETE ACCOUNT -->
    <div id="block_delete_account">
        <a id="btn_delete_account" class="btn btn-primary" href="index.php?action=deleteUserAccount" title="SUPPRIMER MON COMPTE LIBRUMNIVORES"><i class="fas fa-user-slash"></i></a>
    </div>
    
</div>

<!-- SCRIPT JS -->
<script src="Public/js/confirmation.js"></script>
<script>objetConfirmation.deleteAccountUser();</script>
<script src="Public/js/form.js"></script>
<script>objetForm.initProfil();</script>

<?php $content = ob_get_clean(); ?>
<?php require('App/View/template.php');