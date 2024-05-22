describe('Formulaire inscription', () => {
    it('test 1 - inscription OK', () => {
        cy.visit('/register');

        // Entrer le nom d'utilisateur et le mot de passe
        cy.get('#registration_form_email').type('test.cypress@mail.com');
        cy.get('#registration_form_plainPassword').type('cypress');
        cy.get('#registration_form_firstName').type('John');
        cy.get('#registration_form_lastName').type('Doe');
        cy.get('#registration_form_agreeTerms').check().should('be.checked');

        // Soumettre le formulaire
        cy.get('button[type="submit"]').click();

        // Vérifier que l'utilisateur est connecté
        cy.contains('Welcome to PDF Generator').should('exist');
    });

    it('test 1 - inscription OK', () => {
        cy.visit('/register');

        // Entrer le nom d'utilisateur et le mot de passe
        cy.get('#registration_form_email').type('test@mail.com');
        cy.get('#registration_form_plainPassword').type('cypress');
        cy.get('#registration_form_firstName').type('John');
        cy.get('#registration_form_lastName').type('Doe');
        cy.get('#registration_form_agreeTerms').check().should('be.checked');

        // Soumettre le formulaire
        cy.get('button[type="submit"]').click();

        // Vérifier que l'utilisateur est connecté
        cy.contains('There is already an account with this email').should('exist');
    });
});