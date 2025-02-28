<?php


$czyzalogowany = isset($_SESSION['UzytkownikID']);

$serwer = 'localhost';
$baza_danych = 'srv82461_pizza3test';
$uzytkownik = 'srv82461_pizza3test';
$haslo = '12345678';

$baza = mysqli_connect($serwer, $uzytkownik, $haslo, $baza_danych);

// Zmienna na komunikaty (np będne haslo)
$komunikat = '';
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
<?php include '../navbar.php'; ?>  <!-- TUTAJ NAVBAR INCLUDE JEST (komentarz dla mnie jakbym zgubil go) -->
    <main>
        <section class="form-container">
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

                <?php
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
                    $email = $_POST['email'];
                    $haslo = $_POST['haslo'];

                    
                    $stmt = $baza->prepare("SELECT UzytkownikID, HasloHash FROM Uzytkownicy WHERE Email = ?");
                    $stmt->bind_param('s', $email);
                    $stmt->execute();
                    $stmt->store_result();

                    if ($stmt->num_rows > 0) {
                        $stmt->bind_result($UzytkownikID, $HasloHash);
                        $stmt->fetch();

                        if (password_verify($haslo, $HasloHash)) {
                            /*
                            sie okazalo ze to nie potrzebne, wiec w sumie fajnie
                            
                            Generowanie unique tokena sesji dla danego uzytkownika
                            $sesjaToken = bin2hex(random_bytes(32));
                            $_SESSION['SesjaToken'] = $sesjaToken;
                            $_SESSION['UzytkownikID'] = $UzytkownikID;

                            
                            $update_stmt = $baza->prepare("UPDATE Uzytkownicy SET SesjaToken = ? WHERE UzytkownikID = ?");
                            $update_stmt->bind_param('si', $sesjaToken, $UzytkownikID);
                            $update_stmt->execute();
                            */
                            header('Location: mojekonto.php'); // Przekierowanie na strone konta (user panel)
                            exit;
                        } else {
                            $komunikat = "<p style='color: red;'>Nieprawidłowe hasło.</p>";
                        }
                    } else {
                        $komunikat = "<p style='color: red;'>Użytkownik z podanym e-mailem nie istnieje.</p>";
                    }
                }
                ?>
                
                <p>Nie masz konta? <a href="rejestracja.php">Zarejestruj się</a></p>
            </div>
            <?php if (!empty($komunikat)): ?>
                <div class="komunikat">
                    <?php echo $komunikat; ?>
                </div>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>
