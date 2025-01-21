<?php
include 'header.php'; // Include header which might contain session start and necessary assets
include './functions/db_connectie.php';

if (!isset($_SESSION['user']['role']) || $_SESSION['user']['role'] !== 'Client') {
    header('Location: index.php');
    exit;
}

$username = $_SESSION['user']['username']; // Get logged-in user's username

// Query to fetch orders for this client
$query = "
SELECT 
    o.order_id,
    STRING_AGG(p.name, ', ') AS items,
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
                <td>
                    <?php
                        switch ($order['status']) {
                            case 1:
                                echo "Wordt bereid";
                                break;
                            case 2:
                                echo "Onderweg";
                                break;
                            case 3:
                                echo "Geleverd";
                                break;
                            default:
                                echo "Onbekend";
                                break;
                        }
                    ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>
</body>
</html>
