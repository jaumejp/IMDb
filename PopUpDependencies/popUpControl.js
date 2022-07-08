// Show pop up
export function showPopUp(popUpId) {
    document.querySelector(`${popUpId} .pop-up`).scrollTop = 0
    document.querySelector(popUpId).classList.add('show')
}

// Close pop up: 
export function closePopUp(popUpId) {
    document.querySelector(popUpId).classList.remove('show')
}




