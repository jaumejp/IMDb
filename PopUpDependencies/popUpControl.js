
export class PopUp {
    constructor(id) {
        this.id = `#${id}`
        this.randomId = Math.random()

        // Custom events listeners to show or close pop up
        document.querySelector(`#${id}`).addEventListener(`show-${id}`, () => {this.show()})
        document.querySelector(`#${id}`).addEventListener(`close-${id}`, () => {this.close()})

        // Close Pop Up when click cancel button
        document.querySelectorAll(`[data-close-modal="close-${id}"]`).forEach(btn => { 
            btn.addEventListener('click', () => {
                this.close()
            })
        })
        
    }

    showRandomId() {
        alert(this.randomId)
    }

    show() {
        document.querySelector(`${this.id} .pop-up`).scrollTop = 0
        document.querySelector(this.id).classList.add('show')
    }

    close() {
        document.querySelector(this.id).classList.remove('show')
    }
}

