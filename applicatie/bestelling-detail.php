<?php
include 'header.php';

if (!isset($_SESSION['user']['role']) || $_SESSION['user']['role'] !== 'Personnel') {
    header('Location: index.php');
    exit;
}
?>

        <main>
            <h2>Bestelling #1234</h2>
            <p><strong>Adres:</strong> Straatnaam 123, Stad</p>
            <p><strong>Telefoonnummer:</strong> 0123456789</p>
            <p><strong>Tijd van Bestelling:</strong> 19:45</p>
            <p><strong>Items:</strong> 2x Margherita, 1x Pepperoni</p>
            <p><strong>Status:</strong> In de oven</p>
        </main>
    </body>
</html>
