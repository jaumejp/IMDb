import { eventForSubmitFilters, showAllMovies } from "./modules/cardsControl.js";
import { checkInputToDelete, closePopUp, showPopUp } from "./modules/popUpControl.js";

document.addEventListener('DOMContentLoaded', () => {
    
    async function displayContent() {
        await showAllMovies()

        eventForSubmitFilters()
    
        showPopUp()

        closePopUp()

        checkInputToDelete()
    }
    
    displayContent()

  });


