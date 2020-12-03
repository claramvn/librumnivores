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
            <div id="infos_count"><p>Organiser ici l'ensemble de vos librum</p><span><?php if ($bookCount > 0) { echo "(" . $bookCount . ")" ; } ?></span></div>
        </div>
        <div> 
            <button id="button_open_search" type="button" class="btn btn-primary">Ajouter un livre</button>
        </div>
    </div>

    
    <!-- ERROR OR SUCCESS ADD BOOK -->
    <?php if (isset($_SESSION['error_add_book'])) {
                echo '<p class="errors">' . $_SESSION['error_add_book'] . '</p>';
            }
            unset($_SESSION['error_add_book']);

            if (isset($_SESSION['success_add_book'])) {
                echo '<p class="success">' . $_SESSION['success_add_book'] . '</p>';
            }
            unset($_SESSION['success_add_book']); ?>


    <!-- SUCCESS DELETE SELECTED BOOK -->
    <?php if (isset($_SESSION['success_delete_book'])) {
                echo '<p class="success">' . $_SESSION['success_delete_book'] . '</p>';
            }
            unset($_SESSION['success_delete_book']); ?>


    <!-- BLOCK SEARCH TO ADD BOOK -->
    <div id="block_search">

        <button type="button" id="button_close"><i class="fas fa-times"></i></button>

        <!-- SEARCH -->
        <div class="display_form">
            <form>
                <div class="form-group">
                    <label id="search_label" for ="input_search">Un livre à ajouter ?</label>
                    <input type="search" id ="input_search" class="form-control" placeholder="Identification par ISBN" >
                </div>
                <button id="button_search" type="button" class="btn btn-primary">Rechercher</button>
            </form>
        </div>

        <!-- RESPONSE -->
        <div id="block_result" class="card mb-3">
            <!-- CARD -->
            <div class="row no-gutters">
                <div class="col-md-4">
                    <img src="" id="result_img" class="card-img" alt="Librumnivores - image de couverture">
                </div>
                <div id="card_add" class="col-md-8">
                    <div class="card-body">
                        <h5 id="result_title" class="card-title"></h5>
                        <h6 id="result_author" class="card-title"></h6>
                        <p id="result_description" class="card-text"></p>

                        <!-- FORM FOR DB -->
                        <form action="index.php?action=addBook" method="post">
                            <input type="hidden" name="title_book" id="title_book" />
                            <input type="hidden" name="author_book" id="author_book" />
                            <input type="hidden" name="image_book" id="image_book" />
                            <input type="hidden" name="isbn_book" id="isbn_book" />
                            <input type="hidden" name="publisher_book" id="publisher_book" />
                            <input type="hidden" name="published_date_book" id="published_date_book" />
                            <input type="hidden" name="page_count_book" id="page_count_book" />
                            <input type="hidden" name="short_description_book" id="short_description_book" />
                            <input type="hidden" name="description_book" id="description_book" />
                            <input type="submit" name="button_add" id="button_add" class="btn btn-primary" value="Ajouter à ma bibliothèque" />
                            <div id="line"></div>
                            <label for="button_add_wish"><span id="more_sign"><i class="fas fa-plus"></i></span></label>
                            <input type="submit" name="button_add_wish" id="button_add_wish" value="Ajouter à ma liste de souhaits"/>
                        </form>

                    </div>
                </div>
            </div>
        </div>

        <!-- IF NO RESULT --> 
        <div id="no_result">
            <p>Désolé, aucun résultat ne correspond à votre recherche.</p>
        </div>

    </div>

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
    <div id="block_search_engine"> 
        <form action="index.php?action=listBooks<?php if(isset($_GET['f'])){ echo '&amp;f=' . $this->cleanParam($_GET['f']);}?>" method="post"> 
            <input id="input_search_engine" type="text" name="content_search" placeholder="Rechercher" />
            <button id="button_search_engine" type="submit" name="button_search_engine" class="btn btn-primary"><i class="fas fa-search"></i></button> 
        </form>
    </div>

    <!-- LISTING SEARCH BOOKS --> 
    <?php if (isset($_POST['content_search'])) { if($countedBooksSearch > 0) { ?>
    <h4 id="titre_recherche"><span class="red"><i class="fas fa-square"></i></span> Et voici le(s) fruit(s) de votre recherche :</h4>
    <div id="block_shelves">
        <?php foreach ($searchBooks as $dataBooksSearch) { ?> 
                <div id="card_shelves" class="card"><a href="index.php?action=getBook&amp;id=<?= htmlspecialchars($dataBooksSearch['id_book']) ?>">
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
        <div id="search_no_result"><p id="nothing_to_show"><i class="fas fa-book-open"></i> Votre recherche ne correspond à aucun résultat ...</p></div>
    <?php } } else { ?>
   

    <!-- LISTING BOOKS --> 
    <div id="block_shelves">
        <?php if ($bookCount > 0) {
            foreach ($books as $dataBooks) { ?> 
                <div id="card_shelves" class="card"><a href="index.php?action=getBook&amp;id=<?= htmlspecialchars($dataBooks['id_book']) ?>">
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
                    <a href="index.php?action=listBooks&page=<?= $currentPage - 1 ?><?php if(isset($_GET['f'])){ echo '&amp;f=' . $this->cleanParam($_GET['f']);}?>#block_pagination" class="page-link"><i class="fas fa-chevron-left"></i></a>
                </li>
                <?php for($i = 1; $i <= $pages; $i++){ ?>
                <li class="page-item <?php if($currentPage == $i){ echo "active";}else { echo "";} ?>">
                    <a href="index.php?action=listBooks&page=<?= $i ?><?php if(isset($_GET['f'])){ echo '&amp;f=' . $this->cleanParam($_GET['f']);}?>#block_pagination" class="page-link"><?= $i ?></a>
                </li>
                <?php } ?>
                 <li class="page-item <?php if($currentPage == $pages){ echo "disabled"; } else { echo ""; } ?>">
                    <a href="index.php?action=listBooks&page=<?= $currentPage + 1 ?><?php if(isset($_GET['f'])){ echo '&amp;f=' . $this->cleanParam($_GET['f']);}?>#block_pagination" class="page-link"><i class="fas fa-chevron-right"></i></a>
                </li>
            </ul>
        </nav>
    </div>
    <?php } }?>


    <!-- LENT BOOKS INFO -->
    <?php if ($countedLentBooks > 0) { ?>
    <div id="header_bookcase">
        <div>
            <h1>Vous avez <span class="number_book"><?= $countedLentBooks ?></span> prêts en cours. <span id="link_lent_books"><a href="index.php?action=listLentBooks&amp;f=all">ah oui ? allons voir d'un peu plus prêts, euh près ...</a></span></h1>
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