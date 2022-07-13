
export class PopUp {
    constructor(id) {
        this.id = `#${id}`
        this.randomId = Math.random()

        // Custom events listeners to show or close pop up
        document.querySelector(`#${id}`).addEventListener(`show-${id}`, () => {this.show()})
        document.querySelector(`#${id}`).addEventListener(`close-${id}`, () => {this.close()})

        //foreach de tots els elements que tinguin data-close-modal=IDdelmodal afegir un event listener del click del botó que executi mostrar
        
        // Custom events listeners to close edit pop up.
        // Estic creant això també quan no s'ha de crear, amb el delete.
        //document.querySelectorAll('[data-close-modal="edit-pop-up"]').forEach(btn => () => { alert(btn) })
        
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

