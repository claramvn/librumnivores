<?php
$title = 'Ma bibliothèque';
?>

<!-- CONTENT -->
<?php ob_start(); ?>

<div class="content">

    <!-- HEADER BOOKCASE -->
    <div id="header_bookcase">
        <div id="intro_header_bookcase">
            <h1>Ma bibliothèque <span class="red"><i class="fas fa-square"></i></span></h1>
            <div id="infos_count"><p>Organisez ici l'ensemble de vos libri</p><span><?php if ($bookCount > 0) { echo "(" . $bookCount . ")" ; } ?></span></div>
        </div>
        <div> 
            <button id="button_open_search" type="submit" class="btn btn-primary">AJOUTER UN LIVRE</button>
        </div>
    </div>

    <!-- BLOCK SEARCH ISBN TO ADD BOOK -->
    <?php include("searchIsbn.php"); ?>

    <!-- FILTERS BOOKS -->
    <?php if (!isset($_POST['content_search']) && $bookCount > 0) { ?>
    <div id="filters">
        <p>Trier par</p>
        <p id="btn_filter_all" class="<?php if(isset($_GET['f']) && $_GET['f'] === 'all') { echo 'filters activate'; } else {echo 'filters desactivate'; } ?>"><a href="index.php?action=listBooks&amp;f=all">Date d'ajout</a></p>
        <p id="btn_filter_title" class="<?php if(isset($_GET['f']) && $_GET['f'] === 'title') { echo 'filters activate'; } else {echo 'filters desactivate'; } ?>"><a href="index.php?action=listBooks&amp;f=title">Titre</a></p>
        <p id="btn_filter_author" class="<?php if(isset($_GET['f']) && $_GET['f'] === 'author') { echo 'filters activate'; } else {echo 'filters desactivate'; } ?>"><a href="index.php?action=listBooks&amp;f=author">Auteur</a></p>
    </div>
    <?php } ?>

    <!-- SEARCH ENGINE -->
    <?php if ($bookCount > 0) { ?>
    <div id="block_search_engine"> 
        <form action="index.php?action=listBooks<?php if(isset($_GET['f'])){ echo '&amp;f=' . $this->cleanParam($_GET['f']);}?>" method="post"> 
            <input id="input_search_engine" type="search" name="content_search" placeholder="Recherche par isbn, auteur, titre" />
            <button id="button_search_engine" type="submit" name="button_search_engine" class="btn btn-primary"><i class="fas fa-search"></i></button> 
        </form>
    </div>
    <?php } ?>

    <!-- LISTING SEARCH ENGINE BOOKS --> 
    <?php if (isset($_POST['content_search'])) { if($countedBooksSearch > 0) { ?>

    <!-- BACK TO BOOKCASE -->
    <div id="back_recherche" class="links">
        <a href="index.php?action=listBooks<?php if(isset($_GET['f'])){ echo '&amp;f=' . $this->cleanParam($_GET['f']);}?>">Bibliothèque</a> <span class="red"><i class=" fas fa-chevron-right"></i><i class="fas fa-chevron-right"></i></span> Et voici le(s) fruit(s) de votre recherche :
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
    <div id="separation"></div>
    <?php } else { ?> 
        <div id="search_no_result"><p id="nothing_to_show"><i class="fas fa-book-open"></i> Oups, aucun ingrédient ne correspond à cette recette ...</p></div>
    <?php } } else { ?>
    
    
    
    <!-- ERROR OR SUCCESS SESSIONS ADD BOOK -->
    <?php if (isset($_SESSION['error_add_book'])) {
        echo '<div id="block_message"><p class="errors">' . $_SESSION['error_add_book'] . '</p></div>';
    }
    unset($_SESSION['error_add_book']);

    if (isset($_SESSION['success_add_book'])) {
        echo '<div id="block_message"><p class="success">' . $_SESSION['success_add_book'] . '</p></div>';
    }
    unset($_SESSION['success_add_book']); ?>
   

    <!-- LISTING BOOKS / BOOKCASE --> 
    <div id="block_shelves">
        <?php if ($bookCount > 0) {
            foreach ($books as $dataBooks) { ?> 
                <div id="card_shelves" class="card"><a href="index.php?action=getBook&amp;id=<?php echo htmlspecialchars($dataBooks['id_book']); if(isset($_GET['f'])){ echo '&amp;f=' . $this->cleanParam($_GET['f']);}?>">
                    <img src="<?php if(preg_match("(http)", htmlspecialchars_decode($dataBooks['cover_book']))) { echo htmlspecialchars_decode($dataBooks['cover_book']); } else if(preg_match("((noimg))", htmlspecialchars_decode($dataBooks['cover_book']))) { echo "Public/img/" . htmlspecialchars_decode($dataBooks['cover_book']); }else { echo "Public/img/cover/" . htmlspecialchars_decode($dataBooks['cover_book']);} ?>" class="card-img" alt="Librumnivores - Image de couverture"/>   
                    <div class="card-body">
                        <p id="title_list" class="card-text"><?= htmlspecialchars($dataBooks['title_book']) ?></p>
                        <p id="author_list" class="card-text"><?= htmlspecialchars($dataBooks['author_book']) ?></p>
                    </div>
                </a></div>
        <?php }  } else { ?>
            <p id="nothing_to_show"><i class="fas fa-book-open"></i> Votre librumnivothèque attend son premier livre ...</p>
        <?php } ?>
    </div>

    <!-- PAGINATION -->  
    <?php if ($bookCount > 0) { ?>
    <div id="block_pagination">
        <nav>
            <ul class="pagination">
                <li class="page-item <?php if($currentPage == 1){ echo "disabled"; }else { echo ""; } ?>">
                    <a href="index.php?action=listBooks&page=<?= $currentPage - 1 ?><?php if(isset($_GET['f'])){ echo '&amp;f=' . $this->cleanParam($_GET['f']);}?>#filters" class="page-link"><i class="fas fa-chevron-left"></i></a>
                </li>
                <?php for($i = 1; $i <= $pages; $i++){ ?>
                <li class="page-item <?php if($currentPage == $i){ echo "active";}else { echo "";} ?>">
                    <a href="index.php?action=listBooks&page=<?= $i ?><?php if(isset($_GET['f'])){ echo '&amp;f=' . $this->cleanParam($_GET['f']);}?>#filters" class="page-link"><?= $i ?></a>
                </li>
                <?php } ?>
                 <li class="page-item <?php if($currentPage == $pages){ echo "disabled"; } else { echo ""; } ?>">
                    <a href="index.php?action=listBooks&page=<?= $currentPage + 1 ?><?php if(isset($_GET['f'])){ echo '&amp;f=' . $this->cleanParam($_GET['f']);}?>#filters" class="page-link"><i class="fas fa-chevron-right"></i></a>
                </li>
            </ul>
        </nav>
    </div>
    <?php } }?>


    <!-- LENT BOOKS INFO -->
    <?php if ($countedLentBooks > 0) { ?>
    <div id="header_bookcase">
        <div>
            <h1>Vous avez <span class="number_book"><?= $countedLentBooks ?></span> prêts en cours. <span id="link_lent_books"><a href="index.php?action=listLentBooks<?php if(isset($_GET['f'])){ echo '&amp;f=' . $this->cleanParam($_GET['f']);}?>">ah oui ? allons voir d'un peu plus prêts, euh près ...</a></span></h1>
        </div>
    </div>
    <?php } ?>
    
</div>

<!-- SCRIPT JS -->
<script src="Public/js/ajax.js"></script>
<script src="Public/js/searchBook.js"></script>
<script src="Public/js/form.js"></script>
<script>objetForm.initSearchBook();</script>

<?php $content = ob_get_clean(); ?>
<?php require('App/View/template.php');