<?php
include 'header.php';
include 'functions/db_connectie.php';
include './functions/winkelmand-functies.php';

if (!isset($_SESSION['winkelmandje'])) {
    $_SESSION['winkelmandje'] = [];
}

if (isset($_POST['add_to_cart'])) {
    $productName = trim($_POST['product_name']);
    $productPrice = $_POST['product_price'];
    addToCart($productName, $productPrice);
}

function getPizzaMenu() {
    $query = "
        SELECT 
            pt.name AS ProductType,
            p.name AS ProductName,
            p.price AS ProductPrice,
            COALESCE(STRING_AGG(i.name, ', ') WITHIN GROUP (ORDER BY i.name), '') AS Ingredients
        FROM 
            Product p
        JOIN 
            ProductType pt ON p.type_id = pt.name
        LEFT JOIN 
            Product_Ingredient pi ON p.name = pi.product_name
        LEFT JOIN 
            Ingredient i ON pi.ingredient_name = i.name
        GROUP BY 
            pt.name, p.name, p.price
        ORDER BY 
            pt.name, p.name
    ";

    $products = getData($query);

    $html = '<main><section><h2>Pizza\'s</h2><ul>';

    foreach ($products as $product) {
        $productName = htmlspecialchars($product['ProductName']);
        $productPrice = number_format($product['ProductPrice'], 2);
        $ingredients = htmlspecialchars($product['Ingredients']);

        $html .= '<li>';
        $html .= "$productName - €$productPrice<br>Ingrediënten: $ingredients";
        $html .= ' <div class="button-container">';

        $html .= '<form action="" method="POST">';
        $html .= "<input type='hidden' name='product_name' value='$productName'>";
        $html .= "<input type='hidden' name='product_price' value='$productPrice'>";
        $html .= "<button type='submit' name='add_to_cart'>Voeg toe</button>";
        $html .= '</form>';

        $html .= '</div>';
        $html .= '</li>';
    }

    $html .= '</ul></section></main>';

    return $html;
}
?>

        <?php echo getPizzaMenu(); ?>
    </body>
</html>
