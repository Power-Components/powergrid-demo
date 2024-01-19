import moment from "moment";

describe('simple', () => {
    it('can visit simple page', () => {
        cy.visit('/examples/simple')
        cy.contains('Simple')
    })

    it('should be able to search properly', () => {
        cy.visit('/examples/simple')
        cy.contains('Source Code')
        cy.contains('Simple')
        cy.contains('Pastel de Nata')

        cy.get('input').should('have.attr', 'placeholder', 'Search...').type('Bife')

        cy.wait(1000) // wait for livewire debounce 700

        cy.contains('Bife à Rolê')
        cy.contains('Bife à Parmegiana')
        cy.contains('Bife à Milanesa')
        cy.contains('Pastel de Nata').should('not.exist');

        cy.contains('Showing 1 to 3 of 3 Results')
        
        cy.get('a:contains("Source Code")').click()
    })
})
