import { closePopUp } from "../../PopUpDependencies/popUpControl.js";
import { createEndPoint, fetchDataFrom } from "./fetch.js";

export function showMoviesFromFilters(e) {
    e.preventDefault();
    async function showFilteredMovies() {
         const endPoint = createEndPoint()
         const movies = await fetchDataFrom(endPoint);
         display(movies)
     }
     showFilteredMovies()
}
export async function showAllMovies() {
    const movies = await fetchDataFrom('http://imbd.test/api/movies');
    display(movies)
}

export async function deleteMovie(e) {     

    // Get id from data atributes on the pop up container
    
    const movieId = document.querySelector('#movie-id').dataset.movid
 
    await fetch(`http://imbd.test/api/delete?id=${movieId}`)

    closePopUp('#delete-pop-up')

    showMoviesFromFilters(e)
    
}

export async function editMovie(e) {
 
    closePopUp('#edit-pop-up')

    showMoviesFromFilters(e)

}

function display(movies) {

    if (movies.length === 0) {
        noMoviesFounded()
    } else {
        createMovieCards(movies);
    }
}

function cleanPage() {
    // First reset all movies to add new ones: 
    const moviesListContainer = document.querySelector('#movies-list')
    const articles = moviesListContainer.querySelectorAll(".movie-card");
    for (const article of articles) {
        moviesListContainer.removeChild(article)
    }
    // Delete error message:
    document.querySelector('#error-message').textContent = ''
}

function noMoviesFounded() {
    cleanPage()
    // Display error message
    document.querySelector('#error-message').textContent = 'No Movies Found!' 
}

function createMovieCards(movies) {
    // clean page: 
    cleanPage()

    // Create fragment to avoid reflow:
    const fragment = document.createDocumentFragment();

    // Get reference to template: 
    const template = document.querySelector('#movie-card-template').content 

    // Generate all the movie cards: 
    for(const movie of movies) {
        // Create clone of the <article> given by the template: 
        const movieCard = template.cloneNode(true);
        
        // Modify data for these article:
        movieCard.querySelector('img').src = movie.coverImage
        movieCard.querySelector('img').alt = movie.title
        movieCard.querySelector('.title').textContent = movie.title

        // Grab reference to <ul>
        const ul = movieCard.querySelector('.genres-list');

        // For all the genres, create <li> tags
        for (const genre of movie.genres) {
            // Create tag:
            const li = document.createElement("li");
            // Change text of the tag: 
            li.textContent = genre
            // Add genre to <ul> genres-list
            ul.appendChild(li)
        }

        movieCard.querySelector('.rating').textContent = movie.rating
        movieCard.querySelector('.description p').textContent = movie.description

        movieCard.querySelector('.buttons .delete').dataset.movid = movie.id
        movieCard.querySelector('.buttons .edit').dataset.movid = movie.id
        movieCard.querySelector('.buttons .more-info').dataset.movid = movie.id

        // Add card to fragment:
        fragment.appendChild(movieCard)
    }

    // Grab a reference to where we'll put the fragment
    const moviesList = document.querySelector('#movies-list');

    // Add the fragment to DOM:
    moviesList.appendChild(fragment);
}