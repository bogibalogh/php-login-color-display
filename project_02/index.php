<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bejelentkezés</title>
</head>
<body>
<?php
// Adatbázis kapcsolódás
$servername = "localhost";
$username = "felhasznalonev";
$password = "jelszo";
$dbname = "adatok";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Nem sikerült kapcsolódni az adatbázishoz: " . $conn->connect_error);
}

// Felhasználónév és jelszó ellenőrzése
if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Titkosított jelszó beolvasása
    $encrypted_passwords = file_get_contents("password.txt");

    // Dekódolás
    function decode_password($encoded_passwords, $key) {
        $decoded_passwords = '';
        foreach (str_split($encoded_passwords) as $char) {
            $decoded_passwords .= chr(ord($char) - $key);
        }
        return $decoded_passwords;
    }

    $decoded_passwords = decode_password($encrypted_passwords, 5);

    // Felhasználónév és jelszó ellenőrzése
    $credentials = explode("\n", $decoded_passwords);
    $found = false;
    foreach ($credentials as $credential) {
        list($user, $pass) = explode("*", $credential);
        if ($user === $username && $pass === $password) {
            $found = true;
            break;
        }
    }

    if ($found) {
        // Felhasználói adatok lekérdezése az adatbázisból
        $sql = "SELECT * FROM tabla WHERE Username='$username'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $color = $row['Titkos'];
            echo "<div style='background-color: $color; width: 100vw; height: 100vh;'></div>";
        } else {
            echo "Nincs ilyen felhasználó!";
        }
    } else {
        echo "Hibás felhasználónév vagy jelszó! Átirányítás...";
        header("refresh:3;url=https://www.police.hu/");
    }
}

$conn->close();
?>

<form method="post" action="">
    <label for="username">Felhasználónév:</label><br>
    <input type="text" id="username" name="username" required><br>
    <label for="password">Jelszó:</label><br>
    <input type="password" id="password" name="password" required><br><br>
    <input type="submit" value="Bejelentkezés">
</form>

</body>
</html>
