import { PopUp } from "../PopUpDependencies/popUpControl.js";
import { showAllMovies, showMoviesFromFilters } from "./modules/createMovieCards.js";
import { deleteMovie } from "./modules/deleteMovieCard.js";
import { updateMovie } from "./modules/uptadaMovieCard.js";



document.addEventListener('DOMContentLoaded', () => {

    new PopUp("delete-pop-up")
    new PopUp("edit-pop-up")

    async function displayContent() {
        console.log("DOM Loaded")
        
        // Show all movies
        await showAllMovies()

        // Event to show selected filters when submit the form:
        document.querySelector('.searcher-card').addEventListener('submit', (e) => {
            e.preventDefault()
            showMoviesFromFilters(e)
        })
        
        // Event to confirm delete movie when button clicked
        document.querySelector('#delete-movie-ok').addEventListener('click', (e) => {
            deleteMovie(e)
        })

        // Event to submit edit pop up when submit form
        document.querySelector('#edit-movie-form').addEventListener('submit', (e) => {
            e.preventDefault()
            updateMovie(e);
        })
    }
    
    displayContent()

});



