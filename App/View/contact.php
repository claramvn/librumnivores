<?php
// Titre site
$title = 'Contact';
?>

<!-- Content -->
<?php ob_start(); ?>

<div class="content">

    <!-- BACK HOME -->
    <div class="links"><a href="index.php">Accueil</a> <span class="red"><i class=" fas
                    fa-chevron-right"></i><i class="fas fa-chevron-right"></i></span> Contact</div>

    <!-- FORM -->
    <div class="display_form">
        <h1>Contact <span class="red"><i class="fas fa-square"></i></span></h1>
        <form action="index.php?action=contact" method="post">
            <div class="form-group">
                <label for="user_name">NOM D'UTILISATEUR</label>
                <input type="text" class="form-control" id="user_name" name="user_name" value="<?= $name ?>" required>
            </div>
            <div class="form-group">
                <label for="user_email">E-MAIL</label>
                <input type="email" class="form-control" id="user_email" name="user_email" value="<?= $email ?>" required>
            </div>
            <div class="form-group">
            <label for="user_message">MESSSAGE</label>
            <textarea class="form-control" id="user_message" name="user_message" rows="3" required><?= $message ?></textarea>
            </div>
            <input id="button_form" name="button_contact" type="submit" class="btn btn-primary" value="ENVOYER" />
        </form>

        <!-- ERRORS -->
        <?php
        if (!empty($errors)) { ?>
        <div class="errors"><?= implode('<br/>', $errors) ?></div><br /><br />
        <?php
        }
        ?>
        <?php
        if (!empty($success)) { ?>
        <div class="success"><?=  $success ?></div><br /><br />
        <?php
        }
        ?>
    </div>
</div>

<?php $content = ob_get_clean(); ?>
<?php require('App/View/template.php');