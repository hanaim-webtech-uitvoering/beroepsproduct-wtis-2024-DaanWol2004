<?php
include 'header.php';
include './functions/db_connectie.php';

if (isset($_SESSION['user']['role'])) {
    header('Location: index.php');
    exit;
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $firstName = trim($_POST['first-name']);
    $lastName = trim($_POST['last-name']);
    $password = $_POST['password'];
    $passwordRepeat = $_POST['password-repeat'];
    $address = trim($_POST['address']);
    $postcode = trim($_POST['postcode']);
    $city = trim($_POST['city']);

    if (empty($username) || empty($firstName) || empty($lastName) || empty($password) || empty($passwordRepeat) || empty($address) || empty($postcode) || empty($city)) {
        $error = "Alle velden moeten ingevuld zijn.";
    }

    elseif (!preg_match('/^[A-Za-z0-9._-]+$/', $username)) {
        $error = "De gebruikersnaam mag alleen letters, cijfers, en de symbolen . _ - bevatten.";
    }

    elseif (!preg_match('/^[A-Za-z]+$/', $firstName) || !preg_match('/^[A-Za-z]+$/', $lastName)) {
        $error = "Een naam mag alleen letters bevatten.";
    }

    elseif (!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $password)) {
        $error = "Het wachtwoord moet minimaal 8 tekens bevatten, één hoofdletter, één cijfer en één speciaal karakter.";
    }

    elseif ($password !== $passwordRepeat) {
        $error = "Wachtwoorden komen niet overeen!";
    }

    elseif (!preg_match('/^[A-Za-z0-9\s]+$/', $address)) {
        $error = "Adres mag alleen letters, cijfers en spaties bevatten.";
    }

    elseif (!preg_match('/^[A-Za-z0-9\s]+$/', $postcode)) {
        $error = "Postcode mag alleen letters, cijfers en spaties bevatten.";
    }

    elseif (!preg_match('/^[A-Za-z]+$/', $city)) {
        $error = "Stad mag alleen letters bevatten.";
    }

    if (empty($error)) {
        $fullAddress = $address . ", " . $postcode . ", " . $city;

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $role = 'Client';

        $query = "INSERT INTO [User] (username, password, first_name, last_name, role, address) 
                  VALUES (:username, :password, :first_name, :last_name, :role, :address)";

        $params = [
            ':username' => $username,
            ':password' => $hashedPassword,
            ':first_name' => $firstName,
            ':last_name' => $lastName,
            ':role' => $role,
            ':address' => $fullAddress
        ];

        if (postData($query, $params)) {
            $_SESSION['user'] = [
                'role' => $role
            ];
            header("Location: index.php");
            exit;
        } else {
            $error = "Er is een fout opgetreden bij het aanmaken van je account.";
        }
    }
}
?>

            <form method="POST">
                <div class="form-row">
                    <label for="username">Gebruikersnaam:</label>
                    <input type="text" id="username" name="username" placeholder="Voer je gebruikersnaam in" required pattern="[A-Za-z0-9._-]+" title="De gebruikersnaam mag alleen letters, cijfers, en de symbolen . _ - bevatten">
                </div>

                <div class="form-row">
                    <label for="first-name">Voornaam:</label>
                    <input type="text" id="first-name" name="first-name" placeholder="Voer je voornaam in" required pattern="[A-Za-z]+" title="Een naam mag alleen letters bevatten">
                
                    <label for="last-name">Achternaam:</label>
                    <input type="text" id="last-name" name="last-name" placeholder="Voer je achternaam in" required pattern="[A-Za-z]+" title="Een naam mag alleen letters bevatten">
                </div>
                
                <div class="form-row">
                    <label for="password">Wachtwoord:</label>
                    <input type="password" id="password" name="password" placeholder="Voer je wachtwoord in" required pattern="^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$" 
                        title="Het wachtwoord moet minimaal 8 tekens bevatten, één hoofdletter, één cijfer en één speciaal karakter (zoals @$!%*?&).">
                
                    <label for="password-repeat">Herhaal Wachtwoord:</label>
                    <input type="password" id="password-repeat" name="password-repeat" placeholder="Herhaal je wachtwoord" required pattern="^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$" 
                        title="Het wachtwoord moet minimaal 8 tekens bevatten, één hoofdletter, één cijfer en één speciaal karakter (zoals @$!%*?&).">
                </div>
                
                <div class="form-row">
                    <label for="address">Adres (straatnaam en huisnummer):</label>
                    <input type="text" id="address" name="address" placeholder="Voer je straatnaam en huisnummer in" required pattern="^[A-Za-z0-9\s]+$" title="Een adres mag alleen letters en cijfers bevatten">
                
                    <label for="postcode">Postcode:</label>
                    <input type="text" id="postcode" name="postcode" placeholder="Voer je postcode in" required pattern="^[A-Za-z0-9\s]+$" title="Een postcode mag alleen letters en cijfers bevatten">
                
                    <label for="city">Stad:</label>
                    <input type="text" id="city" name="city" placeholder="Voer je stad in" required pattern="[A-Za-z]+" title="Een stad mag alleen letters bevatten">
                </div>                
                <button type="submit">Account Aanmaken</button>

                <?php if (!empty($error)): ?>
                    <p class="error-message"><?php echo $error; ?></p>
                <?php endif; ?>
            </form>
        </main>
    </body>
</html>
