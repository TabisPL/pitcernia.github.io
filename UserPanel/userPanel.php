<?php
session_start(); // Start sesji

// Dane do połączenia z bazą danych
$serwer = 'localhost';
$baza_danych = 'pizza3test';
$uzytkownik = 'root';
$haslo = '';

// Połączenie z bazą danych
$baza = mysqli_connect($serwer, $uzytkownik, $haslo, $baza_danych);

$czyzalogowany = isset($_SESSION['UzytkownikID']);
if ($czyzalogowany) {
  $logged_user = $_SESSION['UzytkownikID'];
}


// Funkcja tworzy tabelę do wyświetlania zamówień i pobiera je z bazy danych
function get_orders($baza, $logged_user) {
  // Definiowanie zmiennych
  $total_amount = 0;
  $sql = "SELECT zamowienia.KwotaCalkowita, zamowienia.Status, zamowienia.DataUtworzenia, zamowienia.DataAktualizacji, szczegolyzamowienia.Ilosc, pizze.Nazwa, pizze.Rozmiar, zamowienia.ZamowienieID FROM `zamowienia`
  JOIN szczegolyzamowienia ON szczegolyzamowienia.ZamowienieID = zamowienia.ZamowienieID JOIN pizze ON pizze.PizzaID = szczegolyzamowienia.PizzaID
  WHERE zamowienia.UzytkownikID = '$logged_user' ORDER BY zamowienia.Status;";

  $orders = mysqli_query($baza, $sql);
  // Tworzenie tabeli dla każdego zamówienia osobno
  foreach($orders as $order) {
    $total_amount += $order["KwotaCalkowita"]; // Sumowanie kwot zamówień
    echo "<div class='bg-light justify-content-center'>";
    echo "<table class='table'>";
    echo "<tr><td>Data utworzenia:</td><td>".$order["DataUtworzenia"]."</td><td>Ostatnia aktualizacja:</td><td>".$order["DataAktualizacji"]."</td></tr>";
    echo "<tr><td>Pizza:</td><td>".$order["Nazwa"]."</td><td>Status:</td><td>".$order["Status"]."</td></tr>";
    echo "<tr><td>Rozmiar:</td><td>".$order["Rozmiar"]."</td></tr>";
    echo "<tr><td>Ilość:</td><td>".$order["Ilosc"]."</td></tr>";
    echo "<tr><td>Cena:</td><td>".$order["KwotaCalkowita"]."</td></tr>";
    if ($order["Status"] == "Oczekujace") {
      $order_id = $order["ZamowienieID"];
      echo "<tr><td colspan='4'><div class='text-end'><button class='btn btn-warning'>Anuluj Zamówienie</button></div></td></tr>";
    }
    echo "</table>";
    echo "</div>";
  }
  return $total_amount;
}
// Funkcja sprawdza czy zamówienie nie jest w trakcie realizacji
function get_status($baza, $order_id) {
  $sql = "SELECT Status FROM zamowienia WHERE ZamowienieID = '$order_id';";
  $status = mysqli_query($baza, $sql);
  return $status;
}
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
<body class="bg-dark text-white">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<!-- NAGŁÓWEK -->
<header class="p-3 bg-orange text-white">
  <div class="container">
    <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
      <a class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
      <img src="https://i.imgur.com/hUa9V6E.png" alt="Logo" class="Logo" style="width: 100px; height: auto;"></a>
      <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
        <li><a href="../menu.php" class="nav-link px-2 text-white">MENU</a></li>
        <li><a href="#" class="nav-link px-2 text-white">KOSZYK</a></li>
        <li><a href="../UserPanel/userPanel.php" class="nav-link px-2 text-white">MOJE KONTO</a></li>
      </ul>
      <?php if (!$czyzalogowany): ?>
      <div class="text-end">
      <a href="../login/login.php" class="btn btn-outline-light me-2">Login</a>
      <a href="../login/rejestracja.php" class="btn btn-warning">Sign-up</a>
      <?php endif; ?>
      </div>
    </div>
  </div>
</header>
<main>
  </br>
  <div class="container row">
    <div class="col-8">
      <?php 
      if ($czyzalogowany) {
        $total_amount = get_orders($baza, $logged_user);
      }
      else {
        echo  "Użytkownik nie zalogowany!";
      }?>
    </div>
    <div class="col-4 bg-light text-dark p-3">
      <h4>Łączna kwota zamówień: </h4>
      <?php
        echo "<h3>$total_amount zł</h3>";
      ?>
    </div>
  </div>
</main>

</body>
</html>