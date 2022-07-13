
export function openDeletePopUp(e) {
    e.preventDefault()

    const elementClicked = e.target 

    if (!elementClicked.classList.contains('delete')) return false;

    // Add data-attribut for moveId: 
    const movieId = elementClicked.dataset.movid

    // Get reference to movie pop up container
    document.querySelector('#movie-id').dataset.movid = movieId;

    const movieName = elementClicked.parentNode.parentNode.parentNode.querySelector('.title').textContent
    document.querySelector('#name-verification').textContent = movieName
    
    // Custom Event to Open Delete PopUp
    const openEvent = new CustomEvent('show-delete-pop-up')
    document.querySelector('#delete-pop-up').dispatchEvent(openEvent)
  
}

export function openEditPopUp(e) {
    e.preventDefault()

    const elementClicked = e.target 

    if (!elementClicked.classList.contains('edit')) return false;

    const movieId = elementClicked.dataset.movid

    // Get info from movie clicked
    async function getMovieToEdit(e, movieId) {       
        const response = await fetch(`http://imbd.test/api/show?id=${movieId}`)

        const movie = await response.json();

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
        document.querySelector('#message-error').textContent = ''

        // Open edit pop up
        const openEvent = new CustomEvent('show-edit-pop-up')
        document.querySelector('#edit-pop-up').dispatchEvent(openEvent)
    }

    getMovieToEdit(e, movieId)  
}