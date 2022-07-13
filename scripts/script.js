import { showMoviesFromFilters, showAllMovies, deleteMovie } from "./modules/cardsControl.js";
import { PopUp } from "../PopUpDependencies/popUpControl.js";

document.addEventListener('DOMContentLoaded', () => {

    new PopUp("delete-pop-up")
    new PopUp("edit-pop-up")

    async function displayContent() {
        console.log("DOM Loaded")

        await showAllMovies()

        // Event to show selected filters when submit the form:
        document.querySelector('.searcher-card').addEventListener('submit', (e) => {showMoviesFromFilters(e)})
        
        // Confirm delete movie
        document.querySelector('#delete-movie-ok').addEventListener('click', (e) => { deleteMovie(e) })

        // Event to close delete pop up
        document.querySelector('#delete-movie-cancel').addEventListener('click', () => { 
            const closeEvent = new CustomEvent('close-delete-pop-up')
            document.querySelector('#delete-pop-up').dispatchEvent(closeEvent)
        })

        // Event to close edit pop up 
        document.querySelector('#close-edit-form').addEventListener('click', () => { 
            const closeEvent = new CustomEvent('close-edit-pop-up')
            document.querySelector('#edit-pop-up').dispatchEvent(closeEvent)
         })

        // Event to submit edit pop up
        document.querySelector('#edit-movie-form').addEventListener('submit', (e) => { 
            e.preventDefault()
            
            async function uptadeMovie() {
                // Get data from form:
                const form = document.querySelector('#edit-movie-form') ;
                const data = new FormData(form)

                const response = await fetch('http://imbd.test/api/update', { method: "POST", body: data })
                const message = await response.json()

                if (message.result === false) {
                    // show again edit pop up
                    const messageError = document.querySelector('#message-error')
                    messageError.textContent = message.message

                } else {
                    // close pop up and refresh page to see changes
                    const closeEvent = new CustomEvent('close-edit-pop-up')
                    document.querySelector('#edit-pop-up').dispatchEvent(closeEvent)
                    showMoviesFromFilters(e)
                }
            }
            
            uptadeMovie()
            
        })

    }
    
    displayContent()

});



