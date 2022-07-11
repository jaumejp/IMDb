import { showMoviesFromFilters, showAllMovies, deleteMovie } from "./modules/cardsControl.js";
import { closePopUp } from "../PopUpDependencies/popUpControl.js";

document.addEventListener('DOMContentLoaded', () => {

    async function displayContent() {
        console.log("DOM Loaded")

        await showAllMovies()

        // Event to show selected filters when submit the form:
        document.querySelector('.searcher-card').addEventListener('submit', (e) => {showMoviesFromFilters(e)})
        
        // Confirm delete movie
        document.querySelector('#delete-movie-ok').addEventListener('click', (e) => { deleteMovie(e) })

        // Event to close delete pop up
        document.querySelector('#delete-movie-cancel').addEventListener('click', () => { closePopUp('#delete-pop-up') })

        // Event to close edit pop up 
        document.querySelector('#close-edit-form').addEventListener('click', () => { closePopUp('#edit-pop-up') })

    }
    
    displayContent()

});



