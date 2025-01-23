<?php
include 'header.php';
include 'functions/db_connectie.php';
include './functions/winkelmand-functies.php';

if (isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'Personnel') {
    header('Location: bestellingen-personeel.php');
    exit;
}

if (isset($_SESSION['user']['username'])) {
    $username = $_SESSION['user']['username'];
    
    $query = "SELECT first_name, last_name, address FROM [User] WHERE username = :username";
    $params = [':username' => $username];
    $userData = getData($query, $params);

    if ($userData) {
        $firstName = $userData[0]['first_name'];
        $lastName = $userData[0]['last_name'];
        $address = $userData[0]['address'];

        $addressParts = explode(",", $address);
        if (count($addressParts) == 3) {
            list($streetAndNumber, $postcode, $city) = array_map('trim', $addressParts);
        } else {
            $streetAndNumber = $postcode = $city = '';
        }
    }
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

if (isset($_POST['submit_order']) && !empty($_SESSION['winkelmandje'])) {
    $addressPattern = "/^[A-Za-z0-9\s]+$/";
    $postcodePattern = "/^[A-Za-z0-9\s]+$/";
    $stadPattern = "/^[A-Za-z\s]+$/";
    $naamPattern = "/^[A-Za-z\s]+$/";

    $address = isset($_POST['address']) ? trim($_POST['address']) : '';
    $postcode = isset($_POST['postcode']) ? trim($_POST['postcode']) : '';
    $stad = isset($_POST['stad']) ? trim($_POST['stad']) : '';
    $naam = isset($_POST['naam']) ? trim($_POST['naam']) : '';

    if (!preg_match($addressPattern, $address)) {
        $error = "Een adres mag alleen letters en cijfers bevatten.";
    }

    if (!preg_match($postcodePattern, $postcode)) {
        $error = "Een postcode mag alleen lettersen cijfers bevatten.";
    }

    if (!preg_match($stadPattern, $stad)) {
        $error = "Een stadsnaam mag alleen letters bevatten.";
    }

    if (!preg_match($naamPattern, $naam)) {
        $error = "Een Naam mag alleen letters bevatten.";
    }

    if (!empty($address) && !empty($postcode) && !empty($stad) && !empty($naam) && empty($error)) {
        $query = "SELECT MAX(username) AS MaxPersonnelName FROM [User] WHERE role = :role";
        $params = ['role' => 'Personnel'];
        $data = getData($query, $params);

        $fullAddress = $address . ', ' . $postcode . ', ' . $stad;

        if (isset($_SESSION['user']) && isset($_SESSION['user']['username'])) {
            $clientUsername = $_SESSION['user']['username'];
        } else {
            $clientUsername = null;
        }

        $clientName = $naam;
        $personnelUsername = $data[0]['MaxPersonnelName'];
        $datetime = new DateTime();
        $datetime->modify('+1 hour');
        $datetime = $datetime->format('Y-m-d H:i:s');
        $status = 1;

        $orderQuery = "INSERT INTO Pizza_Order (client_username, client_name, personnel_username, datetime, status, address) 
                       VALUES (:client_username, :client_name, :personnel_username, :datetime, :status, :address)";
        $orderParams = [
            ':client_username' => $clientUsername,
            ':client_name' => $clientName,
            ':personnel_username' => $personnelUsername,
            ':datetime' => $datetime,
            ':status' => $status,
            ':address' => $fullAddress
        ];
        postData($orderQuery, $orderParams);

        $conn = maakVerbinding();
        $orderId = $conn->lastInsertId();

        $productCounts = array_count_values(array_column($_SESSION['winkelmandje'], 'name'));

        foreach ($productCounts as $productName => $quantity) {
            $productQuery = "INSERT INTO Pizza_Order_Product (order_id, product_name, quantity) 
                             VALUES (:order_id, :product_name, :quantity)";
            $productParams = [
                ':order_id' => $orderId,
                ':product_name' => $productName,
                ':quantity' => $quantity
            ];
        
            postData($productQuery, $productParams);
        }
        
        $error = 'Uw bestelling is geplaatst!';
    } else {
        $error = 'Vul alle velden.';
    }
} elseif (isset($_POST['submit_order']) && empty($_SESSION['winkelmandje'])) {
    $error = 'Uw winkelmandje is leeg, voeg eerst producten toe aan uw winkelmandje.';
}
?>

        <main>
            <?php echo getCartHTML(); ?>

            <form action="" method="POST" class="order-info" name="order_form">
                <div class="form-row">
                    <label for="naam">Naam:</label>
                    <input type="text" id="naam" name="naam" placeholder="Bijv. Henk Steen" 
                        value="<?php echo isset($firstName) && isset($lastName) ? $firstName . ' ' . $lastName : ''; ?>" 
                        required pattern="^[A-Za-z\s]+$" title="Een Naam mag alleen letters bevatten">
                </div>
                <div class="form-row">
                    <label for="address">Adres:</label>
                    <input type="text" id="address" name="address" placeholder="Straatnaam en huisnummer" 
                        value="<?php echo isset($streetAndNumber) ? $streetAndNumber : ''; ?>" 
                        required pattern="^[A-Za-z0-9\s]+$" title="Een adres mag alleen letters en cijfers bevatten">
                </div>
                <div class="form-row">
                    <label for="postcode">Postcode:</label>
                    <input type="text" id="postcode" name="postcode" placeholder="Bijv. 1234AB" 
                        value="<?php echo isset($postcode) ? $postcode : ''; ?>" 
                        required pattern="^[A-Za-z0-9\s]+$" title="Een postcode mag alleen letters en cijfers bevatten">
                </div>
                <div class="form-row">
                    <label for="stad">Stad:</label>
                    <input type="text" id="stad" name="stad" placeholder="Bijv. Stad" 
                        value="<?php echo isset($city) ? $city : ''; ?>" 
                        required pattern="^[A-Za-z\s]+$" title="Een stadsnaam mag alleen letters bevatten">
                </div>
                
                <button type="submit" name="submit_order">Bestelling Plaatsen</button>
                <?php if (isset($error)): ?>
                    <p class="<?php echo (strpos($error, 'geplaatst') !== false) ? 'success-message' : 'error-message'; ?>">
                        <?php echo $error; ?>
                    </p>
                <?php endif; ?>
            </form>
        </main>
    </body>
</html>