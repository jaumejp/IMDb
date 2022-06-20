<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        img {
            height: 200px;
        }
    </style>
</head>
<body>

    <?php foreach($listOfMovies as $movie) : ?>
        <h1> <?= $movie->getTitle() ?> </h1>
        <p> <?= $movie->getDescription() ?> </p>
        <img src="<?= $movie->getCoverImage() ?>" alt="<?= $movie->getTitle() ?>">
        <p> <?= $movie->getRating() ?> </p>
    <?php endforeach ?>

    
</body>
</html>