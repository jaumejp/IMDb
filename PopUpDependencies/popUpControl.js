
class PopUp {
    constructor(id) {
        this.id = `#${id}`
    }

    show() {
        document.querySelector(`${this.id} .pop-up`).scrollTop = 0
        document.querySelector(this.id).classList.add('show')
    }

    close() {
        document.querySelector(this.id).classList.remove('show')
    }
}

export const deletePopUp = new PopUp("delete-pop-up")
export const editPopUp = new PopUp("edit-pop-up")
