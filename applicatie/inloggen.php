<?php
include 'header.php';
include './functions/db_connectie.php';

if (isset($_SESSION['user']['role'])) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!empty($username) && !empty($password)) {
        $sql = "SELECT * FROM [User] WHERE username = ?";
        $user = getData($sql, [$username]);

        if ($user && password_verify($password, $user[0]['password'])) {
            $_SESSION['user'] = [
                'role' => $user[0]['role']
            ];
            header('Location: index.php');
            exit;
        } else {
            $error = "Ongeldige gebruikersnaam of wachtwoord.";
        }
    } else {
        $error = "Vul alle velden in.";
    }
}
?>

        <main>
            <form method="POST">
                <div class="form-row">           
                    <label for="username">Gebruikersnaam:</label>
                    <input type="text" id="username" name="username" placeholder="Uw gebruikersnaam" required><br>
                    
                    <label for="password">Wachtwoord:</label>
                    <input type="password" id="password" name="password" placeholder="Uw wachtwoord" required><br>
                </div>
                <button type="submit">Inloggen</button>
                <?php if (isset($error)) echo "<p class='error-message''>$error</p>"; ?>   
            </form>
        </main>
    </body>
</html>