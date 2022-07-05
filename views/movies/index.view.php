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
                                <label for=""><?= $genre ?></label>
                                <input type="checkbox" value="<?= $genre ?>" name="tags[]" <?= (in_array($genre, $selectedFilters["genres"])) ? "checked" : ''; ?> ></input>
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
                            <button class="btn delete"><a href="">Delete</a></button>
                            <button class="btn edit"><a href="">Edit</a></button>
                            <button class="btn more-info"><a href="">More info</a></button>
                        </div>
                    </div>
                </article>
            </template>            
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

    <script>

        function createMovieCards(movies) {
            // First reset all movies to add new ones: 
            moviesListContainer = document.querySelector('#movies-list')
            articles = moviesListContainer.querySelectorAll(".movie-card");
            for (const article of articles) {
                moviesListContainer.removeChild(article)
            }

            // Create fragment:
            const fragment = document.createDocumentFragment();

            // Get referenct to template: 
            const template = document.querySelector('#movie-card-template').content 

            // Generate all the movie cards: 
            for(const movie of movies) {
                // Create clone of the <article> given by the template: 
                const movieCard = template.cloneNode(true);
                
                // Modify data for these article:
                movieCard.querySelector('img').src = movie.coverImage
                movieCard.querySelector('img').alt = movie.title
                movieCard.querySelector('.title').textContent = movie.title

                // Grab reference to <ul>
                const ul = movieCard.querySelector('.genres-list');

                // For all the genres, create <li> tags
                for (const genre of movie.genres) {
                    // Create tag:
                    const li = document.createElement("li");
                    // Change text of the tag: 
                    li.textContent = genre
                    // Add genre to <ul> genres-list
                    ul.appendChild(li)
                }

                movieCard.querySelector('.rating').textContent = movie.rating
                movieCard.querySelector('.description p').textContent = movie.description

                movieCard.querySelector('.buttons .delete a').href = `./movies/delete?id=${movie.id}`
                movieCard.querySelector('.buttons .edit a').href = `./movies/edit?id=${movie.id}`
                movieCard.querySelector('.buttons .more-info a').href = `./movies/show?id=${movie.id}`

                // Add card to fragment:
                fragment.appendChild(movieCard)
            }

            // Grab a reference to where we'll put the fragment ()
            const moviesList = document.querySelector('#movies-list');

            // Add the fragment to DOM:
            moviesList.appendChild(fragment);
        }

        function createEndPoint() {
            // Get filtes from searcher card and add the info to end point: 
            let endPoint = 'http://imdb.test/api/movies?'
            
            // Add title to endpoint
            movieTitle = document.querySelector('#movie-title').value
            endPoint += `title=${movieTitle}`

            // Add director to endpoint
            directorName = document.querySelector('#movie-directors').value
            endPoint += `&director-name=${directorName}`

            // Add ratings to endPoint
            const ratingsList = document.querySelectorAll("input[name='rating[]']")
            for (const rating of ratingsList) {
                if(rating.checked) {
                    endPoint += `&rating[]=${rating.value}`
                }
            }

            // Add Genres to the endPoint
            const genresList = document.querySelectorAll("input[name='tags[]']")
            for (const tag of genresList) {
                if(tag.checked) {
                    endPoint += `&tags[]=${tag.value}`
                }
            } 

            return endPoint
        }

        async function createDOMwith(endPoint) {
            const response = await fetch(endPoint)
            const movies = await response.json()
            createMovieCards(movies);
        }

        document.addEventListener('DOMContentLoaded', () => {
            createDOMwith('http://imbd.test/api/movies');
            
            document.querySelector('.searcher-card').addEventListener('submit', (e) => {
                e.preventDefault();
                endPoint = createEndPoint()
                createDOMwith(endPoint);
                //window.location.replace(endPoint)
            })
        })

</script>
    
</body>
</html>