

export async function fetchDataFrom(endPoint) {
    const response = await fetch(endPoint)
    const movies = await response.json()

    return  movies;
}

export function createEndPoint() {
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

    return endPoint
}