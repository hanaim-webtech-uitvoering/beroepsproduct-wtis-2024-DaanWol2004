<?php
include 'header.php';

if (isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'Personnel') {
    header('Location: bestellingen-personeel.php'); 
    exit;
}
?>

        <main>
            <table>
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Aantal</th>
                        <th>Prijs per stuk</th>
                        <th>Totaal</th>
                        <th>Acties</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Margherita</td>
                        <td>
                            <button>-</button> 2 <button>+</button>
                        </td>
                        <td>€10.00</td>
                        <td>€20.00</td>
                        <td><button>Verwijder</button></td>
                    </tr>
                    <tr>
                        <td>Pepperoni</td>
                        <td>
                            <button>-</button> 1 <button>+</button>
                        </td>
                        <td>€12.50</td>
                        <td>€12.50</td>
                        <td><button>Verwijder</button></td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3"><strong>Totaalbedrag:</strong></td>
                        <td><strong>€32.50</strong></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>

            <form class="order-info">
                <div class="form-row">
                    <label for="address">Adres:</label>
                    <input type="text" id="address" name="address" placeholder="Straatnaam en huisnummer" required pattern="^[A-Za-z0-9\s]+$" title="Een adres mag alleen letters en cijfers bevatten">
                </div>
                <div class="form-row">
                    <label for="city">Stad:</label>
                    <input type="text" id="city" name="city" placeholder="Bijv. Amsterdam" required pattern="[A-Za-z]+" title="Een stad mag alleen letters bevatten">
                </div>
                <div class="form-row">
                    <label for="phone">Telefoonnummer:</label>
                    <input type="tel" id="phone" name="phone" placeholder="06-12345678" required pattern="^[0-9\d-]+$"  title="Een telefoonnummer mag alleen cijfers en - bevatten">
                </div>
            </form>
        
            <button>Bestelling Plaatsen</button>
        </main>
    </body>
</html>
