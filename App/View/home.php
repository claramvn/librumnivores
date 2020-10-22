<?php
// Titre site
$title = 'test books';
?>

<!-- Content -->
<?php ob_start(); ?>

<p>coucou</p>
<?php $content = ob_get_clean(); ?>
<?php require('App/View/template.php');
