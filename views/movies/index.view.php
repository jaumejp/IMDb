
    <?php require 'components/header.php' ?>

    <!--Content of the website-->
    <main>
        <section>  
            <h2>Filter movies by:</h2>
            <form class="searcher-card" method="post" enctype='multipart/form-data'>

                <!-- Director's  Filter -->
                <div>
                    <label for="">Movie name or description:</label>
                    <input id="movie-title" name="title" type="text" placeholder="some information.." value="<?= $selectedFilters["title"] ?>">
                </div>

                <div>
                    <label for="">Director's Name:</label>
                    <select name="director-name" id="movie-directors">
                        <option selected value="">None</option>
                        <?php foreach($listOfDirectors as $director) : ?>
                        <option value="<?= $director ?>" <?= ($director == $selectedFilters["director"]) ? "selected" : ''; ?> > <?= $director ?> </option>
                        <?php endforeach ?>
                    </select> 
                </div>


                <!-- Rating Filter -->
                <div>
                    <label for="">Rating:</label>
                    &lt3<input type="checkbox" name="rating[]" value="low-score" <?= (in_array("low-score", $selectedFilters["ratings"])) ? "checked" : ''; ?> >
                    3-5<input type="checkbox" name="rating[]" value="medium-score" <?= (in_array("medium-score", $selectedFilters["ratings"])) ? "checked" : ''; ?> >
                    &gt8<input type="checkbox" name="rating[]" value="high-score" <?= (in_array("high-score", $selectedFilters["ratings"])) ? "checked" : ''; ?> >
                </div>

                <!-- Genres Filter --> 
                <div class="genres-container"> 
                    <label for="">Genres:</label>
                    <div class="generes">
                        <?php foreach($listOfGenres as $genre) : ?>
                                <input type="checkbox" value="<?= $genre ?>" name="tags[]" <?= (in_array($genre, $selectedFilters["genres"])) ? "checked" : ''; ?> ></input>
                                <label for=""><?= $genre ?></label>
                        <?php endforeach ?>
                    </div>
                </div>

                <!-- Order By -->
                <div>
                    <label for="">Order by:</label>
                    <select id="order-by">
                        <option selected value="">None</option>
                        <option value="rating">Rating</option>
                        <option value="title">Name</option>
                    </select> 
                </div>

                <div>
                    <button type="submit" class="btn" >Search</button>
                    <button type="button" class="btn"><a href="./movies/create">Add Movie</a></button>
                </div>
            </form>
        </section>

        <section>
            <!-- Message for search input invalid or not founded -->
            <?php if(isset($_SESSION['flash_message'])): ?>
                <?php $message = $_SESSION['flash_message']; ?>
                <?php unset($_SESSION['flash_message']); ?>
                <p class="error-message"> <?= $message ?> </p>
            <?php endif ?>
        </section>
        
        
        <!--List of movies-->
        <section id="movies-list">   
            <!-- Message error from javaScript -->
            <h2 id="error-message"></h2>
            <template id="movie-card-template">
                <article class="movie-card">
                    <div class="main">
                        <img 
                            src="--MovieImage--"
                            alt="--MovieAlt--?>"
                        />
                        <div class="info">
                            <p class="title">--MovieTitle--</p>
                            <div class="genres">
                                <ul class="genres-list">
                                    <!-- Create all the <li>genre</li> by javaScript -->
                                </ul>
                            </div>
                            <p class="rating">--MovieRating--</p>
                        </div>
                    </div>
                    <div class="description">
                        <p>--MovieDescription--</p>
                        <div class="buttons">
                            <button type='button' class="btn delete">Delete</button>
                            <button type='button' class="btn edit" data-movid="">Edit</button>
                            <button type='button' class="btn more-info" data-movid="">More Info</button>
                        </div>
                    </div>
                </article>
            </template>            
        </section>

        <!--Delete Pop up-->
        <div class="pop-up-container" id="delete-pop-up">
            <div class="pop-up pop-up-delete">
                <?php require 'views/components/deletePopUp.php' ?>

            </div>
        </div>
        <!--Edit Pop up-->
        <div class="pop-up-container" id="edit-pop-up">
            <div class="pop-up pop-up-edit">
                <?php require 'views/components/editPopUp.php' ?>

            </div>
        </div>

    </main>

    <?php require 'components/footer.php' ?>