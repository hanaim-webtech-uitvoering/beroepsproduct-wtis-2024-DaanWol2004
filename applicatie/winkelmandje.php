<?php
include 'header.php';

if (isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'Personnel') {
    header('Location: bestellingen-personeel.php');
    exit;
}

if (!isset($_SESSION['winkelmandje'])) {
    $_SESSION['winkelmandje'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_to_cart'])) {
        $productName = trim($_POST['product_name']);
        $productPrice = $productPrices[$productName] ?? 0;
        $_SESSION['winkelmandje'][] = ['name' => $productName, 'price' => $productPrice];
    }

    if (isset($_POST['update_cart'])) {
        $action = $_POST['update_cart'];
        $productName = $_POST['product_name'];

        if ($action === 'increase') {
            $productPrice = $productPrices[$productName] ?? 0;
            $_SESSION['winkelmandje'][] = ['name' => $productName, 'price' => $productPrice];
        }

        if ($action === 'decrease') {
            foreach ($_SESSION['winkelmandje'] as $key => $item) {
                if ($item['name'] === $productName) {
                    unset($_SESSION['winkelmandje'][$key]);
                    $_SESSION['winkelmandje'] = array_values($_SESSION['winkelmandje']);
                    break;
                }
            }
        }
    }
}

function getCartHTML() {
    $html = '<table>
        <thead>
            <tr>
                <th>Item</th>
                <th>Aantal</th>
                <th>Prijs per stuk</th>
                <th>Totaal</th>
            </tr>
        </thead>
        <tbody>';

    $productCounts = array_count_values(array_column($_SESSION['winkelmandje'], 'name'));
    $totalAmount = 0;

    foreach ($productCounts as $productName => $quantity) {
        $price = 0;
        foreach ($_SESSION['winkelmandje'] as $item) {
            if ($item['name'] === $productName) {
                $price = $item['price'];
                break;
            }
        }

        $total = $price * $quantity;
        $totalAmount += $total;

        $html .= "<tr>
            <td>" . htmlspecialchars($productName) . "</td>
            <td>
                <form action='' method='POST' style='display:inline;'>
                    <input type='hidden' name='product_name' value='" . htmlspecialchars($productName) . "'>
                    <button type='submit' name='update_cart' value='decrease'>-</button>
                    $quantity
                    <button type='submit' name='update_cart' value='increase'>+</button>
                </form>
            </td>
            <td>€" . number_format($price, 2) . "</td>
            <td>€" . number_format($total, 2) . "</td>
        </tr>";
    }

    $html .= '</tbody>
        <tfoot>
            <tr>
                <td colspan="3"><strong>Totaalbedrag:</strong></td>
                <td><strong>€' . number_format($totalAmount, 2) . '</strong></td>
            </tr>
        </tfoot>
    </table>';
    
    return $html;
}
?>

        <main>
            <?php echo getCartHTML(); ?>

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
                    <input type="tel" id="phone" name="phone" placeholder="06-12345678" required pattern="^[0-9\d-]+$" title="Een telefoonnummer mag alleen cijfers en - bevatten">
                </div>
            </form>

            <button>Bestelling Plaatsen</button>
        </main>
    </body>
</html>
