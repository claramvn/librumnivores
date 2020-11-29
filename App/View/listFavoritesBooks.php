<?php
$title = 'Mes favoris';
?>

<!-- CONTENT -->
<?php ob_start(); ?>

<div class="content">

    <!-- HEADER BOOKCASE -->
    <div id="header_bookcase">
        <div id="intro_header_bookcase">
            <h1>Ma liste de favoris <span class="red"><i class="fas fa-square"></i></span></h1>
            <div id="infos_count"><p>Réunisser ici vos librum 5 étoiles</p><span><?php if ($favoritesBookCount > 0) { echo "(" . $favoritesBookCount . ")" ; } ?></span></div>
        </div>
    </div>


    <!-- LISTING BOOKS --> 
    <div id="block_shelves">
        <?php if ($favoritesBookCount > 0) { foreach ($favoritesBooks as $dataFavoritesBooks) { ?>
            <div id="card_shelves" class="card"><a href="index.php?action=getBook&amp;id=<?= htmlspecialchars($dataFavoritesBooks['id_book']) ?>">
                <img src="<?php if(preg_match("(http)", htmlspecialchars_decode($dataFavoritesBooks['cover_book']))) { echo htmlspecialchars_decode($dataFavoritesBooks['cover_book']); } else if(preg_match("((noimg))", htmlspecialchars_decode($dataFavoritesBooks['cover_book']))) { echo "Public/img/" . htmlspecialchars_decode($dataFavoritesBooks['cover_book']); }else { echo "Public/img/cover/" . htmlspecialchars_decode($dataFavoritesBooks['cover_book']);} ?>" class="card-img-top" alt="Librumnivores - Image de couverture"/>
                <div class="card-body">
                    <p class="card-text"><?= htmlspecialchars($dataFavoritesBooks['title_book']) ?></p>
                </div></a>
            </div>
        <?php } } else { ?>
        <p id="nothing_to_show"><i class="fas fa-book-open"></i> Votre librumnivothèque des favoris attend son premier coup de coeur ...</p>
        <?php } ?>
    </div>

    
    <!-- PAGINATION --> 
    <?php if ($favoritesBookCount > 0) { ?> 
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
    <?php } ?>
    
</div>


<?php $content = ob_get_clean(); ?>
<?php require('App/View/template.php');