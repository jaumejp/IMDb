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
            <button class="btn"><a href="./movies/delete?id=<?= $movie->getId() ?>">Delete</a></button>
            <button class="btn"><a href="./movies/edit?id=<?= $movie->getId() ?>">Edit</a></button>
            <button class="btn"><a href="./movies/show?id=<?= $movie->getId() ?>">More info</a></button>
        </div>
    </div>
</article>