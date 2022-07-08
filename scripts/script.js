import { showMoviesFromFilters, showAllMovies, deleteMovie, editMovie } from "./modules/cardsControl.js";
import { closePopUp, showPopUp } from "../PopUpDependencies/popUpControl.js";


document.addEventListener('DOMContentLoaded', () => {
    
    async function displayContent() {

        await showAllMovies()

        // Event to show selected filters when submit the form:
        document.querySelector('.searcher-card').addEventListener('submit', (e) => {showMoviesFromFilters(e)})

        // Show movie page: 
        document.querySelector('#movies-list').addEventListener('click', (e) => { 
            e.preventDefault()

            const elementClicked = e.target 
        
            if (!elementClicked.classList.contains('more-info')) return false;

            const movieId = elementClicked.dataset.movid;
         
            window.location.replace(`movies/show?id=${movieId}`)
        })

        // Event to open delete pop up
        document.querySelector('#movies-list').addEventListener('click', (e) => { 
            e.preventDefault()

            const elementClicked = e.target 
        
            if (!elementClicked.classList.contains('delete')) return false;
        
            // Add data-attribut for moveId: 
            const movieId = elementClicked.dataset.movid
        
            // Get reference to movie pop up container
            document.querySelector('#movie-id').dataset.movid = movieId;
        
            const movieName = elementClicked.parentNode.parentNode.parentNode.querySelector('.title').textContent
            document.querySelector('#name-verification').textContent = movieName
            
            showPopUp('#delete-pop-up') 
        
        })
       
        // Event to close delete pop up
        document.querySelector('#delete-movie-cancel').addEventListener('click', () => { closePopUp('#delete-pop-up') })
        
        // Confirm delete movie
        document.querySelector('#delete-movie-ok').addEventListener('click', (e) => { deleteMovie(e) })

        // Event to open edit pop up
        document.querySelector('#movies-list').addEventListener('click', (e) => { 
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
                console.log(movie[0].coverImage)
                document.querySelector('#edit-movie-form #cover-image').value = movie[0].coverImage





            
                showPopUp('#edit-pop-up') 
            }
            getMovieToEdit(e, movieId)      
            
        
        })

        // Event to edit movie: 
        document.querySelector('#edit-movie-btn').addEventListener('submit', (e) => { console.log("hola") })

        // Event to close edit pop up 
        document.querySelector('#close-edit-form').addEventListener('click', () => { closePopUp('#edit-pop-up') })

    }
    
    displayContent()

});

