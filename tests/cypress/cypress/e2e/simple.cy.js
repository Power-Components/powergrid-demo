import moment from "moment";

describe('simple', () => {
    it('can visit simple page', () => {
        cy.visit('/simple')
        cy.contains('Simple')
    })

    it('should be able to search properly', () => {
        cy.visit('/simple')
        cy.contains('Simple')

        cy.get('[data-cy=pg-search-default]').
            type('Bife')

        cy.wait(1000) // wait for livewire debounce 700

        const createdAt = moment().format('DD/MM/YYYY')

        const data = [
            '4', 'Bife à Rolê', 'Vitor', '$100.13', 'No', ''+createdAt,
            '11', 'Bife à Parmegiana', 'Luan', '$110.20', 'Yes', ''+createdAt,
            '45', 'Bife à Milanesa', 'Dan', '$100.10', 'No', ''+createdAt,
        ];

        cy.get('table tbody tr td').then(($td) => {
            const texts = Cypress._.map($td, 'innerText')

            expect(texts, 'data').to.deep.equal(data)
        })
    })


})
