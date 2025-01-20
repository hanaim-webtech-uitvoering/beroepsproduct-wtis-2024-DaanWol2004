<?php
include 'header.php';

if (isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'Personnel') {
    header('Location: bestellingen-personeel.php'); 
    exit;
}
?>

        <main>
            <section>
                <h2>Inleiding</h2>
                <p>Bij Pizzeria Sole Machina respecteren we uw privacy en zetten we ons in om uw persoonlijke gegevens te beschermen. Deze privacyverklaring legt uit hoe wij omgaan met uw gegevens wanneer u onze website gebruikt.</p>
            </section>

            <section>
                <h2>Welke gegevens verzamelen wij?</h2>
                <p>We verzamelen de volgende soorten gegevens wanneer u gebruik maakt van onze website:</p>
                <ul>
                    <li><strong>Persoonlijke gegevens:</strong> Zoals uw naam, adres, telefoonnummer en e-mailadres wanneer u een bestelling plaatst of zich registreert.</li>
                    <li><strong>Betalingsgegevens:</strong> Uw betalingsinformatie wordt verzameld via externe betalingssystemen zoals iDEAL of PayPal, maar wordt niet opgeslagen op onze servers.</li>
                    <li><strong>Technische gegevens:</strong> Zoals uw IP-adres, browsertype, bezochte pagina’s en de datum en tijd van uw bezoek voor analytische doeleinden.</li>
                </ul>
            </section>

            <section>
                <h2>Hoe gebruiken wij uw gegevens?</h2>
                <p>De gegevens die we verzamelen, worden gebruikt voor de volgende doeleinden:</p>
                <ul>
                    <li>Het verwerken en leveren van uw bestellingen.</li>
                    <li>Om u op de hoogte te houden van uw bestellingen via e-mail of telefoon.</li>
                    <li>Voor klantenservice en het beantwoorden van vragen of verzoeken.</li>
                    <li>Om de functionaliteit van onze website te verbeteren en het gebruiksgemak te optimaliseren.</li>
                    <li>Voor marketingdoeleinden, zoals het versturen van aanbiedingen, maar alleen als u zich hiervoor heeft aangemeld.</li>
                </ul>
            </section>

            <section>
                <h2>Hoe beschermen wij uw gegevens?</h2>
                <p>Wij nemen passende technische en organisatorische maatregelen om uw persoonlijke gegevens te beschermen tegen ongeoorloofde toegang, verlies of misbruik. Onze website maakt gebruik van beveiligde verbindingen (SSL) voor het verwerken van uw gegevens en betalingen.</p>
            </section>

            <section>
                <h2>Hoe lang bewaren wij uw gegevens?</h2>
                <p>We bewaren uw persoonlijke gegevens niet langer dan nodig is voor de doeleinden waarvoor ze zijn verzameld. Gegevens die nodig zijn voor het verwerken van betalingen en bestellingen worden bewaard voor de wettelijke periode van 7 jaar, zoals vereist door belastingwetgeving.</p>
            </section>

            <section>
                <h2>Uw rechten</h2>
                <p>Als gebruiker van onze website heeft u de volgende rechten met betrekking tot uw persoonlijke gegevens:</p>
                <ul>
                    <li><strong>Toegang:</strong> U kunt op elk moment verzoeken om de gegevens die wij over u hebben in te zien.</li>
                    <li><strong>Correctie:</strong> U kunt verzoeken om onjuiste of verouderde gegevens te corrigeren.</li>
                    <li><strong>Verwijdering:</strong> U kunt verzoeken om uw gegevens te laten verwijderen, mits er geen wettelijke verplichting bestaat om deze te bewaren.</li>
                    <li><strong>Bezwaar maken:</strong> U kunt bezwaar maken tegen het gebruik van uw gegevens voor marketingdoeleinden.</li>
                </ul>
            </section>

            <section>
                <h2>Cookies</h2>
                <p>Onze website maakt gebruik van cookies om het gebruik van onze website te analyseren en de gebruikerservaring te verbeteren. U kunt cookies uitschakelen via de instellingen van uw browser. Dit kan echter invloed hebben op de functionaliteit van de website.</p>
            </section>

            <section>
                <h2>Contact opnemen</h2>
                <p>Als u vragen heeft over deze privacyverklaring of het gebruik van uw gegevens, kunt u contact met ons opnemen via de onderstaande gegevens:</p>
                <address>
                    <p>Pizzeria Sole Machina</p>
                    <p>Email: <a href="mailto:info@solemachina.nl">info@solemachina.nl</a></p>
                    <p>Telefoon: 012-3456789</p>
                </address>
            </section>
        </main>

        <footer>
            <p>&copy; 2024 Pizzeria Sole Machina. Alle rechten voorbehouden.</p>
        </footer>
    </body>
</html>
