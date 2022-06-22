
<style>
    form {
        display: flex;
        flex-direction:column;
        gap: 0.5em;
        width: 200px;
    }
    .genres-container {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 2em;
    }
    p {
        color: red;
    }
</style>
<?php session_start(); ?>

<?php require 'database/fetchDirectors.php' ?>
<?php $listOfDirectors = fetchDirectors() ?>

<?php require 'database/fetchGenres.php' ?>
<?php $listOfGenres = fetchGenres() ?>

<?php if(isset($_SESSION['flash_message'])): ?>
    <?php $message = $_SESSION['flash_message']; ?>
    <?php unset($_SESSION['flash_message']); ?>
    <p> <?= $message ?> </p>
<?php endif ?>

<form method="post" enctype='multipart/form-data' action="/api/movies">

    <label for="">Movie title</label>
    <input name="title"></input>

    <label for="">Resume</label>
    <textarea name="resume" rows="4" cols="50"></textarea>

    <label for="">Description</label>
    <textarea name="description" rows="4" cols="50"></textarea>

    <label for="">Rating</label>
    <input type="number" min="0" max="10" step="0.1" name="rating"></input>

    <label for="">Cover Image</label>
    <input type="file" name="cover-image"></input>

    <label for="">Director's name</label>
    <select name="director-name">
        <option selected value="" disabled>Select director's movie</option>
        <?php foreach($listOfDirectors as $director) : ?>
        <option value="<?= $director ?>"> <?= $director ?> </option>
        <?php endforeach ?>
    </select>

    <label for="">Genres:</label>
    <div class="genres-container"> 
        <?php foreach($listOfGenres as $genre) : ?>
            <div>
                <label for=""><?= $genre ?></label>
                <input type="checkbox" value="<?= $genre ?>" name="tags[]"></input>
            </div>
        <?php endforeach ?>
    </div>

    <label for="screen_shots">Screen Shots:</label>
    <input type="file" name="screen_shots[]" multiple></input>

    <button type="submit">Submit</button>

</form> 


