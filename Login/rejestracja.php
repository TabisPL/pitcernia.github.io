<?php
// Dane do połączenia z bazą danych
$serwer = 'localhost';
$baza_danych = 'pizza3test';
$uzytkownik = 'root';
$haslo = '';

// Zmienna na komunikaty
$komunikat = '';

// Połączenie z bazą danych
$conn = mysqli_connect($serwer, $uzytkownik, $haslo, $baza_danych);

// Sprawdzenie połączenia
if (!$conn) {
    die("Błąd połączenia z bazą danych: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Pobieranie danych z formularza
    $nazwa_uzytkownika = $_POST['nazwa_uzytkownika'];
    $imie = $_POST['imie'];
    $nazwisko = $_POST['nazwisko'];
    $email = $_POST['email'];
    $haslo = $_POST['haslo'];
    $potwierdzenie_hasla = $_POST['potwierdzenie_hasla'];

    $ulica = $_POST['ulica'];
    $numer_domu = $_POST['numer_domu'];
    $numer_mieszkania = $_POST['numer_mieszkania'];
    $kod_pocztowy = $_POST['kod_pocztowy'];
    $miasto = $_POST['miasto'];

    // Walidacja: sprawdź, czy wszystkie pola zostały wypełnione
    if (empty($nazwa_uzytkownika) || empty($email) || empty($haslo)) {
        $komunikat = "<p style='color: red;'>Wszystkie pola są wymagane!</p>";
    } else {
        // Sprawdzanie zgodności haseł
        if ($haslo !== $potwierdzenie_hasla) {
            $komunikat = "<p style='color: red;'>Hasła nie są takie same.</p>";
        } else {
            // Hashowanie hasła
            $haslo_hash = password_hash($haslo, PASSWORD_DEFAULT);

            // Sprawdzenie, czy nazwa użytkownika lub e-mail są już w użyciu
            $zapytanie = $conn->prepare("SELECT COUNT(*) FROM uzytkownicy WHERE NazwaUzytkownika = ? OR Email = ?");
            $zapytanie->bind_param('ss', $nazwa_uzytkownika, $email);
            $zapytanie->execute();
            $zapytanie->bind_result($liczba_rekordow);
            $zapytanie->fetch();
            $zapytanie->close();

            if ($liczba_rekordow > 0) {
                $komunikat = "<p style='color: red;'>Nazwa użytkownika lub e-mail są już w użyciu. Proszę wybrać inne.</p>";
            } else {
                // Dodawanie użytkownika i adresu
                $sql_uzytkownik = "INSERT INTO Uzytkownicy (NazwaUzytkownika, Imie, Nazwisko, Email, HasloHash, DataRejestracji, CzyAktywny) 
                                   VALUES ('$nazwa_uzytkownika', '$imie', '$nazwisko', '$email', '$haslo_hash', NOW(), TRUE)";

                if (mysqli_query($conn, $sql_uzytkownik)) {
                    $uzytkownik_id = mysqli_insert_id($conn); // Pobranie ID nowo dodanego użytkownika

                    $sql_adres = "INSERT INTO adresyuzytkownikow (UzytkownikID, Miasto, Ulica, NumerDomu, NumerMieszkania, KodPocztowy) 
                                  VALUES ('$uzytkownik_id', '$miasto', '$ulica', '$numer_domu', '$numer_mieszkania', '$kod_pocztowy')";

                    if (mysqli_query($conn, $sql_adres)) {
                        $komunikat = "<p style='color: green;'>Rejestracja zakończona sukcesem! Możesz się teraz zalogować.</p>";
                    } else {
                        $komunikat = "<p style='color: red;'>Błąd podczas dodawania adresu: " . mysqli_error($conn) . "</p>";
                    }
                } else {
                    $komunikat = "<p style='color: red;'>Błąd podczas rejestracji użytkownika: " . mysqli_error($conn) . "</p>";
                }
            }
        }
    }
}

// Zamknięcie połączenia
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rejestracja</title>
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
                    <li><a href="login.php" class="login-button">Login</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <main>
        <section class="form-container">
        

            <!-- Formularz rejestracji -->
            <div id="register" class="form-section">
    <h2>Zarejestruj się</h2>
    <form action="" method="post">
        <!-- Dane osobowe usera -->
        <div class="form-group">
            <label for="nazwa_uzytkownika">Nazwa użytkownika:</label>
            <input type="text" id="nazwa_uzytkownika" name="nazwa_uzytkownika" required>
        </div>
        <div class="form-group">
            <label for="imie">Imię:</label>
            <input type="text" id="imie" name="imie" required>
        </div>
        <div class="form-group">
            <label for="nazwisko">Nazwisko:</label>
            <input type="text" id="nazwisko" name="nazwisko" required>
        </div>
        <div class="form-group">
            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="haslo">Hasło:</label>
            <input type="password" id="haslo" name="haslo" required>
        </div>
        <div class="form-group">
            <label for="potwierdzenie_hasla">Potwierdź hasło:</label>
            <input type="password" id="potwierdzenie_hasla" name="potwierdzenie_hasla" required>
        </div>
        
        <!-- Adres usera -->
        <h3>Adres</h3>
        <div class="form-group">
            <label for="ulica">Ulica:</label>
            <input type="text" id="ulica" name="ulica" required>
        </div>
        <div class="form-group">
            <label for="numer_domu">Numer domu:</label>
            <input type="text" id="numer_domu" name="numer_domu" required>
        </div>
        <div class="form-group">
            <label for="numer_mieszkania">Numer mieszkania:</label>
            <input type="text" id="numer_mieszkania" name="numer_mieszkania">
        </div>
        <div class="form-group">
            <label for="kod_pocztowy">Kod pocztowy:</label>
            <input type="text" id="kod_pocztowy" name="kod_pocztowy" required>
        </div>
        <div class="form-group">
            <label for="miasto">Miasto:</label>
            <input type="text" id="miasto" name="miasto" required>
        </div>

        <button type="submit" class="form-button">Zarejestruj się</button>

        <!-- Komunikaty o tworzeniu konta -->
        <?php if (!empty($komunikat)): ?>
                <div class="komunikat <?php echo strpos($komunikat, 'sukcesem') !== false ? 'success' : 'error'; ?>">
                    <?php echo $komunikat; ?>
                </div>
            <?php endif; ?>
    </form>
</div>
        </section>
    </main>
</body>
</html>
