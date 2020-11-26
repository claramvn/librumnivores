<?php
$title = 'Ma bibliothèque';
?>

<!-- CONTENT -->
<?php ob_start(); ?>

<div class="content">

    <!-- BACK TO BOOKCASE -->
    <div class="links">
        <a href="index.php?action=listBooks">Bibliothèque</a> <span class="red"><i class=" fas fa-chevron-right"></i><i class="fas fa-chevron-right"></i></span> <?= htmlspecialchars($book['title_book']) ?>
    </div>


    <!-- BOOK -->
    <div id="card_book" class="card mb-3">
        <div class="row no-gutters">
            <div class="col-md-4">
                <img src="<?= htmlspecialchars_decode($book['cover_book']) ?>" class="card-img" alt="...">
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($book['title_book']) ?></h5>
                    <h6 class="card-title"><?= htmlspecialchars($book['author_book']) ?></h6>
                    <p class="card-text"><?= htmlspecialchars_decode($book['description_book']) ?></p>
                    <div id="line"></div>
                    <div class="card_infos">
                        <p class="card-text"><small class="text-muted">ISBN : <?= htmlspecialchars($book['isbn_book']) ?></small></p>
                        <p class="card-text"><small class="text-muted">Éditeur : <?= htmlspecialchars($book['publisher_book']) ?></small></p>
                    </div>
                    <div class="card_infos">
                        <p class="card-text"><small class="text-muted">Date de publication : <?= $this->dateUsToDateFr(htmlspecialchars($book['published_date_book']))?></small></p>
                        <p class="card-text"><small class="text-muted">Nombre de page : <?= htmlspecialchars($book['page_count_book']) ?></small></p>
                    </div>
                </div>
            </div>
        </div>


        <!-- FLAGS --> 
        <div id="flags">
            <?php if($book['wish_book'] === "0") {
                      if($book['favorite_book'] === "0") {?>
                    <div class="fav"><a href="index.php?action=addToFavoritesBooks&amp;id=<?= htmlspecialchars($book['id_book']) ?>" title="AJOUTER AUX FAVORIS"><i class="fas fa-heart"></i></a></div>
            <?php } else { ?>
                    <div class="fav"><a href="index.php?action=takeBackFromFavoritesBooks&amp;id=<?= htmlspecialchars($book['id_book']) ?>" title="SUPPRIMER DES FAVORIS"><i class="fas fa-heart-broken"></i></a></div>
            <?php } if($book['lend_book'] === "0") { ?>
                    <div class="lend"><a href="index.php?action=lendABook&amp;id=<?= htmlspecialchars($book['id_book']) ?>" title="PRÊTER LE LIVRE"><i class="fas fa-user-plus"></i></a></div>
            <?php } else { ?>
                    <div class="lend"><a href="index.php?action=takeBackFromLentBooks&amp;id=<?= htmlspecialchars($book['id_book']) ?>" title="RÉCUPÉRER LE LIVRE"><i class="fas fa-users-cog"></i></a></div>
            <?php } } else { ?>
                <div class="add_wish"><a href="index.php?action=addWishToBookcase&amp;id=<?= htmlspecialchars($book['id_book']) ?>" title="AJOUTER À MA BIBLIOTHÈQUE"><i class="fas fa-book-open"></i></a></div>
            <?php } ?>
                <div class="delete_book"><a id="btn_delete_book" href="index.php?action=deleteBook&amp;id=<?= htmlspecialchars($book['id_book']) ?>" title="SUPPRIMER LE LIVRE"><i class="fas fa-trash-alt"></i></a></div>
        </div>

        
        <!-- ERROR OR SUCCESS FLAGS -->
        <?php
            if (isset($_SESSION['error_flags'])) { 
                echo '<div class="errors_triangle"></div><p class="errors_flags">' . $_SESSION['error_flags'] . '</p>';
            }
            unset($_SESSION['error_flags']);

            if (isset($_SESSION['success_flags'])) {
                echo '<div class="success_triangle"></div><p class="success_flags">' . $_SESSION['success_flags'] . '</p>';
            }
            unset($_SESSION['success_flags']);
        ?>
    </div>

</div>

<!-- SCRIPT JS -->
<script src="Public/js/confirmation.js"></script>

<?php $content = ob_get_clean(); ?>
<?php require('App/View/template.php');