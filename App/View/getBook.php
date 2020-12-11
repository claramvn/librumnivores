<?php
$title = 'Ma bibliothèque';
?>

<!-- CONTENT -->
<?php ob_start(); ?>

<div class="content">

    <!-- BACK TO BOOKCASE -->
    <div class="links">
        <a href="index.php?action=listBooks<?php if(isset($_GET['f'])){ echo '&amp;f=' . $this->cleanParam($_GET['f']);}?>">Bibliothèque</a> <span class="red"><i class=" fas fa-chevron-right"></i><i class="fas fa-chevron-right"></i></span> <?= htmlspecialchars($book['title_book']) ?>
    </div>

    <!-- UPDATES --> 
    <div id="button_display_updates">
        <a id="btn_update_infos_book" title="MODIFIER"><i class="fas fa-pen"></i></a>
    </div>

    <!-- BLOCK UPDATES --> 
    <div id="block_updates">
        <button type="button" id="button_close_block_updates"><i class="fas fa-times"></i></button>

        <!-- FORM -->
        <div class="display_form">
            <h1 id="update_title"><?= htmlspecialchars($book['title_book']) ?> <span class="red"><i class="fas fa-square"></i></span></h1>
            <form action="index.php?action=updateInfosBook<?php if(isset($_GET['f'])){ echo '&amp;f=' . $this->cleanParam($_GET['f']);}?>" method="post" enctype="multipart/form-data">
                <input type="hidden" class="form-control" id="id_book" name="id_book" value="<?= htmlspecialchars($book['id_book']) ?>" >
                <div class="form-group">
                    <div id="block_cover"> 
                        <img src="<?php if(preg_match("(http)", htmlspecialchars_decode($coverBook))) { echo htmlspecialchars_decode($coverBook); } else if(preg_match("((noimg))", htmlspecialchars_decode($coverBook))) { echo "Public/img/" . htmlspecialchars_decode($coverBook); }else { echo "Public/img/cover/" . htmlspecialchars_decode($coverBook);} ?>" class="card-img-top" alt="Librumnivores - Image de couverture"/>
                    </div>
                </div>
                <div class="form-group">
                    <input type="file" class="form-control-file" id="cover_book" name="cover_book" accept="image/png, image/jpeg, image/jpg"/>
                </div>
                <div class="form-group">
                    <label>TITRE</label>
                    <input type="text" class="form-control" id="title_book" name="title_book" value="<?= htmlspecialchars($titleBook) ?>" >
                </div>
                <div class="form-group">
                    <label>AUTEUR</label>
                    <input type="text" class="form-control" id="author_book" name="author_book" value="<?= htmlspecialchars($authorBook) ?>">
                </div>
                <div class="form-group">
                    <label>DESCRIPTION</label>
                    <textarea class="form-control" id="description_book" name="description_book" rows="8"><?= htmlspecialchars_decode($descriptionBook) ?></textarea>
                </div>
                <button type="submit" class="btn btn-primary" id="button_updates_book" name="button_updates_book">MODIFIER</button>
            </form>
        </div>
    </div>

    <!-- BOOK -->
    <div id="card_book" class="card mb-3">
        <div class="row no-gutters">
            <div class="col-md-4">
                <img src="<?php if(preg_match("(http)", htmlspecialchars_decode($book['cover_book']))) { echo htmlspecialchars_decode($book['cover_book']); } else if(preg_match("((noimg))", htmlspecialchars_decode($book['cover_book']))) { echo "Public/img/" . htmlspecialchars_decode($book['cover_book']); }else { echo "Public/img/cover/" . htmlspecialchars_decode($book['cover_book']);} ?>" class="card-img" alt="Librumnivores - Image de couverture"/>
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($book['title_book']) ?></h5>
                    <h6 class="card-title"><?= htmlspecialchars($book['author_book']) ?></h6>
                    <p class="card-text"><?= nl2br(htmlspecialchars_decode($book['description_book'])) ?></p>
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
                    <div class="fav"><a href="index.php?action=addToFavoritesBooks&amp;id=<?php echo htmlspecialchars($book['id_book']); if(isset($_GET['f'])){ echo '&amp;f=' . $this->cleanParam($_GET['f']);}?>" title="AJOUTER AUX FAVORIS"><i class="fas fa-heart"></i></a></div>
            <?php } else { ?>
                    <div class="fav"><a href="index.php?action=takeBackFromFavoritesBooks&amp;id=<?php echo htmlspecialchars($book['id_book']); if(isset($_GET['f'])){ echo '&amp;f=' . $this->cleanParam($_GET['f']);}?>" title="SUPPRIMER DES FAVORIS"><i class="fas fa-heart-broken"></i></a></div>
            <?php } if($book['lend_book'] === "0") { ?>
                    <div class="lend"><a href="index.php?action=lendABook&amp;id=<?php echo htmlspecialchars($book['id_book']); if(isset($_GET['f'])){ echo '&amp;f=' . $this->cleanParam($_GET['f']);}?>" title="PRÊTER LE LIVRE"><i class="fas fa-user-plus"></i></a></div>
            <?php } else { ?>
                    <div class="lend"><a href="index.php?action=takeBackFromLentBooks&amp;id=<?php echo htmlspecialchars($book['id_book']); if(isset($_GET['f'])){ echo '&amp;f=' . $this->cleanParam($_GET['f']);}?>" title="RÉCUPÉRER LE LIVRE"><i class="fas fa-users-cog"></i></a></div>
            <?php } } else { ?>
                <div class="add_wish"><a href="index.php?action=addWishToBookcase&amp;id=<?php echo htmlspecialchars($book['id_book']); if(isset($_GET['f'])){ echo '&amp;f=' . $this->cleanParam($_GET['f']);}?>" title="AJOUTER À MA BIBLIOTHÈQUE"><i class="fas fa-book-open"></i></a></div>
            <?php } ?>
                <div class="delete_book"><a id="btn_delete_book" href="index.php?action=deleteBook&amp;id=<?php echo htmlspecialchars($book['id_book']); if(isset($_GET['f'])){ echo '&amp;f=' . $this->cleanParam($_GET['f']);}?>" title="SUPPRIMER LE LIVRE"><i class="fas fa-trash-alt"></i></a></div>
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

        <!-- ERROR OR SUCCESS UPDATES -->
        <?php if (isset($_SESSION['errors_updates'])) { ?>
             <p class="errors"><?= implode('<br/>', $_SESSION['errors_updates']) ?></p><br />
        <?php }
        unset($_SESSION['errors_updates']); ?>

        <?php if (isset($_SESSION['success_updates'])) { ?>
             <p class="success"><?= implode('<br/>', $_SESSION['success_updates']) ?></p><br />
        <?php }
        unset($_SESSION['success_updates']); ?>        

    </div>

</div>

<!-- SCRIPT JS -->
<script src="Public/js/confirmation.js"></script>
<script>objetConfirmation.deleteBook();</script>
<script src="Public/js/updateInfosBook.js"></script>
<script src="Public/js/form.js"></script>
<script>objetForm.initUpdateInfosBook();</script>

<?php $content = ob_get_clean(); ?>
<?php require('App/View/template.php');