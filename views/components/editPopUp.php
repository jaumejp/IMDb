
<form method="post" enctype='multipart/form-data' action="/movies/update" id="edit-movie-form">
    <h4 style="color: red; text-align: center" id="message-error"></h4>

    <label for="">Movie title</label>
    <input id='title' name="title"></input>

    <label for="">Resume</label>
    <textarea id='resume' name="resume" rows="4" cols="50"></textarea>

    <label for="">Description</label>
    <textarea id='description' name="description" rows="4" cols="50"></textarea>

    <label for="">Rating</label>
    <input id="rating" type="range" min="0" max="10" step="0.1" name="rating" value = "" ></input>
    <output>0</output>

    <label for="">Cover Image</label>
    <input id="cover-image" type="file" name="cover-image">

    <label for="">Director's name</label>
    <select id="director-name" name="director-name">
        <option selected value="" disabled>Select director's movie</option>
        <?php foreach($listOfDirectors as $director) : ?>
            <option value = "<?= $director ?>"><?= $director ?></option>
        <?php endforeach ?>
    </select>

    <label for="">Genres:</label>
    <div class="genres-container genres-container-edit-pop-up"> 
        <?php foreach($listOfGenres as $genre) : ?>
            <div>
                <label for=""><?= $genre ?></label>
                <input class="genreList" type="checkbox" value="<?= $genre ?>" name="tags[]"></input>
            </div>
        <?php endforeach ?>
    </div>

    <label for="screen_shots">Screen Shots:</label>
    <input id="screen-shot" type="file" name="screen_shots[]" multiple></input>


    <!-- Hidden input to send movie id to update page -->

    <input id='movie-id' type="hidden" name="movie-id"></input>

    <input id='hidden-cover-image' type="hidden" name="old-cover-image"></input>

    <div id='old-screen-shots'></div>


    <button id='edit-movie-btn' class="btn" type="submit">Submit</button> 

</form> 

<button class="btn" id="close-edit-form" data-close-modal="edit-pop-up">Cancel</button>
