export function showPopUp(e) {
    e.preventDefault()

    const elementClicked = e.target 

    if (!elementClicked.classList.contains('delete')) return false;

    // Add data-attribut for moveId: 
    const movieId = elementClicked.dataset.movid
   
    // Get reference to movie pop up container
    const popUpContainer = document.querySelector('.pop-up')

    popUpContainer.dataset.movid = movieId;

    const movieName = elementClicked.parentNode.parentNode.parentNode.querySelector('.title').textContent
    document.querySelector('#name-verification').textContent = movieName

    // Show pop up
    document.querySelector('.pop-up-container').classList.add('show')

}

// Close pop up: 
export function closePopUp() {
    document.querySelector('.pop-up-container').classList.remove('show')
}




