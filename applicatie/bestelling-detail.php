<?php
include 'header.php';
include './functions/order-status.php';

if(isset($_SESSION['user']['username'])){
    $role = getUserRoleByUsername($_SESSION['user']['username']);
}

if (isset($role) && $role !== 'Personnel') {
    header('Location: index.php');
    exit;
}

$order_id = isset($_GET['order_id']) ? $_GET['order_id'] : 43;

if (!$order_id) {
    echo "<p>No order specified.</p>";
    exit;
}

$query = "
    SELECT
        po.order_id,
        po.client_name,
        po.address,
        po.datetime,
        po.status,
        p.name AS product_name,
        pop.quantity
    FROM Pizza_Order po
    JOIN Pizza_Order_Product pop ON po.order_id = pop.order_id
    JOIN Product p ON pop.product_name = p.name
    WHERE po.order_id = :order_id AND po.status IN (1, 2, 3)  -- Filter by status (In the oven, Being prepared, Delivered)
";

$order = getData($query, ['order_id' => $order_id]);

if ($order) {
    $client_name = $order[0]['client_name'];
    $address = $order[0]['address'];
    $datetime = $order[0]['datetime'];
    $status = $order[0]['status'];

    $products = [];
    foreach ($order as $item) {
        $products[] = $item['product_name'] . " (x" . $item['quantity'] . ")";
    }
    $products_list = implode(', ', $products);
} else {
    $error_message = "Order not found.";
}

$datetime_object = new DateTime($datetime);
$formatted_datetime = $datetime_object->format('H:i d-m-Y');

?>

        <main>
            <?php if (isset($error_message)) { ?>
                <p><?php echo $error_message; ?></p>
            <?php } else { ?>
                <h2>Bestelling #<?php echo $order_id; ?></h2>
                <p><strong>Naam Klant:</strong> <?php echo $client_name; ?></p>
                <p><strong>Adres:</strong> <?php echo $address; ?></p>
                <p><strong>Tijd van Bestelling:</strong> <?php echo $formatted_datetime; ?></p>
                <p><strong>Items:</strong> <?php echo $products_list; ?></p>
                <p><strong>Status:</strong> <?php echo getOrderStatus($status); ?></p>
            <?php } ?>
        </main>
    </body>
</html>