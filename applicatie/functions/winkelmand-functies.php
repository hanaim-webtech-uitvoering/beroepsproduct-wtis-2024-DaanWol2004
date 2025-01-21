<?php
function addToCart($productName, $productPrice) {
    $_SESSION['winkelmandje'][] = ['name' => $productName, 'price' => $productPrice];
}

function increaseCartItem($productName, $productPrice) {
    $_SESSION['winkelmandje'][] = ['name' => $productName, 'price' => $productPrice];
}

function decreaseCartItem($productName) {
    foreach ($_SESSION['winkelmandje'] as $key => $item) {
        if ($item['name'] === $productName) {
            unset($_SESSION['winkelmandje'][$key]);
            $_SESSION['winkelmandje'] = array_values($_SESSION['winkelmandje']);
            break;
        }
    }
}
?>