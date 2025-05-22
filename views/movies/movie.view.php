<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Template</title>
    <link rel="stylesheet" href="../../Styles/generalStyles.css">
    <link rel="stylesheet" href="../../Styles/movieStyles.css">
    <link rel="stylesheet" href="../../Styles/genresStyles.css">
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

    <!--Content of each movie-->
    <main>
        <section class="movie">
            <div class="general">
                <h2> <?= $movie["title"] ?> </h2>
                <img src="<?= $movie["cover_image"] ?>" alt=" <?= $movie["title"] ?>">
            </div>
            <div class="info">
                <div>
                    <h3>Director's Name</h3>
                    <p> <?= $movie["director_name"] ?> </p>
                    <hr>
                    <h3>Movie Description:</h3>
                    <p class="description"> <?= $movie["description"] ?> </p>
                </div>
                <div class="genres">
                    <ul>
                        <?php foreach($movie["genres_list"] as $genre): ?>
                        <li> <?= $genre ?> </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <div class="screen-shots">
                <?php foreach($movie["screen_shots_list"] as $screenShot): ?>
                    <figure>
                        <img src="<?= $screenShot ?>" alt="movie-screen-shot">
                    </figure>
                <?php endforeach; ?>
            </div>
        </section>
    </main>

    <!--Footer-->
    <footer>
        <p>Some legat text here</p>
    </footer>

</body> 
</html>

