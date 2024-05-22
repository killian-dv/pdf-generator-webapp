describe('Generation de pdf', () => {
    it('test 1 - generatio OK', () => {
        cy.visit('/login');

        // Entrer le nom d'utilisateur et le mot de passe
        cy.get('#username').type('test@mail.com');
        cy.get('#password').type('test');

        // Soumettre le formulaire
        cy.get('button[type="submit"]').click();

        // Vérifier que l'utilisateur est connecté
        cy.contains('Welcome to PDF Generator').should('exist');

        // aller sur la page de génération de PDF
        cy.visit('/generate/pdf');

        // Entrer le nom du pdf et l'url
        cy.get('#generate_pdf_form_pdfName').type('cypress');
        cy.get('#generate_pdf_form_url').type('https://docs.cypress.io/guides/overview/why-cypress');

        // Vérifiez que l'élément <embed> de type application/pdf est présent
        cy.get('embed[type="application/pdf"]').should('exist');
    });

});