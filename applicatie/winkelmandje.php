<?php
include 'header.php';
include 'functions/db_connectie.php';
include './functions/winkelmand-functies.php';

if (isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'Personnel') {
    header('Location: bestellingen-personeel.php');
    exit;
}

$productPrices = [];
$products = getData("SELECT name, price FROM Product");

foreach ($products as $product) {
    $productPrices[$product['name']] = $product['price'];
}

if (!isset($_SESSION['winkelmandje'])) {
    $_SESSION['winkelmandje'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_cart'])) {
        $action = $_POST['update_cart'];
        $productName = $_POST['product_name'];

        if ($action === 'increase') {
            global $productPrices;
            $productPrice = $productPrices[$productName] ?? $productPrice;
            increaseCartItem($productName, $productPrice);
        }

        if ($action === 'decrease') {
            decreaseCartItem($productName);
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

    global $productPrices;

    foreach ($productCounts as $productName => $quantity) {
        $price = $productPrices[$productName] ?? 0;
    
        $total = $price * $quantity;
        $totalAmount += $total;
    
        $html .=    "<tr>
                        <td>" . htmlspecialchars($productName) . "</td>
                        <td>
                            <form action='' method='POST'>
                                <input type='hidden' name='product_name' value='" . htmlspecialchars($productName) . "'>
                                <button type='submit' name='update_cart' value='decrease'>−</button>
                                <span>$quantity</span>
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

if (isset($_POST['submit_order'])) {
    $addressPattern = "/^[A-Za-z0-9\s]+$/";
    $postcodePattern = "/^[A-Za-z0-9\s]+$/";
    $stadPattern = "/^[A-Za-z\s]+$/";

    $address = isset($_POST['address']) ? trim($_POST['address']) : '';
    $postcode = isset($_POST['postcode']) ? trim($_POST['postcode']) : '';
    $stad = isset($_POST['stad']) ? trim($_POST['stad']) : '';

    if (!preg_match($addressPattern, $address)) {
        $error = "Adres is invalid. It should only contain letters, numbers, and spaces.";
    }

    if (!preg_match($postcodePattern, $postcode)) {
        $error = "Postcode is invalid. It should only contain letters, numbers, and spaces.";
    }

    if (!preg_match($stadPattern, $stad)) {
        $error = "Stad is invalid. It should only contain letters and spaces.";
    }

    if (!empty($address) && !empty($postcode) && !empty($stad) && empty($error)) {
        $fullAddress = $address . ', ' . $postcode . ', ' . $stad;
        $clientUsername = 'Client';
        $personnelUsername = 'test';
        $datetime = date('Y-m-d H:i:s');
        $status = 1;

        $orderQuery = "INSERT INTO Pizza_Order (client_username, client_name, personnel_username, datetime, status, address) 
                       VALUES (:client_username, :client_name, :personnel_username, :datetime, :status, :address)";
        $orderParams = [
            ':client_username' => 'Client',
            ':client_name' => 'Client',
            ':personnel_username' => $personnelUsername,
            ':datetime' => $datetime,
            ':status' => $status,
            ':address' => $fullAddress
        ];
        postData($orderQuery, $orderParams);

        $conn = maakVerbinding();
        $orderId = $conn->lastInsertId();

        foreach ($_SESSION['winkelmandje'] as $product) {
            $productName = $product['name'];
            $quantity = array_count_values(array_column($_SESSION['winkelmandje'], 'name'))[$productName];
            $productQuery = "INSERT INTO Pizza_Order_Product (order_id, product_name, quantity) 
                             VALUES (:order_id, :product_name, :quantity)";
            $productParams = [
                ':order_id' => $orderId,
                ':product_name' => $productName,
                ':quantity' => $quantity
            ];
        
            postData($productQuery, $productParams);
        }
        
        $error = 'Order has been placed successfully!';
    } else {
        $error = 'Please fill in all fields for address, postcode, and city.';
    }
}
?>

        <main>
            <?php echo getCartHTML(); ?>

            <form action="" method="POST" class="order-info" name="order_form">
                <div class="form-row">
                    <label for="address">Adres:</label>
                    <input type="text" id="address" name="address" placeholder="Straatnaam en huisnummer" required pattern="^[A-Za-z0-9\s]+$" title="Een adres mag alleen letters en cijfers bevatten">
                </div>
                <div class="form-row">
                    <label for="postcode">Postcode:</label>
                    <input type="text" id="postcode" name="postcode" placeholder="Bijv. 1234AB" required pattern="^[A-Za-z0-9\s]+$" title="Een postcode mag alleen lettersen cijfers bevatten">
                </div>
                <div class="form-row">
                    <label for="stad">Stad:</label>
                    <input type="text" id="stad" name="stad" placeholder="Bijv. Stad" required pattern="^[A-Za-z\s]+$" title="Een stadsnaam mag alleen letters bevatten">
                </div>

                <button type="submit" name="submit_order">Bestelling Plaatsen</button>
                <?php if (isset($error)) echo "<p class='error-message''>$error</p>"; ?>
            </form>
        </main>
    </body>
</html>