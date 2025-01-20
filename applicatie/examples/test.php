<?php
require_once './functions/db_connectie.php';

// maak verbinding met de database (zie db_connection.php)
$db = maakVerbinding();

// haal alle componisten op en tel het aantal stukken
$query = 'select max(name) as name from ProductType';

$data = $db->query($query);

while($rij = $data->fetch()) {
    echo $rij['name'];
}