<!-- BLOCK SEARCH ISBN TO ADD BOOK -->
<div id="block_search">

<button type="button" id="button_close"><i class="fas fa-times"></i></button>

<!-- SEARCH ISBN -->
<div class="display_form">
    <div class="form-group">
        <label id="search_label">Un livre à ajouter ?</label>
        <input type="search" id ="input_search" class="form-control" placeholder="ISBN : 9782070584628" >
    </div>
    <button id="button_search" type="submit" class="btn btn-primary">RECHERCHER</button>
</div>

<!-- RESPONSE  SEARCH ISBN -->
<div id="block_result" class="card mb-3">
    <div class="row no-gutters">
        <div class="col-md-4">
            <img src="" id="result_img" class="card-img" alt="Librumnivores - image de couverture">
        </div>
        <div id="card_add" class="col-md-8">
            <div class="card-body">
                <h5 id="result_title" class="card-title"></h5>
                <h6 id="result_author" class="card-title"></h6>
                <p id="result_description" class="card-text"></p>

                <!-- FORM INFOS BOOK FOR  ADD TO DB -->
                <form action="index.php?action=addBook<?php if(isset($_GET['f'])){ echo '&amp;f=' . $this->cleanParam($_GET['f']);}?>" method="post">
                    <input type="hidden" name="title_book" id="title_book" />
                    <input type="hidden" name="author_book" id="author_book" />
                    <input type="hidden" name="image_book" id="image_book" />
                    <input type="hidden" name="isbn10_book" id="isbn10_book" />
                    <input type="hidden" name="isbn13_book" id="isbn13_book" />
                    <input type="hidden" name="publisher_book" id="publisher_book" />
                    <input type="hidden" name="published_date_book" id="published_date_book" />
                    <input type="hidden" name="page_count_book" id="page_count_book" />
                    <input type="hidden" name="short_description_book" id="short_description_book" />
                    <input type="hidden" name="description_book" id="description_book" />
                    <input type="submit" name="button_add" id="button_add" class="btn btn-primary" value="AJOUTER À MA BIBLIOTHÈQUE" />
                    <p class="choose_btn">ou</p>
                    <input type="submit" name="button_add_wish" id="button_add_wish" class="btn btn-primary" value="AJOUTER À MA LISTE DE SOUHAITS" />
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