<?php
$title = 'Mes favoris';
?>

<!-- CONTENT -->
<?php ob_start(); ?>

<div class="content">

    <!-- HEADER BOOKCASE -->
    <div id="header_bookcase">
    <div>
        <h1>Ma liste de favoris <span class="number_book"><?= $favoritesBookCount ?></span></h1>
        <p>Réunisser ici vos librum 5 étoiles.</p>
    </div>
    </div>

    <!-- LISTING BOOKS --> 
    <div id="block_shelves">
    <?php 
    if ($favoritesBookCount > 0) {
        foreach ($favoritesBooks as $dataFavoritesBooks) {
    ?> 
            <div id="card_shelves" class="card"><a href="index.php?action=getBook&amp;id=<?= htmlspecialchars($dataFavoritesBooks['id_book']) ?>">
                <img src="<?= htmlspecialchars_decode($dataFavoritesBooks['cover_book']) ?>" class="card-img-top" alt="Librumnivores - Image de couverture">
                <div class="card-body">
                    <p class="card-text"><?= htmlspecialchars($dataFavoritesBooks['title_book']) ?></p>
                </div></a>
             </div>
    <?php 
        }
    }else {
    ?>
    <p><i class="fas fa-book-open"></i> Votre librumnivothèque des favoris attend son premier coup de coeur ...</p>
    <?php
     }
    ?>
    </div>

    <!-- PAGINATION -->  
    <div id="block_pagination">
        <nav>
            <ul class="pagination">
                <li class="page-item <?php if($currentPage == 1){ echo "disabled"; }else { echo ""; } ?>">
                    <a href="index.php?action=listFavoritesBooks&page=<?= $currentPage - 1 ?>#block_pagination" class="page-link"><i class="fas fa-chevron-left"></i></a>
                </li>
                <?php for($i = 1; $i <= $pages; $i++){ ?>
                    <li class="page-item <?php if($currentPage == $i){ echo "active";}else { echo "";} ?>">
                        <a href="index.php?action=listFavoritesBooks&page=<?= $i ?>#block_pagination" class="page-link"><?= $i ?></a>
                    </li>
                <?php } ?>
                    <li class="page-item <?php if($currentPage == $pages){ echo "disabled"; } else { echo ""; } ?>">
                        <a href="index.php?action=listFavoritesBooks&page=<?= $currentPage + 1 ?>#block_pagination" class="page-link"><i class="fas fa-chevron-right"></i></a>
                    </li>
            </ul>
        </nav>
    </div>
    
</div>


<?php $content = ob_get_clean(); ?>
<?php require('App/View/template.php');