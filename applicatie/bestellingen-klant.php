<?php
include 'header.php';
include './functions/order-status.php';

if(isset($_SESSION['user']['username'])){
    $role = getUserRoleByUsername($_SESSION['user']['username']);
}

if (!isset($role) || $role !== 'Client') {
    header('Location: index.php');
    exit;
}


$username = $_SESSION['user']['username'];

$query = "
SELECT 
    o.order_id,
    STRING_AGG(p.name + ' (x' + CAST(op.quantity AS VARCHAR) + ')', ', ') AS items,
    o.status
FROM Pizza_Order o
JOIN Pizza_Order_Product op ON o.order_id = op.order_id
JOIN Product p ON op.product_name = p.name
WHERE o.client_username = :username
GROUP BY o.order_id, o.status
ORDER BY o.order_id DESC;
";

$orders = getData($query, ['username' => $username]);
?>

        <main>
            <table>
                <thead>
                    <tr>
                        <th>Bestelnummer</th>
                        <th>Items</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                    <tr>
                        <td>#<?= htmlspecialchars($order['order_id']) ?></td>
                        <td><?= htmlspecialchars($order['items']) ?></td>
                        <td><?= getOrderStatus($order['status']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </main>
    </body>
</html>