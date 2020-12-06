<?php
$title = 'Erreur';
?>

<!-- CONTENT -->
<?php ob_start(); ?>

<!-- BLOCK ERROR -->
<div class="content">
<div id="error"><img src="Public/img/error.png" alt="Librumnivores - Page erreur" /></div>
<div id="para_error"><p>Oups, il semblerait que la page que vous cherchez soit introuvable ...</p></div>
</div>

<?php $content = ob_get_clean(); ?>
<?php require('App/View/template.php');