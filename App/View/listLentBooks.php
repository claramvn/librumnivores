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
            <div id="infos_count"><p>Gardez un oeil du côté de vos prêts</p><span><?php if ($lentBookCount > 0) { echo "(" . $lentBookCount . ")" ; } ?></span></div>
        </div>
    </div>

    <!-- FILTERS LENT BOOKS -->
    <?php if ($lentBookCount > 0) {?>
    <div id="filters">
        <p>Trier par</p>
        <p id="btn_filter_all" class="<?php if(isset($_GET['f']) && $_GET['f'] === 'all') { echo 'filters activate'; } else {echo 'filters desactivate'; } ?>"><a href="index.php?action=listLentBooks&amp;f=all">Date d'ajout</a></p>
        <p id="btn_filter_title" class="<?php if(isset($_GET['f']) && $_GET['f'] === 'title') { echo 'filters activate'; } else {echo 'filters desactivate'; } ?>"><a href="index.php?action=listLentBooks&amp;f=title">Titre</a></p>
        <p id="btn_filter_author" class="<?php if(isset($_GET['f']) && $_GET['f'] === 'author') { echo 'filters activate'; } else {echo 'filters desactivate'; } ?>"><a href="index.php?action=listLentBooks&amp;f=author">Auteur</a></p>
    </div>

    <!-- SEARCH ENGINE -->
    <div id="block_search_engine"> 
        <form action="index.php?action=listLentBooks<?php if(isset($_GET['f'])){ echo '&amp;f=' . $this->cleanParam($_GET['f']);}?>" method="post"> 
            <input id="input_search_engine" type="search" name="content_search" placeholder="Recherche par isbn, auteur, titre" />
            <button id="button_search_engine" type="submit" name="button_search_engine" class="btn btn-primary"><i class="fas fa-search"></i></button> 
        </form>
    </div>
    <?php } ?>

    <!-- LISTING SEARCH ENGINE BOOKS --> 
    <?php if (isset($_POST['content_search'])) { if($countedBooksSearch > 0) { ?>

    <!-- BACK TO BOOKCASE -->
    <div id="back_recherche" class="links">
        <a href="index.php?action=listLentBooks<?php if(isset($_GET['f'])){ echo '&amp;f=' . $this->cleanParam($_GET['f']);}?>">Ma liste de prêts</a> <span class="red"><i class=" fas fa-chevron-right"></i><i class="fas fa-chevron-right"></i></span> Et voici le(s) fruit(s) de votre recherche :
    </div>

    <!-- BLOCK DISPLAY SEARCH ENGINE BOOKS -->
    <div id="block_shelves">
    <?php foreach ($searchBooks as $dataBooksSearch) { ?> 
        <div id="card_shelves" class="card"><a href="index.php?action=getBook&amp;id=<?php echo htmlspecialchars($dataBooksSearch['id_book']); if(isset($_GET['f'])){ echo '&amp;f=' . $this->cleanParam($_GET['f']);}?>">
            <img src="<?php if(preg_match("(http)", htmlspecialchars_decode($dataBooksSearch['cover_book']))) { echo htmlspecialchars_decode($dataBooksSearch['cover_book']); } else if(preg_match("((noimg))", htmlspecialchars_decode($dataBooksSearch['cover_book']))) { echo "Public/img/" . htmlspecialchars_decode($dataBooksSearch['cover_book']); }else { echo "Public/img/cover/" . htmlspecialchars_decode($dataBooksSearch['cover_book']);} ?>" class="card-img" alt="Librumnivores - Image de couverture"/>   
            <div class="card-body">
                <p id="title_list" class="card-text"><?= htmlspecialchars($dataBooksSearch['title_book']) ?></p>
                <p id="author_list" class="card-text"><?= htmlspecialchars($dataBooksSearch['author_book']) ?></p>
            </div>
        </a></div>
    <?php }?>
    </div>
    <?php } else { ?> 
        <div id="search_no_result"><p id="nothing_to_show"><i class="fas fa-book-open"></i> Oups, aucun ingrédient ne correspond à cette recette ...</p></div>
    <?php } } else { ?>


    <!-- LISTING LENT BOOKS --> 
    <div id="block_shelves">
        <?php if ($lentBookCount > 0) { foreach ($listLentBooks as $dataLentBooks) { ?> 
        <div id="card_shelves" class="card"><a href="index.php?action=getBook&amp;id=<?php echo htmlspecialchars($dataLentBooks['id_book']); if(isset($_GET['f'])){ echo '&amp;f=' . $this->cleanParam($_GET['f']);}?>">
            <img src="<?php if(preg_match("(http)", htmlspecialchars_decode($dataLentBooks['cover_book']))) { echo htmlspecialchars_decode($dataLentBooks['cover_book']); } else if(preg_match("((noimg))", htmlspecialchars_decode($dataLentBooks['cover_book']))) { echo "Public/img/" . htmlspecialchars_decode($dataLentBooks['cover_book']); }else { echo "Public/img/cover/" . htmlspecialchars_decode($dataLentBooks['cover_book']);} ?>" class="card-img-top" alt="Librumnivores - Image de couverture"/>
            <div class="card-body">
            <p id="title_list" class="card-text"><?= htmlspecialchars($dataLentBooks['title_book']) ?></p>
                    <p id="author_list" class="card-text"><?= htmlspecialchars($dataLentBooks['author_book']) ?></p>
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
                    <a href="index.php?action=listLentBooks&page=<?= $currentPage - 1 ?><?php if(isset($_GET['f'])){ echo '&amp;f=' . $this->cleanParam($_GET['f']);}?>#filters" class="page-link"><i class="fas fa-chevron-left"></i></a>
                </li>
                <?php for($i = 1; $i <= $pages; $i++){ ?>
                <li class="page-item <?php if($currentPage == $i){ echo "active";}else { echo "";} ?>">
                    <a href="index.php?action=listLentBooks&page=<?= $i ?><?php if(isset($_GET['f'])){ echo '&amp;f=' . $this->cleanParam($_GET['f']);}?>#filters" class="page-link"><?= $i ?></a>
                </li>
                <?php } ?>
                <li class="page-item <?php if($currentPage == $pages){ echo "disabled"; } else { echo ""; } ?>">
                <a href="index.php?action=listLentBooks&page=<?= $currentPage + 1 ?><?php if(isset($_GET['f'])){ echo '&amp;f=' . $this->cleanParam($_GET['f']);}?>#filters" class="page-link"><i class="fas fa-chevron-right"></i></a>
                </li>
            </ul>
        </nav>
    </div>
    <?php } }?>
    
</div>


<?php $content = ob_get_clean(); ?>
<?php require('App/View/template.php');