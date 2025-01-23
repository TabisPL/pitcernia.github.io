<?php
session_start(); // Start sesji

$czyzalogowany = isset($_SESSION['UzytkownikID']);

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!-- NAGŁÓWEK -->
    <header class="p-3 text">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
        <img src="https://i.imgur.com/hUa9V6E.png" alt="Logo" class="Logo" style="width: 100px; height: auto;">
        </a>

        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
          <li><a href="#" class="nav-link px-2 text-white">MENU</a></li>
          <li><a href="#" class="nav-link px-2 text-white">KOSZYK</a></li>
          <li><a href="mojekonto.php" class="nav-link px-2 text-white">MOJE KONTO</a></li>
        </ul>

       <!-- If na sprawdzenie czy wyswietlamy guziki --> 
    <?php if (!$czyzalogowany): ?>
        <a href="login.php" class="btn btn-outline-light me-2">Login</a>
        <a href="rejestracja.php" class="btn btn-warning">Sign-up</a>
        <?php endif; ?>
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
