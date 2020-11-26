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
        <p>Modifier votre profil librumnivores</p>
    </div>
    </div>

    <!-- AVATAR --> 
    <div id="block_avatar"> 
        <img src="Public/img/avatar/<?php echo $this->user['avatar_user']?>" alt="Librumnivores - avatar utilisateur"/>
    </div>

    <div class="display_form">
        <form action="index.php?action=updateProfil" method="post">
            <div class="form-group">
            <label for="user_avatar">IMAGE :</label><br />
            <input type="file" class="form-control-file" id="user_avatar" name="user_avatar" accept="image/png, image/jpeg, image/jpg" />
            </div>
            <div class="form-group">
                <label for="user_name">NOM D'UTILISATEUR</label>
                <input type="text" class="form-control" id="user_name" name="user_name" value="<?= htmlspecialchars($name) ?>">
            </div>
            <div class="form-group">
                <label for="user_email">E-MAIL</label>
                <input type="email" class="form-control" id="user_email" name="user_email" value="<?= htmlspecialchars($email) ?>">
            </div>
            <input id="button_update_profil" type="submit" class="btn btn-primary" name="button_update_profil" value="MODIFIER" />
        </form>
    </div>

     <!-- ERRORS & SUCCESS -->
     <?php if (!empty($errors)) { ?>
        <div class="errors"><?= implode('<br/>', $errors) ?></div><br /><br />
    <?php } else if (!empty($success)) { ?>
        <div class="success"><?= implode('<br/>', $success) ?></div><br /><br />
    <?php } ?>
    
    
</div>


<?php $content = ob_get_clean(); ?>
<?php require('App/View/template.php');