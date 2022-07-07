<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iMDb</title>
    <link rel="stylesheet" href="./Styles/generalStyles.css">
    <link rel="stylesheet" href="./Styles/cardStyles.css">
    <link rel="stylesheet" href="./Styles/genresStyles.css"> 
    <link rel="stylesheet" href="../../PopUpDependencies/popUpStyles.css"> 

    <script src="../../scripts/script.js" type="module"></script>
    <script src="../../PopUpDependencies/popUpControl.js" type="module"></script>

    <style>
        /* Desde l'arxiu css no funciona */
        .error-message span{
            font-weight: bold;
        }
    </style>
</head>
<body>
    <!--Header-->
    <header>
        <h1>iMDb<span class="dot">.</span>io</h1>

        <nav>
            <ul>
                <li>Some</li>
                <li>Navigation</li>
                <li>Options</li>
                <li>Here</li>
            </ul>
        </nav>
    </header>

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
                            <button class="btn edit"><a href="">Edit</a></button>
                            <button class="btn more-info" data-movieId=""><a href="">More info</a></button>
                        </div>
                    </div>
                </article>
            </template>            
        </section>

        <!--Pop up-->
        <section class="pop-up-container">
            <div class="pop-up" data-movid="">
            <p class="pop-up-title">Unexpected bad things will happen if you don’t read this!</p>
                <p>This action cannot be undone. This will permanently delete the movie card: <span class="delete-message">title, summary, description, rating, genres and all related images of the movie</span></p>
                <p>You will delete: <span class="delete-message" id="name-verification">movie-title</span>.</p>
                <div>
                    <button class="btn" id="delete-movie-ok">Accept</button>
                    <button class="btn" id="delete-movie-cancel">Cancel</button>
                </div>
            </div>
        </section>
    </main>

    <!--Footer-->
    <footer>
        <p>Some legat text here</p>
    </footer>
    
</body>
</html>