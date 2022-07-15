class MovieRepository
{

    async getAll() {
        const response = await fetch('http://imbd.test/api/movies')
        const movies = await response.json()
        return  movies;
    }

    async getDataFrom(endPoint) {
        const response = await fetch(endPoint)
        const movies = await response.json()
        return  movies;
    }

    async update(data) {
        const result = await fetch('http://imbd.test/api/update', { method: "POST", body: data })
        const response = await result.json()
        return response
    }

    async delete(id) {
        const result = await fetch(`http://imbd.test/api/delete?id=${id}`)
        const response = await result.json()
        return response
    }
    
    async get(id) {
        const response = await fetch(`http://imbd.test/api/show?id=${id}`)
        const movie = await response.json();
        return movie
    }

}

export const movieRepo = new MovieRepository();