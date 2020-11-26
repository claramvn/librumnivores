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
            <p>Organiser ici l'ensemble de vos librum</p>
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
                    <img src="..." id="result_img" class="card-img" alt="Librumnivores - image de couverture">
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
    <div id="filters">
        <p>Trier par</p>
        <p class="filters"><a href="">Titre</a></p>
        <p class="filters"><a href="">Auteur</a></p>
        <p class="filters"><a href="">Tous</a></p>
    </div>

    <!-- LISTING BOOKS --> 
    <div id="block_shelves">
        <?php if ($bookCount > 0) {
            foreach ($books as $dataBooks) { ?> 
                <div id="card_shelves" class="card"><a href="index.php?action=getBook&amp;id=<?= htmlspecialchars($dataBooks['id_book']) ?>">
                    <img src="<?= htmlspecialchars_decode($dataBooks['cover_book']) ?>" class="card-img-top" alt="Librumnivores - Image de couverture">
                    <div class="card-body">
                        <p class="card-text"><?= htmlspecialchars($dataBooks['title_book']) ?></p>
                    </div></a>
                </div>
        <?php }  } else { ?>
            <p><i class="fas fa-book-open"></i> Votre librumnivothèque attend son premier livre ...</p>
        <?php } ?>
    </div>

    <!-- PAGINATION -->  
    <div id="block_pagination">
        <nav>
            <ul class="pagination">
                <li class="page-item <?php if($currentPage == 1){ echo "disabled"; }else { echo ""; } ?>">
                    <a href="index.php?action=listBooks&page=<?= $currentPage - 1 ?>#block_pagination" class="page-link"><i class="fas fa-chevron-left"></i></a>
                </li>
                <?php for($i = 1; $i <= $pages; $i++){ ?>
                <li class="page-item <?php if($currentPage == $i){ echo "active";}else { echo "";} ?>">
                    <a href="index.php?action=listBooks&page=<?= $i ?>#block_pagination" class="page-link"><?= $i ?></a>
                </li>
                <?php } ?>
                 <li class="page-item <?php if($currentPage == $pages){ echo "disabled"; } else { echo ""; } ?>">
                    <a href="index.php?action=listBooks&page=<?= $currentPage + 1 ?>#block_pagination" class="page-link"><i class="fas fa-chevron-right"></i></a>
                </li>
            </ul>
        </nav>
    </div>


    <!-- LENT BOOKS INFO -->
    <?php if ($countedLentBooks > 0) { ?>
    <div id="header_bookcase">
        <div>
            <h1>Vous avez <span class="number_book"><?= $countedLentBooks ?></span> prêts en cours. <span id="link_lent_books"><a href="index.php?action=listLentBooks">ah oui ? allons voir d'un peu plus prêts, euh près ...</a></span></h1>
        </div>
    </div>
    <?php } ?>
    
</div>

<!-- SCRIPT JS -->
<script src="Public/js/ajax.js"></script>
<script src="Public/js/searchBook.js"></script>

<?php $content = ob_get_clean(); ?>
<?php require('App/View/template.php');