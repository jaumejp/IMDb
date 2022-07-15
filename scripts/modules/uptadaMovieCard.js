import { movieRepo } from "../repositories/MovieRepository.js";
import { showMoviesFromFilters } from "./createMovieCards.js";

export async function updateMovie(e) {
    // Get data from form:
    const form = document.querySelector('#edit-movie-form') ;
    const data = new FormData(form)

    const response = await movieRepo.update(data)

    if (response.result === false) {
        // show again edit pop up
        const messageError = document.querySelector('#edit-message-error')
        messageError.textContent = response.message

    } else {
        // close pop up and refresh page to see changes
        const closeEvent = new CustomEvent('close-edit-pop-up')
        document.querySelector('#edit-pop-up').dispatchEvent(closeEvent)
        
        showMoviesFromFilters(e)
    }
}