<?php
$title = 'Mes souhaits';
?>

<!-- CONTENT -->
<?php ob_start(); ?>

<div class="content">

    <!-- HEADER BOOKCASE -->
    <div id="header_bookcase">
        <div id="intro_header_bookcase">
            <h1>Ma liste de souhaits <span class="red"><i class="fas fa-square"></i></span></h1>
            <p>Mijoter ici vos futurs régals</p>
        </div>
    </div>


    <!-- SUCCESS ADD WISH BOOK -->
    <?php if (isset($_SESSION['success_add_wish_book'])) {
            echo '<p class="success">' . $_SESSION['success_add_wish_book'] . '</p>';
        }
        unset($_SESSION['success_add_wish_book']); ?>


    <!-- LISTING WISH BOOKS --> 
    <div id="block_shelves">
    <?php if ($wishBookCount > 0) { foreach ($listWishBooks as $dataWishBooks) { ?> 
        <div id="card_shelves" class="card"><a href="index.php?action=getBook&amp;id=<?= htmlspecialchars($dataWishBooks['id_book']) ?>">
            <img src="<?= htmlspecialchars_decode($dataWishBooks['cover_book']) ?>" class="card-img-top" alt="Librumnivores - Image de couverture">
            <div class="card-body">
                <p class="card-text"><?= htmlspecialchars($dataWishBooks['title_book']) ?></p>
            </div></a>
        </div>
    <?php } } else { ?>
        <p><i class="fas fa-book-open"></i> Votre librumnivothèque n'a pas d'envie spécifique pour le moment ...</p>
    <?php } ?>
    </div>

    
    <!-- PAGINATION -->  
    <div id="block_pagination">
        <nav>
            <ul class="pagination">
                <li class="page-item <?php if($currentPage == 1){ echo "disabled"; }else { echo ""; } ?>">
                    <a href="index.php?action=listWishBooks&page=<?= $currentPage - 1 ?>#block_pagination" class="page-link"><i class="fas fa-chevron-left"></i></a>
                </li>
                <?php for($i = 1; $i <= $pages; $i++){ ?>
                <li class="page-item <?php if($currentPage == $i){ echo "active";}else { echo "";} ?>">
                    <a href="index.php?action=listWishBooks&page=<?= $i ?>#block_pagination" class="page-link"><?= $i ?></a>
                    </li>
                <?php } ?>
                <li class="page-item <?php if($currentPage == $pages){ echo "disabled"; } else { echo ""; } ?>">
                    <a href="index.php?action=listWishBooks&page=<?= $currentPage + 1 ?>#block_pagination" class="page-link"><i class="fas fa-chevron-right"></i></a>
                </li>
            </ul>
        </nav>
    </div>

    
</div>


<?php $content = ob_get_clean(); ?>
<?php require('App/View/template.php');