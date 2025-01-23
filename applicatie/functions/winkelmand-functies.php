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
?>