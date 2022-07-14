
<link rel="stylesheet" href="../Styles/movieStyles.css">

<?php require 'components/header.php' ?>


    <!--Content of each movie-->
    <main>
        <section class="movie movie-section">
            <div class="movie-general">
                <h2> <?= $movie["title"] ?> </h2>
                <img src="<?= $movie["cover_image"] ?>" alt=" <?= $movie["title"] ?>">
            </div>
            <div class="movie-info">
                <div>
                    <h3>Director's Name</h3>
                    <p> <?= $movie["director_name"] ?> </p>
                    <hr>
                    <h3>Movie Description:</h3>
                    <p class="movie-description"> <?= $movie["description"] ?> </p>
                </div>
                <div class="genres">
                    <ul>
                        <?php foreach($movie["genres_list"] as $genre): ?>
                        <li> <?= $genre ?> </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <div class="movie-screen-shots">
                <?php foreach($movie["screen_shots_list"] as $screenShot): ?>
                    <figure>
                        <img src="<?= $screenShot ?>" alt="movie-screen-shot">
                    </figure>
                <?php endforeach; ?>
            </div>
        </section>
    </main>

    <?php require 'components/footer.php' ?>

