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
        cy.contains('борщ')

        cy.get('input').should('have.attr', 'placeholder', 'Search...').type('Pas')

        cy.wait(1000) // wait for livewire debounce 700

        cy.contains('Pasta salad')
        cy.contains('Pastel de Nata')
        cy.contains('Pastrami')
        cy.contains('борщ').should('not.exist');

        cy.contains('Showing 1 to 4 of 4 Results')
        
        cy.get('a:contains("Source Code")').click()
    })
})
