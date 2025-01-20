        <?php include 'header.php'; ?>
        <main>
            <form>
                <div class="form-row">
                    <label for="first-name">Voornaam:</label>
                    <input type="text" id="first-name" placeholder="Voer je voornaam in" required pattern="[A-Za-z]+" title="Een naam mag alleen letters bevatten">
                
                    <label for="last-name">Achternaam:</label>
                    <input type="text" id="last-name" placeholder="Voer je achternaam in" required pattern="[A-Za-z]+" title="Een naam mag alleen letters bevatten">
                </div>
                
                <div class="form-row">
                    <label for="email">Email:</label>
                    <input type="email" id="email" placeholder="Voer je email in" required>
                </div>
                
                <div class="form-row">
                    <label for="password">Wachtwoord:</label>
                    <input type="password" id="password" placeholder="Voer je wachtwoord in" required pattern="^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$" 
                        title="Het wachtwoord moet minimaal 8 tekens bevatten, één hoofdletter, één cijfer en één speciaal karakter (zoals @$!%*?&).">
                
                    <label for="password-repeat">Herhaal Wachtwoord:</label>
                    <input type="password" id="password-repeat" placeholder="Herhaal je wachtwoord" required pattern="^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$" 
                        title="Het wachtwoord moet minimaal 8 tekens bevatten, één hoofdletter, één cijfer en één speciaal karakter (zoals @$!%*?&).">
                </div>
                
                <div class="form-row">
                    <label for="address">Adres (straatnaam en huisnummer):</label>
                    <input type="text" id="address" placeholder="Voer je straatnaam en huisnummer in" required pattern="^[A-Za-z0-9\s]+$" title="Een adres mag alleen letters en cijfers bevatten">
                
                    <label for="postcode">Postcode:</label>
                    <input type="text" id="postcode" placeholder="Voer je postcode in" required pattern="^[A-Za-z0-9\s]+$" title="Een postcode mag alleen letters en cijfers bevatten">
                
                    <label for="city">Stad:</label>
                    <input type="text" id="city" placeholder="Voer je stad in" required pattern="[A-Za-z]+" title="Een stad mag alleen letters bevatten">
                </div>
                
                <div class="form-row">
                    <label for="phone">Telefoonnummer:</label>
                    <input type="tel" id="phone" placeholder="Voer je telefoonnummer in" required pattern="^[0-9\d-]+$"  title="Een telefoonnummer mag alleen cijfers en - bevatten">
                </div>
                
                <button>Account Aanmaken</button>
            </form>
        </main>
    </body>
</html>
