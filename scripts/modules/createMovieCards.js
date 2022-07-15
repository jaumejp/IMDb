import { movieRepo } from "../repositories/MovieRepository.js";
import { display } from "./showMovieCards.js";

export async function showAllMovies() {
    const movies = await movieRepo.getAll()
    display(movies)
}

export async function showMoviesFromFilters() {
    const endPoint = createEndPoint()
    const movies = await movieRepo.getDataFrom(endPoint);
    
    display(movies)
}

function createEndPoint() {
    // Get filtes from searcher card and add the info to end point: 
    let endPoint = 'http://imbd.test/api/movies?'
    
    // Add title to endpoint
    const movieTitle = document.querySelector('#movie-title').value
    endPoint += `title=${movieTitle}`

    // Add director to endpoint
    const directorName = document.querySelector('#movie-directors').value
    endPoint += `&director-name=${directorName}`

    // Add ratings to endPoint
    const ratingsList = document.querySelectorAll("input[name='rating[]']")
    for (const rating of ratingsList) {
        if(rating.checked) {
            endPoint += `&rating[]=${rating.value}`
        }
    }

    // Add Genres to the endPoint
    const genresList = document.querySelectorAll("input[name='tags[]']")
    for (const tag of genresList) {
        if(tag.checked) {
            endPoint += `&tags[]=${tag.value}`
        }
    } 

    // Add Rating to the endPoint: 
    const orderBy = document.querySelector("#order-by").value
    endPoint += `&order-by=${orderBy}`

    return endPoint
}
     


