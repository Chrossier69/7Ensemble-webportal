/**
 * MODAL-HTML.JS  –  Shared registration modal injector
 *
 * Injects #registrationModal into any page that doesn't already have it,
 * so modal.js / showModalBothOptions() works on every page without
 * duplicating HTML in each file.
 *
 * Must be loaded BEFORE modal.js.
 */
(function () {
    if (document.getElementById('registrationModal')) return; // already present

    document.body.insertAdjacentHTML('beforeend', `
    <!-- Unified Registration Modal (injected by modal-html.js) -->
    <div id="registrationModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2 class="modal-title-centered">🌟 Rejoindre 7 Ensemble 🌟</h2>

            <form id="registrationForm" onsubmit="return submitRegistrationForm(event)">
                <!-- Alcyone -->
                <div class="form-group">
                    <label for="alcyone">Alcyone (personne qui vous a invité) <span class="required">*</span></label>
                    <input type="text" id="alcyone" name="alcyone" placeholder="Nom de votre Alcyone" required>
                </div>

                <!-- Prénom -->
                <div class="form-group">
                    <label for="prenom">Prénom <span class="required">*</span></label>
                    <input type="text" id="prenom" name="prenom" placeholder="Votre prénom" autocomplete="given-name">
                </div>

                <!-- Nom -->
                <div class="form-group">
                    <label for="nom">Nom <span class="required">*</span></label>
                    <input type="text" id="nom" name="nom" placeholder="Votre nom de famille" autocomplete="family-name">
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label for="email">Email <span class="required">*</span></label>
                    <input type="email" id="email" name="email" placeholder="votre@email.com" autocomplete="email">
                </div>

                <!-- Country -->
                <div class="form-group">
                    <label for="country">Pays <span class="required">*</span></label>
                    <select id="country" name="country" autocomplete="country">
                        <option value="">Choisir votre pays</option>
                        <option value="FR">France</option>
                        <option value="CH">Suisse</option>
                        <option value="BE">Belgique</option>
                        <option value="CA">Canada</option>
                        <option value="MA">Maroc</option>
                        <option value="TN">Tunisie</option>
                        <option value="SN">Sénégal</option>
                        <option value="CI">Côte d\'Ivoire</option>
                        <option value="IN">Inde</option>
                        <option value="OTHER">Autre</option>
                    </select>
                </div>

                <!-- Payment Method -->
                <div class="form-group">
                    <label for="paymentMethod">Mode de paiement préféré <span class="required">*</span></label>
                    <select id="paymentMethod" name="paymentMethod">
                        <option value="">Choisir votre méthode</option>
                        <option value="card">💳 Carte bancaire</option>
                        <option value="paypal">🔵 PayPal</option>
                        <option value="transfer">🏦 Virement bancaire</option>
                        <option value="mobile">📱 Mobile Money (Afrique)</option>
                        <option value="crypto">₿ Bitcoin/Crypto</option>
                        <option value="other">🌍 Autre (nous nous adapterons)</option>
                    </select>
                </div>

                <!-- Terms -->
                <div class="form-group checkbox-group">
                    <label class="checkbox-label">
                        <input type="checkbox" id="terms" name="terms" class="checkbox-inline">
                        <span class="checkbox-label-text">J\'accepte le système d\'entraide 7 Ensemble et comprends le principe de solidarité mutuelle. <span class="required">*</span></span>
                    </label>
                </div>

                <!-- Options Section -->
                <div class="section-centree options-container">
                    <h3 id="optionsTitle">✨ Choisir mon option ✨</h3>

                    <!-- Option 3 people (conditionally shown) -->
                    <div id="option3Container" class="option-container" style="display: none;">
                        <label class="option-label">
                            <input type="radio" id="option3Radio" name="choixOption" value="3">
                            <span class="option-text">Option 3 personnes vers 7\'789€</span>
                        </label>
                    </div>

                    <!-- Option 7 people (conditionally shown) -->
                    <div id="option7Container" class="option-container" style="display: none;">
                        <label class="option-label">
                            <input type="radio" id="option7Radio" name="choixOption" value="7">
                            <span class="option-text">Option 7 personnes vers 1\'575\'747€</span>
                        </label>
                    </div>

                    <button type="submit" class="btn-primary btn-full-width">
                        🚀 Créer Ma Constellation !
                    </button>

                    <p class="voyage-text">
                        Bravo, votre aventure commence ici 💖
                    </p>
                </div>
            </form>
        </div>
    </div>`);
}());
