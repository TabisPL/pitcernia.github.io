<?php
session_start(); // Start sesji

// Dane do połączenia z bazą danych
$serwer = 'localhost';
$baza_danych = 'pizza3test';
$uzytkownik = 'root';
$haslo = '';

// Połączenie z bazą danych
$baza = mysqli_connect($serwer, $uzytkownik, $haslo, $baza_danych);

$logged_user = #Wstawić zalogowanego użytkownika

// Funkcja tworzy tabelę do wyświetlania zamówień i pobiera je z bazy danych
function get_orders() {
    $sql = "SELECT Ilosc, Suma, UzytkownikID, KwotaCalkowita, Status, zamowienia.DataUtworzenia, DataAktualizacji, szczegolyzamowienia.PizzaID, Nazwa, Opis, Cena, Rozmiar FROM `szczegolyzamowienia` JOIN zamowienia ON szczegolyzamowienia.ZamowienieID = zamowienia.ZamowienieID JOIN pizze ON szczegolyzamowienia.PizzaID = pizze.PizzaID WHERE UzytkownikID LIKE $logged_user;";
    $orders = mysqli_query($baza, $sql);
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pitcernia</title>
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
                <li><a href="#">MOJE KONTO</a></li>
                <li><button class="login-button"><a href="login\test2-login.php">LOGIN</a></button></li>
            </ul>
        </nav>
    </div>
</header>
</body>
</html>