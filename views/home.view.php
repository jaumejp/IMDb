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
            <h2>Filter movie:</h2>
            <form class="searcher-card" method="post" enctype='multipart/form-data'>

                <!-- Director's  Filter -->
                <div>
                    <label for="">Movie name or description:</label>
                    <input name="title" type="text" placeholder="some information.." value="<?= $selectedFilters["title"] ?>">
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
                                <label for=""><?= $genre ?></label>
                                <input type="checkbox" value="<?= $genre ?>" name="tags[]" <?= (in_array($genre, $selectedFilters["genres"])) ? "checked" : ''; ?> ></input>
                        <?php endforeach ?>
                    </div>
                </div>

                <div>
                    <button type="submit" class="btn" >Search</button>
                    <button type="button" class="btn">Add Movie</button>
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
        <section>   
            <?php foreach($listOfMovies as $movie) : ?>

                <article class="movie-card">
                    <div class="main">
                        <img 
                            src="<?= $movie->getCoverImage() ?>"
                            alt="<?= $movie->getTitle() ?>"
                        />
                        <div class="info">
                            <p class="title"> <?= $movie->getTitle() ?> </p>
                            <div class="genres">
                                <ul>
                                    <?php foreach($movie->getGenres() as $genre): ?>
                                        <li><?= $genre ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <p class="rating"><?= $movie->getRating() ?></p>
                        </div>
                    </div>
                    <div class="description">
                        <p><?= $movie->getDescription() ?></p>
                        <div>
                            <button class="btn">Delete</button>
                            <button class="btn"><a href="./movies/edit?id=<?= $movie->getId() ?>">Edit</a></button>
                            <button class="btn"><a href="./movie.html">More info</a></button>
                        </div>
                    </div>
                </article>

            <?php endforeach ?>
            
        </section>

        <!-- Delete Pop up container -->
        <section class="pop-up-container">
            <div class="pop-up">
                <img src="./images/icons/close.png" alt="close-icon" class="btn-close">
                <p class="pop-up-title delete-title">Unexpected bad things will happen if you don’t read this!</p>
                <p>This action cannot be undone. This will permanently delete the movie card: <span class="delete-message">title, summary, description, rating, genres and all related images of the movie</span></p>
                <p>Please type <span class="delete-message">movie-title/director</span> to confirm.</p>
                <input class="wrong" type="text" placeholder="movie-title/director">
                <button class="btn btn-delete">Delete</button>
            </div>
        </section>
    </main>

    <!--Footer-->
    <footer>
        <p>Some legat text here</p>
    </footer>
    
</body>
</html>