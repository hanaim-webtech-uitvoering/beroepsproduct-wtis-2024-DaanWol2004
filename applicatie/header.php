<?php
session_start();
include './functions/db_connectie.php';

if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit();
}

if(isset($_SESSION['user']['username'])){
    $role = getUserRoleByUsername($_SESSION['user']['username']);
}

$isLoggedIn = isset($_SESSION['user']) && $role;
$userRole = $isLoggedIn ? $role : null;

function getNavigation($isLoggedIn, $userRole) {
    $navHtml = '<nav>
        <div class="nav-left">';

    if ($userRole != 'Personnel') {
        $navHtml .= '<a href="index.php">Home</a>
                     <a href="menu.php">Menu</a>
                     <a href="winkelmandje.php">Winkelmandje</a>';
    }

    if ($isLoggedIn && $userRole == 'Personnel') {
        $navHtml .= '<a href="bestellingen-personeel.php" class="btn">Bestellingen overzicht</a>';
    }

    $navHtml .= '</div>
        <div class="nav-right">';

    if ($userRole != 'Personnel') {
        $navHtml .= '<a href="privacyverklaring.php" class="privacy-link">Privacyverklaring</a>';
    }

    $navHtml .= '<div class="dropdown">
                <button class="dropdown-btn">Account</button>
                <div class="dropdown-content">';

    if ($isLoggedIn) {
        if ($userRole == 'Client') {
            $navHtml .= '<a href="bestellingen-klant.php">Mijn Bestellingen</a>';
        }

        $navHtml .= '<a href="?logout=true">Logout</a>';
    } else {
        $navHtml .= '<a href="inloggen.php">Inloggen</a>
                     <a href="registratie.php">Registreren</a>';
    }

    $navHtml .= '</div>
            </div>
        </div>
    </nav>';

    return $navHtml;
}
?>


<!DOCTYPE html>
<html lang="nl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Pizzeria - Sole Machina</title>
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/navbar.css">
    </head>

    <body>
        <img src="images/pizza.png" alt="Een lekkere pizza met verschillende toppings" class="background-img">

        <header>
            <h1>Pizzeria Sole Machina</h1>
        </header>
        <?php echo getNavigation($isLoggedIn, $userRole); ?>