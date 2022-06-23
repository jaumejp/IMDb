
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

<?php if(isset($_SESSION['flash_message'])): ?>
    <?php $message = $_SESSION['flash_message']; ?>
    <?php unset($_SESSION['flash_message']); ?>
    <p> <?= $message ?> </p>
<?php endif ?>

<form method="post" enctype='multipart/form-data' action="/movies/search">

    <label for="">Movie Title or information:</label>
    <input name="title"></input>

    <label for="">Rating:</label>
    <div class="rating">
        &lt3<input type="checkbox" name="rating[]" value="low-score">
        3-5<input type="checkbox" name="rating[]" value="medium-score">
        &gt8<input type="checkbox" name="rating[]" value="high-score">
    </div>


    <label for="">Director's name</label>
    <select name="director-name">
        <option selected value="">None</option>
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

    <button type="submit">Submit</button>

</form> 


