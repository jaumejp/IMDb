
const nameVerification = document.querySelector('#name-verification')

export function showPopUp() {
    
    document.querySelectorAll('.buttons .delete').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault()
            const elementClicked = e.target.parentNode.parentNode.parentNode.parentNode

            // Add data-attribut for moveId: 
            const movieId = elementClicked.querySelector('.buttons .delete').dataset.movid
            
            // Get reference to movie pop up container
            const popUpContainer = document.querySelector('.pop-up')

            popUpContainer.dataset.movid = movieId;
            
            const movieTitle = elementClicked.querySelector('.title').textContent; 

            nameVerification.textContent = `delete/${movieTitle}`

            // Show pop up
            document.querySelector('.pop-up-container').classList.add('show')

            // return id to used in the function of chek input to delete
            
        })})
    
}

// Close pop up: 
export function closePopUp() {
    document.querySelector('.btn-close').addEventListener('click', () => {
        document.querySelector('.pop-up-container').classList.remove('show')
        // clear input for next time
        const inputValue = document.querySelector('#input-movie-delete').value = ''

    })
}

// Check pop up input: 
export function checkInputToDelete() {

    document.querySelector('#delete-button-popup').addEventListener('click', (e) => {
        // Get id from data atributes on the pop up container
        const movieId = document.querySelector('.pop-up').dataset.movid
        const inputValue = document.querySelector('#input-movie-delete').value

        if (inputValue !== nameVerification.textContent) return
        
        // Get id of these movie and delete it: 
        deleteMovie(movieId)
        
    })

    document.querySelector('#input-movie-delete').addEventListener('keyup', (e) => {
        // Get id from data atributes on the pop up container
        const movieId = document.querySelector('.pop-up').dataset.movid
        const inputValue = document.querySelector('#input-movie-delete').value
        
        if (inputValue !== nameVerification.textContent) return 
        
        if (e.key === 'Enter') deleteMovie(movieId)
    
    })
}

async function deleteMovie(movieId) {      
    console.log(movieId)           
    await fetch(`http://imbd.test/api/delete?id=${movieId}`)

    // Auto close pop up ?

    // Refresh content or only delete the clicked one

    // Separar els events de les funcions, perque poguem fer close pop up sense l'event. 

    // Així, posar un arxiu que sigui handle events i que allà hi siguin tots i després es vagin cridant les funcions que es necessitin que estaran
    // en altres documents, que es podràn reutilitzar. com en el cas de close pop up.
}


