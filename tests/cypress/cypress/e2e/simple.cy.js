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

        cy.wait(800) // wait for livewire debounce 700

        const data = [
            '4', 'Bife à Rolê', 'Luan', '51.79', 'No', '05/04/2023',
            '11', 'Bife à Parmegiana', 'Luan', '129.15', 'Yes', '05/04/2023',
            '45', 'Bife à Milanesa', 'Dan', '181.65', 'Yes', '05/04/2023'
        ];

        cy.get('table tbody tr td').then(($td) => {
            const texts = Cypress._.map($td, 'innerText')

            expect(texts, 'data').to.deep.equal(data)
        })
    })


})
