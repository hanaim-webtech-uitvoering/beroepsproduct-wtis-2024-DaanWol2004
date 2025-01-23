<?php
include 'header.php';
include 'functions/db_connectie.php';
include './functions/winkelmand-functies.php';
include './functions/menu-functies.php';

if (!isset($_SESSION['winkelmandje'])) {
    $_SESSION['winkelmandje'] = [];
}

if (isset($_POST['add_to_cart'])) {
    $productName = trim($_POST['product_name']);
    $productPrice = $_POST['product_price'];
    addToCart($productName, $productPrice);
}


?>

        <?php echo getPizzaMenu(); ?>
    </body>
</html>
