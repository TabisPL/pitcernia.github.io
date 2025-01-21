<?php
session_start(); // Start sesji


// Dane do połączenia z bazą danych
$serwer = 'localhost';
$baza_danych = 'pizza3test';
$uzytkownik = 'root';
$haslo = '';

// Połączenie z bazą danych
$baza = mysqli_connect($serwer, $uzytkownik, $haslo, $baza_danych);

// Zmienna na komunikaty (np błędne hasło)
$komunikat = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email = $_POST['email'];
    $haslo = $_POST['haslo'];

    // Zapytanie do bazy danych
    $stmt = $baza->prepare("SELECT UzytkownikID, HasloHash FROM Uzytkownicy WHERE Email = ?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->store_result();

    // Sprawdzanie, czy użytkownik istnieje
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($UzytkownikID, $HasloHash);
        $stmt->fetch();

        // Weryfikacja hasła
        if (password_verify($haslo, $HasloHash)) {
            // Logowanie udane
            $_SESSION['UzytkownikID'] = $UzytkownikID;
            header('Location: mojekonto.php'); // Przekierowanie na stronę konta (jeśli logowanie udane)
            exit;
        } else {
            $komunikat = "<p style='color: red;'>Nieprawidłowe hasło.</p>";
        }
    } else {
        $komunikat = "<p style='color: red;'>Użytkownik z podanym e-mailem nie istnieje.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logowanie</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>

    <!-- NAGŁÓWEK -->
    <header>
        <div class="banner">
            <div class="logo">PIZZA TEST</div>
            <nav>
                <ul class="menu">
                    <li><a href="#">MENU</a></li>
                    <li><a href="#">KOSZYK</a></li>
                    <li><a href="mojekonto.php">MOJE KONTO</a></li>
                    <li><a href="atest11.php" class="login-button">Login</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Logowanie -->
    <main>
        <section class="form-container">
            <!-- Formularz logowania -->
            <div id="login" class="form-section">
                <h2>Zaloguj się</h2>
                <form method="post">
                    <div class="form-group">
                        <label for="email">E-mail:</label>
                        <input type="email" id="email" name="email" required>
                    </div>

                    <div class="form-group">
                        <label for="haslo">Hasło:</label>
                        <input type="password" id="haslo" name="haslo" required>
                    </div>

                    <button type="submit" name="login" class="form-button">Zaloguj się</button>
                </form>
                <p>Nie masz konta? <a href="rejestracja.php">Zarejestruj się</a></p>
            </div>

            <!-- Komunikaty wyświetlane na dole -->
           
            <?php if (!empty($komunikat)): ?>
                <div class="komunikat">
                    <?php echo $komunikat; ?>
                </div>
            <?php endif; ?>
        </section>
    </main>

</body>
</html>