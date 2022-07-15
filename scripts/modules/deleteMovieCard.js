import { movieRepo } from "../repositories/MovieRepository.js"
import { showMoviesFromFilters } from "./createMovieCards.js"


export async function deleteMovie(e) {     

    // Get id from data atributes on the pop up container
    
    const movieId = document.querySelector('#movie-id').dataset.movid
 
    // await fetch(`http://imbd.test/api/delete?id=${movieId}`)
    const response = await movieRepo.delete(movieId)

    // !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!Aquí tenim el mateix que a edit, pero canviant parametres, fer una funció!!!!!!!!!!!!!!!!!!!1
    if (response.result === false) {
        const messageError = document.querySelector('#delete-message-error')
        messageError.textContent = response.message
    } else {
        const closeEvent = new CustomEvent('close-delete-pop-up')
        document.querySelector('#delete-pop-up').dispatchEvent(closeEvent)
    
        showMoviesFromFilters(e)
    }
    
}