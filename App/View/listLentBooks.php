<?php
$title = 'Mes prêts';
?>

<!-- CONTENT -->
<?php ob_start(); ?>

<div class="content">

    <!-- HEADER BOOKCASE -->
    <div id="header_bookcase">
        <div id="intro_header_bookcase">
            <h1>Ma liste de prêts <span class="red"><i class="fas fa-square"></i></span></h1>
            <div id="infos_count"><p>Garder un oeil du côté de vos prêts</p><span><?php if ($lentBookCount > 0) { echo "(" . $lentBookCount . ")" ; } ?></span></div>
        </div>
    </div>


    <!-- LISTING LENT BOOKS --> 
    <div id="block_shelves">
        <?php if ($lentBookCount > 0) { foreach ($listLentBooks as $dataLentBooks) { ?> 
        <div id="card_shelves" class="card"><a href="index.php?action=getBook&amp;id=<?= htmlspecialchars($dataLentBooks['id_book']) ?>">
            <img src="<?= htmlspecialchars_decode($dataLentBooks['cover_book']) ?>" class="card-img-top" alt="Librumnivores - Image de couverture">
            <div class="card-body">
                <p class="card-text"><?= htmlspecialchars($dataLentBooks['title_book']) ?></p>
            </div></a>
        </div>
        <?php } } else { ?>
        <p id="nothing_to_show"><i class="fas fa-book-open"></i> Votre librumnivothèque ne contient aucun prêt en cours ...</p>
        <?php } ?>
    </div>

    
    <!-- PAGINATION -->  
    <?php if ($lentBookCount > 0) { ?>
    <div id="block_pagination">
        <nav>
            <ul class="pagination">
                <li class="page-item <?php if($currentPage == 1){ echo "disabled"; }else { echo ""; } ?>">
                    <a href="index.php?action=listLentBooks&page=<?= $currentPage - 1 ?>#block_pagination" class="page-link"><i class="fas fa-chevron-left"></i></a>
                </li>
                <?php for($i = 1; $i <= $pages; $i++){ ?>
                <li class="page-item <?php if($currentPage == $i){ echo "active";}else { echo "";} ?>">
                    <a href="index.php?action=listLentBooks&page=<?= $i ?>#block_pagination" class="page-link"><?= $i ?></a>
                </li>
                <?php } ?>
                <li class="page-item <?php if($currentPage == $pages){ echo "disabled"; } else { echo ""; } ?>">
                <a href="index.php?action=listLentBooks&page=<?= $currentPage + 1 ?>#block_pagination" class="page-link"><i class="fas fa-chevron-right"></i></a>
                </li>
            </ul>
        </nav>
    </div>
    <?php } ?>
    
</div>


<?php $content = ob_get_clean(); ?>
<?php require('App/View/template.php');