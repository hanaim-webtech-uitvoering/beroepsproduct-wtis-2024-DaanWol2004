<?php
function getOrderStatus($status) {
    switch ($status) {
        case 1:
            return 'Wordt bereid';
        case 2:
            return 'Onderweg';
        case 3:
            return 'Afgeleverd';
        default:
            return 'Onbekend';
    }
}
?>