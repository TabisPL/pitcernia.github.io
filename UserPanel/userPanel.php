<?php
session_start(); // Start sesji

// Dane do połączenia z bazą danych
$serwer = 'localhost';
$baza_danych = 'pizza3test';
$uzytkownik = 'root';
$haslo = '';

// Połączenie z bazą danych
$baza = mysqli_connect($serwer, $uzytkownik, $haslo, $baza_danych);

#$logged_user = #Wstawić zalogowanego użytkownika

// Funkcja tworzy tabelę do wyświetlania zamówień i pobiera je z bazy danych
#function get_orders() {
#    $sql = "SELECT Ilosc, Suma, UzytkownikID, KwotaCalkowita, Status, zamowienia.DataUtworzenia, DataAktualizacji, szczegolyzamowienia.PizzaID, Nazwa, Opis, Cena, Rozmiar FROM `szczegolyzamowienia` JOIN zamowienia ON szczegolyzamowienia.ZamowienieID = zamowienia.ZamowienieID JOIN pizze ON szczegolyzamowienia.PizzaID = pizze.PizzaID WHERE UzytkownikID LIKE $logged_user;";
#    $orders = mysqli_query($baza, $sql);
#}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pitcernia</title>
    <link rel="stylesheet" href="UserPanel.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<!-- NAGŁÓWEK -->
<header class="p-3 text">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
        <img src="placeholder.png" alt="Logo" class="Logo">
        </a>

        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
          <li><a href="#" class="nav-link px-2 text-white">HOME</a></li>
          <li><a href="#" class="nav-link px-2 text-white">MENU</a></li>
          <li><a href="#" class="nav-link px-2 text-white">KOSZYK</a></li>
          <li><a href="#" class="nav-link px-2 text-white">MOJE KONTO</a></li>
        </ul>

        <div class="text-end">
          <button type="button" class="btn btn-outline-light me-2"><a href="login\test2-login.php">Login</button>
          <button type="button" class="btn btn-warning">Sign-up</button>
        </div>
      </div>
    </div>
</header>

</body>
</html>