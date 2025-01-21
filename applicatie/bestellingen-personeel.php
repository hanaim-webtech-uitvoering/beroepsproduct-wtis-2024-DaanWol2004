<?php
include 'header.php';
include './functions/db_connectie.php';

if (!isset($_SESSION['user']['role']) || $_SESSION['user']['role'] !== 'Personnel') {
    header('Location: index.php');
    exit;
}

$query = "SELECT o.order_id, o.client_name, o.status, 
                 STRING_AGG(p.name + ' (' + CAST(pop.quantity AS VARCHAR) + ')', ', ') AS items
          FROM Pizza_Order o
          JOIN Pizza_Order_Product pop ON o.order_id = pop.order_id
          JOIN Product p ON pop.product_name = p.name
          WHERE o.status != 3
          GROUP BY o.order_id, o.client_name, o.status, o.datetime
          ORDER BY o.datetime ASC";

$orders = getData($query);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id']) && isset($_POST['status'])) {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];

    $updateQuery = "UPDATE Pizza_Order SET status = :status WHERE order_id = :order_id";
    postData($updateQuery, ['status' => $status, 'order_id' => $order_id]);

    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}
?>

        <main>
            <h1>Bestellingen</h1>
            <table>
                <thead>
                    <tr>
                        <th>Bestelnummer</th>
                        <th>Items</th>
                        <th>Status</th>
                        <th>Actie</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td><a href="bestelling-detail.php?order_id=<?= $order['order_id'] ?>">#<?= $order['order_id'] ?></a></td>
                            <td><?= $order['items'] ?></td>
                            <td>
                                <?php
                                $statusLabels = ['Wordt bereid', 'Onderweg', 'Bezorgd'];
                                echo $statusLabels[$order['status'] - 1];
                                ?>
                            </td>
                            <td>
                                <form class="action-form" method="POST" action="">
                                    <input type="hidden" name="order_id" value="<?= $order['order_id'] ?>">
                                    <select name="status">
                                        <option value="1" <?= $order['status'] == 1 ? 'selected' : '' ?>>Wordt bereid</option>
                                        <option value="2" <?= $order['status'] == 2 ? 'selected' : '' ?>>Onderweg</option>
                                        <option value="3" <?= $order['status'] == 3 ? 'selected' : '' ?>>Bezorgd</option>
                                    </select>
                                    <button type="submit" class="update-status-btn">Wijzigen</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </main>
    </body>
</html>
