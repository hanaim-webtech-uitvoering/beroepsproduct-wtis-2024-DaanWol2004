<?php
include 'header.php';

if(isset($_SESSION['user']['username'])){
    $role = getUserRoleByUsername($_SESSION['user']['username']);
}

if (isset($role) && $role === 'Personnel') {
    header('Location: bestellingen-personeel.php'); 
    exit;
}
?>

        <main>
            <p>Welkom op de website van Pizzeria Sole Machina! Bekijk ons menu of plaats direct een bestelling.</p>
        </main>
    </body>
</html>
