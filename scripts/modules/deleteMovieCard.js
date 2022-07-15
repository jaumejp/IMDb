import { movieRepo } from "../repositories/MovieRepository.js"
import { showMoviesFromFilters } from "./createMovieCards.js"


export async function deleteMovie(e) {     

    // Get id from data atributes on the pop up container:
    const movieId = document.querySelector('#movie-id').dataset.movid
 
    // Make a delete request to server:
    const response = await movieRepo.delete(movieId)

    if (response.result === false) {
        const messageError = document.querySelector('#delete-message-error')
        messageError.textContent = response.message
    } else {
        const closeEvent = new CustomEvent('close-delete-pop-up')
        document.querySelector('#delete-pop-up').dispatchEvent(closeEvent)
    
        showMoviesFromFilters(e)
    }
    
}