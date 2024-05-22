describe('Formulaire de Connexion', () => {
    it('test 1 - connexion OK', () => {
        cy.visit('/login');

        // Entrer le nom d'utilisateur et le mot de passe
        cy.get('#username').type('test@mail.com');
        cy.get('#password').type('test');

        // Soumettre le formulaire
        cy.get('button[type="submit"]').click();

        // Vérifier que l'utilisateur est connecté
        cy.contains('Welcome to PDF Generator').should('exist');
    });

    it('test 2 - connexion KO', () => {
        cy.visit('/login');

        // Entrer un nom d'utilisateur et un mot de passe incorrects
        cy.get('#username').type('faux@mail.com');
        cy.get('#password').type('fezdfe');

        // Soumettre le formulaire
        cy.get('button[type="submit"]').click();

        // Vérifier que le message d'erreur est affiché
        cy.contains('Invalid credentials.').should('exist');
    });
});