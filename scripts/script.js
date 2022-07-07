import { showMoviesFromFilters, showAllMovies, deleteMovie } from "./modules/cardsControl.js";
import { closePopUp, showPopUp } from "../PopUpDependencies/popUpControl.js";

// document.addEventListener('DOMContentLoaded', () => {
    
    async function displayContent() {

        await showAllMovies()

        // Event to show selected filters when submit the form:
        document.querySelector('.searcher-card').addEventListener('submit', (e) => {showMoviesFromFilters(e)})

        // Event to open pop up
        document.querySelector('#movies-list').addEventListener('click', (e) => { showPopUp(e) })

        // document.querySelectorAll('.buttons .delete').forEach(btn => {
        //     btn.addEventListener('click', (e) => {
        //         console.log(document.querySelectorAll('.buttons .delete'))
        //         showPopUp(e)
        //     })})
        
        // Event to close pop up
        document.querySelector('#delete-movie-cancel').addEventListener('click', closePopUp)
        
        // Confirm delete movie
        document.querySelector('#delete-movie-ok').addEventListener('click', (e) => { deleteMovie(e) })
        
    }
    
    displayContent()

//   });


