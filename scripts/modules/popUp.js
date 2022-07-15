import { movieRepo } from "../repositories/MovieRepository.js";



export function openDeletePopUp(e) {
    e.preventDefault()

    // Button of delete clicked:
    const elementClicked = e.target 
    
    // Add data-attribut of the movie to delete: 
    const movieId = elementClicked.dataset.movid

    // Fill information of the pop Up
    // Put the movieId reference to pop up container:
    document.querySelector('#movie-id').dataset.movid = movieId;
    
    const movieName = elementClicked.parentNode.parentNode.parentNode.querySelector('.title').textContent
    document.querySelector('#name-verification').textContent = movieName

    // Delete possible previous error message: 
    document.querySelector('#delete-message-error').textContent = ''
    
    // Custom Event to Open Delete PopUp
    const openEvent = new CustomEvent('show-delete-pop-up')
    document.querySelector('#delete-pop-up').dispatchEvent(openEvent)
  
}

export function openEditPopUp(e) {
    e.preventDefault()

    // Button of Edit clicked:
    const elementClicked = e.target 

    // Get movie id to edit:
    const movieId = elementClicked.dataset.movid

    // Get info from movie clicked
    async function getMovieToEdit(e, movieId) {     

        // Make get request to server
        const movie = await movieRepo.get(movieId)

        // Fill pop up template with those data: 
        document.querySelector('#edit-movie-form #title').value = movie[0].title;
        document.querySelector('#edit-movie-form #resume').value = movie[0].resume;
        document.querySelector('#edit-movie-form #description').value = movie[0].description;
        document.querySelector('#edit-movie-form #rating').value = movie[0].rating;
        
        document.querySelector('#rating-output').value = movie[0].rating

        const directors = document.querySelectorAll('#edit-movie-form #director-name option')

        const directorsList = [...document.querySelectorAll('#edit-movie-form #director-name option')].map(option => option.value)

        for (const [index, director] of directorsList.entries()) {
            if (director === movie[0].director) {
                directors[index].selected = true;
            }
        }

        //const tags = e.target.parentNode.parentNode.parentNode.querySelectorAll('.genres-list li')
        const tags = document.querySelectorAll('#edit-movie-form .genres-container input')

        for (const tag of tags) {
            tag.checked = false;
        }

        for (const [index, tag] of tags.entries()) {
            if (movie[0].genres.indexOf(tag.value) >= 0) {
                tags[index].checked = true;
            }  
        }

        document.querySelector('#edit-movie-form #movie-id').value = movie[0].id

        document.querySelector('#hidden-cover-image').value = movie[0].coverImage

        const screenShotsContainer = document.querySelector('#old-screen-shots')
        const screenShots = movie[0].movieScreenShots

        for (const screenShot of screenShots) {
            const input = document.createElement('input')
            input.type = 'hidden'
            input.name = 'old_screen-shots[]'
            input.value = screenShot
            screenShotsContainer.appendChild(input)
        }

        // Any previous selected image or screen shot
        document.querySelector('#cover-image').value = null;
        document.querySelector('#screen-shot').value = null;

        // Delete previous error messsages:
        document.querySelector('#edit-message-error').textContent = ''

        // Open edit pop up
        const openEvent = new CustomEvent('show-edit-pop-up')
        document.querySelector('#edit-pop-up').dispatchEvent(openEvent)
    }

    getMovieToEdit(e, movieId)  
}